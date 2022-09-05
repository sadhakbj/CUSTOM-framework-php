<?php

declare(strict_types=1);

namespace App\Core;

use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\HttpKernel\Controller\{ArgumentResolverInterface, ControllerResolverInterface};
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class Application
{
    public function __construct(
        private readonly UrlMatcherInterface $matcher,
        private readonly ControllerResolverInterface $controllerResolver,
        private readonly ArgumentResolverInterface $argumentResolver
    ) {
    }

    public function handle(Request $request)
    {
        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->controllerResolver->getController($request);
            $arguments  = $this->argumentResolver->getArguments($request, $controller);

            return call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $exception) {
            return new Response('Not Found', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            return new Response('Internal server error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
