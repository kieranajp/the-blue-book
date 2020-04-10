<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Repository;

use PDO;
use BlueBook\Domain\Ingredients\Ingredient;
use BlueBook\Domain\Ingredients\IngredientIdInterface;
use BlueBook\Infrastructure\Persistence\Hydrator\HydratorInterface;
use BlueBook\Domain\Ingredients\Repository\IngredientsRepositoryInterface;
use Ds\Vector;
use PDOException;
use Psr\Log\LoggerInterface;
use BlueBook\Infrastructure\Persistence\Queries\Ingredients\GetIngredients;
use BlueBook\Infrastructure\Persistence\Queries\Ingredients\SaveIngredient;
use BlueBook\Infrastructure\Persistence\Queries\Ingredients\GetIngredientById;

class PDOIngredientsRepository implements IngredientsRepositoryInterface
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
        $stmt = (new GetIngredients($this->connection))->execute();

        $ingredients = new Vector();
        while ($row = $stmt->fetch()) {
            $ingredients->push($this->hydrator->hydrate($row));
        }

        return $ingredients;
    }

    /**
     * @inheritdoc
     */
    public function find(IngredientIdInterface $ingredientId): Ingredient
    {
        $stmt = (new GetIngredientById($this->connection))->execute();
        return $this->hydrator->hydrate($stmt->fetch());
    }

    /**
     * @inheritdoc
     */
    public function save(Ingredient $ingredient): bool
    {
        return (new SaveIngredient($this->connection))->execute($ingredient);
    }
}
