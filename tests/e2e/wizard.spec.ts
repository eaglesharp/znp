/**
 * Step-wizard behaviour for the Post-a-Job form.
 *
 * Covers:
 *   W1 — Step gating: clicking Next on an empty step 1 blocks navigation and
 *        shows inline errors. Filling the required fields then advances.
 *   W2 — Free backward navigation: once on step N, you can click any earlier
 *        step pill to jump back without re-validating.
 *   W3 — Final-step Preview button (no generic Next button on step 5).
 *   W4 — Auto-jump to first failing step: if validation passes through
 *        nextStep() but Preview later fails (e.g. cross-step required
 *        field cleared), Preview jumps back to that step.
 *   W5 — Indicator state: numbers go done/active/idle as the user moves.
 */

import { test, expect } from '@playwright/test';
import {
  ENV, dbClose, login, fillJobForm, Scenario,
} from './helpers';

test.describe('Step wizard', () => {
  test.beforeAll(async () => {
    if (!ENV.email || !ENV.password) {
      throw new Error('COMPANY_EMAIL / COMPANY_PASSWORD must be set in tests/e2e/.env');
    }
  });
  test.afterAll(async () => { await dbClose(); });
  test.beforeEach(async ({ page }) => { await login(page); });

  test('W1 — Step gating: empty step 1 blocks Next + shows errors', async ({ page }) => {
    await page.goto('/post-job-page');
    await page.waitForSelector('#jobTitle');

    /* Try to advance with no fields filled. */
    await page.evaluate(() => (window as any).ZnpPostJob.nextStep());
    const stillOnStep1 = await page.evaluate(() => Number((window as any).ZnpPostJob._step));
    expect(stillOnStep1).toBe(1);

    const errorCount = await page.evaluate(() =>
      document.querySelectorAll('.pj-step-pane[data-step="1"] .has-error').length
    );
    expect(errorCount).toBeGreaterThan(0);

    /* Verify the inline error message is visible on the title field. */
    const titleErr = await page.evaluate(() => {
      const field = document.getElementById('jobTitle')?.closest('.field');
      return field?.querySelector('.field-error.live')?.textContent || '';
    });
    expect(titleErr).toContain('Job title is required');
  });

  test('W2 — Free backward jump via step pill', async ({ page }) => {
    /* Fill step 1 minimally so we can advance, then jump back. */
    await page.goto('/post-job-page');
    await page.waitForSelector('#jobTitle');

    await fillStep1Minimum(page);
    await page.evaluate(() => (window as any).ZnpPostJob.nextStep());
    expect(await currentStep(page)).toBe(2);

    /* Click the step-1 pill — should jump back without any validation. */
    await page.locator('#pjSteps .step[data-step="1"]').click();
    expect(await currentStep(page)).toBe(1);

    /* Verify the step indicator now shows step 1 as active, step 2 as idle. */
    const activeNum = await page.evaluate(() => {
      const a = document.querySelector('#pjSteps .step-num.active') as HTMLElement;
      return a?.textContent?.trim();
    });
    expect(activeNum).toBe('1');
  });

  test('W3 — Step 5 swaps Next for Preview & Post Job in the footer', async ({ page }) => {
    await page.goto('/post-job-page');
    await page.waitForSelector('#jobTitle');

    /* Fast-forward to step 5 (bypass validation — testing UI only). */
    await page.evaluate(() => (window as any).ZnpPostJob.gotoStep(5, { validate: false }));

    /* Generic Next is hidden; Preview button (same footer slot) is shown. */
    expect(await page.locator('#pjNextBtn').isVisible()).toBe(false);
    expect(await page.locator('#pjPreviewBtn').isVisible()).toBe(true);

    /* And vice-versa when we go back to step 4. */
    await page.evaluate(() => (window as any).ZnpPostJob.gotoStep(4, { validate: false }));
    expect(await page.locator('#pjNextBtn').isVisible()).toBe(true);
    expect(await page.locator('#pjPreviewBtn').isVisible()).toBe(false);
  });

  test('W4 — Preview auto-jumps to the earliest failing step', async ({ page }) => {
    /* Fill steps 1–4 properly, then deliberately blank a required field on
       step 3 (about_company) and try to Preview from step 5. */
    await page.goto('/post-job-page');
    await page.waitForSelector('#jobTitle');

    const s = minimalScenario('W4');
    await fillJobForm(page, s);

    /* Jump to step 5 — bypasses validation. */
    await page.evaluate(() => (window as any).ZnpPostJob.gotoStep(5, { validate: false }));
    expect(await currentStep(page)).toBe(5);

    /* Blank out about_company so step-3 validation will fail. */
    await page.evaluate(() => {
      const el = document.querySelector('[name=about_company]') as HTMLTextAreaElement;
      el.value = '';
    });

    /* Click Preview — should fail validation and jump back to step 3. */
    await page.evaluate(() => (window as any).ZnpPostJob.showPreview());

    expect(await currentStep(page)).toBe(3);
    const aboutErr = await page.evaluate(() => {
      const f = document.querySelector('[name=about_company]')?.closest('.field');
      return f?.querySelector('.field-error.live')?.textContent || '';
    });
    expect(aboutErr).toContain('About the company');
  });

  test('W6 — No interview-mode preselect; unticking + Next shows error', async ({ page }) => {
    await page.goto('/post-job-page');
    await page.waitForSelector('#jobTitle');

    /* On fresh load, no interview mode should be ticked. */
    const initiallyChecked = await page.locator('input[name="interview_modes[]"]:checked').count();
    expect(initiallyChecked).toBe(0);

    /* Fill everything else for step 1, leave interview modes blank, click Next. */
    await fillStep1Minimum(page);
    /* fillStep1Minimum auto-ticks one interview mode; uncheck it. */
    await page.evaluate(() => {
      document.querySelectorAll('input[name="interview_modes[]"]:checked').forEach((cb: any) => {
        cb.checked = false;
        cb.dispatchEvent(new Event('change', { bubbles: true }));
      });
    });

    await page.evaluate(() => (window as any).ZnpPostJob.nextStep());
    expect(await currentStep(page)).toBe(1);
    const fieldErr = await page.evaluate(() =>
      document.getElementById('interviewModesField')?.classList.contains('has-error')
    );
    expect(fieldErr).toBe(true);
  });

  test('W7 — Profile Requirements default empty; Next on step 5 blocks until one is ticked', async ({ page }) => {
    await page.goto('/post-job-page');
    await page.waitForSelector('#jobTitle');

    /* Nothing preselected on a fresh page. */
    const initiallyChecked = await page.locator('input[name="profile_requirements[]"]:checked').count();
    expect(initiallyChecked).toBe(0);

    const s = minimalScenario('W7');
    s.profile_requirements = []; // explicitly empty

    await fillJobForm(page, s);
    /* The fillJobForm default would tick one — undo that to actually test gating. */
    await page.evaluate(() => {
      document.querySelectorAll('input[name="profile_requirements[]"]:checked').forEach((cb: any) => {
        cb.checked = false;
        cb.dispatchEvent(new Event('change', { bubbles: true }));
      });
    });

    /* Jump to step 5 and click Preview — should fail with the new validation. */
    await page.evaluate(() => (window as any).ZnpPostJob.gotoStep(5, { validate: false }));
    await page.evaluate(() => (window as any).ZnpPostJob.showPreview());

    expect(await currentStep(page)).toBe(5);
    const fieldErr = await page.evaluate(() =>
      document.getElementById('profileReqsField')?.classList.contains('has-error')
    );
    expect(fieldErr).toBe(true);

    /* Ticking one + retrying advances cleanly.
       Use evaluate so smooth-scrolling from _renderStep doesn't race with .check(). */
    await page.evaluate(() => {
      const cb = document.querySelector('input[name="profile_requirements[]"][value="Expected CTC"]') as HTMLInputElement;
      cb.checked = true;
      cb.dispatchEvent(new Event('change', { bubbles: true }));
    });
    await page.evaluate(() => (window as any).ZnpPostJob.showPreview());
    const overlayShown = await page.evaluate(() =>
      document.getElementById('pjPreviewOverlay')?.classList.contains('show')
    );
    expect(overlayShown).toBe(true);
  });

  test('W8 — Client Industry is required when Hiring for a Client', async ({ page }) => {
    await page.goto('/post-job-page');
    await page.waitForSelector('#jobTitle');

    /* The label should carry the visual asterisk now. */
    const labelHtml = await page.evaluate(() => {
      const sel = document.querySelector('[name=client_industry]');
      const lbl = sel?.closest('.field')?.querySelector('.flabel');
      return lbl?.innerHTML || '';
    });
    expect(labelHtml).toContain('Client Industry');
    expect(labelHtml).toContain('class="req"');

    /* Fill step 1, switch to client, leave industry blank, click Next. */
    await fillStep1Minimum(page);
    await page.evaluate(() => {
      const sel = document.getElementById('postingTypeSelect') as HTMLSelectElement;
      sel.value = 'client';
      sel.dispatchEvent(new Event('change', { bubbles: true }));
    });
    /* Both client fields should now be visible. */
    expect(await page.locator('#clientPanel').isVisible()).toBe(true);

    await page.evaluate(() => (window as any).ZnpPostJob.nextStep());
    expect(await currentStep(page)).toBe(1);
    /* _markError adds has-error to the element itself. */
    const industryErr = await page.evaluate(() =>
      document.querySelector('[name=client_industry]')?.classList.contains('has-error')
    );
    expect(industryErr).toBe(true);
  });

  test('W9 — Pasted Word-styled HTML in Description is sanitised', async ({ page }) => {
    await page.goto('/post-job-page');
    /* #jobDesc lives in step 2 which is hidden by default; wait for the DOM
       attachment instead of visibility. */
    await page.waitForSelector('#jobDesc', { state: 'attached' });

    /* Simulate a Word-paste by directly invoking _sanitizeRich (which the
       paste handler runs). Easier than triggering a real clipboard event. */
    const dirty =
      '<p class="MsoNormal" style="color:red;background:yellow;font-family:Calibri;">' +
      '<strong style="font-size:48px">Hello</strong>' +
      '<span style="mso-spacerun:yes">&nbsp;&nbsp;</span>' +
      'world<script>alert(1)</script><img src="x" onerror="alert(2)">' +
      '</p>';
    const cleaned = await page.evaluate(
      (d) => (window as any).ZnpPostJob._sanitizeRich(d),
      dirty
    );

    /* Whitelist preserved. */
    expect(cleaned).toContain('<p>');
    expect(cleaned).toContain('<strong>Hello</strong>');
    expect(cleaned).toContain('world');
    /* Junk stripped. */
    expect(cleaned.toLowerCase()).not.toContain('mso');
    expect(cleaned.toLowerCase()).not.toContain('style');
    expect(cleaned.toLowerCase()).not.toContain('script');
    expect(cleaned.toLowerCase()).not.toContain('onerror');
    expect(cleaned.toLowerCase()).not.toContain('<img');
    expect(cleaned.toLowerCase()).not.toContain('class=');
  });

  test('W5 — Indicator state cycles done / active / idle as you advance', async ({ page }) => {
    await page.goto('/post-job-page');
    await page.waitForSelector('#jobTitle');

    const s = minimalScenario('W5');
    await fillJobForm(page, s);

    /* Step 1 active, rest idle. */
    let snapshot = await stepNumState(page);
    expect(snapshot).toEqual(['active', 'idle', 'idle', 'idle', 'idle']);

    await page.evaluate(() => (window as any).ZnpPostJob.nextStep());
    snapshot = await stepNumState(page);
    expect(snapshot).toEqual(['done', 'active', 'idle', 'idle', 'idle']);

    await page.evaluate(() => (window as any).ZnpPostJob.gotoStep(4, { validate: false }));
    snapshot = await stepNumState(page);
    expect(snapshot).toEqual(['done', 'done', 'done', 'active', 'idle']);

    await page.evaluate(() => (window as any).ZnpPostJob.gotoStep(5, { validate: false }));
    snapshot = await stepNumState(page);
    expect(snapshot).toEqual(['done', 'done', 'done', 'done', 'active']);
  });
});

