<?php declare(strict_types=1);

namespace BlueBook\Domain\Recipes;

use DateInterval;

class Recipe
{
    private RecipeId $recipeId;

    private string $name;

    private string $description;

    private DateInterval $timing;

    private int $servings;

    public function __construct(
        RecipeId $recipeId,
        string $name,
        string $description,
        DateInterval $timing,
        int $servings
    ) {
        $this->recipeId = $recipeId;
        $this->name = $name;
        $this->description = $description;
        $this->timing = $timing;
        $this->servings = $servings;
    }

    public function getRecipeId(): RecipeId
    {
        return $this->recipeId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTiming(): DateInterval
    {
        return $this->timing;
    }

    public function getServings(): int
    {
        return $this->servings;
    }
}
