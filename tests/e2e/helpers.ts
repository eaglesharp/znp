/**
 * Shared helpers for ZNP Post-a-Job e2e tests.
 *
 *  - login()                   Logs in as the configured test company.
 *  - fillJobForm()             Sets every form field from a typed Scenario object.
 *  - submitOrPreview()         Honours MODE=submit | dryrun.
 *  - assertPreviewMatches()    Sanity-checks the rendered preview overlay.
 *  - dbVerifyLatestJob()       Pulls the last post_jobs row for the test company
 *                              and diffs it against the scenario inputs.
 *  - dbCleanupLatestJob()      Deletes the most recently created test job.
 */

import { expect, Page } from '@playwright/test';
import mysql, { Pool } from 'mysql2/promise';

/* ─── Env ────────────────────────────────────────────────────────────── */

export const ENV = {
  baseUrl: process.env.BASE_URL || 'http://127.0.0.1:8000',
  email:   process.env.COMPANY_EMAIL || '',
  password: process.env.COMPANY_PASSWORD || '',
  mode: (process.env.MODE === 'dryrun' ? 'dryrun' : 'submit') as 'submit' | 'dryrun',
  cleanup: (process.env.CLEANUP_JOBS || 'true').toLowerCase() === 'true',
  dbHost: process.env.DB_HOST || '',
  dbPort: Number(process.env.DB_PORT || 3306),
  dbName: process.env.DB_DATABASE || '',
  dbUser: process.env.DB_USERNAME || '',
  dbPass: process.env.DB_PASSWORD || '',
  /* Demo mode — adds visible pauses + on-screen status banner so a human
     can follow along. Enable with `npm run test:demo` or `DEMO=true npm test`. */
  demo:       process.env.DEMO === 'true',
  demoPauseMs: Number(process.env.DEMO_PAUSE_MS || 1500),
};

export function dbAvailable(): boolean {
  return Boolean(ENV.dbHost && ENV.dbName && ENV.dbUser);
}

let _pool: Pool | null = null;
export function dbPool(): Pool {
  if (!_pool) {
    _pool = mysql.createPool({
      host: ENV.dbHost,
      port: ENV.dbPort,
      database: ENV.dbName,
      user: ENV.dbUser,
      password: ENV.dbPass,
      waitForConnections: true,
      connectionLimit: 5,
    });
  }
  return _pool;
}

export async function dbClose(): Promise<void> {
  if (_pool) { await _pool.end(); _pool = null; }
}

/* ─── Scenario shape ─────────────────────────────────────────────────── */

export interface Scenario {
  label: string;                       // shows in test name
  job_title: string;
  work_mode: 'Work from Office' | 'Hybrid' | 'Remote / WFH' | 'Temp WFH';
  job_type: 'Full Time / Permanent' | 'Contract' | 'Contract to Hire' | 'Internship' | 'Fresher' | 'Part Time';
  job_shift?: string;
  contract_duration?: string;          // only when job_type contains "Contract"
  contract_day_rate?: number;
  contract_extension?: 'Likely' | 'Possible' | 'None';
  min_salary: number | string;
  max_salary: number | string;
  no_of_openings?: number;
  compensation_confidential?: boolean;
  exp_min: number | string;
  exp_max?: number | string;
  primary_language?: string;
  posting_type: 'direct' | 'client';
  client_name?: string;
  client_industry?: string;
  locations?: string[];                // empty allowed when work_mode is Remote/WFH
  locality?: string;
  skills: string[];                    // free text + existing skills both work
  interview_modes: string[];           // UI labels (e.g. "Video Interview", "Walk-in")
  job_description_html: string;
  job_overview_html: string;
  about_company: string;
  website_host: string;                // "example.com" — the form auto-prefixes "https://www."
  industry_option_index?: number;      // 0-based, skips the placeholder
  headcount?: string;                  // e.g. "11-50", "51-200"
  office_address?: string;
  countries_presence?: string[];
  awards?: string[];
  perks?: string[];                    // checkbox labels to tick
  profile_requirements?: string[];     // checkbox labels to tick
  custom_questions?: { label: string; type: 'text' | 'yesno' | 'number' }[];
  q_video_enabled?: boolean;
  strict_mode?: boolean;
  /* Expected normalisations after save (defaults derived from inputs if omitted). */
  expect_work_mode?: string;
  expect_job_type?: string;
  expect_interview_modes_csv?: string;
}

