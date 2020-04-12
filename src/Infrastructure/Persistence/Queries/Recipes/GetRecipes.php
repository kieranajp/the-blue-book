<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries\Recipes;

use PDOStatement;
use BlueBook\Infrastructure\Persistence\Queries\AbstractPDOQuery;

class GetRecipes extends AbstractPDOQuery
{
    protected function query(): string
    {
        return <<<SQL
            SELECT * FROM recipes;
        SQL;
    }

    public function execute(): array
    {
        return $this->executeQuery();
    }
}
