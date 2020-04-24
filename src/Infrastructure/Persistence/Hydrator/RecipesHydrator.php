<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Hydrator;

use DateInterval;
use Ramsey\Uuid\Uuid;
use BlueBook\Domain\Recipes\Recipe;
use BlueBook\Domain\Recipes\RecipeId;
use BlueBook\Infrastructure\Persistence\Hydrator\RecipeStepHydrator;
use BlueBook\Infrastructure\Persistence\Hydrator\RecipeIngredientHydrator;

class RecipesHydrator implements HydratorInterface
{
    /**
     * @inheritdoc
     */
    public function hydrate(array $recipe): Recipe
    {
        $times = explode(":", $recipe[0]['timing']);
        $hours = $times[0];
        $minutes = $times[1];

        if ($recipe['ingredients']) {
            $ingredients = $this->hydrateIngredients($recipe['ingredients']);
        }

        if ($recipe['steps']) {
            $steps = $this->hydrateSteps($recipe['steps']);
        }

        return new Recipe(
            new RecipeId(Uuid::fromString($recipe[0]['uuid'])),
            $recipe[0]['name'],
            $recipe[0]['description'],
            new DateInterval(sprintf('PT%sH%sM', $hours, $minutes)),
            (int) $recipe[0]['serving_size'],
            $ingredients ?? [],
            $steps ?? [],
        );
    }

    public function hydrateIngredients(array $ingredients)
    {
        return array_map(fn(array $ingredient) => (new RecipeIngredientHydrator())->hydrate($ingredient), $ingredients);
    }

    public function hydrateSteps(array $steps)
    {
        return array_map(fn(array $step) => (new RecipeStepHydrator())->hydrate($step), $steps);
    }
}