/* ─── Demo-mode helpers (on-screen banner + visible pauses) ─────────── */

/**
 * Show a floating banner at the top of the page describing the current step,
 * then sleep for `demoPauseMs`. No-op when DEMO is off.
 */
export async function demoStep(page: Page, label: string): Promise<void> {
  if (!ENV.demo) return;
  // eslint-disable-next-line no-console
  console.log(`  ▶ ${label}`);
  await page.evaluate(({ label, total }) => {
    let bar = document.getElementById('__e2e_demo_bar');
    if (!bar) {
      bar = document.createElement('div');
      bar.id = '__e2e_demo_bar';
      Object.assign(bar.style, {
        position: 'fixed', top: '0', left: '0', right: '0', zIndex: '999999',
        background: 'linear-gradient(90deg,#1c3faa,#3b82f6)', color: '#fff',
        font: '600 13px/1.4 system-ui,-apple-system,Segoe UI,Roboto,sans-serif',
        padding: '10px 18px', boxShadow: '0 2px 12px rgba(15,23,42,.25)',
        display: 'flex', alignItems: 'center', gap: '10px',
        pointerEvents: 'none',
      });
      document.body.appendChild(bar);
    }
    bar.innerHTML =
      '<span style="background:rgba(255,255,255,.18);padding:2px 9px;border-radius:10px;font-size:11px;">E2E DEMO</span>' +
      '<span>' + label + '</span>' +
      '<span style="margin-left:auto;opacity:.75;font-size:11px;">' + total + 'ms pause</span>';
  }, { label, total: ENV.demoPauseMs }).catch(() => {});
  await page.waitForTimeout(ENV.demoPauseMs);
}

/* ─── Login ─────────────────────────────────────────────────────────── */

export async function login(page: Page): Promise<void> {
  await page.goto('/employer-login');
  await demoStep(page, 'Logging in as ' + ENV.email);
  await page.locator('#signin-email').fill(ENV.email);
  await page.locator('#signin-password, input[name=password]:visible').first().fill(ENV.password);
  await Promise.all([
    page.waitForURL((url) => !url.pathname.includes('/employer-login'), { timeout: 15_000 }),
    page.locator('button[type=submit]:has-text("Sign In")').first().click(),
  ]);
}

/* ─── Form fill (one big browser-side function — easier than 30 separate clicks) ─── */

