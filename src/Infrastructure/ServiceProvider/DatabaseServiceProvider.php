<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\ServiceProvider;

use BlueBook\Domain\Ingredients\Repository\IngredientsHydrator;
use BlueBook\Domain\Ingredients\Repository\IngredientsRepository;
use BlueBook\Domain\Ingredients\Repository\IngredientsRepositoryInterface;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use PDO;

class DatabaseServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        IngredientsHydrator::class,
        IngredientsRepositoryInterface::class,
    ];

    /**
     * @inheritdoc
     */
    public function register()
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $container->add(PDO::class)
            ->addArgument(sprintf(
                'pgsql:host=%s;port=%s;dbname=%s;user=%s;password=%s',
                getenv('DB_HOST'),
                getenv('DB_PORT') ?: '5432',
                getenv('DB_NAME'),
                getenv('DB_USER'),
                getenv('DB_PASS')
            ));

        $container->add(IngredientsHydrator::class);

        $container->add(IngredientsRepositoryInterface::class, IngredientsRepository::class)
            ->addArgument(PDO::class)
            ->addArgument(IngredientsHydrator::class);
    }
}