/* ─── Helpers ─────────────────────────────────────────────────────────── */

async function currentStep(page: import('@playwright/test').Page): Promise<number> {
  return page.evaluate(() => Number((window as any).ZnpPostJob._step));
}

/** Pull just the active/done/idle class for each step-num, in order. */
async function stepNumState(page: import('@playwright/test').Page): Promise<string[]> {
  return page.evaluate(() =>
    Array.from(document.querySelectorAll('#pjSteps .step-num')).map((n) => {
      if (n.classList.contains('done'))   return 'done';
      if (n.classList.contains('active')) return 'active';
      return 'idle';
    })
  );
}

/**
 * Fill ONLY the step-1 required fields. Used by tests that want to navigate
 * to step 2 without filling the entire form.
 */
async function fillStep1Minimum(page: import('@playwright/test').Page): Promise<void> {
  await page.evaluate(() => {
    const set = (sel: string, val: any) => { const el = document.querySelector(sel) as any; if (el) { el.value = String(val); el.dispatchEvent(new Event('input', { bubbles: true })); el.dispatchEvent(new Event('change', { bubbles: true })); } };
    set('#jobTitle', 'Wizard W2 Test');
    set('#workModeSelect', 'Work from Office');
    set('#jobTypeSelect',  'Full Time / Permanent');
    set('[name=job_shift]', 'General Shift (9 AM – 6 PM)');
    set('#salMin', 10);
    set('#salMax', 15);
    set('[name=no_of_openings]', 1);
    set('#expMin', 2);
    set('[name=primary_language]', 'English');
    set('#postingTypeSelect', 'direct');
    /* Skills */
    const sk = document.getElementById('chooseskill') as HTMLSelectElement;
    if (sk) {
      sk.innerHTML = '';
      const o = document.createElement('option');
      o.value = 'Wizard'; o.text = 'Wizard'; o.selected = true;
      sk.appendChild(o);
      sk.dispatchEvent(new Event('change', { bubbles: true }));
    }
    /* Location */
    const loc = document.getElementById('locationFilter41') as HTMLSelectElement;
    if (loc) {
      loc.innerHTML = '';
      const o = document.createElement('option');
      o.value = 'Bengaluru'; o.text = 'Bengaluru'; o.selected = true;
      loc.appendChild(o);
      loc.dispatchEvent(new Event('change', { bubbles: true }));
    }
    /* Interview mode */
    const im = document.querySelector('input[name="interview_modes[]"][value="Video Interview"]') as HTMLInputElement;
    if (im) { im.checked = true; im.dispatchEvent(new Event('change', { bubbles: true })); }
  });
}

function minimalScenario(label: string): Scenario {
  return {
    label,
    job_title: `Wizard ${label} — ${Date.now()}`,
    work_mode: 'Work from Office',
    job_type:  'Full Time / Permanent',
    job_shift: 'General Shift (9 AM – 6 PM)',
    min_salary: 10, max_salary: 15,
    no_of_openings: 1,
    exp_min: 2, exp_max: 4,
    primary_language: 'English',
    posting_type: 'direct',
    locations: ['Bengaluru'],
    skills: ['Wizard'],
    interview_modes: ['Video Interview'],
    job_description_html: '<p>Wizard scenario description.</p>',
    job_overview_html: '<p>Wizard scenario overview.</p>',
    about_company: 'Wizard scenario about.',
    website_host: 'wizard.example.com',
  };
}
