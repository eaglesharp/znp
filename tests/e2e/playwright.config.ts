import { defineConfig, devices } from '@playwright/test';
import * as dotenv from 'dotenv';
import * as path from 'path';

// Load .env from this directory (tests/e2e/.env)
dotenv.config({ path: path.resolve(__dirname, '.env') });

const BASE_URL = process.env.BASE_URL || 'http://127.0.0.1:8000';
const DEMO     = process.env.DEMO === 'true';
const HEADED   = process.env.HEADED === 'true' || DEMO;       // demo always headed
const SLOW_MO  = Number(process.env.SLOW_MO || (DEMO ? 250 : 0));

export default defineConfig({
  testDir: '.',
  fullyParallel: false,            // scenarios share state (companies.* auto-save), keep serial
  workers: 1,
  retries: 0,
  timeout: DEMO ? 300_000 : 90_000,
  expect: { timeout: 10_000 },
  reporter: [
    ['list'],
    /* `open: 'always'` auto-launches the HTML report when tests finish.
       Override via env: REPORT_OPEN=never | on-failure | always (default).
       In CI you'll usually want REPORT_OPEN=never. */
    ['html', {
      outputFolder: 'playwright-report',
      open: (process.env.REPORT_OPEN as 'always' | 'never' | 'on-failure') || 'always',
    }],
  ],
  use: {
    baseURL: BASE_URL,
    headless: !HEADED,
    launchOptions: { slowMo: SLOW_MO },
    viewport: { width: 1440, height: 900 },
    ignoreHTTPSErrors: true,
    screenshot: 'only-on-failure',
    trace: 'retain-on-failure',
    video: 'retain-on-failure',
  },
  projects: [
    { name: 'chromium', use: { ...devices['Desktop Chrome'] } },
  ],
});