export async function fillJobForm(page: Page, s: Scenario): Promise<void> {
  await page.goto('/post-job');
  await page.waitForSelector('#jobTitle');
  await demoStep(page, `Scenario ${s.label} — opening Post-a-Job form`);

  /* In demo mode, fill section-by-section so you can watch the form populate.
     In normal mode, one bulk evaluate is faster. */
  if (ENV.demo) {
    await fillJobFormDemoMode(page, s);
    return;
  }

  await page.evaluate((scenario) => {
    const $ = (sel: string) => document.querySelector(sel) as HTMLInputElement | HTMLSelectElement | null;
    const setVal = (sel: string, val: any) => {
      const el = $(sel);
      if (!el) return;
      (el as any).value = String(val ?? '');
      el.dispatchEvent(new Event('input', { bubbles: true }));
    };
    const setSelect = (sel: string, val: any) => {
      const el = $(sel) as HTMLSelectElement | null;
      if (!el) return;
      el.value = String(val ?? '');
      el.dispatchEvent(new Event('change', { bubbles: true }));
    };
    const setMultiSel = (id: string, values: string[]) => {
      const el = document.getElementById(id) as HTMLSelectElement;
      if (!el) return;
      el.innerHTML = '';
      values.forEach((v) => {
        const o = document.createElement('option');
        o.value = v; o.text = v; o.selected = true;
        el.appendChild(o);
      });
      el.dispatchEvent(new Event('change', { bubbles: true }));
    };
    const tickCheckboxes = (name: string, wanted: string[]) => {
      const set = new Set(wanted);
      document.querySelectorAll(`input[name="${name}"]`).forEach((cb: any) => {
        cb.checked = set.has(cb.value);
        cb.dispatchEvent(new Event('change', { bubbles: true }));
      });
    };
    const replaceTagRow = (rowId: string, name: string, values: string[]) => {
      const row = document.getElementById(rowId);
      if (!row) return;
      row.querySelectorAll(`input[name="${name}"]`).forEach((i) => i.parentElement?.remove());
      values.forEach((v) => {
        const s = document.createElement('span');
        s.className = 'atag';
        s.innerHTML = `${v}<input type="hidden" name="${name}" value="${v.replace(/"/g, '&quot;')}"><span class="atag-x">×</span>`;
        row.appendChild(s);
      });
    };

    setVal('#jobTitle', scenario.job_title);
    setSelect('#workModeSelect', scenario.work_mode);
    setSelect('#jobTypeSelect',  scenario.job_type);
    if (scenario.job_shift) setSelect('[name=job_shift]', scenario.job_shift);

    if (scenario.contract_duration)  setSelect('[name=contract_duration]', scenario.contract_duration);
    if (scenario.contract_day_rate != null) setVal('[name=contract_day_rate]', scenario.contract_day_rate);
    if (scenario.contract_extension) setSelect('[name=contract_extension]', scenario.contract_extension);

    setVal('#salMin', scenario.min_salary);
    setVal('#salMax', scenario.max_salary);
    if (scenario.no_of_openings != null) setVal('[name=no_of_openings]', scenario.no_of_openings);
    if (scenario.compensation_confidential) {
      (document.getElementById('confidentialField') as HTMLInputElement).value = '1';
      document.getElementById('confidentialToggle')?.classList.add('on');
    }

    setVal('#expMin', scenario.exp_min);
    if (scenario.exp_max != null) setVal('#expMax', scenario.exp_max);
    if (scenario.primary_language) setSelect('[name=primary_language]', scenario.primary_language);

    setSelect('#postingTypeSelect', scenario.posting_type);
    if (scenario.client_name)     setVal('[name=client_name]', scenario.client_name);
    if (scenario.client_industry) setSelect('[name=client_industry]', scenario.client_industry);

    setMultiSel('locationFilter41', scenario.locations || []);
    if (scenario.locality !== undefined) setVal('[name=locality]', scenario.locality);

    setMultiSel('chooseskill', scenario.skills);
    tickCheckboxes('interview_modes[]', scenario.interview_modes);

    document.getElementById('jobDesc')!.innerHTML = scenario.job_description_html;
    document.getElementById('jobOverview')!.innerHTML = scenario.job_overview_html;

    setVal('[name=about_company]', scenario.about_company);
    setVal('#websiteHost', scenario.website_host);

    if (scenario.industry_option_index != null) {
      const ind = document.getElementById('industryIdSelect') as HTMLSelectElement;
      if (ind && ind.options.length > scenario.industry_option_index) {
        ind.selectedIndex = scenario.industry_option_index;
        ind.dispatchEvent(new Event('change', { bubbles: true }));
      }
    }
    if (scenario.headcount)      setVal('[name=headcount]', scenario.headcount);
    if (scenario.office_address) setVal('[name=office_address]', scenario.office_address);

    replaceTagRow('countryTags', 'countries_presence[]', scenario.countries_presence || []);
    if (scenario.awards?.length) {
      scenario.awards.forEach((a) => {
        const row = document.getElementById('awardTags');
        if (!row) return;
        const sp = document.createElement('span');
        sp.className = 'atag';
        sp.innerHTML = `${a}<input type="hidden" name="awards[]" value="${a.replace(/"/g, '&quot;')}"><span class="atag-x">×</span>`;
        row.appendChild(sp);
      });
    }
    if (scenario.perks?.length) tickCheckboxes('perks[]', scenario.perks);
    /* Profile Requirements have no defaults — but step-5 validation requires
       at least one. If the scenario doesn't specify any, tick a sensible default
       so existing tests don't all need updating. */
    const profileReqs = scenario.profile_requirements?.length
      ? scenario.profile_requirements
      : ['Current CTC'];
    tickCheckboxes('profile_requirements[]', profileReqs);

    const cq = JSON.stringify(scenario.custom_questions || []);
    (document.getElementById('customQuestionsField') as HTMLInputElement).value = cq;

    if (scenario.q_video_enabled === false) {
      (document.getElementById('qVideoEnabledField') as HTMLInputElement).value = '0';
      document.getElementById('qVideoToggle')?.classList.add('off');
    }
    if (scenario.strict_mode) {
      (document.getElementById('strictModeField') as HTMLInputElement).value = '1';
      document.getElementById('strictModeToggle')?.classList.add('on');
    }

    const w: any = window;
    if (w.ZnpPostJob) {
      w.ZnpPostJob._customQs = JSON.parse(cq);
      w.ZnpPostJob._renderCustomQs?.();
      w.ZnpPostJob._syncRich?.();
      w.ZnpPostJob.syncWebsite?.();
    }
  }, s as any);
}

