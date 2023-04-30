<?php

use App\Core\Router;
use App\Http\Controllers\HelloController;

Router::get('/hello', [HelloController::class, 'sayHello']);
Router::get('/hello/{name}', [HelloController::class, 'index']);
