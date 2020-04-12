<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Repository;

use PDO;
use Ds\Vector;
use Psr\Log\LoggerInterface;
use BlueBook\Domain\Recipes\Recipe;
use BlueBook\Domain\Recipes\RecipeId;
use BlueBook\Domain\Recipes\Repository\RecipesRepositoryInterface;
use BlueBook\Infrastructure\Persistence\Hydrator\HydratorInterface;
use BlueBook\Infrastructure\Persistence\Queries\Recipes\GetRecipeById;
use BlueBook\Infrastructure\Persistence\Queries\Recipes\IncludeRecipeIngredients;

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
    public function find(RecipeId $recipeId, array $includes = []): Recipe
    {
        $results = (new GetRecipeById($this->connection))->execute($recipeId);

        if (in_array('ingredients', $includes)) {
            $results['ingredients'] = (new IncludeRecipeIngredients($this->connection))->execute($recipeId);
        }

        return $this->hydrator->hydrate($results);
    }
}
