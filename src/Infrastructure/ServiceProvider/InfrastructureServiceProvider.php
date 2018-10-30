<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\ServiceProvider;

use BlueBook\Infrastructure\Database\PostgresHealthCheck;
use Gentux\Healthz\Healthz;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Fractal\Manager;
use Monolog\Formatter\LogstashFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareInterface;
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
        Logger::class,
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

        $container->add(Logger::class)
            ->addArgument(getenv('APP_NAME'))
            ->addMethodCall('pushHandler', [ StreamHandler::class ]);

        $container->inflector(LoggerAwareInterface::class)
            ->invokeMethod('setLogger', [ Logger::class ]);
    }
}
