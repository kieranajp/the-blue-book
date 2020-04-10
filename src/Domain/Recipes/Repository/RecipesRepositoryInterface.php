<?php declare(strict_types=1);

namespace BlueBook\Domain\Recipes\Repository;

use BlueBook\Domain\Recipes\Recipe;
use BlueBook\Domain\Recipes\RecipeIdInterface;
use Ds\Vector;

interface RecipesRepositoryInterface
{
    /**
     * Find all Recipes.
     *
     * @return Vector
     */
    public function all(): Vector;

    /**
     * Find a Recipe by its ID.
     *
     * @param RecipeIdInterface $recipeId
     * @param array $includes
     * @return Recipe
     */
    public function find(RecipeIdInterface $recipeId, array $includes = []): Recipe;
}
