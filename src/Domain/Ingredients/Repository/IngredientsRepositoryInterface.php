<?php declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: kieran
 * Date: 17/10/18
 * Time: 20:43
 */

namespace BlueBook\Domain\Ingredients\Repository;

use BlueBook\Domain\Ingredients\Ingredient;
use BlueBook\Domain\Ingredients\IngredientIdInterface;
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
     * @param IngredientIdInterface $ingredientId
     * @return Ingredient
     */
    public function find(IngredientIdInterface $ingredientId): Ingredient;

    /**
     * Persist an Ingredient entity.
     *
     * @param Ingredient $ingredient
     * @return bool
     */
    public function save(Ingredient $ingredient): bool;
}
