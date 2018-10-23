<?php declare(strict_types=1);

namespace BlueBook\Domain\Ingredients\Repository;

use BlueBook\Domain\Ingredients\Ingredient;
use BlueBook\Domain\Ingredients\IngredientId;
use BlueBook\Infrastructure\Hydrator\HydratorInterface;
use Ramsey\Uuid\Uuid;

class IngredientsHydrator implements HydratorInterface
{
    /**
     * @inheritdoc
     */
    public function hydrate(array $ingredient): Ingredient
    {
        return new Ingredient(
            new IngredientId(Uuid::fromString($ingredient['uuid'])),
            $ingredient['name']
        );
    }
}
