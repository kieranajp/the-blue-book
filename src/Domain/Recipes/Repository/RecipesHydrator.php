<?php declare(strict_types=1);

namespace BlueBook\Domain\Recipes\Repository;

use BlueBook\Domain\Recipes\Recipe;
use BlueBook\Domain\Recipes\RecipeId;
use BlueBook\Infrastructure\Database\HydratorInterface;
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

        return new Recipe(
            new RecipeId(Uuid::fromString($recipe['uuid'])),
            $recipe['name'],
            $recipe['description'],
            new DateInterval(sprintf('PT%sH%sM', $hours, $minutes)),
            (int) $recipe['serving_size']
        );
    }
}
