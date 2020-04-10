<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries\Recipes;

use PDOStatement;
use BlueBook\Domain\Recipes\RecipeId;
use BlueBook\Infrastructure\Persistence\Queries\AbstractPDOQuery;

class IncludeRecipeIngredients extends AbstractPDOQuery
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

    public function execute(RecipeId $recipeId): PDOStatement
    {
        return $this->executeQuery([ 'recipeId' => (string) $recipeId ]);
    }
}
