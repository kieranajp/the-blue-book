<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Repository;

use PDO;
use Ds\Vector;
use Psr\Log\LoggerInterface;
use BlueBook\Domain\Recipes\Recipe;
use BlueBook\Domain\Recipes\RecipeIdInterface;
use BlueBook\Domain\Recipes\Repository\RecipesRepositoryInterface;
use BlueBook\Infrastructure\Persistence\Hydrator\HydratorInterface;

class PDORecipesRepository implements RecipesRepositoryInterface
{
    private PDO $connection;

    private HydratorInterface $hydrator;

    private LoggerInterface $logger;

    public function __construct(PDO $connection, HydratorInterface $hydrator, LoggerInterface $logger)
    {
        $this->connection = $connection;
        $this->hydrator = $hydrator;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function all(): Vector
    {
        $stmt = $this->connection->prepare(
            'SELECT 
                *,
                EXTRACT(HOUR FROM timing) AS hours,
                EXTRACT(MINUTE FROM timing) AS minutes
            FROM recipes;'
        );

        $stmt->execute();

        $recipes = new Vector();
        while ($row = $stmt->fetch()) {
            $recipes->push($this->hydrator->hydrate($row));
        }

        return $recipes;
    }

    /**
     * @inheritdoc
     */
    public function find(RecipeIdInterface $recipeId): Recipe
    {
        $stmt = $this->connection->prepare(
            'SELECT * FROM recipes WHERE uuid = :recipeId LIMIT 1;'
        );

        $stmt->execute([
            ':recipeId' => (string) $recipeId,
        ]);

        $row = $stmt->fetch();

        return $this->hydrator->hydrate($row);
    }
}
