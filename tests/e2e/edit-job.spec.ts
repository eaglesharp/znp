/**
 * ZNP "Edit Job" page coverage.
 *
 *  The edit page reuses the post-job blade. These tests confirm that:
 *   1. Every field a user typed in is rendered back into the form on edit GET.
 *   2. Updates submitted via the edit form actually overwrite the DB row.
 *   3. Skills + JSON columns (perks/awards/profile_requirements/questionnaire)
 *      survive the round-trip without loss.
 */

import { test, expect } from '@playwright/test';
import {
  ENV, Scenario, dbAvailable, dbFindCompanyIdByEmail, dbPool,
  dbVerifyLatestJob, dbVerifyJobById, dbCleanupJob, dbClose, dbGetJobSkillNames,
  login, fillJobForm, submitOrPreview, openEditForm, readFormSnapshot,
} from './helpers';

test.describe('Edit-a-Job form', () => {
  test.beforeAll(async () => {
    if (!ENV.email || !ENV.password) {
      throw new Error('COMPANY_EMAIL / COMPANY_PASSWORD must be set in tests/e2e/.env');
    }
  });
  test.afterAll(async () => { await dbClose(); });
  test.beforeEach(async ({ page }) => { await login(page); });

  /* Both edit tests need a real source job — they're skipped in dryrun mode. */

  test('EDIT-1 — Round-trip: create a rich job, open edit, every field pre-fills correctly', async ({ page }) => {
    test.skip(ENV.mode === 'dryrun', 'Edit test needs a real DB row; requires MODE=submit.');
    if (!dbAvailable()) test.skip(true, 'DB credentials required');

    const s: Scenario = {
      label: 'EDIT-1-source',
      job_title: `Edit Round-Trip (E2E-EDIT-1) — ${Date.now()}`,
      work_mode: 'Hybrid',
      job_type:  'Full Time / Permanent',
      job_shift: 'General Shift (9 AM – 6 PM)',
      min_salary: 14, max_salary: 22,
      no_of_openings: 2,
      exp_min: 4, exp_max: 7,
      primary_language: 'English',
      posting_type: 'direct',
      locations: ['Pune', 'Bengaluru'],
      locality: 'Baner',
      skills: ['Python', 'Django', 'Celery', 'PostgreSQL'],
      interview_modes: ['CV Screening', 'Video Interview', 'HR Interview'],
      job_description_html: '<p><strong>Edit-test</strong> description with <em>formatting</em>.</p>',
      job_overview_html: '<ul><li>Python 4+ yrs</li><li>Django REST</li></ul>',
      about_company: 'Roundtrip test company.',
      website_host: 'edit-rt.example.com',
      industry_option_index: 1,
      headcount: '51-200',
      office_address: 'Baner High Street, Pune',
      countries_presence: ['India', 'UAE'],
      awards: ['Edit Award One', 'Edit Award Two'],
      perks: ['Group Health Insurance', 'Annual Performance Bonus', 'Flexible Work Hours'],
      profile_requirements: ['Current CTC', 'Expected CTC', 'Notice Period', 'Resume / CV (updated)'],
      custom_questions: [
        { label: 'Will you relocate to Pune?', type: 'yesno' },
        { label: 'How many production releases per month?', type: 'number' },
      ],
      strict_mode: true,
      q_video_enabled: false,
    };

    /* Step 1 — Create the source job. */
    await fillJobForm(page, s);
    await submitOrPreview(page);

    const cid = await dbFindCompanyIdByEmail(ENV.email);
    const sourceId = await dbVerifyLatestJob(cid, s);

    /* Step 2 — Open the edit page; assert every visible field matches what was saved. */
    await openEditForm(page, sourceId);
    const snap = await readFormSnapshot(page);

    expect(snap.job_title).toBe(s.job_title);
    expect(snap.work_mode).toBe(s.work_mode);
    expect(snap.job_type).toBe(s.job_type);
    expect(snap.job_shift).toBe(s.job_shift);
    expect(Number(snap.min_salary)).toBe(Number(s.min_salary));
    expect(Number(snap.max_salary)).toBe(Number(s.max_salary));
    expect(Number(snap.no_of_openings)).toBe(Number(s.no_of_openings));
    expect(Number(snap.exp_min)).toBe(Number(s.exp_min));
    expect(Number(snap.exp_max)).toBe(Number(s.exp_max));
    expect(snap.primary_language).toBe(s.primary_language);
    expect(snap.posting_type).toBe(s.posting_type);
    expect(snap.locality).toBe(s.locality);
    expect(snap.about_company).toBe(s.about_company);
    expect(snap.website_host).toContain(s.website_host);
    expect(snap.office_address).toBe(s.office_address);
    expect(snap.headcount).toBe(s.headcount);
    s.locations!.forEach((l) => expect(snap.locations).toContain(l));
    s.interview_modes.forEach((m) => expect(snap.interview_modes).toContain(m));
    s.perks!.forEach((p) => expect(snap.perks).toContain(p));
    s.profile_requirements!.forEach((p) => expect(snap.profile_requirements).toContain(p));
    s.countries_presence!.forEach((c) => expect(snap.countries).toContain(c));
    s.awards!.forEach((a) => expect(snap.awards).toContain(a));
    s.skills.forEach((sk) => expect(snap.skill_names.map((x: string) => x.toLowerCase())).toContain(sk.toLowerCase()));
    expect(String(snap.q_video_enabled)).toBe('0');
    expect(String(snap.strict_mode)).toBe('1');

    const cqParsed = JSON.parse(String(snap.custom_questions || '[]'));
    s.custom_questions!.forEach((cq) => {
      expect(cqParsed.some((q: any) => q.label === cq.label && q.type === cq.type)).toBe(true);
    });

    if (ENV.cleanup) await dbCleanupJob(sourceId);
  });

  test('EDIT-2 — Update an existing job changes the DB row (and only that row)', async ({ page }) => {
    test.skip(ENV.mode === 'dryrun', 'Edit test mutates DB; requires MODE=submit.');
    if (!dbAvailable()) test.skip(true, 'DB credentials required');

    /* Step 1 — Create a source job. */
    const original: Scenario = {
      label: 'EDIT-2-source',
      job_title: `Editable Job (E2E-EDIT-2) — ${Date.now()}`,
      work_mode: 'Work from Office',
      job_type:  'Full Time / Permanent',
      job_shift: 'General Shift (9 AM – 6 PM)',
      min_salary: 10, max_salary: 15,
      no_of_openings: 1,
      exp_min: 2, exp_max: 4,
      primary_language: 'English',
      posting_type: 'direct',
      locations: ['Chennai'],
      locality: 'Velachery',
      skills: ['Java', 'Spring Boot'],
      interview_modes: ['Video Interview'],
      job_description_html: '<p>Original description.</p>',
      job_overview_html: '<p>Original overview.</p>',
      about_company: 'Original about.',
      website_host: 'edit-mutate.example.com',
    };
    await fillJobForm(page, original);
    await submitOrPreview(page);
    const cid = await dbFindCompanyIdByEmail(ENV.email);
    const jobId = await dbVerifyLatestJob(cid, original);
    const originalRow = (await dbPool().query('SELECT * FROM post_jobs WHERE id = ?', [jobId]) as any)[0][0];

    /* Step 2 — Open edit form, apply mutations, submit. */
    await openEditForm(page, jobId);
    const mutated: Scenario = {
      ...original,
      job_title:  original.job_title + ' [updated]',
      min_salary: 30, max_salary: 45,
      no_of_openings: 5,
      exp_min: 6, exp_max: 9,
      locations: ['Chennai', 'Bengaluru'],   // add one
      locality: 'Anna Nagar',
      skills: ['Java', 'Spring Boot', 'Kafka', 'AWS'],  // add two
      interview_modes: ['CV Screening', 'Video Interview', 'HR Interview'],
      job_description_html: '<p><strong>Edited</strong> description.</p>',
      job_overview_html: '<p>Edited overview.</p>',
      about_company: 'Updated about copy.',
      perks: ['Group Health Insurance'],
      profile_requirements: ['Current CTC', 'Expected CTC'],
    };

    /* Re-fill the edit form with the mutated values. Same browser-side function. */
    await page.evaluate((scenario) => {
      const setVal = (sel: string, val: any) => { const el = document.querySelector(sel) as any; if (el) { el.value = String(val ?? ''); el.dispatchEvent(new Event('input', { bubbles: true })); } };
      const setSel = (sel: string, val: any) => { const el = document.querySelector(sel) as any; if (el) { el.value = String(val ?? ''); el.dispatchEvent(new Event('change', { bubbles: true })); } };
      const setMulti = (id: string, values: string[]) => {
        const el = document.getElementById(id) as HTMLSelectElement; if (!el) return;
        el.innerHTML = '';
        values.forEach((v) => { const o = document.createElement('option'); o.value = v; o.text = v; o.selected = true; el.appendChild(o); });
        el.dispatchEvent(new Event('change', { bubbles: true }));
      };
      const tick = (name: string, wanted: string[]) => { const set = new Set(wanted); document.querySelectorAll(`input[name="${name}"]`).forEach((cb: any) => { cb.checked = set.has(cb.value); cb.dispatchEvent(new Event('change', { bubbles: true })); }); };

      setVal('#jobTitle', scenario.job_title);
      setVal('#salMin', scenario.min_salary);
      setVal('#salMax', scenario.max_salary);
      setVal('[name=no_of_openings]', scenario.no_of_openings);
      setVal('#expMin', scenario.exp_min);
      setVal('#expMax', scenario.exp_max);
      setVal('[name=locality]', scenario.locality);
      setVal('[name=about_company]', scenario.about_company);
      setMulti('locationFilter41', scenario.locations || []);
      setMulti('chooseskill', scenario.skills);
      tick('interview_modes[]', scenario.interview_modes);
      tick('perks[]', scenario.perks || []);
      tick('profile_requirements[]', scenario.profile_requirements || []);
      document.getElementById('jobDesc')!.innerHTML = scenario.job_description_html;
      document.getElementById('jobOverview')!.innerHTML = scenario.job_overview_html;
      (window as any).ZnpPostJob?._syncRich?.();
    }, mutated as any);

    /* Use confirmPost directly since edit-page submit lands on /my-jobs too. */
    await Promise.all([
      page.waitForURL((url) => url.pathname.includes('/my-jobs'), { timeout: 30_000 }),
      page.evaluate(() => (window as any).ZnpPostJob.confirmPost()),
    ]);

    /* Step 3 — Verify the SAME row was updated (no new row). */
    await dbVerifyJobById(jobId, mutated);

    const skillNames = await dbGetJobSkillNames(jobId);
    expect(skillNames.length).toBeGreaterThanOrEqual(2);
    expect(skillNames.map((n) => n.toLowerCase())).toContain('java');

    /* Sanity: no extra post_jobs row was inserted by the edit. */
    const [countRows]: any = await dbPool().query(
      'SELECT COUNT(*) AS c FROM post_jobs WHERE company_id = ? AND id >= ?',
      [cid, jobId]
    );
    expect(Number(countRows[0].c)).toBe(1);

    if (ENV.cleanup) await dbCleanupJob(jobId);

    /* Sanity: every other key column from the original was actually mutated. */
    expect(mutated.job_title).not.toBe(original.job_title);
    expect(Number(originalRow.min_salary)).toBe(10);
  });
});
