<?php declare(strict_types=1);

use BlueBook\Application\Controller\HealthCheck\HealthCheckController;
use BlueBook\Infrastructure\Router\Router;

return function(Router $router): void {
    $router->map('GET', '/status', HealthCheckController::class);
};
