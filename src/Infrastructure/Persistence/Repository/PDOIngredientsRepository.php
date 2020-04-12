<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Repository;

use PDO;
use Ds\Sequence;
use BlueBook\Domain\Ingredients\Ingredient;
use BlueBook\Domain\Ingredients\IngredientId;
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
    public function all(): Sequence
    {
        $results = (new GetIngredients($this->connection))->execute();
        return (new Vector($results))->map(fn(array $ingredient): Ingredient => $this->hydrator->hydrate($ingredient));
    }

    /**
     * @inheritdoc
     */
    public function find(IngredientId $ingredientId): Ingredient
    {
        $results = (new GetIngredientById($this->connection))->execute($ingredientId);
        return $this->hydrator->hydrate($results);
    }

    /**
     * @inheritdoc
     */
    public function save(Ingredient $ingredient): bool
    {
        return (new SaveIngredient($this->connection))->execute($ingredient);
    }
}
