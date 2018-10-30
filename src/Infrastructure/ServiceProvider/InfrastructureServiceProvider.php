<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\ServiceProvider;

use BlueBook\Infrastructure\Database\PostgresHealthCheck;
use BlueBook\Infrastructure\Router\Middleware\LoggerMiddleware;
use Gentux\Healthz\Healthz;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Fractal\Manager;
use Monolog\Formatter\LogstashFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

final class InfrastructureServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        'emitter',
        'fractal',
        Stopwatch::class,
        LoggerInterface::class,
        LoggerMiddleware::class,
        LoggerAwareInterface::class,
        ServerRequestInterface::class,
        Healthz::class,
    ];

    /**
     * @inheritdoc
     */
    public function register(): void
    {
        $container = $this->getContainer();

        $container->add('emitter', SapiEmitter::class);
        $container->add('fractal', Manager::class);
        $container->add(ServerRequestInterface::class, function (): ServerRequestInterface {
            return ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
            );
        });

        $container->add(Healthz::class)
            ->addMethodCall('push', [PostgresHealthCheck::class]);

        $container->add(StreamHandler::class, function (): StreamHandler {
            return (new StreamHandler(getenv('LOG_STREAM')))
                ->setFormatter(new LogstashFormatter(getenv('APP_NAME')));
        });

        $container->add(Stopwatch::class);

        $container->add(LoggerInterface::class, Logger::class)
            ->addArgument(getenv('APP_NAME'))
            ->addMethodCall('pushHandler', [ StreamHandler::class ]);

        $container->add(LoggerMiddleware::class)
            ->addArgument(LoggerInterface::class)
            ->addArgument(Stopwatch::class);

        $container->inflector(LoggerAwareInterface::class)
            ->invokeMethod('setLogger', [ LoggerInterface::class ]);
    }
}
