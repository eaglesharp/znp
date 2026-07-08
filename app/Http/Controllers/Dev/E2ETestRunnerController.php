<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

/**
 * Browser-facing UI for the Playwright E2E suite that ships under tests/e2e/.
 *
 * What this controller does:
 *  - GET  /dev/e2e-runner             → render the catalog UI
 *  - POST /dev/e2e-runner/run         → spawn `npx playwright test ...` in the
 *                                       background; output streams to a log file
 *  - GET  /dev/e2e-runner/log/{runId} → tail the log file (polled by the page)
 *  - GET  /dev/e2e-runner/status/{id} → JSON status: running | finished + exit code
 *
 * The controller never runs in production (see ensureNotProduction()) — it
 * shells out to npm and writes files into storage/app/e2e-runs, which is
 * fine for a developer's local box but obviously not for prod.
 */
class E2ETestRunnerController extends Controller
{
    /** Where runtime logs + meta files live. Created on first run. */
    private const RUN_DIR = 'e2e-runs';

    /** Absolute path to the tests/e2e folder — the cwd we pass to npx. */
    private function e2eDir(): string
    {
        return base_path('tests/e2e');
    }

    /**
     * Hard-coded catalog of every Playwright test in the suite.
     *
     * Keeping this server-side (instead of parsing the .spec.ts files at
     * runtime) gives us human descriptions, file paths for "view source"
     * links, and stable IDs that the UI can pass back as run targets.
     *
     * To add a new test: add a new entry here, then the test runner will
     * pick it up on the next page load. The `pattern` is what we pass to
     * `npx playwright test -g <pattern>` so it must uniquely identify the
     * test by its title.
     */
    public function catalog(): array
    {
        return [
            /* ───────────── post-job.spec.ts ───────────── */
            [
                'id'    => 'A', 'file' => 'post-job.spec.ts',
                'title' => 'A — Direct + WFO + Full Time + multi-skill',
                'pattern' => 'A — Direct',
                'group' => 'Post a Job',
                'what'  => 'Fills the form for a typical permanent role posted directly by the employer: Work From Office, Full Time/Permanent, 4 skills, 2 locations, 3 interview modes, awards + perks + custom question. Confirms the row lands in post_jobs with every column normalised correctly.',
            ],
            [
                'id'    => 'B', 'file' => 'post-job.spec.ts',
                'title' => 'B — Client + Hybrid + Contract + Day Rate + Confidential pay',
                'pattern' => 'B — Client',
                'group' => 'Post a Job',
                'what'  => 'Tests the "Hiring for a Client" path: client name + industry, Hybrid work mode, 6-month contract with day rate + extension likelihood, and the "Keep compensation confidential" toggle.',
            ],
            [
                'id'    => 'C', 'file' => 'post-job.spec.ts',
                'title' => 'C — Remote/WFH + Internship + no location required',
                'pattern' => 'C — Remote',
                'group' => 'Post a Job',
                'what'  => 'Proves the location field becomes optional when work mode is Remote / WFH (other modes require at least one city). Posts a 3-month remote internship for a fresher.',
            ],
            [
                'id'    => 'D', 'file' => 'post-job.spec.ts',
                'title' => 'D — Save as Draft (only title required)',
                'pattern' => 'D — Save as Draft',
                'group' => 'Post a Job',
                'what'  => 'Clicks "Save as Draft" with only a job title filled. Confirms that drafts skip the regular required-field validation and that the row lands with is_draft=1.',
            ],
            [
                'id'    => 'E', 'file' => 'post-job.spec.ts',
                'title' => 'E — Clone-from-latest carry-over flow',
                'pattern' => 'E — Clone',
                'group' => 'Post a Job',
                'what'  => 'Creates a source job, opens the post-job page again, clicks "Copy details from this job", tweaks only the title and confirms the cloned job saves with the carried-over fields intact.',
            ],

            /* ───────────── edit-job.spec.ts ───────────── */
            [
                'id'    => 'EDIT-1', 'file' => 'edit-job.spec.ts',
                'title' => 'EDIT-1 — Round-trip: create then open edit, every field pre-fills',
                'pattern' => 'EDIT-1',
                'group' => 'Edit a Job',
                'what'  => 'Creates a rich job with every section filled (skills, perks, awards, profile reqs, custom questions, strict mode, video toggle off). Opens /post-job-page/{id}/edit and asserts every visible form field matches what was saved.',
            ],
            [
                'id'    => 'EDIT-2', 'file' => 'edit-job.spec.ts',
                'title' => 'EDIT-2 — Update an existing job changes only that row',
                'pattern' => 'EDIT-2',
                'group' => 'Edit a Job',
                'what'  => 'Creates a job, opens edit, mutates ~10 fields (title, salary, locations, skills, perks, description, etc.), submits and asserts the same row was updated — no duplicate post_jobs entry is inserted.',
            ],

            /* ───────────── clone-regression.spec.ts ───────────── */
            [
                'id'    => 'CLONE-SKILLS', 'file' => 'clone-regression.spec.ts',
                'title' => 'Clone restores skill NAMES (not "Skill #<id>")',
                'pattern' => 'skill NAMES',
                'group' => 'Bug Regressions',
                'what'  => 'Regression for the bug where cloned jobs showed skill chips as literal "Skill #55" because only IDs were sent. Verifies the Select2 option labels after clone are the real skill names.',
            ],
            [
                'id'    => 'CLONE-PROFILE', 'file' => 'clone-regression.spec.ts',
                'title' => 'Clone restores Profile Requirements (Current CTC, etc.)',
                'pattern' => 'Profile Requirements when the',
                'group' => 'Bug Regressions',
                'what'  => 'Regression for the bug where "Current CTC" and other profile fields disappeared after cloning. Toggles the new "Profile Requirements" carry-over pill and verifies the checkboxes are restored.',
            ],

            /* ───────────── variety.spec.ts ───────────── */
            [
                'id'    => 'F', 'file' => 'variety.spec.ts',
                'title' => 'F — Temp WFH + Contract-to-Hire + multi-type custom questions',
                'pattern' => 'F — Temp WFH',
                'group' => 'Variety Scenarios',
                'what'  => 'Exercises a 12-month contract-to-hire with day rate and three custom questions of every type (yes/no, number, free text). Confirms all questions land in the questionnaire JSON.',
            ],
            [
                'id'    => 'G', 'file' => 'variety.spec.ts',
                'title' => 'G — All 10 profile requirements ticked persist exactly',
                'pattern' => 'G — All 10',
                'group' => 'Variety Scenarios',
                'what'  => 'Selects every single profile-requirement checkbox + strict mode and verifies all 10 values are stored verbatim in the profile_requirements JSON column.',
            ],
            [
                'id'    => 'H', 'file' => 'variety.spec.ts',
                'title' => 'H — Video question OFF + Strict mode ON persists in questionnaire JSON',
                'pattern' => 'H — Video',
                'group' => 'Variety Scenarios',
                'what'  => 'Disables the "share video introduction" question via the toggle, turns Strict mode on, and confirms both flags survive the round-trip in the questionnaire JSON + strict_mode column.',
            ],
            [
                'id'    => 'I', 'file' => 'variety.spec.ts',
                'title' => 'I — Wide multi-select fan-out (8 skills, 3 locations, 4 countries, 5 perks)',
                'pattern' => 'I — Wide',
                'group' => 'Variety Scenarios',
                'what'  => 'Stress-tests every multi-select with realistic large counts. Verifies all 8 skills land in manage_job_skills and JSON columns hold every selected value.',
            ],
            [
                'id'    => 'J', 'file' => 'variety.spec.ts',
                'title' => 'J — Special characters in title/description/about preserved exactly',
                'pattern' => 'J — Special',
                'group' => 'Variety Scenarios',
                'what'  => 'Posts a job with Unicode (₹, €, ‒, smart quotes), &amp; entities, &lt;angle brackets&gt; and embedded HTML to confirm the form encodes them safely and the DB stores the original text without corruption.',
            ],
            [
                'id'    => 'K', 'file' => 'variety.spec.ts',
                'title' => 'K — Hybrid + Contract + Walk-in interview mode normalisation',
                'pattern' => 'K — Hybrid',
                'group' => 'Variety Scenarios',
                'what'  => 'Selects the "Walk-in" interview mode (UI label) and confirms it normalises to the legacy DB value "Walkin" so old listing queries still work.',
            ],

            /* ───────────── wizard.spec.ts ───────────── */
            [
                'id'    => 'W1', 'file' => 'wizard.spec.ts',
                'title' => 'W1 — Step gating: empty step 1 blocks Next + shows errors',
                'pattern' => 'W1 — Step gating',
                'group' => 'Step Wizard',
                'what'  => 'Clicks Next on an empty step 1. Confirms the wizard stays on step 1, every required field gets a has-error class, and the inline message ("Job title is required") is rendered.',
            ],
            [
                'id'    => 'W2', 'file' => 'wizard.spec.ts',
                'title' => 'W2 — Free backward jump via step pill',
                'pattern' => 'W2 — Free backward',
                'group' => 'Step Wizard',
                'what'  => 'Fills step 1, advances to step 2, then clicks the step-1 pill. Confirms backward navigation is unconditional (no re-validation) and the indicator repaints correctly.',
            ],
            [
                'id'    => 'W3', 'file' => 'wizard.spec.ts',
                'title' => 'W3 — Step 5 swaps Next for Preview & Post Job',
                'pattern' => 'W3 — Step 5',
                'group' => 'Step Wizard',
                'what'  => 'On the final step the generic "Next" button is hidden and the orange "Preview & Post Job" button appears in the same footer slot — no duplicate CTAs.',
            ],
            [
                'id'    => 'W4', 'file' => 'wizard.spec.ts',
                'title' => 'W4 — Preview auto-jumps to the earliest failing step',
                'pattern' => 'W4 — Preview',
                'group' => 'Step Wizard',
                'what'  => 'Fills the whole form, jumps to step 5, then blanks a required field on step 3. Clicking Preview should detect the missing field and jump the wizard back to step 3 with the error highlighted.',
            ],
            [
                'id'    => 'W5', 'file' => 'wizard.spec.ts',
                'title' => 'W5 — Indicator state cycles done / active / idle',
                'pattern' => 'W5 — Indicator',
                'group' => 'Step Wizard',
                'what'  => 'Walks through every step and asserts the top step indicator paints each pill correctly (done = blue, active = orange, idle = grey).',
            ],
            [
                'id'    => 'W6', 'file' => 'wizard.spec.ts',
                'title' => 'W6 — No interview-mode preselect; unticking + Next shows error',
                'pattern' => 'W6 — No interview',
                'group' => 'Step Wizard',
                'what'  => 'Confirms no interview mode is checked on a fresh form (we removed the Video Interview default). Unticking everything and clicking Next blocks the step.',
            ],
            [
                'id'    => 'W7', 'file' => 'wizard.spec.ts',
                'title' => 'W7 — Profile Requirements default empty; step 5 blocks until one is ticked',
                'pattern' => 'W7 — Profile',
                'group' => 'Step Wizard',
                'what'  => 'Confirms no profile requirement is checked on a fresh form. Trying to preview without ticking any one fails validation — ticking "Expected CTC" then retrying opens the preview overlay.',
            ],
            [
                'id'    => 'W8', 'file' => 'wizard.spec.ts',
                'title' => 'W8 — Client Industry is required when Hiring for a Client',
                'pattern' => 'W8 — Client Industry',
                'group' => 'Step Wizard',
                'what'  => 'Switches posting type to "Hiring for a Client", leaves the industry dropdown empty, clicks Next. Confirms the asterisk renders in the label and validation rejects the missing industry.',
            ],
            [
                'id'    => 'W9', 'file' => 'wizard.spec.ts',
                'title' => 'W9 — Pasted Word-styled HTML in Description is sanitised',
                'pattern' => 'W9 — Pasted',
                'group' => 'Step Wizard',
                'what'  => 'Runs a realistic Word-paste payload (mso-* styles, inline colors, &lt;script&gt;, &lt;img onerror&gt;) through the sanitiser. Confirms only the whitelist (p, strong, em, ul, li, etc.) survives — no styles, scripts or alien attributes.',
            ],
        ];
    }

