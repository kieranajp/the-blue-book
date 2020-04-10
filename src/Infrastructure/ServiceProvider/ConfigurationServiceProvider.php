<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\ServiceProvider;

use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ConfigurationServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        'config.app',
        'config.database',
        'config.logger',
    ];

    public function register()
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $container->add('config.app', function (): array {
            return [
                'env'  => getenv('APP_ENV') ?: 'local',
                'name' => getenv('APP_NAME'),
            ];
        });

        $container->add('config.database', function (): array {
            return [
                'scheme' => 'tcp',
                'host' => getenv('DB_HOST'),
                'port' => getenv('DB_PORT') ?: '3306',
                'name' => getenv('DB_NAME'),
                'user' => getenv('DB_USER'),
                'pass' => getenv('DB_PASS'),
            ];
        });

        $container->add('config.logger', function (): array {
            return [
                'level' => getenv('LOG_LEVEL') ?: 'warning',
            ];
        });
    }
}
