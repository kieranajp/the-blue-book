<?php declare(strict_types=1);

namespace BlueBook\Domain\Ingredients;

class Ingredient
{
    private IngredientId $ingredientId;

    private string $name;

    public function __construct(IngredientId $ingredientId, string $name)
    {
        $this->ingredientId = $ingredientId;
        $this->name = $name;
    }

    public function getIngredientId(): IngredientId
    {
        return $this->ingredientId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
