<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Router;

use BlueBook\Infrastructure\Router\Middleware\LoggerMiddleware;
use Http\Factory\Diactoros\ResponseFactory;
use League\Container\Container;
use League\Route\Router as LeagueRouter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var LeagueRouter
     */
    private $router;

    /**
     * Router constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;

        $responseFactory = new ResponseFactory();

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
     */
    public function map(string $method, string $path, string $handler): void
    {
        $this->router->map($method, $path, $handler);
    }

    /**
     * Map an incoming request to a route and dispatch it.
     *
     * @return ResponseInterface
     */
    public function dispatch(): ResponseInterface
    {
        $request = $this->container->get(ServerRequestInterface::class);

        return $this->router->dispatch($request);
    }
}