    /* ─────────────────────────── Page render ─────────────────────────── */

    public function index()
    {
        $this->ensureNotProduction();

        $catalog = $this->catalog();

        /* Group tests by their .group field for the section dividers. */
        $groups = [];
        foreach ($catalog as $row) {
            $groups[$row['group']][] = $row;
        }

        return view('dev.e2e-runner', [
            'catalog' => $catalog,
            'groups'  => $groups,
            'envOk'   => $this->envSummary(),
        ]);
    }

    /* ─────────────────────────── Run a job ──────────────────────────── */

    /**
     * Spawn `npx playwright test` in the background. Returns the run ID
     * the page will poll for log + status.
     *
     * Request body:
     *   - scope: "all" | "selected"
     *   - ids:   ["A", "W7", …]   (only used when scope=selected)
     */
    public function run(Request $request)
    {
        $this->ensureNotProduction();

        /* Force a UTF-8 locale before escapeshellarg() — without it PHP
           strips multi-byte characters (the em-dashes in our test titles
           would vanish and Playwright's -g regex would match nothing). */
        setlocale(LC_CTYPE, 'C.UTF-8', 'C.utf8', 'en_US.UTF-8');

        $scope = (string) $request->input('scope', 'all');
        $ids   = (array)  $request->input('ids', []);

        $cmd = $this->buildCommand($scope, $ids);
        if ($cmd === null) {
            return response()->json(['error' => 'No tests matched the selection.'], 422);
        }

        $runId = date('Ymd_His') . '_' . substr(md5(uniqid('', true)), 0, 6);
        $dir   = $this->runDir();
        $logPath  = $dir . DIRECTORY_SEPARATOR . $runId . '.log';
        $metaPath = $dir . DIRECTORY_SEPARATOR . $runId . '.json';
        $pidPath  = $dir . DIRECTORY_SEPARATOR . $runId . '.pid';

        $meta = [
            'run_id'       => $runId,
            'scope'        => $scope,
            'ids'          => array_values($ids),
            'started_at'   => now()->toIso8601String(),
            'finished_at'  => null,
            'status'       => 'running',
            'exit_code'    => null,
            'command'      => $cmd,
            'log_relative' => self::RUN_DIR . '/' . $runId . '.log',
        ];
        file_put_contents($metaPath, json_encode($meta, JSON_PRETTY_PRINT));

        /* Build a shell one-liner that:
              1. Runs the command, redirecting stdout/stderr to the log
              2. Captures the exit code
              3. Updates the meta file with finished_at + status + exit_code
           We background it with nohup so the HTTP response can return
           immediately while the suite keeps running. */
        $phpBin   = PHP_BINARY;
        $metaEsc  = escapeshellarg($metaPath);
        $logEsc   = escapeshellarg($logPath);
        $pidEsc   = escapeshellarg($pidPath);
        $cmdEsc   = $cmd; /* already pre-escaped by buildCommand */

        $finalizeScript = $this->e2eDir() . DIRECTORY_SEPARATOR . 'finalize-run.php';
        $finalizer = sprintf(
            '%s %s %s',
            escapeshellarg($phpBin),
            escapeshellarg($finalizeScript),
            $metaEsc
        );

        $shell = sprintf(
            'cd %s && ( %s >> %s 2>&1; ec=$?; echo "" >> %s; echo "----- finished (exit $ec) -----" >> %s; %s "$ec" >> %s 2>&1 ) & echo $! > %s',
            escapeshellarg($this->e2eDir()),
            $cmdEsc,
            $logEsc, $logEsc, $logEsc,
            $finalizer,
            $logEsc,
            $pidEsc
        );

        /* Launch detached. We don't wait for it — Process is just a convenient
           way to execute the shell line and capture any immediate spawn error. */
        $proc = Process::fromShellCommandline($shell);
        $proc->disableOutput();
        $proc->setTimeout(null);
        $proc->run();

        return response()->json([
            'run_id'  => $runId,
            'command' => $cmd,
            'count'   => $this->matchedCount($scope, $ids),
        ]);
    }

