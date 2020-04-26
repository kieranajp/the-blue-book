<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries\Ingredients;

use BlueBook\Infrastructure\Persistence\Queries\FetchManyPDOQuery;

class GetIngredients extends FetchManyPDOQuery
{
    protected function query(): string
    {
        return <<<SQL
            SELECT * FROM ingredients;
        SQL;
    }

    public function execute(): array
    {
        return $this->executeQuery();
    }
}
