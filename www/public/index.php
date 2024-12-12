<?php
// Autoload core files using namespaces and PSR-4 autoloading
use app\controllers\HomeController;
use app\controllers\PoolController;
use app\controllers\GiftController;
use core\Router;

spl_autoload_register(function($class) {
    $file = '../' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

$router = new Router();

// Define routes
$router->add('/', [new HomeController(), 'index']);
$router->add('/api/v1/pool', [new PoolController(), 'index']);
$router->add('/api/v1/pool/create', [new PoolController(), 'store']);
$router->add('/api/v1/gift/create', [new GiftController(), 'store']);


// Get the requested URL
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Dispatch the route
$router->dispatch($url);
