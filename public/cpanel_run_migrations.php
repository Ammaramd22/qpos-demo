<?php
/**
 * QPOS — one-time cPanel migration runner (NO TERMINAL needed)
 *
 * HOW TO USE:
 * 1. Change MIGRATE_SECRET below to a random password.
 * 2. Upload this file (already in the ZIP under public/).
 * 3. Open in browser:
 *    https://YOURDOMAIN.com/cpanel_run_migrations.php?key=YOUR_SECRET
 * 4. Wait for "SUCCESS".
 * 5. DELETE this file from the server immediately.
 *
 * This runs: php artisan migrate --force
 * Safe for existing shops — only pending migrations run (does NOT wipe data).
 */

declare(strict_types=1);

// ========== KEY must match the ?key= in the URL ==========
const MIGRATE_SECRET = '12345678';
// Example URL: https://rts-qpos.avenque.io/cpanel_run_migrations.php?key=12345678
// ========================================================

ini_set('display_errors', '1');
ini_set('max_execution_time', '0');
ini_set('memory_limit', '512M');
header('Content-Type: text/plain; charset=utf-8');

$key = $_GET['key'] ?? '';
if (! hash_equals(MIGRATE_SECRET, (string) $key)) {
    http_response_code(403);
    echo "FORBIDDEN — wrong key.\n\n";
    echo "Edit this file in cPanel File Manager:\n";
    echo "  public/cpanel_run_migrations.php\n";
    echo "Set MIGRATE_SECRET to the same value as ?key= in the URL, save, then reload.\n";
    exit;
}

$basePath = dirname(__DIR__);
require $basePath.'/vendor/autoload.php';
$app = require_once $basePath.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Running pending migrations...\n\n";
    $exitCode = Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    echo Illuminate\Support\Facades\Artisan::output();
    echo "\nExit code: {$exitCode}\n";

    if ($exitCode === 0) {
        echo "\nSUCCESS — migrations applied.\n";
        echo "IMPORTANT: Delete this file now:\n";
        echo "  public/cpanel_run_migrations.php\n";
    } else {
        echo "\nFAILED — check the output above / storage/logs/laravel.log\n";
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo "ERROR: ".$e->getMessage()."\n";
    echo $e->getFile().':'.$e->getLine()."\n";
}
