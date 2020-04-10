<?php declare(strict_types=1);

namespace BlueBook\Application\Ingredients\Transformer;

use BlueBook\Domain\Ingredients\Ingredient;
use League\Fractal\TransformerAbstract;

class IngredientsTransformer extends TransformerAbstract
{
    public function transform(Ingredient $ingredient): array
    {
        return [
            'id' => (string) $ingredient->getIngredientId(),
            'name' => $ingredient->getName(),
        ];
    }
}
