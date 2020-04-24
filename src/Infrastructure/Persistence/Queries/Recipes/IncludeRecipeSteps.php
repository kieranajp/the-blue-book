<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries\Recipes;

use PDO;
use PDOStatement;
use BlueBook\Domain\Recipes\RecipeId;
use League\Container\Exception\NotFoundException;
use BlueBook\Infrastructure\Persistence\Queries\AbstractPDOQuery;

class IncludeRecipeSteps extends AbstractPDOQuery
{
    protected function query(): string
    {
        return <<<SQL
            SELECT
                s.uuid,
                s.index,
                s.instruction
            FROM steps s
            WHERE s.recipe_id = :recipeId
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
