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

        $ingredients = $this->hydrateIngredients($recipe);

        return new Recipe(
            new RecipeId(Uuid::fromString($recipe['uuid'])),
            $recipe['name'],
            $recipe['description'],
            new DateInterval(sprintf('PT%sH%sM', $hours, $minutes)),
            (int) $recipe['serving_size'],
            [],
        );
    }

    public function resolveIngredients(array $records): array
    {
        $recipes = new Vector();

        foreach ($records as $record) {
            try {
                $recipe = $recipes
                    ->filter(fn(array $recipe): bool => (int) $record['id'] === (int) $recipe['id'])
                    ->first();
            } catch (UnderflowException $e) {
                $recipe = $record;
                $recipe['ingredients'][] = $this->extractIngredient($record);
                $recipes->push($recipe);
                continue;
            }

            $recipes = $recipes
                ->filter(fn(array $recipe): bool => (int) $record['id'] !== (int) $recipe['id']);

            $recipe['ingredients'][] = $this->extractIngredient($record);
            $recipes->push($recipe);
        }

        return $recipes->toArray();
    }

    private function extractIngredient(array $record): array
    {
        $ingredientFields = [
            'ingredient_name',
            'quantity',
            'unit_name',
        ];

        $ingredient = [];
        foreach ($ingredientFields as $field) {
            $ingredient[$field] = $record[$field];
        }

        return $ingredient;
    }

    public function hydrateIngredients(array $recipe)
    {
        dd($recipe);
        return (new IngredientsHydrator())->hydrate($recipe);
    }
}
