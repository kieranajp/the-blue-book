<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\ServiceProvider;

use BlueBook\Application\Controller\HealthCheck\HealthCheckController;
use BlueBook\Application\Controller\Ingredients\IndexIngredientsController;
use BlueBook\Application\Transformer\IngredientsTransformer;
use BlueBook\Domain\Ingredients\Repository\IngredientsRepositoryInterface;
use Gentux\Healthz\Healthz;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ApplicationServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        HealthCheckController::class,
        IndexIngredientsController::class,
    ];

    /**
     * @inheritdoc
     */
    public function register()
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $container->add(HealthCheckController::class)
            ->addArgument(Healthz::class);

        $container->add(IndexIngredientsController::class)
            ->addArgument(IngredientsTransformer::class)
            ->addArgument(IngredientsRepositoryInterface::class);
    }
}
