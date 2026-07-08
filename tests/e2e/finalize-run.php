<?php
/**
 * Called by the E2E Test Runner UI after each Playwright run finishes.
 *
 * Usage: php finalize-run.php /path/to/run.json <exit-code>
 */
$metaPath = $argv[1] ?? '';
$exitCode = (int) ($argv[2] ?? 1);

if ($metaPath === '' || ! is_file($metaPath)) {
    fwrite(STDERR, "finalize-run: meta file not found\n");
    exit(1);
}

$meta = json_decode(file_get_contents($metaPath), true);
if (! is_array($meta)) {
    fwrite(STDERR, "finalize-run: invalid meta JSON\n");
    exit(1);
}

$meta['status']      = $exitCode === 0 ? 'passed' : 'failed';
$meta['exit_code']   = $exitCode;
$meta['finished_at'] = date('c');

file_put_contents($metaPath, json_encode($meta, JSON_PRETTY_PRINT));
