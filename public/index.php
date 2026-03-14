<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
$autoloadPath = __DIR__.'/../vendor/autoload.php';

if (! file_exists($autoloadPath)) {
    $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
    $normalizedPath = rtrim($requestPath, '/');
    $normalizedPath = $normalizedPath === '' ? '/' : $normalizedPath;

    if ($normalizedPath === '/install') {
        require __DIR__.'/install-bootstrap.php';

        return;
    }

    http_response_code(503);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Dependencies are missing (vendor/autoload.php not found). Run "composer install" or open /install?token=YOUR_INSTALL_TOKEN.';

    return;
}

require $autoloadPath;

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
