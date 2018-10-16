<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Router;

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
    }

    public function map(string $method, string $path, string $handler): void
    {
        $this->router->map($method, $path, $handler);
    }

    public function dispatch(): ResponseInterface
    {
        $request = $this->container->get(ServerRequestInterface::class);

        return $this->router->dispatch($request);
    }
}
