<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\ServiceProvider;

use BlueBook\Application\Common\Middleware\LoggerMiddleware;
use BlueBook\Application\Common\Middleware\ErrorHandlingMiddleware;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Psr\Log\LoggerInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use BlueBook\Application\Common\Middleware\ParseQueryStringMiddleware;

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
            ->addArgument(Stopwatch::class)
            ->addArgument([ 'level' => getenv('LOG_LEVEL') ?: 'warn' ]);

        $container->add('middleware', [
            $container->get(LoggerMiddleware::class),
            $container->get(ErrorHandlingMiddleware::class),
            $container->get(ParseQueryStringMiddleware::class),
        ]);
    }
}
