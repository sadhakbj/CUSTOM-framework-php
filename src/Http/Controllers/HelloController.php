<?php

namespace App\Http\Controllers;


use Symfony\Component\HttpFoundation\Response;

class HelloController
{
    public function index(string $name): Response
    {
        return new Response("Hello $name");
    }

}
