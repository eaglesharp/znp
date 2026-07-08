<?php

/**
 * Creates (or refreshes) the test company used by the e2e suite.
 *
 *  Reads the desired email/password from tests/e2e/.env so the seeded
 *  account always matches what the Playwright tests will try to log in as.
 *
 *  Usage (from repo root):
 *      php tests/e2e/seed-local-company.php
 *
 *  Idempotent — safe to re-run; updates password + active flags each time.
 */

require __DIR__ . '/../../vendor/autoload.php';

$app = require __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

/* Parse tests/e2e/.env (no need to pull in another lib). */
$envPath = __DIR__ . '/.env';
if (! file_exists($envPath)) {
    fwrite(STDERR, "tests/e2e/.env not found. Copy .env.example to .env first.\n");
    exit(1);
}
$env = [];
foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    if (preg_match('/^\s*#/', $line)) continue;
    if (! str_contains($line, '=')) continue;
    [$k, $v] = explode('=', $line, 2);
    $env[trim($k)] = trim($v);
}

$email = $env['COMPANY_EMAIL'] ?? 'znp_pj_test@example.com';
$pwd   = $env['COMPANY_PASSWORD'] ?? 'TestPass123!';

$existing = DB::table('companies')->where('email', $email)->first();
if ($existing) {
    DB::table('companies')->where('id', $existing->id)->update([
        'password'        => Hash::make($pwd),
        'email_verified'  => 1,
        'is_active'       => 1,
        'status'          => 1,
        'updated_at'      => now(),
    ]);
    echo "Refreshed existing test company id={$existing->id} ({$email})\n";
    exit(0);
}

$id = DB::table('companies')->insertGetId([
    'name'              => 'ZNP E2E Test Company',
    'email'             => $email,
    'password'          => Hash::make($pwd),
    'phone'             => '9999999999',
    'status'            => 1,
    'is_active'         => 1,
    'email_verified'    => 1,
    'email_verified_at' => now(),
    'created_at'        => now(),
    'updated_at'        => now(),
]);

echo "Created test company id={$id} ({$email})\n";
echo "You can now run:  cd tests/e2e && npm test\n";
