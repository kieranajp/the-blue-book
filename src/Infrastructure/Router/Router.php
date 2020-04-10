<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Router;

use League\Container\Container;
use League\Route\Route;
use League\Route\RouteGroup;
use League\Route\Router as LeagueRouter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class Router
{
    /**
     * @var Container
     */
    private Container $container;

    /**
     * @var LeagueRouter
     */
    private LeagueRouter $router;

    /**
     * Router constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $responseFactory = $container->get(ResponseFactoryInterface::class);

        $strategy = new FractalStrategy($responseFactory);
        $strategy->setContainer($container);

        $this->router = new LeagueRouter();
        $this->router->setStrategy($strategy);
        $this->router->middlewares($container->get('middleware'));
    }

    /**
     * Match up routes and controller actions.
     *
     * @param string $method
     * @param string $path
     * @param string $handler
     * @return Route
     */
    public function map(string $method, string $path, string $handler): Route
    {
        $route = $this->router->map($method, $path, $handler);
        $route->setName(substr($handler, ((int) strrpos($handler, '\\')) + 1));
        return $route;
    }

    /**
     * Group routes for convenience
     *
     * @param string $prefix
     * @param callable $callback
     * @return RouteGroup
     */
    public function group(string $prefix, callable $callback): RouteGroup
    {
        return $this->router->group($prefix, $callback);
    }

    /**
     * Map an incoming request to a route and dispatch it.
     *
     * @return ResponseInterface
     */
    public function dispatch(): ResponseInterface
    {
        $request = $this->container->get(ServerRequestInterface::class);

        return $this->router->dispatch($request)->withAddedHeader('Content-Type', 'application/json');
    }
}
