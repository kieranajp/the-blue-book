<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\ServiceProvider;

use BlueBook\Application\Controller\HealthCheck\HealthCheckController;
use BlueBook\Application\Controller\Ingredients\IndexIngredientsController;
use BlueBook\Application\Transformer\IngredientsTransformer;
use BlueBook\Domain\Ingredients\Repository\IngredientsRepositoryInterface;
use BlueBook\Infrastructure\Router\Middleware\LoggerMiddleware;
use BlueBook\Infrastructure\Router\Middleware\PaginationMiddleware;
use Gentux\Healthz\Healthz;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Psr\Log\LoggerInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class MiddlewareServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        'middleware',
    ];

    /**
     * @inheritdoc
     */
    public function register()
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $container->add(LoggerMiddleware::class)
            ->addArgument(LoggerInterface::class)
            ->addArgument(Stopwatch::class);

        $container->add('middleware', [
            $container->get(LoggerMiddleware::class),
        ]);
    }
}
