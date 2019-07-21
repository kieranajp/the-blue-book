<?php declare(strict_types=1);

namespace BlueBook\Application\Transformer;

use BlueBook\Domain\Ingredients\Ingredient;
use League\Fractal\TransformerAbstract;

class IngredientsTransformer extends TransformerAbstract
{
    /**
     * Serialise an Ingredient.
     *
     * @param Ingredient $ingredient
     * @return array
     */
    public function transform(Ingredient $ingredient): array
    {
        return [
            'id' => (string) $ingredient->getIngredientId(),
            'name' => $ingredient->getName(),
        ];
    }
}
