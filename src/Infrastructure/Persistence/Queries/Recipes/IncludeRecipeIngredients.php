<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries\Recipes;

use BlueBook\Domain\Recipes\RecipeId;
use League\Container\Exception\NotFoundException;
use BlueBook\Infrastructure\Persistence\Queries\FetchManyPDOQuery;

class IncludeRecipeIngredients extends FetchManyPDOQuery
{
    protected function query(): string
    {
        return <<<SQL
            SELECT
                ri.quantity,
                i.uuid,
                i.name AS ingredient_name,
                u.name AS unit_name,
                u.abbreviation AS unit_abbr
            FROM recipe_ingredient ri
            INNER JOIN ingredients i
                ON i.uuid = ri.ingredient_id
            INNER JOIN units u
                ON u.uuid = ri.unit_id
            WHERE ri.recipe_id = :recipeId
        SQL;
    }

    public function execute(RecipeId $recipeId): array
    {
        try {
            return $this->executeQuery([ 'recipeId' => (string) $recipeId ]);
        } catch (NotFoundException $e) {
            return [];
        }
    }
}
