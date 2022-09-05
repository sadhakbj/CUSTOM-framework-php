<?php

namespace Tests;

use App\Core\Application;
use App\Http\Controllers\HelloController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class ApplicationTest extends TestCase
{
    public function testNotFoundHandling()
    {
        $framework = $this->getApplicationForException(new ResourceNotFoundException());
        $response  = $framework->handle(new Request());

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testErrorHandling()
    {
        $framework = $this->getApplicationForException(new \RuntimeException());
        $response  = $framework->handle(new Request());

        $this->assertEquals(500, $response->getStatusCode());
    }

    public function testControllerResponse()
    {
        $matcher   = $this->createMock(UrlMatcherInterface::class);
        $returnVal = [
            '_route'      => 'hello/{name}',
            'name'        => 'World',
            '_controller' => [new HelloController(), 'index'],
        ];
        $matcher->expects($this->once())->method('match')->willReturn($returnVal);
        $controllerResolver = new ControllerResolver();
        $argumentResolver   = new ArgumentResolver();

        $framework = new Application($matcher, $controllerResolver, $argumentResolver);

        $response = $framework->handle(new Request());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Hello World', $response->getContent());
    }

    private function getApplicationForException($exception)
    {
        $matcher = $this->createMock(UrlMatcherInterface::class);
        $matcher->expects($this->once())->method('match')->will($this->throwException($exception));
        $controllerResolver = $this->createMock(ControllerResolverInterface::class);
        $argumentResolver   = $this->createMock(ArgumentResolverInterface::class);

        return new Application($matcher, $controllerResolver, $argumentResolver);
    }
}
