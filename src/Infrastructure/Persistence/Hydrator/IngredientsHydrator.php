<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Hydrator;

use BlueBook\Domain\Ingredients\Ingredient;
use BlueBook\Domain\Ingredients\IngredientId;
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
