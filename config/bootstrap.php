<?php declare(strict_types=1);

use BlueBook\Infrastructure\Router\Router;
use League\Container\Container;
use League\Container\ReflectionContainer;

$providers = require_once 'services.php';
$mapRoutes = require_once 'routes.php';

$container = new Container();
$container->delegate((new ReflectionContainer())->cacheResolutions());

$providers->map(function (string $provider) use ($container): void {
    $container->addServiceProvider($provider);
});

$router = new Router($container);
$mapRoutes($router);

$container->get('emitter')->emit($router->dispatch());
