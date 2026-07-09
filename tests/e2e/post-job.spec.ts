/**
 * Post-a-Job form: full scenario coverage.
 *
 *  Each `test(...)` block is independent. To add a new scenario, copy any
 *  existing block, change the Scenario object, and you're done.
 *
 *  Modes (set in .env):
 *    MODE=submit  → fills the form, opens preview, confirms, asserts DB row.
 *    MODE=dryrun  → fills the form, opens preview, asserts preview contents,
 *                   then closes WITHOUT saving. Safe for staging/production.
 */

import { test, expect } from '@playwright/test';
import {
  ENV, Scenario, dbAvailable, dbFindCompanyIdByEmail,
  dbVerifyLatestJob, dbCleanupJob, dbClose,
  login, fillJobForm, openPreview, submitOrPreview, assertPreviewMatches,
} from './helpers';

test.describe('Post-a-Job form', () => {
  test.beforeAll(async () => {
    if (!ENV.email || !ENV.password) {
      throw new Error('COMPANY_EMAIL / COMPANY_PASSWORD must be set in tests/e2e/.env');
    }
  });

  test.afterAll(async () => { await dbClose(); });

  test.beforeEach(async ({ page }) => { await login(page); });

  /* ───── A: Direct + Work From Office + Full Time + multi-skill ───── */
  test('A — Direct + WFO + Full Time + multi-skill', async ({ page }) => {
    const s: Scenario = {
      label: 'A',
      job_title: 'Senior Backend Engineer (E2E-A)',
      work_mode: 'Work from Office',
      job_type:  'Full Time / Permanent',
      job_shift: 'General Shift (9 AM – 6 PM)',
      min_salary: 18, max_salary: 32,
      no_of_openings: 3,
      exp_min: 5, exp_max: 8,
      primary_language: 'English',
      posting_type: 'direct',
      locations: ['Bengaluru', 'Hyderabad'],
      locality: 'Koramangala',
      skills: ['Laravel', 'PostgreSQL', 'Redis', 'AWS'],
      interview_modes: ['CV Screening', 'Video Interview', 'HR Interview'],
      job_description_html: '<p>We are looking for a Senior Backend Engineer.</p>',
      job_overview_html: '<ul><li>5+ years backend</li><li>Strong SQL</li><li>AWS</li></ul>',
      about_company: 'We build hiring tools for the Indian market.',
      website_host: 'e2e-a-example.com',
      industry_option_index: 1,
      headcount: '51-200',
      office_address: '4th Floor, Test Tower, Koramangala, Bengaluru',
      countries_presence: ['India', 'Singapore'],
      awards: ['Great Place to Work® Certification', 'Top 50 Startups 2025'],
      perks: ['Group Health Insurance', 'Flexible Work Hours', 'Annual Performance Bonus'],
      profile_requirements: ['Current CTC', 'Notice Period', 'Resume / CV (updated)'],
      custom_questions: [{ label: 'Are you ok with on-call rotation?', type: 'yesno' }],
    };
    await runScenario(page, s);
  });

  /* ───── B: Hiring for a Client + Hybrid + Contract + Day Rate ───── */
  test('B — Client + Hybrid + Contract + Day Rate + Confidential pay', async ({ page }) => {
    const s: Scenario = {
      label: 'B',
      job_title: 'DevOps Consultant (E2E-B)',
      work_mode: 'Hybrid',
      job_type: 'Contract',
      job_shift: 'General Shift (9 AM – 6 PM)',
      contract_duration: '6 Months',
      contract_day_rate: 2500,
      contract_extension: 'Likely',
      min_salary: 20, max_salary: 24,
      no_of_openings: 1,
      compensation_confidential: true,
      exp_min: 7, exp_max: 10,
      primary_language: 'English & Hindi',
      posting_type: 'client',
      client_name: 'Acme Corp Pvt Ltd',
      client_industry: 'Information Technology',
      locations: ['Mumbai'],
      locality: 'Andheri East',
      skills: ['Kubernetes', 'Terraform', 'Jenkins'],
      interview_modes: ['Video Interview', 'Walk-in'],
      job_description_html: '<p>6-month DevOps consulting engagement.</p>',
      job_overview_html: '<ul><li>K8s production exp</li><li>IaC expertise</li></ul>',
      about_company: 'Boutique consulting agency.',
      website_host: 'e2e-b-example.com',
      industry_option_index: 2,
      headcount: '11-50',
      office_address: 'Andheri East, Mumbai',
    };
    await runScenario(page, s);
  });

  /* ───── C: Remote/WFH + Internship (location should not be required) ───── */
  test('C — Remote/WFH + Internship + no location required', async ({ page }) => {
    const s: Scenario = {
      label: 'C',
      job_title: 'Frontend Intern (E2E-C)',
      work_mode: 'Remote / WFH',
      job_type: 'Internship',
      job_shift: 'General Shift (9 AM – 6 PM)',
      min_salary: 3, max_salary: 5,
      no_of_openings: 2,
      exp_min: 0, exp_max: 1,
      primary_language: 'English',
      posting_type: 'direct',
      locations: [],          // ← intentionally empty; Remote mode allows it
      locality: '',
      skills: ['React', 'TypeScript'],
      interview_modes: ['Video Interview'],
      job_description_html: '<p>3-month remote internship building UI components.</p>',
      job_overview_html: '<p>Final year CS undergrad.</p>',
      about_company: 'Remote-first startup.',
      website_host: 'e2e-c-example.com',
      industry_option_index: 3,
      headcount: '11-50',
    };
    await runScenario(page, s);
  });

  /* ───── D: Save as Draft (only title required) ───── */
  test('D — Save as Draft (only title required)', async ({ page }) => {
    test.skip(ENV.mode === 'dryrun', 'Draft scenario writes to DB; skipped in dryrun mode.');

    await page.goto('/post-job');
    await page.locator('#jobTitle').fill('Draft Only Title (E2E-D)');
    await Promise.all([
      page.waitForURL((url) => url.pathname.includes('/my-jobs')),
      page.evaluate(() => (window as any).ZnpPostJob.saveDraft()),
    ]);

    if (dbAvailable()) {
      const cid = await dbFindCompanyIdByEmail(ENV.email);
      const jobId = await dbVerifyLatestJob(cid, {
        label: 'D', job_title: 'Draft Only Title (E2E-D)',
        work_mode: 'Hybrid', job_type: 'Internship',
        min_salary: '', max_salary: '', exp_min: '',
        posting_type: 'direct', skills: [], interview_modes: [],
        job_description_html: '', job_overview_html: '',
        about_company: '', website_host: '',
      }, { isDraft: true });
      if (ENV.cleanup) await dbCleanupJob(jobId);
    }
  });

  /* ───── E: Clone the latest non-draft job ─────
     Seeds its own source job first so it's not dependent on test order. */
  test('E — Clone-from-latest carry-over flow', async ({ page }) => {
    test.skip(ENV.mode === 'dryrun', 'Clone test needs a real source job; requires MODE=submit.');

    /* Step 1 — Create a fresh "source" job (so this test is self-contained). */
    const source: Scenario = {
      label: 'E-source',
      job_title: `Source for Clone (E2E-E-src) — ${Date.now()}`,
      work_mode: 'Hybrid',
      job_type:  'Full Time / Permanent',
      job_shift: 'General Shift (9 AM – 6 PM)',
      min_salary: 12, max_salary: 18,
      no_of_openings: 1,
      exp_min: 3, exp_max: 5,
      primary_language: 'English',
      posting_type: 'direct',
      locations: ['Bengaluru'],
      locality: 'Indiranagar',
      skills: ['SourceSkill1', 'SourceSkill2'],
      interview_modes: ['Video Interview'],
      job_description_html: '<p>Clone source description.</p>',
      job_overview_html: '<p>Clone source overview.</p>',
      about_company: 'Auto-saved from clone source.',
      website_host: 'e2e-clone-src.com',
    };
    await fillJobForm(page, source);
    await submitOrPreview(page);

    let sourceJobId: number | null = null;
    if (dbAvailable()) {
      const cid = await dbFindCompanyIdByEmail(ENV.email);
      const { dbPool } = await import('./helpers');
      const [rows]: any = await dbPool().query(
        'SELECT id FROM post_jobs WHERE company_id = ? ORDER BY id DESC LIMIT 1', [cid]
      );
      sourceJobId = Number(rows[0].id);
    }

    /* Step 2 — Open the form again, banner should now show the source job. */
    await page.goto('/post-job');
    const hasLatest = await page.evaluate(() => !!document.getElementById('cloneLatestId'));
    expect(hasLatest).toBe(true);

    /* Step 3 — Enable the Interview Modes carry-over pill (otherwise the
       cloned form has no interview modes ticked and step-1 validation fails),
       then apply clone, tweak only the title, and submit. */
    await page.evaluate(() => {
      const cb = document.querySelector('.clone-check-pill input[data-cc="interview"]') as HTMLInputElement;
      if (cb) { cb.checked = true; cb.closest('.clone-check-pill')?.classList.add('on'); }
    });
    await page.evaluate(() => (window as any).ZnpPostJob.applyClone());
    const cloned = await page.evaluate(() => ({
      title:    (document.getElementById('jobTitle')       as HTMLInputElement).value,
      workMode: (document.getElementById('workModeSelect') as HTMLSelectElement).value,
      jobType:  (document.getElementById('jobTypeSelect')  as HTMLSelectElement).value,
      salMin:   (document.getElementById('salMin')         as HTMLInputElement).value,
    }));
    expect(cloned.title).toBe(source.job_title);
    expect(cloned.workMode).toBe(source.work_mode);
    expect(cloned.jobType).toBe(source.job_type);
    expect(cloned.salMin).toBe(String(source.min_salary));

    const newTitle = `Cloned Job (E2E-E) — ${Date.now()}`;
    await page.evaluate((t) => {
      const el = document.getElementById('jobTitle') as HTMLInputElement;
      el.value = t; el.dispatchEvent(new Event('input', { bubbles: true }));

      /* Profile reqs aren't carried over by clone (Profile pill is off by
         default) — but step-5 validation requires at least one. Tick a
         sensible default so we can submit. */
      const cb = document.querySelector('input[name="profile_requirements[]"][value="Current CTC"]') as HTMLInputElement;
      if (cb) { cb.checked = true; cb.dispatchEvent(new Event('change', { bubbles: true })); }
    }, newTitle);

    await submitOrPreview(page);

    /* Step 4 — Verify + cleanup both rows. */
    if (dbAvailable()) {
      const cid = await dbFindCompanyIdByEmail(ENV.email);
      const { dbPool } = await import('./helpers');
      const [rows]: any = await dbPool().query(
        'SELECT id, job_title, work_mode FROM post_jobs WHERE company_id = ? ORDER BY id DESC LIMIT 1', [cid]
      );
      expect(rows[0].job_title).toBe(newTitle);
      expect(rows[0].work_mode).toBeTruthy();
      if (ENV.cleanup) {
        await dbCleanupJob(Number(rows[0].id));
        if (sourceJobId) await dbCleanupJob(sourceJobId);
      }
    }
  });
});

/* ─── Reusable runner: fill → preview → assert → submit → verify → cleanup ─── */

async function runScenario(page: import('@playwright/test').Page, s: Scenario): Promise<void> {
  await fillJobForm(page, s);

  /* Walk through the wizard, then open preview & verify its rendered content. */
  await openPreview(page);
  await assertPreviewMatches(page, s);
  await page.evaluate(() => (window as any).ZnpPostJob.closePreview());

  /* Re-submit through the real flow (submit | dryrun). The previous step
     already advanced us to step 5, so this just re-opens the preview. */
  const outcome = await submitOrPreview(page);

  if (outcome === 'submitted' && dbAvailable()) {
    const cid = await dbFindCompanyIdByEmail(ENV.email);
    const jobId = await dbVerifyLatestJob(cid, s);
    if (ENV.cleanup) await dbCleanupJob(jobId);
  }
}
