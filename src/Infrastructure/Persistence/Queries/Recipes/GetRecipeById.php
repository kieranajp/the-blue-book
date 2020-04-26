<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries\Recipes;

use BlueBook\Domain\Recipes\RecipeId;
use BlueBook\Infrastructure\Persistence\Queries\FetchOnePDOQuery;

class GetRecipeById extends FetchOnePDOQuery
{
    protected function query(): string
    {
        return <<<SQL
            SELECT * FROM recipes WHERE uuid = :recipeId LIMIT 1;
        SQL;
    }

    public function execute(RecipeId $recipeId): array
    {
        return $this->executeQuery([ 'recipeId' => (string) $recipeId ]);
    }
}
