<?php

declare(strict_types=1);

namespace Core;

use Symfony\Component\Routing\Route;

class Router
{
    /** @var Route[]  */
    private static array $routes = [];

    public static function get(string $path, $handler): void
    {
        self::add($path, $handler, ['GET']);
    }

    public static function post(string $path, $handler): void
    {
        self::add($path, $handler, ['POST']);
    }

    public static function patch(string $path, $handler): void
    {
        self::add($path, $handler, ['PATCH']);
    }

    public static function delete(string $path, $handler): void
    {
        self::add($path, $handler, ['DELETE']);
    }

    private static function add(string $path, $handler, array $methods): void
    {
        self::$routes[] = new Route(
            $path,
            ['_controller' => $handler],
            [],
            [],
            '',
            [],
            $methods
        );
    }

    /**
     * @return Route[]
     */
    public static function getRoutes(): array
    {
        return self::$routes;
    }
}
