# ZNP End-to-End Tests

Playwright-based browser tests for the Post-a-Job form (and future flows).
Designed so you can re-run anytime, add scenarios in a few lines, and point
the same suite at local / staging / production.

```
tests/e2e/
├── post-job.spec.ts          ← scenarios A–E (create + draft + clone)
├── edit-job.spec.ts          ← EDIT-1 round-trip prefill, EDIT-2 update-in-place
├── clone-regression.spec.ts  ← BUG-1 skill names, BUG-2 profile requirements
├── variety.spec.ts           ← scenarios F–K (wide fan-out, strict mode, etc.)
├── wizard.spec.ts            ← W1–W9 (step gating, validation, paste sanitise)
├── helpers.ts                ← login, fillJobForm, navigateSteps, DB verify
├── seed-local-company.php    ← creates the test login on local
├── playwright.config.ts
├── package.json
└── .env.example              ← copy to .env and edit
```

**24 tests total** — run with `npm test` (headless) or `npm run test:demo` (headed + pauses).

The form is a **5-step wizard**. Tests call `navigateStepsToEnd()` (via `openPreview` / `submitOrPreview`) which clicks **Next** on each step so per-step validation is exercised automatically.

## Web UI (recommended for manual runs)

When `APP_ENV` is **not** `production`, open:

```
http://127.0.0.1:8000/dev/e2e-runner
```

This page lists every test with a plain-English description of what it checks. You can:

- **Run all** — full suite
- **Run selected** — tick checkboxes, then run
- **Run just this** — one scenario at a time
- Watch **live output** in the console panel (polls every ~1.2s)
- **Open last HTML report** when a run finishes (Playwright report with traces/screenshots)

> Blocked automatically on production (`404`). Requires `npm install` in `tests/e2e/` on the machine running Laravel.

## 1. First-time setup (do this once)

```bash
cd tests/e2e
cp .env.example .env             # then edit .env (see "Environments" below)
npm install                      # installs Playwright + mysql2 + dotenv
npm run install:browsers         # downloads the Chromium binaries (~115 MB)
```

For **local** runs, also create the test company once:

```bash
php tests/e2e/seed-local-company.php
```

The script reads `COMPANY_EMAIL` / `COMPANY_PASSWORD` from your `.env`, so
the seeded account always matches what the tests will log in as.
Re-running the script just refreshes the password and active flags.

## 2. Run the tests

```bash
cd tests/e2e

npm test                         # all scenarios, headless (fast — ~12s)
npm run test:headed              # watch the browser, full speed
npm run test:demo                # ⭐ headed + section-by-section pauses
                                 #    + on-screen banner narrating each step
                                 #    Best for watching what the form does.
npm run test:ui                  # interactive Playwright UI (time-travel)
npm test -- -g "A —"             # run only scenario A
npm test -- -g "Clone"           # run only the clone scenario
npm run report                   # open the HTML report after a run
```

### Demo mode tuning

`npm run test:demo` defaults to a 1.5 s pause between major steps and
a 250 ms slow-mo between Playwright actions. Tweak with env vars:

```bash
DEMO=true DEMO_PAUSE_MS=3000 SLOW_MO=500 npm test    # extra slow
DEMO=true DEMO_PAUSE_MS=500 npm test                 # snappier
```

When the run finishes, the HTML report **auto-opens in your default browser**.
You'll also find screenshots / videos / traces under `tests/e2e/test-results/`
and the report itself at `tests/e2e/playwright-report/index.html`.

To disable auto-open (e.g. in CI or on a headless server):

```bash
REPORT_OPEN=never npm test            # never open
REPORT_OPEN=on-failure npm test       # open only when something failed
```

## 3. Environments

The same suite works against any environment — just swap `.env`.
Keep one `.env.local`, `.env.staging`, `.env.prod` per environment and
symlink or copy whichever you need into `.env`.

| Var               | Local                            | Staging                                  | Production                                |
| ----------------- | -------------------------------- | ---------------------------------------- | ----------------------------------------- |
| `BASE_URL`        | `http://127.0.0.1:8000`          | `https://staging.zeronoticeperiod.com`   | `https://zeronoticeperiod.com`            |
| `COMPANY_EMAIL`   | seeded by `seed-local-company.php` | pre-created staging test account       | pre-created prod test account             |
| `COMPANY_PASSWORD`| `TestPass123!`                   | from your secrets manager                | from your secrets manager                 |
| `MODE`            | `submit`                         | `submit` (with cleanup) or `dryrun`      | **`dryrun` — never write to prod**        |
| `HEADED`          | `false` or `true`                | `false`                                  | `false`                                   |
| `CLEANUP_JOBS`    | `true`                           | `true` (requires DB access)              | `false` (no DB access from your laptop)   |
| `DB_*`            | local MySQL                      | staging DB (read-only is fine)           | leave blank                               |

