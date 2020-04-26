<?php declare(strict_types=1);

namespace BlueBook\Application\Recipes\Transformer;

use League\Fractal\TransformerAbstract;
use BlueBook\Domain\Recipes\RecipeIngredient;

class RecipeIngredientTransformer extends TransformerAbstract
{
    public function transform(RecipeIngredient $ingredient): array
    {
        return [
            'id' => (string) $ingredient->getIngredientId(),
            'name' => $ingredient->getName(),
            'unit' => [
                'name' => $ingredient->getUnit()->getName(),
                'abbr' => $ingredient->getUnit()->getAbbr(),
            ],
            'quantity' => $ingredient->getQuantity(),
        ];
    }
}