    /* ─────────────────────── Log + status (polled) ─────────────────────── */

    public function log(string $runId)
    {
        $this->ensureNotProduction();
        $this->validateRunId($runId);

        $logPath = $this->runDir() . DIRECTORY_SEPARATOR . $runId . '.log';
        $contents = file_exists($logPath) ? file_get_contents($logPath) : '';
        return response()->json([
            'run_id' => $runId,
            'log'    => $contents,
            'size'   => strlen($contents),
        ]);
    }

    public function status(string $runId)
    {
        $this->ensureNotProduction();
        $this->validateRunId($runId);

        $metaPath = $this->runDir() . DIRECTORY_SEPARATOR . $runId . '.json';
        if (! file_exists($metaPath)) {
            return response()->json(['error' => 'Run not found'], 404);
        }
        $meta = json_decode(file_get_contents($metaPath), true);

        /* If the background finalizer missed, infer completion from the log
           footer we always append ("----- finished (exit N) -----"). */
        if (($meta['status'] ?? '') === 'running') {
            $logPath = $this->runDir() . DIRECTORY_SEPARATOR . $runId . '.log';
            if (is_file($logPath)) {
                $log = file_get_contents($logPath);
                if (preg_match('/----- finished \(exit (\d+)\) -----/s', $log, $m)) {
                    $ec = (int) $m[1];
                    $meta['status']      = $ec === 0 ? 'passed' : 'failed';
                    $meta['exit_code']   = $ec;
                    $meta['finished_at'] = $meta['finished_at'] ?? now()->toIso8601String();
                    file_put_contents($metaPath, json_encode($meta, JSON_PRETTY_PRINT));
                }
            }
        }

        return response()->json($meta);
    }

