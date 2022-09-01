<?php

use App\Http\Controllers\HelloController;
use Symfony\Component\Routing;
use Symfony\Component\Routing\Route;

$routes = new Routing\RouteCollection();


$routes->add('hello', new Route('/hello/{name}', [
   '_controller' => [HelloController::class, 'index']
]));

return $routes;
