<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\ServiceProvider;

use BlueBook\Infrastructure\Database\PostgresHealthCheck;
use Gentux\Healthz\Healthz;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Fractal\Manager;
use Psr\Http\Message\ServerRequestInterface;
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
    }
}