    public function cancel(string $runId)
    {
        $this->ensureNotProduction();
        $this->validateRunId($runId);

        $pidPath = $this->runDir() . DIRECTORY_SEPARATOR . $runId . '.pid';
        if (! file_exists($pidPath)) {
            return response()->json(['error' => 'PID file not found'], 404);
        }
        $pid = (int) trim(file_get_contents($pidPath));
        if ($pid > 0) {
            /* Kill the whole shell tree — playwright spawns children. */
            @exec('pkill -P ' . escapeshellarg((string) $pid));
            @posix_kill($pid, defined('SIGTERM') ? SIGTERM : 15);
        }

        $metaPath = $this->runDir() . DIRECTORY_SEPARATOR . $runId . '.json';
        if (file_exists($metaPath)) {
            $j = json_decode(file_get_contents($metaPath), true);
            $j['status']       = 'cancelled';
            $j['finished_at']  = now()->toIso8601String();
            file_put_contents($metaPath, json_encode($j, JSON_PRETTY_PRINT));
        }
        return response()->json(['ok' => true]);
    }

    /**
     * Stream the Playwright HTML report (and its assets) out of
     * tests/e2e/playwright-report/. We can't symlink that folder into
     * public/ from this controller, so we just proxy file reads.
     *
     * Defaults to index.html when no path is supplied. Refuses to escape
     * the report root via "..".
     */
    public function report(?string $path = null)
    {
        $this->ensureNotProduction();

        $base = base_path('tests/e2e/playwright-report');
        if (! is_dir($base)) {
            return response('No Playwright report has been generated yet. Run the suite first.', 404);
        }
        $relative = ltrim($path ?? '', '/');
        if ($relative === '' || substr($relative, -1) === '/') {
            $relative .= 'index.html';
        }

        $full = $base . DIRECTORY_SEPARATOR . $relative;
        $real = realpath($full);
        $baseReal = realpath($base);
        if (! $real || ! $baseReal || strpos($real, $baseReal) !== 0 || ! is_file($real)) {
            abort(404);
        }
        return response()->file($real);
    }

