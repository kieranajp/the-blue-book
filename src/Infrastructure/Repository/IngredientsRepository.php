<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Repository;

use BlueBook\Domain\Ingredients\Ingredient;
use BlueBook\Domain\Ingredients\IngredientIdInterface;
use BlueBook\Domain\Ingredients\Repository\IngredientsRepositoryInterface;
use BlueBook\Infrastructure\Database\HydratorInterface;
use Ds\Vector;
use PDOException;
use Psr\Log\LoggerInterface;

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
            'SELECT * FROM ingredients;'
        );

        $stmt->execute();

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
        $stmt = $this->connection->prepare(
            'SELECT * FROM ingredients WHERE uuid = :ingredientId LIMIT 1;'
        );

        $stmt->execute([
            ':ingredientId' => (string) $ingredientId,
        ]);

        $row = $stmt->fetch();

        return $this->hydrator->hydrate($row);
    }

    /**
     * @inheritdoc
     */
    public function save(Ingredient $ingredient): bool
    {
        $this->connection->beginTransaction();
        $stmt = $this->connection->prepare(
            'INSERT INTO ingredients VALUES (:id, :name);'
        );

        try {
            $stmt->execute([
                ':id'   => (string) $ingredient->getIngredientId(),
                ':name' => $ingredient->getName(),
            ]);
        } catch (PDOException $e) {
            $this->connection->rollBack();
            $this->logger->error('Error saving Ingredient', [
                'ingredient' => $ingredient->getName(),
                'error' => $e->getMessage(),
            ]);

            return false;
        }

        return $this->connection->commit();
    }
}