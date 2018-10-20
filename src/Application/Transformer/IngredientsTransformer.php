<?php declare(strict_types=1);

namespace BlueBook\Application\Transformer;

use BlueBook\Domain\Ingredients\Ingredient;
use League\Fractal\TransformerAbstract;

class IngredientsTransformer extends TransformerAbstract
{
    public function transform(Ingredient $ingredient): array
    {
        return [
            'id' => $ingredient->getIngredientId(),
            'name' => $ingredient->getName(),
        ];
    }
}
