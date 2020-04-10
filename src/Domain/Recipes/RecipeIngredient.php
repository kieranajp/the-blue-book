<?php declare(strict_types=1);

namespace BlueBook\Domain\Recipes;

use BlueBook\Domain\Ingredients\IngredientId;
use BlueBook\Domain\Ingredients\UnitOfMeasure;

class RecipeIngredient
{
    private IngredientId $ingredientId;

    private string $name;

    private UnitOfMeasure $unit;

    private float $quantity;

    public function __construct(IngredientId $ingredientId, string $name, UnitOfMeasure $uom, float $quantity)
    {
        $this->ingredientId = $ingredientId;
        $this->name = $name;
        $this->unit = $uom;
        $this->quantity = $quantity;
    }

    public function getIngredientId(): IngredientId
    {
        return $this->ingredientId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUnit(): UnitOfMeasure
    {
        return $this->unit;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }
}
