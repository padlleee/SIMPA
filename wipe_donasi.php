<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

DB::statement('SET FOREIGN_KEY_CHECKS=0;');
DB::table('donasi')->truncate();
DB::statement('SET FOREIGN_KEY_CHECKS=1;');

Artisan::call('db:seed', ['--class' => 'DonasiSeeder']);
echo Artisan::output();
echo "Wiped and seeded donasi.\n";
