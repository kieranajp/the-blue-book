<?php declare(strict_types=1);

namespace BlueBook\Domain\Ingredients\Repository;

use BlueBook\Domain\Ingredients\Ingredient;
use BlueBook\Domain\Ingredients\IngredientId;
use BlueBook\Domain\Ingredients\IngredientIdInterface;

class IngredientsRepository implements IngredientsRepositoryInterface
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * IngredientsRepository constructor.
     *
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
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

        return $this->hydrate($row);
    }

    // TODO: Move to hydrator class
    private function hydrate(array $ingredient): Ingredient
    {
        return new Ingredient(
            new IngredientId($ingredient['id']),
            $ingredient['name']
        );
    }
}
