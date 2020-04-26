<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries\Ingredients;

use BlueBook\Domain\Ingredients\Ingredient;
use BlueBook\Infrastructure\Persistence\Queries\WritePDOQuery;

class SaveIngredient extends WritePDOQuery
{
    protected function query(): string
    {
        return <<<SQL
            INSERT INTO ingredients VALUES (:id, :name);
        SQL;
    }

    public function execute(Ingredient $ingredient): bool
    {
        return $this->executeQuery([
            ':id'   => (string) $ingredient->getIngredientId(),
            ':name' => $ingredient->getName(),
        ]);
    }
}