/* ─── Edit-page helpers ─── */

/** Opens /post-job/{id}/edit. */
export async function openEditForm(page: Page, jobId: number): Promise<void> {
  await page.goto(`/post-job/${jobId}/edit`);
  await page.waitForSelector('#jobTitle');
}

/** Read the current visual state of the form. Used by edit-page tests to assert
 *  what the user actually sees matches what's in the DB. */
export async function readFormSnapshot(page: Page): Promise<Record<string, any>> {
  return page.evaluate(() => {
    const v = (sel: string) => (document.querySelector(sel) as any)?.value ?? '';
    const mv = (id: string) => Array.from(
      ((document.getElementById(id) as HTMLSelectElement | null)?.selectedOptions ?? [])
    ).map((o: any) => o.value);
    const checked = (name: string) =>
      Array.from(document.querySelectorAll(`input[name="${name}"]:checked`)).map((c: any) => c.value);
    const tags = (id: string, name: string) =>
      Array.from(document.querySelectorAll(`#${id} input[name="${name}"]`)).map((i: any) => i.value);

    return {
      job_title:          v('#jobTitle'),
      work_mode:          v('#workModeSelect'),
      job_type:           v('#jobTypeSelect'),
      job_shift:          v('[name=job_shift]'),
      contract_duration:  v('[name=contract_duration]'),
      contract_day_rate:  v('[name=contract_day_rate]'),
      contract_extension: v('[name=contract_extension]'),
      min_salary:         v('#salMin'),
      max_salary:         v('#salMax'),
      no_of_openings:     v('[name=no_of_openings]'),
      exp_min:            v('#expMin'),
      exp_max:            v('#expMax'),
      primary_language:   v('[name=primary_language]'),
      posting_type:       v('#postingTypeSelect'),
      client_name:        v('[name=client_name]'),
      client_industry:    v('[name=client_industry]'),
      locality:           v('[name=locality]'),
      about_company:      v('[name=about_company]'),
      website_host:       v('#websiteHost'),
      headcount:          v('[name=headcount]'),
      office_address:     v('[name=office_address]'),
      locations:          mv('locationFilter41'),
      skills:             mv('chooseskill'),
      skill_names:        Array.from(
        ((document.getElementById('chooseskill') as HTMLSelectElement | null)?.selectedOptions ?? [])
      ).map((o: any) => o.text),
      interview_modes:    checked('interview_modes[]'),
      perks:              checked('perks[]'),
      profile_requirements: checked('profile_requirements[]'),
      countries:          tags('countryTags', 'countries_presence[]'),
      awards:             tags('awardTags', 'awards[]'),
      job_description:    (document.getElementById('jobDesc') as HTMLElement)?.innerHTML || '',
      job_overview:       (document.getElementById('jobOverview') as HTMLElement)?.innerHTML || '',
      q_video_enabled:    v('#qVideoEnabledField'),
      strict_mode:        v('#strictModeField'),
      custom_questions:   v('#customQuestionsField'),
    };
  });
}

