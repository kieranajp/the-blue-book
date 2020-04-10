<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries\Ingredients;

use PDOStatement;
use Ramsey\Uuid\UuidInterface;
use BlueBook\Infrastructure\Persistence\Queries\AbstractPDOQuery;

class GetIngredientById extends AbstractPDOQuery
{
    protected function query(): string
    {
        return <<<SQL
            SELECT * FROM ingredients WHERE uuid = :ingredientId LIMIT 1;
        SQL;
    }

    public function execute(UuidInterface $ingredientId): PDOStatement
    {
        return $this->executeQuery([ 'ingredientId' => (string) $ingredientId ]);
    }
}
