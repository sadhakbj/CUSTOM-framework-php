<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HelloController
{
    public function sayHello()
    {
        return new JsonResponse(["Hello welcome to my app"]);
    }
    public function index(string $name): Response
    {
        return new JsonResponse("Hello $name");
    }
}