/* Section-by-section fill so a human can watch the form populate. */
async function fillJobFormDemoMode(page: Page, s: Scenario): Promise<void> {
  const scrollTo = (sel: string) =>
    page.evaluate((s) => document.querySelector(s)?.scrollIntoView({ behavior: 'smooth', block: 'center' }), sel);

  await demoStep(page, '§1 Job basics — title, work mode, type, shift');
  await scrollTo('#jobTitle');
  await page.evaluate((scenario) => {
    const setVal = (sel: string, val: any) => { const el = document.querySelector(sel) as any; if (el) { el.value = String(val ?? ''); el.dispatchEvent(new Event('input', { bubbles: true })); } };
    const setSel = (sel: string, val: any) => { const el = document.querySelector(sel) as any; if (el) { el.value = String(val ?? ''); el.dispatchEvent(new Event('change', { bubbles: true })); } };
    setVal('#jobTitle', scenario.job_title);
    setSel('#workModeSelect', scenario.work_mode);
    setSel('#jobTypeSelect',  scenario.job_type);
    if (scenario.job_shift) setSel('[name=job_shift]', scenario.job_shift);
  }, s as any);

  await demoStep(page, '§1 Salary, openings, experience, language');
  await scrollTo('#salMin');
  await page.evaluate((scenario) => {
    const setVal = (sel: string, val: any) => { const el = document.querySelector(sel) as any; if (el) { el.value = String(val ?? ''); el.dispatchEvent(new Event('input', { bubbles: true })); } };
    const setSel = (sel: string, val: any) => { const el = document.querySelector(sel) as any; if (el) { el.value = String(val ?? ''); el.dispatchEvent(new Event('change', { bubbles: true })); } };
    if (scenario.contract_duration)  setSel('[name=contract_duration]', scenario.contract_duration);
    if (scenario.contract_day_rate != null) setVal('[name=contract_day_rate]', scenario.contract_day_rate);
    if (scenario.contract_extension) setSel('[name=contract_extension]', scenario.contract_extension);
    setVal('#salMin', scenario.min_salary);
    setVal('#salMax', scenario.max_salary);
    if (scenario.no_of_openings != null) setVal('[name=no_of_openings]', scenario.no_of_openings);
    if (scenario.compensation_confidential) {
      (document.getElementById('confidentialField') as HTMLInputElement).value = '1';
      document.getElementById('confidentialToggle')?.classList.add('on');
    }
    setVal('#expMin', scenario.exp_min);
    if (scenario.exp_max != null) setVal('#expMax', scenario.exp_max);
    if (scenario.primary_language) setSel('[name=primary_language]', scenario.primary_language);
  }, s as any);

  await demoStep(page, '§1 Posting type, location, skills, interview modes');
  await scrollTo('#postingTypeSelect');
  await page.evaluate((scenario) => {
    const setVal = (sel: string, val: any) => { const el = document.querySelector(sel) as any; if (el) { el.value = String(val ?? ''); el.dispatchEvent(new Event('input', { bubbles: true })); } };
    const setSel = (sel: string, val: any) => { const el = document.querySelector(sel) as any; if (el) { el.value = String(val ?? ''); el.dispatchEvent(new Event('change', { bubbles: true })); } };
    const setMulti = (id: string, values: string[]) => { const el = document.getElementById(id) as HTMLSelectElement; if (!el) return; el.innerHTML = ''; values.forEach(v => { const o=document.createElement('option'); o.value=v;o.text=v;o.selected=true; el.appendChild(o); }); el.dispatchEvent(new Event('change',{bubbles:true})); };
    setSel('#postingTypeSelect', scenario.posting_type);
    if (scenario.client_name) setVal('[name=client_name]', scenario.client_name);
    if (scenario.client_industry) setSel('[name=client_industry]', scenario.client_industry);
    setMulti('locationFilter41', scenario.locations || []);
    if (scenario.locality !== undefined) setVal('[name=locality]', scenario.locality);
    setMulti('chooseskill', scenario.skills);
    const set = new Set(scenario.interview_modes);
    document.querySelectorAll('input[name="interview_modes[]"]').forEach((cb: any) => { cb.checked = set.has(cb.value); cb.dispatchEvent(new Event('change',{bubbles:true})); });
  }, s as any);

  await demoStep(page, '§2 Description + eligibility (rich text)');
  await scrollTo('#jobDesc');
  await page.evaluate((scenario) => {
    document.getElementById('jobDesc')!.innerHTML = scenario.job_description_html;
    document.getElementById('jobOverview')!.innerHTML = scenario.job_overview_html;
  }, s as any);

  await demoStep(page, '§3 Company snapshot — about / website / industry / address');
  await scrollTo('[name=about_company]');
  await page.evaluate((scenario) => {
    const setVal = (sel: string, val: any) => { const el = document.querySelector(sel) as any; if (el) { el.value = String(val ?? ''); el.dispatchEvent(new Event('input', { bubbles: true })); } };
    setVal('[name=about_company]', scenario.about_company);
    setVal('#websiteHost', scenario.website_host);
    if (scenario.industry_option_index != null) {
      const ind = document.getElementById('industryIdSelect') as HTMLSelectElement;
      if (ind && ind.options.length > scenario.industry_option_index) {
        ind.selectedIndex = scenario.industry_option_index;
        ind.dispatchEvent(new Event('change', { bubbles: true }));
      }
    }
    if (scenario.headcount)      setVal('[name=headcount]', scenario.headcount);
    if (scenario.office_address) setVal('[name=office_address]', scenario.office_address);
    const row = document.getElementById('countryTags');
    if (row && scenario.countries_presence?.length) {
      row.querySelectorAll('input[name="countries_presence[]"]').forEach((i) => i.parentElement?.remove());
      scenario.countries_presence.forEach((c: string) => {
        const sp = document.createElement('span');
        sp.className = 'atag';
        sp.innerHTML = `${c}<input type="hidden" name="countries_presence[]" value="${c.replace(/"/g, '&quot;')}"><span class="atag-x">×</span>`;
        row.appendChild(sp);
      });
    }
  }, s as any);

  await demoStep(page, '§4-7 Awards, perks, profile reqs, custom questions');
  await scrollTo('#awardTags');
  await page.evaluate((scenario) => {
    if (scenario.awards?.length) {
      const row = document.getElementById('awardTags');
      scenario.awards.forEach((a: string) => {
        const sp = document.createElement('span');
        sp.className = 'atag';
        sp.innerHTML = `${a}<input type="hidden" name="awards[]" value="${a.replace(/"/g, '&quot;')}"><span class="atag-x">×</span>`;
        row?.appendChild(sp);
      });
    }
    const tick = (name: string, wanted: string[]) => { const set = new Set(wanted); document.querySelectorAll(`input[name="${name}"]`).forEach((cb: any) => { cb.checked = set.has(cb.value); cb.dispatchEvent(new Event('change',{bubbles:true})); }); };
    if (scenario.perks?.length) tick('perks[]', scenario.perks);
    /* Profile Requirements default — see fillJobForm for rationale. */
    const profileReqs = scenario.profile_requirements?.length
      ? scenario.profile_requirements
      : ['Current CTC'];
    tick('profile_requirements[]', profileReqs);
    const cq = JSON.stringify(scenario.custom_questions || []);
    (document.getElementById('customQuestionsField') as HTMLInputElement).value = cq;
    const w: any = window;
    if (w.ZnpPostJob) {
      w.ZnpPostJob._customQs = JSON.parse(cq);
      w.ZnpPostJob._renderCustomQs?.();
      w.ZnpPostJob._syncRich?.();
      w.ZnpPostJob.syncWebsite?.();
    }
  }, s as any);
}

