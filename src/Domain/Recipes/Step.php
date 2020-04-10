<?php declare(strict_types=1);

namespace BlueBook\Domain\Recipes;

final class Step
{
    private RecipeId $recipeId;

    private int $index;

    private string $instruction;

    public function __construct(RecipeId $recipeId, int $index, string $instruction)
    {
        $this->recipeId = $recipeId;
        $this->index = $index;
        $this->instruction = $instruction;
    }
}
