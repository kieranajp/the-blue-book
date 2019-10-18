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
     * Find an Ingredient by its ID.
     *
     * @param RecipeIdInterface $recipeId
     * @return Recipe
     */
    public function find(RecipeIdInterface $recipeId): Recipe;
}
