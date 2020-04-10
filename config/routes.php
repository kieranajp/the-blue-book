<?php declare(strict_types=1);

use BlueBook\Infrastructure\Router\Router;
use BlueBook\Application\Welcome\Controller\WelcomeController;
use BlueBook\Application\Recipes\Controller\ShowRecipeController;
use BlueBook\Application\Recipes\Controller\IndexRecipesController;
use BlueBook\Application\HealthCheck\Controller\HealthCheckController;
use BlueBook\Application\Ingredients\Controller\IndexIngredientsController;
use BlueBook\Application\Ingredients\Controller\CreateIngredientController;

/**
 * @param Router $router
 */
return function (Router $router): void {
    $router->map('GET', '/', WelcomeController::class);

    $router->map('GET', '/status', HealthCheckController::class);

    $router->map('GET', '/ingredients', IndexIngredientsController::class);
    $router->map('POST', '/ingredients', CreateIngredientController::class);

    $router->map('GET', '/recipes', IndexRecipesController::class);

    $router->map('GET', '/recipe/{id:uuid}', ShowRecipeController::class);
};
