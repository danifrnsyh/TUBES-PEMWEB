<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// maintenance mode (sesuai struktur InfinityFree)
if (file_exists($maintenance = __DIR__.'/laravel_app/storage/framework/maintenance.php')) {
    require $maintenance;
}

// autoload composer
require __DIR__.'/../vendor/autoload.php';

// bootstrap laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