    /* ─────────────────────────── Helpers ─────────────────────────── */

    private function ensureNotProduction(): void
    {
        if (app()->environment('production')) {
            abort(404, 'Not available in production.');
        }
    }

    private function validateRunId(string $runId): void
    {
        if (! preg_match('/^[0-9]{8}_[0-9]{6}_[a-f0-9]{6}$/', $runId)) {
            abort(400, 'Invalid run id.');
        }
    }

    private function runDir(): string
    {
        $dir = storage_path('app' . DIRECTORY_SEPARATOR . self::RUN_DIR);
        if (! is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        return $dir;
    }

    /**
     * Translate the (scope, ids) selection into a single shell-ready
     * `npx playwright test ...` command. Returns null if the selection
     * resolves to zero tests.
     */
    private function buildCommand(string $scope, array $ids): ?string
    {
        $base = 'REPORT_OPEN=never npx playwright test';

        if ($scope === 'all') {
            return $base;
        }

        /* Selected — collect unique patterns + unique files. We use file
           paths to narrow the scope and -g (regex) to pick the titles.
           Playwright's -g is OR-joined when you pass multiple patterns,
           so we build one big alternation. */
        $catalog = collect($this->catalog())->keyBy('id');
        $files = [];
        $patterns = [];
        foreach ($ids as $id) {
            $row = $catalog->get($id);
            if (! $row) continue;
            $files[$row['file']]     = true;
            $patterns[$row['pattern']] = true;
        }

        if (empty($patterns)) {
            return null;
        }

        $fileArgs    = implode(' ', array_map('escapeshellarg', array_keys($files)));
        $patternRegex = '(' . implode('|', array_map(function ($p) {
            return preg_quote($p, '/');
        }, array_keys($patterns))) . ')';

        return $base . ' ' . $fileArgs . ' -g ' . escapeshellarg($patternRegex);
    }

    private function matchedCount(string $scope, array $ids): int
    {
        if ($scope === 'all') return count($this->catalog());
        $catalog = collect($this->catalog())->keyBy('id');
        return collect($ids)->filter(fn ($id) => $catalog->has($id))->count();
    }

    private function envSummary(): array
    {
        $envFile = $this->e2eDir() . DIRECTORY_SEPARATOR . '.env';
        return [
            'e2e_env_exists'   => file_exists($envFile),
            'node_modules_ok'  => is_dir($this->e2eDir() . '/node_modules/@playwright/test'),
            'e2e_dir'          => $this->e2eDir(),
        ];
    }
}
