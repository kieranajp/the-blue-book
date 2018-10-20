<?php
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
    public function all(): Vector;

    public function find(IngredientIdInterface $ingredientId): Ingredient;
}
