<?php
// Autoload core files using namespaces and PSR-4 autoloading
use app\controllers\HomeController;
use app\controllers\PoolController;
use app\controllers\GiftController;
use app\controllers\TicketController;
use app\controllers\UserController;
use app\controllers\BalanceController;
use app\controllers\UserBalanceController;
use app\controllers\UserTicketController;
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
$router->add('/api/v1/pool/inform', [new PoolController(), 'inform']);
$router->add('/api/v1/pool/create', [new PoolController(), 'store']);
$router->add('/api/v1/gift/create', [new GiftController(), 'store']);
$router->add('/api/v1/ticket/create', [new TicketController(), 'store']);
$router->add('/api/v1/ticket/purchase', [new UserTicketController(), 'store']);
$router->add('/api/v1/ticket/inform', [new UserTicketController(), 'inform']);
$router->add('/api/v1/user/create', [new UserController(), 'store']);
$router->add('/api/v1/balance/create', [new BalanceController(), 'store']);
$router->add('/api/v1/user/balance', [new UserBalanceController(), 'store']);

// Get the requested URL
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Dispatch the route
$router->dispatch($url);
