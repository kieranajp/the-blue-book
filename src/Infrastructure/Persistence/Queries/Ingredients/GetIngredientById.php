<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries\Ingredients;

use BlueBook\Domain\Ingredients\IngredientId;
use BlueBook\Infrastructure\Persistence\Queries\FetchOnePDOQuery;

class GetIngredientById extends FetchOnePDOQuery
{
    protected function query(): string
    {
        return <<<SQL
            SELECT * FROM ingredients WHERE uuid = :ingredientId LIMIT 1;
        SQL;
    }

    public function execute(IngredientId $ingredientId): array
    {
        return $this->executeQuery([ 'ingredientId' => (string) $ingredientId ]);
    }
}