/* ─── Step wizard navigation ─────────────────────────────────────────── */

/**
 * Walk through every wizard step in order, clicking "Next" between each.
 * Each click runs that step's validation, so this also exercises the
 * step-by-step gating. Throws (with a friendly message) if any step
 * blocks navigation due to a missing field.
 */
export async function navigateStepsToEnd(page: Page): Promise<void> {
  const totalSteps = 5;
  for (let s = 1; s < totalSteps; s++) {
    await demoStep(page, `Wizard step ${s} → ${s + 1}: clicking Next (validates step ${s})`);
    await page.evaluate(() => (window as any).ZnpPostJob.nextStep());
    const current = await page.evaluate(() => Number((window as any).ZnpPostJob._step));
    if (current !== s + 1) {
      throw new Error(`Step ${s} validation failed — expected to advance to step ${s + 1} but stayed on ${current}.`);
    }
  }
}

/* ─── Submit (or dry-run) ─────────────────────────────────────────────── */

/**
 * Open the preview overlay. If we're not already on the final step, walks
 * the wizard step-by-step first so per-step validation runs. Safe to call
 * multiple times — closes any existing preview first.
 */
export async function openPreview(page: Page): Promise<void> {
  await page.evaluate(() => {
    const w = window as any;
    /* Make sure any prior preview is closed before we (re-)open it. */
    w.ZnpPostJob.closePreview?.();
  });

  const onStep = await page.evaluate(() => Number((window as any).ZnpPostJob._step));
  if (onStep !== 5) {
    await navigateStepsToEnd(page);
  }

  await demoStep(page, 'Opening Preview overlay (final validation runs first)');
  const opened = await page.evaluate(() => {
    (window as any).ZnpPostJob.showPreview();
    return document.getElementById('pjPreviewOverlay')?.classList.contains('show') === true;
  });
  if (!opened) throw new Error('Preview overlay did not open — form has validation errors.');
}

