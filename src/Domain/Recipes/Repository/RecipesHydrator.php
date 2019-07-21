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
        return new Recipe(
            new RecipeId(Uuid::fromString($recipe['uuid'])),
            $recipe['name'],
            $recipe['description'],
            new DateInterval(sprintf('PT%sH%sM', $recipe['hours'], $recipe['minutes'])),
            (int) $recipe['serving_size']
        );
    }
}
