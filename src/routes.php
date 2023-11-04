<?php

declare(strict_types=1);

use Core\Router;
use Symfony\Component\Routing\{RouteCollection};

require_once __DIR__."/api.php";


$routes = new RouteCollection();
foreach (Router::getRoutes() as $route) {
    if ( is_callable($route->getDefaults()['_controller']) ) {
        $routes->add(md5($route->getPath()), $route);
    } else {
        $routes->add(md5(serialize($route)), $route);
    }
}


return $routes;
