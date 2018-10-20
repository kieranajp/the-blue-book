<?php declare(strict_types=1);

namespace BlueBook\Domain\Ingredients\Repository;

use BlueBook\Domain\Ingredients\Ingredient;
use BlueBook\Domain\Ingredients\IngredientId;
use BlueBook\Infrastructure\Hydrator\HydratorInterface;

class IngredientsHydrator implements HydratorInterface
{
    public function hydrate(array $ingredient): Ingredient
    {
        return new Ingredient(
            new IngredientId($ingredient['id']),
            $ingredient['name']
        );
    }
}
