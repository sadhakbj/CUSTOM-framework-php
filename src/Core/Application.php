<?php

declare(strict_types=1);

namespace App\Core;

use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\HttpKernel\Controller\{ArgumentResolver, ControllerResolver};
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class Application
{
    public function __construct(
        private readonly UrlMatcher $matcher,
        private readonly ControllerResolver $controllerResolver,
        private readonly ArgumentResolver $argumentResolver
    ) {
    }

    public function handle(Request $request)
    {
        $this->matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->controllerResolver->getController($request);
            $arguments  = $this->argumentResolver->getArguments($request, $controller);

            return call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $exception) {
            return new Response('Not Found', 404);
        }
    }

}
