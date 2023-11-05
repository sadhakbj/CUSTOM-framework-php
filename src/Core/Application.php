<?php

declare(strict_types=1);

namespace Core;

use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};
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

            if (is_callable($controller)) {
                if (is_array($controller) && is_callable($controller[0])) {
                    // Handle the case where the controller is an array, like [MyController::class, 'methodName']
                    $controller[0] = new $controller[0];
                }

                // Execute the controller
                $arguments = $this->argumentResolver->getArguments($request, $controller);
                $response = call_user_func_array($controller, $arguments);
            } else {
                // Handle the case where the controller cannot be resolved
                throw new \Exception('Controller not found');
            }

            return $response;
        } catch (ResourceNotFoundException $exception) {
            return new Response('Not Found', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            $data = [
                'error' => [
                    'message' => 'Internal server error',
                    'exception' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'trace' => $exception->getTraceAsString(),
                ],
            ];

            return new JsonResponse($data, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
