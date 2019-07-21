<?php declare(strict_types=1);

namespace BlueBook\Application\Transformer;

use BlueBook\Domain\Recipes\Recipe;
use League\Fractal\TransformerAbstract;

class RecipesTransformer extends TransformerAbstract
{
    /**
     * Serialise an Recipe.
     *
     * @param Recipe $recipe
     * @return array
     */
    public function transform(Recipe $recipe): array
    {
        return [
            'id' => (string) $recipe->getRecipeId(),
            'name' => $recipe->getName(),
            'description' => $recipe->getName(),
            'timing' => $recipe->getTiming()->format('H:i'),
            'serving_size' => $recipe->getServings(),
        ];
    }
}
