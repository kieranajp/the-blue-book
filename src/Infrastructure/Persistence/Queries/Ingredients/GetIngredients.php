<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries\Ingredients;

use PDOStatement;
use BlueBook\Infrastructure\Persistence\Queries\AbstractPDOQuery;

class GetIngredients extends AbstractPDOQuery
{
    protected function query(): string
    {
        return <<<SQL
            SELECT * FROM ingredients;
        SQL;
    }

    public function execute(): PDOStatement
    {
        return $this->executeQuery();
    }
}
