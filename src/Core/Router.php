<?php

declare(strict_types=1);

namespace Core;

use Core\Http\RequestType;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Router
{
    /** @var Route[] */
    private static array $routes = [];

    public static function get(string $path, $handler): void
    {
        self::add($path, $handler, [RequestType::GET->value]);
    }

    public static function post(string $path, $handler): void
    {
        self::add($path, $handler, [RequestType::POST->value]);
    }

    public static function patch(string $path, $handler): void
    {
        self::add($path, $handler, [RequestType::PATCH->value]);
    }

    public static function delete(string $path, $handler): void
    {
        self::add($path, $handler, [RequestType::DELETE->value]);
    }

    private static function add(string $path, $handler, array $methods): void
    {
        self::$routes[] = new Route(
            $path, ['_controller' => $handler], [], [], '', [], $methods
        );
    }

    /**
     * @return Route[]
     */
    public static function getRoutes(): array
    {
        return self::$routes;
    }

    public static function initializeRoutes(): void
    {
        require dirname(__DIR__)."/App/Routes/api.php";
    }

    public static function loadRoutes(): RouteCollection
    {
        $routes = new RouteCollection();
        foreach (Router::getRoutes() as $route) {
            if ( is_callable($route->getDefaults()['_controller']) ) {
                $routes->add(md5($route->getPath()), $route);
            } else {
                $routes->add(md5(serialize($route)), $route);
            }
        }

        return $routes;
    }
}
