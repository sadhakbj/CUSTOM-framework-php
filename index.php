<?php

require_once __DIR__.'/vendor/autoload.php';

use App\Core\Application;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\{Request};
use Symfony\Component\HttpKernel\Controller\{ArgumentResolver, ControllerResolver};
use Symfony\Component\Routing;

Debug::enable();


$request = Request::createFromGlobals();
$routes  = include __DIR__.'/src/routes.php';

$context            = new Routing\RequestContext();
$matcher            = new Routing\Matcher\UrlMatcher($routes, $context);
$controllerResolver = new ControllerResolver();
$argumentResolver   = new ArgumentResolver();

$app      = new Application($matcher, $controllerResolver, $argumentResolver);
$response = $app->handle($request);
$response->send();