### MODE = `submit` vs `dryrun`

- **`submit`** — fills the form, opens preview, clicks **Confirm**, then verifies
  the new `post_jobs` row column-by-column. Cleans the row up if `CLEANUP_JOBS=true`
  and `DB_*` is set. **Creates real DB rows** — use on local / staging only.
- **`dryrun`** — fills the form, opens the preview overlay, asserts the rendered
  content matches the inputs, then **closes the preview without submitting**.
  No DB writes. Safe for production smoke tests.

The "Save as Draft" scenario is automatically skipped in `dryrun` (drafts always
write to the DB by design).

## 4. Adding a new scenario

Open `post-job.spec.ts` and copy any existing `test('...', ...)` block.
Change the `Scenario` object and the test name — that's it:

```ts
test('F — Walk-in + Fresher role', async ({ page }) => {
  const s: Scenario = {
    label: 'F',
    job_title: 'Trainee Sales Executive (E2E-F)',
    work_mode: 'Work from Office',
    job_type:  'Fresher',
    min_salary: 2, max_salary: 4,
    exp_min: 0, exp_max: 1,
    posting_type: 'direct',
    locations: ['Pune'],
    skills: ['Communication', 'MS Office'],
    interview_modes: ['Walk-in'],
    job_description_html: '<p>Walk-in drive for fresh graduates.</p>',
    job_overview_html: '<p>Any graduate, 2023/2024/2025 batch.</p>',
    about_company: 'High-growth ed-tech.',
    website_host: 'e2e-f-example.com',
  };
  await runScenario(page, s);
});
```

Available knobs are documented in the `Scenario` interface in `helpers.ts`.
Anything you don't set just isn't filled.

## 5. What gets verified

For each `submit`-mode scenario the suite checks the new `post_jobs` row for:

- `job_title`, `is_draft`
- Normalised `work_mode` (UI `"Work from Office"` → DB `"Work From Office"`, etc.)
- Normalised `job_type` (UI `"Full Time / Permanent"` → DB `"Full time/Permanent"`)
- Normalised `interview_modes` (UI `"Video Interview"` → DB `"Video Interviews"`)
- `min_salary`, `max_salary`, `compensation_confidential`
- `posting_type`, `client_name`, `client_industry` (when relevant)
- `contract_day_rate`, `contract_extension` (when contract type)
- `location` (PHP-serialized) contains every chosen city
- `locality`, `about_company`, `website_address` (with `https://` prefix)

Plus the preview overlay is sanity-checked before submit (title, work mode,
job type, first skill all appear).

If you want to extend the column checks, edit `dbVerifyLatestJob()` in
`helpers.ts` — there's one block per column.

## 6. CI integration

Drop this into any CI runner (GitHub Actions, GitLab CI, Jenkins, etc.):

```yaml
- run: php artisan serve --port=8000 &           # start the app
- run: php tests/e2e/seed-local-company.php      # create the test login
- run: cd tests/e2e && npm ci && npm run install:browsers
- run: cd tests/e2e && REPORT_OPEN=never npm test
- uses: actions/upload-artifact@v4               # upload report on failure
  if: failure()
  with:
    name: playwright-report
    path: tests/e2e/playwright-report
```

## 7. Troubleshooting

| Problem | Likely cause / fix |
| --- | --- |
| `Test company "..." not found` | Run `php tests/e2e/seed-local-company.php` (local) or create the account manually in the env. |
| `Preview overlay did not open` | Form has client-side validation errors. Open headed (`npm run test:headed`) to see what's red. |
| `Cannot connect to MySQL` | `DB_*` values in `.env` are wrong. For staging/prod you can leave them blank — verification will be UI-only. |
| `BrowserType.launch: Executable doesn't exist` | Run `npm run install:browsers` once. |
| Tests pass but I see test jobs in `/my-jobs` | Set `CLEANUP_JOBS=true` and provide `DB_*` credentials. |
