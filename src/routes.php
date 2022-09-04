<?php

declare(strict_types=1);

use App\Http\Controllers\HelloController;
use Symfony\Component\Routing\{Route, RouteCollection};

$routes = new RouteCollection();

$routes->add(
    'hello',
    new Route(path: '/hello/{name}', defaults: [
        '_controller' => [HelloController::class, 'index'],
    ], methods:     ['DELETE'])
);

return $routes;
