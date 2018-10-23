<?php declare(strict_types=1);

use BlueBook\Infrastructure\Router\Router;
use League\Container\Container;
use League\Route\Router as LeagueRouter;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

describe(Router::class, function () {

    it('defers mapping routes', function () {
        $method = 'POST';
        $path = '/banana';
        $handler = 'BananaHandler';

        $baseRouter = new LeagueRouter;

        allow($baseRouter)->toReceive('map')
            ->with($method, $path, $handler);

        expect(
            (new Router(new Container))
                ->map($method, $path, $handler)
        )->toBe(null);
    });

    it('defers dispatching requests', function () {
        $request = new ServerRequest;
        $baseRouter = new LeagueRouter;
        $container = new Container;

        allow($baseRouter)->toReceive('dispatch')
            ->with($request)
            ->andReturn(new Response);

        allow($container)->toReceive('get')
            ->andReturn($request);

        expect(
            (new Router($container))
                ->dispatch()
        )->toBeAnInstanceOf(Response::class);
    });

});

