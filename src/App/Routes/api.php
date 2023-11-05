<?php

use Core\Router;
use App\Http\Controllers\HelloController;
use Symfony\Component\HttpFoundation\{Request, Response};

Router::get('/hello', [HelloController::class, 'sayHello']);
Router::get('/hello/{name}', [HelloController::class, 'index']);

// Closures
Router::get('/test/{testId}', function (Request $request, $testId) {
    return new Response("This is the test with id: $testId");
});

Router::get('/test', function () {
    return new Response("This is a test");
});
