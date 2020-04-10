<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\ServiceProvider;

use PDO;
use Psr\Log\LoggerInterface;
use League\Container\Container;
use BlueBook\Infrastructure\Persistence\PostgresHealthCheck;
use League\Container\ServiceProvider\AbstractServiceProvider;
use BlueBook\Infrastructure\Persistence\Hydrator\RecipesHydrator;
use BlueBook\Domain\Recipes\Repository\RecipesRepositoryInterface;
use BlueBook\Infrastructure\Persistence\Hydrator\IngredientsHydrator;
use BlueBook\Infrastructure\Persistence\Repository\PDORecipesRepository;
use BlueBook\Domain\Ingredients\Repository\IngredientsRepositoryInterface;
use BlueBook\Infrastructure\Persistence\Repository\PDOIngredientsRepository;

class DatabaseServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        PostgresHealthCheck::class,
        IngredientsHydrator::class,
        IngredientsRepositoryInterface::class,
        RecipesHydrator::class,
        RecipesRepositoryInterface::class,
    ];

    /**
     * @inheritdoc
     */
    public function register()
    {
        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=%s;user=%s;password=%s',
            getenv('DB_HOST') ?: '127.0.0.1',
            getenv('DB_PORT') ?: '5432',
            getenv('DB_NAME') ?: 'recipes',
            getenv('DB_USER') ?: 'root',
            getenv('DB_PASS') ?: '',
        );

        /** @var Container $container */
        $container = $this->getContainer();

        $container->add(PDO::class)
            ->addArgument($dsn)
            ->addMethodCall('setAttribute', [ PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ])
            ->setShared(true);

        $container->add(PostgresHealthCheck::class)
            ->addArgument($dsn);

        $container->add(IngredientsHydrator::class);
        $container->add(IngredientsRepositoryInterface::class, PDOIngredientsRepository::class)
            ->addArgument(PDO::class)
            ->addArgument(IngredientsHydrator::class)
            ->addArgument(LoggerInterface::class);

        $container->add(RecipesHydrator::class);
        $container->add(RecipesRepositoryInterface::class, PDORecipesRepository::class)
            ->addArgument(PDO::class)
            ->addArgument(RecipesHydrator::class)
            ->addArgument(LoggerInterface::class);
    }
}
