<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Hydrator;

use Ramsey\Uuid\Uuid;
use BlueBook\Domain\Ingredients\IngredientId;
use BlueBook\Domain\Ingredients\UnitOfMeasure;
use BlueBook\Domain\Recipes\RecipeIngredient;

class RecipeIngredientHydrator implements HydratorInterface
{
    /**
     * @inheritdoc
     */
    public function hydrate(array $ingredient): RecipeIngredient
    {
        return new RecipeIngredient(
            new IngredientId(Uuid::fromString($ingredient['uuid'])),
            $ingredient['ingredient_name'],
            new UnitOfMeasure($ingredient['unit_name'], $ingredient['unit_abbr']),
            (float) $ingredient['quantity'],
        );
    }
}
