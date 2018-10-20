<?php declare(strict_types=1);

namespace BlueBook\Domain\Ingredients\Repository;

use BlueBook\Domain\Ingredients\Ingredient;
use BlueBook\Domain\Ingredients\IngredientIdInterface;
use BlueBook\Infrastructure\Hydrator\HydratorInterface;

class IngredientsRepository implements IngredientsRepositoryInterface
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
     * IngredientsRepository constructor.
     *
     * @param \PDO              $connection
     * @param HydratorInterface $hydrator
     */
    public function __construct(\PDO $connection, HydratorInterface $hydrator)
    {
        $this->connection = $connection;
        $this->hydrator = $hydrator;
    }

    public function find(IngredientIdInterface $ingredientId): Ingredient
    {
        $stmt = $this->connection->prepare(
            'SELECT * FROM ingredients WHERE id = :ingredientId LIMIT 1;'
        );

        $stmt->execute([
            ':ingredientId' => (string) $ingredientId,
        ]);

        $row = $stmt->fetch();

        return $this->hydrator->hydrate($row);
    }
}
