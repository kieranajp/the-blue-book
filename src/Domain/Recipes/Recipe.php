<?php

namespace BlueBook\Domain\Recipes;

use DateInterval;

class Recipe
{
    /**
     * @var RecipeId
     */
    private $recipeId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var DateInterval
     */
    private $timing;

    /**
     * @var int
     */
    private $servings;

    /**
     * Recipe constructor.
     * @param RecipeId $recipeId
     * @param string $name
     * @param string $description
     * @param DateInterval $timing
     * @param int $servings
     */
    public function __construct(RecipeId $recipeId, string $name, string $description, DateInterval $timing, int $servings)
    {
        $this->recipeId = $recipeId;
        $this->name = $name;
        $this->description = $description;
        $this->timing = $timing;
        $this->servings = $servings;
    }

    /**
     * @return RecipeId
     */
    public function getRecipeId(): RecipeId
    {
        return $this->recipeId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return DateInterval
     */
    public function getTiming(): DateInterval
    {
        return $this->timing;
    }

    /**
     * @return int
     */
    public function getServings(): int
    {
        return $this->servings;
    }
}
