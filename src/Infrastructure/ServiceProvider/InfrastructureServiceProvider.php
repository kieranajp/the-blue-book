<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\ServiceProvider;

use League\Container\Container;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\ResponseFactoryInterface;
use League\Fractal\Serializer\DataArraySerializer;
use BlueBook\Infrastructure\Persistence\PostgresHealthCheck;
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

final class InfrastructureServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Stopwatch::class,
        LoggerInterface::class,
        LoggerAwareInterface::class,
        ServerRequestInterface::class,
        ResponseFactoryInterface::class,
        Healthz::class,
    ];

    /**
     * @inheritdoc
     */
    public function register(): void
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $psr17Factory = new Psr17Factory();
        $container->add(ResponseFactoryInterface::class, $psr17Factory);
        $container->add(ServerRequestInterface::class, function () use ($psr17Factory): ServerRequestInterface {
            return (new ServerRequestCreator($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory))
                ->fromGlobals();
        });

        $container->share(Manager::class, function (): Manager {
            return (new Manager())
                ->setSerializer(new DataArraySerializer());
        });

        $container->add(Healthz::class)
            ->addMethodCall('push', [PostgresHealthCheck::class]);

        $container->add(StreamHandler::class)
            ->addArgument(getenv('LOG_STREAM'))
            ->addMethodCall('setFormatter', [ new LogstashFormatter(getenv('APP_NAME') ?: '') ])
            ->addMethodCall('setLevel', [ getenv('LOG_LEVEL') ]);

        $container->add(Stopwatch::class);

        $container->add(LoggerInterface::class, Logger::class)
            ->addArgument(getenv('APP_NAME'))
            ->addMethodCall('pushHandler', [ StreamHandler::class ]);

        $container->inflector(LoggerAwareInterface::class)
            ->invokeMethod('setLogger', [ LoggerInterface::class ]);
    }
}
