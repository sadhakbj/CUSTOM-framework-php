<?php

declare(strict_types=1);

use App\Core\Router;
use App\Http\Controllers\HelloController;
use Symfony\Component\Routing\{Route, RouteCollection};




// Router::get('/hello', [HelloController::class, 'sayHello']);
// Router::get('/hello/{name}', [HelloController::class, 'index']);

require_once __DIR__ . "/api.php";


$routes = new RouteCollection();
foreach (Router::getRoutes() as $route) {
    $routes->add(md5(serialize($route)), $route);
}


return $routes;