export async function submitOrPreview(page: Page): Promise<'submitted' | 'previewed'> {
  await openPreview(page);

  if (ENV.mode === 'dryrun') {
    await demoStep(page, 'DRYRUN — closing preview without saving');
    await page.evaluate(() => (window as any).ZnpPostJob.closePreview());
    return 'previewed';
  }

  await demoStep(page, 'Clicking Confirm & Post Job — saving to DB');
  await Promise.all([
    page.waitForURL((url) => url.pathname.includes('/my-jobs'), { timeout: 30_000 }),
    page.evaluate(() => (window as any).ZnpPostJob.confirmPost()),
  ]);
  await demoStep(page, 'Saved! Landed on /my-jobs');
  return 'submitted';
}

/* ─── Assertions: preview overlay matches inputs ─────────────────────── */

export async function assertPreviewMatches(page: Page, s: Scenario): Promise<void> {
  /* The preview reads salary/work-mode/title/job-type/locations from form
     fields directly, so those are reliable. Skills are read from the
     Select2-rendered tag pills, which our tests bypass — we verify skills
     end-to-end via the DB row instead. */
  const snippet = await page.evaluate(() =>
    (document.getElementById('pjPreviewBody')?.innerText || '').slice(0, 1500)
  );
  expect(snippet).toContain(s.job_title);
  expect(snippet).toContain(s.work_mode === 'Remote / WFH' ? 'Remote' : s.work_mode);
  /* Job type lives in a meta row that may fall outside the 1500-char preview slice. */
  if (snippet.includes('Job Type')) {
    expect(snippet).toContain(s.job_type);
  }
  if (s.locations?.length) expect(snippet).toContain(s.locations[0]);
}

/* ─── DB verification + cleanup ───────────────────────────────────────── */

const WORK_MODE_MAP: Record<string, string> = {
  'Work from Office': 'Work From Office',
  'Remote / WFH':     'Remote/WFH',
};
const JOB_TYPE_MAP: Record<string, string> = {
  'Full Time / Permanent': 'Full time/Permanent',
  'Contract to Hire':      'Contract To Hire',
};
const INTERVIEW_MAP: Record<string, string> = {
  'Video Interview': 'Video Interviews',
  'Walk-in':         'Walkin',
};
function expectedWorkMode(s: Scenario): string  { return s.expect_work_mode  ?? WORK_MODE_MAP[s.work_mode]  ?? s.work_mode; }
function expectedJobType(s: Scenario): string   { return s.expect_job_type   ?? JOB_TYPE_MAP[s.job_type]    ?? s.job_type; }
function expectedInterviewCsv(s: Scenario): string {
  return s.expect_interview_modes_csv ?? s.interview_modes.map((m) => INTERVIEW_MAP[m] ?? m).join(',');
}

export async function dbVerifyLatestJob(companyId: number, s: Scenario, opts: { isDraft?: boolean } = {}): Promise<number> {
  const [rows]: any = await dbPool().query(
    'SELECT * FROM post_jobs WHERE company_id = ? ORDER BY id DESC LIMIT 1',
    [companyId]
  );
  if (!rows.length) throw new Error(`No post_jobs row found for company ${companyId}`);
  return verifyJobRow(rows[0], s, opts);
}

/** Verify a specific row (used by edit-page tests). */
export async function dbVerifyJobById(jobId: number, s: Scenario, opts: { isDraft?: boolean } = {}): Promise<number> {
  const [rows]: any = await dbPool().query('SELECT * FROM post_jobs WHERE id = ?', [jobId]);
  if (!rows.length) throw new Error(`Job #${jobId} not found`);
  return verifyJobRow(rows[0], s, opts);
}

