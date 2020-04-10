<?php declare(strict_types=1);

namespace BlueBook\Application\Recipes\Transformer;

use BlueBook\Domain\Recipes\Recipe;
use League\Fractal\TransformerAbstract;

class RecipesTransformer extends TransformerAbstract
{
    public function transform(Recipe $recipe): array
    {
        return [
            'id' => (string) $recipe->getRecipeId(),
            'name' => $recipe->getName(),
            'description' => $recipe->getName(),
            'timing' => $recipe->getTiming()->format('%H:%I:%S'),
            'serving_size' => $recipe->getServings(),
        ];
    }
}
