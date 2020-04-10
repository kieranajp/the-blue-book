<?php declare(strict_types=1);

namespace BlueBook\Domain\Ingredients\Repository;

use BlueBook\Domain\Ingredients\Ingredient;
use BlueBook\Domain\Ingredients\IngredientId;
use Ds\Vector;

interface IngredientsRepositoryInterface
{
    /**
     * Find all Ingredients.
     *
     * @return Vector
     */
    public function all(): Vector;

    /**
     * Find an Ingredient by its ID.
     *
     * @param IngredientId $ingredientId
     * @return Ingredient
     */
    public function find(IngredientId $ingredientId): Ingredient;

    /**
     * Persist an Ingredient entity.
     *
     * @param Ingredient $ingredient
     * @return bool
     */
    public function save(Ingredient $ingredient): bool;
}
