<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\ServiceProvider;

use BlueBook\Domain\Ingredients\Repository\IngredientsHydrator;
use BlueBook\Domain\Ingredients\Repository\IngredientsRepositoryInterface;
use BlueBook\Domain\Recipes\Repository\RecipesHydrator;
use BlueBook\Domain\Recipes\Repository\RecipesRepositoryInterface;
use BlueBook\Infrastructure\Repository\IngredientsRepository;
use BlueBook\Infrastructure\Database\PostgresHealthCheck;
use BlueBook\Infrastructure\Repository\RecipesRepository;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use PDO;
use Psr\Log\LoggerInterface;

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
            getenv('DB_HOST'),
            getenv('DB_PORT') ?: '5432',
            getenv('DB_NAME'),
            getenv('DB_USER'),
            getenv('DB_PASS')
        );

        /** @var Container $container */
        $container = $this->getContainer();

        $container->add(PDO::class)
            ->addArgument($dsn)
            ->addMethodCall('setAttribute', [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION])
            ->setShared(true);

        $container->add(PostgresHealthCheck::class)
            ->addArgument($dsn);

        $container->add(IngredientsHydrator::class);
        $container->add(IngredientsRepositoryInterface::class, IngredientsRepository::class)
            ->addArgument(PDO::class)
            ->addArgument(IngredientsHydrator::class)
            ->addArgument(LoggerInterface::class);

        $container->add(RecipesHydrator::class);
        $container->add(RecipesRepositoryInterface::class, RecipesRepository::class)
            ->addArgument(PDO::class)
            ->addArgument(RecipesHydrator::class)
            ->addArgument(LoggerInterface::class);
    }
}
