/**
 * Regression tests for the two bugs the user reported on 2026-05-20:
 *
 *   BUG-1 — "Skills not coming properly" after clone.
 *           The clone payload was shipping bare IDs and the JS rendered
 *           them as literal "Skill #55". Fixed by shipping [{id, name}].
 *
 *   BUG-2 — "Current CTC" (and other profile requirements) not surviving
 *           a clone. The clone JS had no handler for profile_requirements
 *           at all. Fixed by adding a new "Profile Requirements" pill
 *           with its own carry-over flag.
 *
 * These tests prove both fixes by cloning a known job and inspecting the
 * resulting form state in the browser (before re-submitting).
 */

import { test, expect } from '@playwright/test';
import {
  ENV, Scenario, dbAvailable, dbFindCompanyIdByEmail, dbPool,
  dbVerifyLatestJob, dbCleanupJob, dbClose,
  login, fillJobForm, submitOrPreview,
} from './helpers';

test.describe('Clone-bug regressions', () => {
  test.beforeAll(async () => {
    if (!ENV.email || !ENV.password) {
      throw new Error('COMPANY_EMAIL / COMPANY_PASSWORD must be set in tests/e2e/.env');
    }
  });
  test.afterAll(async () => { await dbClose(); });
  test.beforeEach(async ({ page }) => { await login(page); });

  test('Clone restores skill NAMES (not "Skill #<id>")', async ({ page }) => {
    test.skip(ENV.mode === 'dryrun', 'Needs a real source job; requires MODE=submit.');
    if (!dbAvailable()) test.skip(true, 'DB credentials required');

    const source: Scenario = {
      label: 'CLONE-SKILLS-src',
      job_title: `Clone Skills Source (E2E-CLN-S) — ${Date.now()}`,
      work_mode: 'Work from Office',
      job_type:  'Full Time / Permanent',
      job_shift: 'General Shift (9 AM – 6 PM)',
      min_salary: 12, max_salary: 18,
      no_of_openings: 1,
      exp_min: 4, exp_max: 6,
      primary_language: 'English',
      posting_type: 'direct',
      locations: ['Bengaluru'],
      locality: 'HSR Layout',
      skills: ['React', 'TypeScript', 'GraphQL', 'NodeJS'],
      interview_modes: ['Video Interview'],
      job_description_html: '<p>Clone skills source.</p>',
      job_overview_html: '<p>Strong JS chops.</p>',
      about_company: 'Clone skills auto-saved company.',
      website_host: 'clone-skills.example.com',
    };
    await fillJobForm(page, source);
    await submitOrPreview(page);

    const cid = await dbFindCompanyIdByEmail(ENV.email);
    const sourceId = await dbVerifyLatestJob(cid, source);

    /* Open the post-job page, click clone, inspect the rendered skill option labels. */
    await page.goto('/post-job');
    await page.waitForSelector('#cloneLatestId', { state: 'attached' });
    await page.evaluate(() => (window as any).ZnpPostJob.applyClone());

    const skillTexts: string[] = await page.evaluate(() =>
      Array.from(
        ((document.getElementById('chooseskill') as HTMLSelectElement | null)?.selectedOptions ?? [])
      ).map((o: any) => o.text)
    );

    /* BUG-1 regression: no option text should literally read "Skill #<id>". */
    skillTexts.forEach((t) => expect(t).not.toMatch(/^Skill #\d+$/));
    source.skills.forEach((sk) =>
      expect(skillTexts.map((t) => t.toLowerCase())).toContain(sk.toLowerCase())
    );

    if (ENV.cleanup) await dbCleanupJob(sourceId);
  });

  test('Clone restores Profile Requirements when the "Profile" pill is on', async ({ page }) => {
    test.skip(ENV.mode === 'dryrun', 'Needs a real source job; requires MODE=submit.');
    if (!dbAvailable()) test.skip(true, 'DB credentials required');

    const source: Scenario = {
      label: 'CLONE-PROFILE-src',
      job_title: `Clone Profile Reqs Source (E2E-CLN-P) — ${Date.now()}`,
      work_mode: 'Hybrid',
      job_type:  'Full Time / Permanent',
      job_shift: 'General Shift (9 AM – 6 PM)',
      min_salary: 15, max_salary: 25,
      no_of_openings: 1,
      exp_min: 5, exp_max: 8,
      primary_language: 'English',
      posting_type: 'direct',
      locations: ['Mumbai'],
      locality: 'BKC',
      skills: ['Product Mgmt'],
      interview_modes: ['Video Interview', 'HR Interview'],
      job_description_html: '<p>Profile reqs source.</p>',
      job_overview_html: '<p>Looking for a PM.</p>',
      about_company: 'Profile reqs auto-save.',
      website_host: 'clone-profile.example.com',
      profile_requirements: [
        'Current CTC', 'Expected CTC', 'Notice Period',
        'Total Years of Experience', 'Highest Qualification',
      ],
    };
    await fillJobForm(page, source);
    await submitOrPreview(page);

    const cid = await dbFindCompanyIdByEmail(ENV.email);
    const sourceId = await dbVerifyLatestJob(cid, source);

    await page.goto('/post-job');
    await page.waitForSelector('#cloneLatestId', { state: 'attached' });

    /* Toggle the "Profile Requirements" pill on (default = off). */
    await page.evaluate(() => {
      const cb = document.querySelector('.clone-check-pill input[data-cc="profile"]') as HTMLInputElement;
      if (!cb) throw new Error('Profile pill not found');
      cb.checked = true;
      cb.closest('.clone-check-pill')?.classList.add('on');
    });

    await page.evaluate(() => (window as any).ZnpPostJob.applyClone());

    const checkedProfile: string[] = await page.evaluate(() =>
      Array.from(document.querySelectorAll('input[name="profile_requirements[]"]:checked')).map((c: any) => c.value)
    );
    source.profile_requirements!.forEach((p) => expect(checkedProfile).toContain(p));

    if (ENV.cleanup) await dbCleanupJob(sourceId);
  });
});
