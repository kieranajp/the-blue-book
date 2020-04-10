<?php declare(strict_types=1);

namespace BlueBook\Domain\Ingredients;

class Ingredient
{
    private IngredientIdInterface $ingredientId;

    private string $name;

    public function __construct(IngredientIdInterface $ingredientId, string $name)
    {
        $this->ingredientId = $ingredientId;
        $this->name = $name;
    }

    public function getIngredientId(): IngredientIdInterface
    {
        return $this->ingredientId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
