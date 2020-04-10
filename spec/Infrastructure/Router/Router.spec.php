<?php declare(strict_types=1);

use BlueBook\Infrastructure\Router\Middleware\LoggerMiddleware;
use BlueBook\Infrastructure\Router\Router;
use League\Container\Container;
use League\Route\Router as LeagueRouter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

$stubMiddleware = new class implements MiddlewareInterface {
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($request);
    }
};

describe(Router::class, function () use ($stubMiddleware) {

    it('defers mapping routes', function () use ($stubMiddleware) {
        $method = 'POST';
        $path = '/banana';
        $handler = 'BananaHandler';

        $baseRouter = new LeagueRouter();
        allow($baseRouter)->toReceive('map')
            ->with($method, $path, $handler);

        allow(Container::class)
            ->toReceive('get')
            ->with('middleware')
            ->andReturn([$stubMiddleware]);

        expect(
            (new Router(new Container()))
                ->map($method, $path, $handler)
        )->toBeEmpty();
    });

    it('defers dispatching requests', function () use ($stubMiddleware) {
        $request = new ServerRequest();
        $baseRouter = new LeagueRouter();

        allow($baseRouter)->toReceive('dispatch')
            ->with($request)
            ->andReturn(new Response());

        allow($baseRouter)->toReceive('middleware')
            ->with($stubMiddleware);

        allow(Container::class)->toReceive('get')
            ->with('middleware')
            ->andReturn([$stubMiddleware]);

        allow(Container::class)->toReceive('get')
            ->with(ServerRequestInterface::class)
            ->andReturn($request);

        expect(
            (new Router(new Container()))
                ->dispatch()
        )->toBeAnInstanceOf(Response::class);
    });
});
