<?php declare(strict_types=1);

use BlueBook\Application\Controller\HealthCheck\HealthCheckController;
use BlueBook\Application\Controller\Ingredients\CreateIngredientController;
use BlueBook\Application\Controller\Ingredients\IndexIngredientsController;
use BlueBook\Application\Controller\Welcome\WelcomeController;
use BlueBook\Infrastructure\Router\Router;

/**
 * @param Router $router
 */
return function (Router $router): void {
    $router->map('GET', '/', WelcomeController::class);

    $router->map('GET', '/status', HealthCheckController::class);

    $router->map('GET', '/ingredients', IndexIngredientsController::class);
    $router->map('POST', '/ingredients', CreateIngredientController::class);
};
