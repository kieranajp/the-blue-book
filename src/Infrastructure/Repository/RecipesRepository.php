<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Repository;

use BlueBook\Domain\Recipes\Recipe;
use BlueBook\Domain\Recipes\RecipeIdInterface;
use BlueBook\Domain\Recipes\Repository\RecipesRepositoryInterface;
use BlueBook\Infrastructure\Database\HydratorInterface;
use Ds\Vector;
use Psr\Log\LoggerInterface;

class RecipesRepository implements RecipesRepositoryInterface
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * IngredientsRepository constructor.
     *
     * @param \PDO              $connection
     * @param HydratorInterface $hydrator
     * @param LoggerInterface   $logger
     */
    public function __construct(\PDO $connection, HydratorInterface $hydrator, LoggerInterface $logger)
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
            'SELECT * FROM recipes WHERE uuid = :ingredientId LIMIT 1;'
        );

        $stmt->execute([
            ':recipeId' => (string) $recipeId,
        ]);

        $row = $stmt->fetch();

        return $this->hydrator->hydrate($row);
    }
}
