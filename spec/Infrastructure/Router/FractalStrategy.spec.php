<?php declare(strict_types=1);

use BlueBook\Infrastructure\Router\FractalStrategy;
use Http\Factory\Diactoros\ResponseFactory;
use League\Container\Container;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Route\Route;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\ServerRequest;

describe(FractalStrategy::class, function () {

    it('converts an array to a JSON response', function () {
         $responseFactory = new ResponseFactory();
         $strategy = new FractalStrategy($responseFactory);
         $container = new Container();

         allow($strategy)->toReceive('getContainer')
             ->andReturn($container);

         $route = new Route('POST', '/banana', 'BananaHandler');
         $request = new ServerRequest();

         allow($route)->toReceive('getVars')
             ->andReturn([]);
         allow($route)->toReceive('getCallable')
             ->andReturn(function ($request, $vars) {
                 return ['hello', 'banana'];
             });

         $result = $strategy->invokeRouteCallable($route, $request);

        expect($result)->toBeAnInstanceOf(ResponseInterface::class);

        expect((string) $result->getBody())->toContain('banana');
    });

    it('transforms a Resource', function () {
        $responseFactory = new ResponseFactory();
        $strategy = new FractalStrategy($responseFactory);
        $container = new Container();

        allow($strategy)->toReceive('getContainer')
            ->andReturn($container);

        allow($strategy)->toReceive('transformResourceToArray')
            ->andReturn([ 'hello' => 'banana' ]);

        $route = new Route('POST', '/banana', 'BananaHandler');
        $request = new ServerRequest();

        allow($route)->toReceive('getVars')
            ->andReturn([]);
        allow($route)->toReceive('getCallable')
            ->andReturn(function ($request, $vars) {
                return new Collection(['hello' => 'banana']);
            });

        $result = $strategy->invokeRouteCallable($route, $request);

        expect($result)->toBeAnInstanceOf(ResponseInterface::class);

        expect((string) $result->getBody())->toContain('banana');
    });
});
