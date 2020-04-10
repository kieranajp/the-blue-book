<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries\Recipes;

use PDOStatement;
use BlueBook\Domain\Recipes\RecipeId;
use BlueBook\Infrastructure\Persistence\Queries\AbstractPDOQuery;

class GetRecipeById extends AbstractPDOQuery
{
    protected array $includes;

    protected function query(): string
    {
        if (in_array('steps', $this->includes)) {
            if (in_array('ingredients', $this->includes)) {
                return $this->queryIncludeIngredientsAndSteps();
            }

            return $this->queryIncludeSteps();
        }

        if (in_array('ingredients', $this->includes)) {
            return $this->queryIncludeIngredients();
        }

        return <<<SQL
            SELECT * FROM recipes WHERE uuid = :recipeId LIMIT 1;
        SQL;
    }

    protected function queryIncludeIngredients(): string
    {
        return <<<SQL
            SELECT
                *
            FROM recipes
            --INNER JOIN ingredients 
            WHERE uuid = :recipeId
            LIMIT 1;
        SQL;
    }

    public function execute(RecipeId $recipeId, array $includes = []): PDOStatement
    {
        $this->includes = $includes;

        return $this->executeQuery([ 'recipeId' => (string) $recipeId ]);
    }
}
