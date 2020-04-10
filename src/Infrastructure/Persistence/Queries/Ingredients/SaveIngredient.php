<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries\Ingredients;

use PDOStatement;
use BlueBook\Domain\Ingredients\Ingredient;
use BlueBook\Infrastructure\Persistence\Queries\AbstractPDOQuery;

class SaveIngredient extends AbstractPDOQuery
{
    protected function query(): string
    {
        return <<<SQL
            INSERT INTO ingredients VALUES (:id, :name);
        SQL;
    }

    public function execute(Ingredient $ingredient): bool
    {
        return $this->executeWriteQuery([
            ':id'   => (string) $ingredient->getIngredientId(),
            ':name' => $ingredient->getName(),
        ]);
    }
}
