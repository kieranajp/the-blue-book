<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries\Recipes;

use BlueBook\Infrastructure\Persistence\Queries\FetchManyPDOQuery;

class GetRecipes extends FetchManyPDOQuery
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
