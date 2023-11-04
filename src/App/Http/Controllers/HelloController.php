<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;

class HelloController
{
    public function sayHello(): JsonResponse
    {
        return new JsonResponse(["Hello welcome to my app"]);
    }
    public function index(string $name): JsonResponse
    {
        return new JsonResponse("Hello $name");
    }
}