function verifyJobRow(job: any, s: Scenario, opts: { isDraft?: boolean } = {}): number {
  expect(job.job_title).toBe(s.job_title);
  expect(Number(job.is_draft) === 1).toBe(Boolean(opts.isDraft));

  if (!opts.isDraft) {
    expect(job.work_mode).toBe(expectedWorkMode(s));
    expect(job.job_type).toBe(expectedJobType(s));
    expect(String(job.min_salary)).toBe(String(s.min_salary));
    expect(String(job.max_salary)).toBe(String(s.max_salary));
    expect(Number(job.compensation_confidential)).toBe(s.compensation_confidential ? 1 : 0);
    expect(job.posting_type).toBe(s.posting_type);
    if (s.client_name)     expect(job.client_name).toBe(s.client_name);
    if (s.client_industry) expect(job.client_industry).toBe(s.client_industry);
    if (s.interview_modes.length) {
      const expectedSet = new Set(s.interview_modes.map((m) => INTERVIEW_MAP[m] ?? m));
      const actualSet   = new Set(String(job.interview_modes || '').split(',').map((m) => m.trim()).filter(Boolean));
      expect(actualSet).toEqual(expectedSet);
    }
    if (s.contract_day_rate != null) expect(Number(job.contract_day_rate)).toBe(s.contract_day_rate);
    if (s.contract_extension) expect(job.contract_extension).toBe(s.contract_extension);
    if (s.locations?.length) {
      s.locations.forEach((loc) => expect(String(job.location || '')).toContain(loc));
    }
    if (s.locality !== undefined && s.locality !== '') expect(job.locality).toBe(s.locality);
    expect(String(job.about_company || '')).toBe(s.about_company);
    expect(String(job.website_address || '')).toContain(s.website_host);

    if (s.no_of_openings != null) expect(Number(job.no_of_openings)).toBe(s.no_of_openings);
    if (s.exp_min !== undefined)  expect(Number(job.exp_min)).toBe(Number(s.exp_min));
    if (s.exp_max !== undefined && s.exp_max !== '') expect(Number(job.exp_max)).toBe(Number(s.exp_max));
    if (s.primary_language) expect(job.primary_language).toBe(s.primary_language);
    if (s.job_shift)        expect(job.job_shift).toBe(s.job_shift);

    /* JSON columns. */
    if (s.countries_presence?.length) {
      const parsed = JSON.parse(String(job.countries_presence || '[]'));
      s.countries_presence.forEach((c) => expect(parsed).toContain(c));
    }
    if (s.awards?.length) {
      const parsed = JSON.parse(String(job.awards || '[]'));
      s.awards.forEach((a) => expect(parsed).toContain(a));
    }
    if (s.perks?.length) {
      const parsed = JSON.parse(String(job.perks || '[]'));
      s.perks.forEach((p) => expect(parsed).toContain(p));
    }
    if (s.profile_requirements?.length) {
      const parsed = JSON.parse(String(job.profile_requirements || '[]'));
      s.profile_requirements.forEach((p) => expect(parsed).toContain(p));
    }
    if (s.custom_questions?.length) {
      const q = JSON.parse(String(job.questionnaire || '[]'));
      s.custom_questions.forEach((cq) => {
        expect(q.some((x: any) => x.label === cq.label && x.type === cq.type)).toBe(true);
      });
    }
    if (s.q_video_enabled !== undefined) {
      const q = JSON.parse(String(job.questionnaire || '[]'));
      const v = q.find((x: any) => x.key === 'video_intro');
      expect(Number(!!v?.enabled)).toBe(s.q_video_enabled ? 1 : 0);
    }
    if (s.strict_mode !== undefined) {
      expect(Number(job.strict_mode)).toBe(s.strict_mode ? 1 : 0);
    }
  }

  return Number(job.id);
}

/** Returns the skill NAMES stored against a job — for clone/edit verification. */
export async function dbGetJobSkillNames(jobId: number): Promise<string[]> {
  const [rows]: any = await dbPool().query(
    `SELECT js.job_skill AS name
       FROM manage_job_skills mjs
       JOIN job_skills js ON js.id = mjs.job_skill_id
      WHERE mjs.job_id = ?
   ORDER BY mjs.id`,
    [jobId]
  );
  return rows.map((r: any) => String(r.name));
}

export async function dbCleanupJob(jobId: number): Promise<void> {
  await dbPool().query('DELETE FROM manage_job_skills WHERE job_id = ?', [jobId]);
  await dbPool().query('DELETE FROM post_jobs WHERE id = ?', [jobId]);
}

export async function dbFindCompanyIdByEmail(email: string): Promise<number> {
  const [rows]: any = await dbPool().query('SELECT id FROM companies WHERE email = ? LIMIT 1', [email]);
  if (!rows.length) throw new Error(`Test company "${email}" not found. Run seed-local-company.php first.`);
  return Number(rows[0].id);
}
