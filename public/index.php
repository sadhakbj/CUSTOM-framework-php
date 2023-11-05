<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use Core\Application;
use Core\Router;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\{Request};
use Symfony\Component\HttpKernel\Controller\{ArgumentResolver, ControllerResolver};
use Symfony\Component\Routing\{Matcher\UrlMatcher, RequestContext};

Debug::enable();


$request = Request::createFromGlobals();
$context = new RequestContext(method: $request->getMethod());
Router::initializeRoutes();
$matcher            = new UrlMatcher(Router::loadRoutes(), $context);
$controllerResolver = new ControllerResolver();
$argumentResolver   = new ArgumentResolver();

$app      = new Application($matcher, $controllerResolver, $argumentResolver);
$response = $app->handle($request);
$response->send();
