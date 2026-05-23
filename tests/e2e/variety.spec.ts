/**
 * Wider variety coverage for the Post-a-Job form.
 *
 * Each scenario stresses a different code path (work mode normalisation,
 * contract pricing, all profile requirements, video toggle off, strict
 * mode on, lots of perks/awards/locations/skills, custom Qs of every type).
 *
 * These are append-only — copy any block to add another corner case.
 */

import { test, expect } from '@playwright/test';
import {
  ENV, Scenario, dbAvailable, dbFindCompanyIdByEmail,
  dbVerifyLatestJob, dbCleanupJob, dbClose, dbGetJobSkillNames,
  login, fillJobForm, submitOrPreview, assertPreviewMatches,
} from './helpers';

test.describe('Post-a-Job variety', () => {
  test.beforeAll(async () => {
    if (!ENV.email || !ENV.password) {
      throw new Error('COMPANY_EMAIL / COMPANY_PASSWORD must be set in tests/e2e/.env');
    }
  });
  test.afterAll(async () => { await dbClose(); });
  test.beforeEach(async ({ page }) => { await login(page); });

  /* ── F: Temp WFH + Contract to Hire + per-month custom Q ── */
  test('F — Temp WFH + Contract-to-Hire + multi-type custom questions', async ({ page }) => {
    const s: Scenario = {
      label: 'F',
      job_title: `Solutions Architect (E2E-F) — ${Date.now()}`,
      work_mode: 'Temp WFH',
      job_type:  'Contract to Hire',
      job_shift: 'General Shift (9 AM – 6 PM)',
      contract_duration:  '12 Months',
      contract_day_rate:  3200,
      contract_extension: 'Possible',
      min_salary: 25, max_salary: 35,
      no_of_openings: 1,
      exp_min: 8, exp_max: 12,
      primary_language: 'English',
      posting_type: 'direct',
      locations: ['Bengaluru'],
      locality: 'Whitefield',
      skills: ['AWS', 'Kubernetes', 'Terraform', 'Python', 'Go'],
      interview_modes: ['CV Screening', 'Video Interview', 'HR Interview'],
      job_description_html: '<p>Hybrid C2H — 12-month engagement convertible to FT.</p>',
      job_overview_html:    '<p>Architect for distributed systems.</p>',
      about_company: 'Enterprise platform team.',
      website_host:  'e2e-f.example.com',
      headcount: '201-500',
      office_address: 'Whitefield, Bengaluru',
      perks: ['Group Health Insurance', 'Annual Performance Bonus'],
      profile_requirements: ['Current CTC', 'Expected CTC', 'Notice Period'],
      custom_questions: [
        { label: 'Are you available within 2 weeks?', type: 'yesno' },
        { label: 'How many AWS regions have you deployed across?', type: 'number' },
        { label: 'Describe your largest migration project.',       type: 'text'   },
      ],
    };
    await runScenario(page, s);
  });

  /* ── G: All profile requirements ticked, ensure none are dropped ── */
  test('G — All 10 profile requirements ticked persist exactly', async ({ page }) => {
    const allProfile = [
      'Current CTC','Expected CTC','Notice Period','Current Location',
      'Preferred Work Mode','Total Years of Experience','Resume / CV (updated)',
      'LinkedIn Profile URL','Highest Qualification','Preferred Job Location',
    ];
    const s: Scenario = {
      label: 'G',
      job_title: `Full Profile Reqs (E2E-G) — ${Date.now()}`,
      work_mode: 'Work from Office',
      job_type:  'Full Time / Permanent',
      job_shift: 'General Shift (9 AM – 6 PM)',
      min_salary: 8, max_salary: 12,
      no_of_openings: 1,
      exp_min: 1, exp_max: 3,
      primary_language: 'English',
      posting_type: 'direct',
      locations: ['Hyderabad'],
      locality: 'Hitech City',
      skills: ['Excel'],
      interview_modes: ['Video Interview'],
      job_description_html: '<p>Junior analyst role.</p>',
      job_overview_html: '<p>Strong communication.</p>',
      about_company: 'Analytics firm.',
      website_host: 'e2e-g.example.com',
      profile_requirements: allProfile,
      strict_mode: true,
    };
    await runScenario(page, s);
  });

  /* ── H: Video question disabled + strict mode + minimum-required fields ── */
  test('H — Video question OFF + strict mode ON persists in questionnaire JSON', async ({ page }) => {
    const s: Scenario = {
      label: 'H',
      job_title: `Strict + No Video (E2E-H) — ${Date.now()}`,
      work_mode: 'Remote / WFH',
      job_type:  'Full Time / Permanent',
      job_shift: 'General Shift (9 AM – 6 PM)',
      min_salary: 18, max_salary: 28,
      no_of_openings: 1,
      exp_min: 5, exp_max: 8,
      primary_language: 'English',
      posting_type: 'direct',
      locations: [],
      skills: ['Rust'],
      interview_modes: ['Video Interview'],
      job_description_html: '<p>Remote Rust engineer — strict applicant matching.</p>',
      job_overview_html: '<p>Async, lifetimes, embedded.</p>',
      about_company: 'Strict mode test.',
      website_host: 'e2e-h.example.com',
      q_video_enabled: false,
      strict_mode: true,
    };
    await runScenario(page, s);
  });

  /* ── I: Huge fan-out — 8 skills, 3 locations, 4 countries, 5 perks, 3 awards ── */
  test('I — Wide multi-select fan-out (8 skills, 3 locations, 4 countries, 5 perks)', async ({ page }) => {
    const s: Scenario = {
      label: 'I',
      job_title: `Wide Fanout (E2E-I) — ${Date.now()}`,
      work_mode: 'Hybrid',
      job_type:  'Full Time / Permanent',
      job_shift: 'General Shift (9 AM – 6 PM)',
      min_salary: 22, max_salary: 38,
      no_of_openings: 4,
      exp_min: 6, exp_max: 10,
      primary_language: 'English & Hindi',
      posting_type: 'direct',
      locations: ['Bengaluru', 'Mumbai', 'Pune'],
      locality: 'Multiple',
      skills: ['Java','Spring Boot','PostgreSQL','Redis','Kafka','AWS','Kubernetes','Datadog'],
      interview_modes: ['CV Screening', 'Video Interview', 'HR Interview'],
      job_description_html: '<p>Large platform team hiring across multiple cities.</p>',
      job_overview_html: '<p>Backend platform.</p>',
      about_company: 'Wide fan-out test.',
      website_host: 'e2e-i.example.com',
      headcount: '500-1K',
      office_address: 'Multi-office HQ',
      countries_presence: ['India', 'Singapore', 'UAE', 'United Kingdom'],
      awards: ['Award One', 'Award Two', 'Award Three'],
      perks: [
        'Group Health Insurance',
        'Annual Performance Bonus',
        'Flexible Work Hours',
        'Provident Fund (PF)',
        'Maternity / Paternity Leave',
      ],
      profile_requirements: ['Current CTC', 'Expected CTC'],
    };

    /* Custom DB skill-count assertion. */
    await fillJobForm(page, s);
    await page.evaluate(() => (window as any).ZnpPostJob.showPreview());
    await assertPreviewMatches(page, s);
    await page.evaluate(() => (window as any).ZnpPostJob.closePreview());

    const outcome = await submitOrPreview(page);
    if (outcome === 'submitted' && dbAvailable()) {
      const cid = await dbFindCompanyIdByEmail(ENV.email);
      const jobId = await dbVerifyLatestJob(cid, s);

      const skillNames = await dbGetJobSkillNames(jobId);
      const lower = skillNames.map((n) => n.trim().toLowerCase());
      s.skills.forEach((sk) => expect(lower).toContain(sk.toLowerCase()));
      expect(skillNames.length).toBeGreaterThanOrEqual(s.skills.length);

      if (ENV.cleanup) await dbCleanupJob(jobId);
    }
  });

  /* ── J: Edge-case characters in title + description ── */
  test('J — Special characters in title/description/about preserved exactly', async ({ page }) => {
    const weird = `Sr. C++ / "Rust" Engineer ‒ <Platform> — ${Date.now()}`;
    const s: Scenario = {
      label: 'J',
      job_title: weird,
      work_mode: 'Work from Office',
      job_type:  'Full Time / Permanent',
      job_shift: 'General Shift (9 AM – 6 PM)',
      min_salary: 20, max_salary: 30,
      no_of_openings: 1,
      exp_min: 5, exp_max: 8,
      primary_language: 'English',
      posting_type: 'direct',
      locations: ['Bengaluru'],
      skills: ['C++', 'Rust'],
      interview_modes: ['Video Interview'],
      job_description_html: '<p>Salary uses ₹ &amp; € — full <strong>Unicode</strong>.</p>',
      job_overview_html: '<p>Quotes "ok" &amp; apostrophes\'s fine.</p>',
      about_company: 'Test with — ‒ « » " " ‘ ’ symbols.',
      website_host: 'e2e-j.example.com',
    };
    await runScenario(page, s);
  });

  /* ── K: Hybrid + Contract (no day rate) + Walk-in interview ── */
  test('K — Hybrid + Contract + Walk-in interview mode normalisation', async ({ page }) => {
    const s: Scenario = {
      label: 'K',
      job_title: `Walk-in Hybrid (E2E-K) — ${Date.now()}`,
      work_mode: 'Hybrid',
      job_type:  'Contract',
      job_shift: 'General Shift (9 AM – 6 PM)',
      contract_duration:  '3 Months',
      contract_extension: 'None',
      min_salary: 6, max_salary: 9,
      no_of_openings: 2,
      exp_min: 1, exp_max: 3,
      primary_language: 'English',
      posting_type: 'client',
      client_name: 'WalkIn Client Co',
      client_industry: 'Information Technology',
      locations: ['Bengaluru'],
      locality: 'JP Nagar',
      skills: ['Manual Testing'],
      interview_modes: ['Walk-in', 'HR Interview'],
      job_description_html: '<p>Walk-in interviews this Saturday.</p>',
      job_overview_html: '<p>QA fresher-friendly.</p>',
      about_company: 'Client-side walk-in.',
      website_host: 'e2e-k.example.com',
    };
    await runScenario(page, s);
  });
});

async function runScenario(page: import('@playwright/test').Page, s: Scenario): Promise<void> {
  await fillJobForm(page, s);
  await page.evaluate(() => (window as any).ZnpPostJob.showPreview());
  await assertPreviewMatches(page, s);
  await page.evaluate(() => (window as any).ZnpPostJob.closePreview());
  const outcome = await submitOrPreview(page);
  if (outcome === 'submitted' && dbAvailable()) {
    const cid = await dbFindCompanyIdByEmail(ENV.email);
    const jobId = await dbVerifyLatestJob(cid, s);
    if (ENV.cleanup) await dbCleanupJob(jobId);
  }
}
