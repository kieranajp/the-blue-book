<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Hydrator;

use Ds\Vector;
use UnderflowException;
use BlueBook\Domain\Recipes\Recipe;
use BlueBook\Domain\Recipes\RecipeId;
use DateInterval;
use Ramsey\Uuid\Uuid;

class RecipesHydrator implements HydratorInterface
{
    /**
     * @inheritdoc
     */
    public function hydrate(array $recipe): Recipe
    {
        $times = explode(":", $recipe['timing']);
        $hours = $times[0];
        $minutes = $times[1];

        if ($recipe['ingredients']) {
            $ingredients = $this->hydrateIngredients($recipe['ingredients']);
        }

        return new Recipe(
            new RecipeId(Uuid::fromString($recipe['uuid'])),
            $recipe['name'],
            $recipe['description'],
            new DateInterval(sprintf('PT%sH%sM', $hours, $minutes)),
            (int) $recipe['serving_size'],
            $ingredients ?? [],
        );
    }

    public function hydrateIngredients(array $ingredients)
    {
        return array_map(fn(array $ingredient) => (new RecipeIngredientHydrator())->hydrate($ingredient), $ingredients);
    }
}
