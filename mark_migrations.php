<?php
// Temporary script to mark migrations as run

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

DB::table('migrations')->insertOrIgnore([
    ['migration' => '2024_06_03_000001_create_materis_table', 'batch' => 3],
    ['migration' => '2024_06_03_000002_create_certificates_table', 'batch' => 3]
]);

echo "✅ Migrations marked as run\n";
