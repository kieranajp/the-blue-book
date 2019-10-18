<?php declare(strict_types=1);

namespace BlueBook\Domain\Recipes;

class Step
{
    /**
     * @var RecipeId
     */
    private $recipeId;
    /**
     * @var int
     */
    private $index;
    /**
     * @var string
     */
    private $instruction;

    /**
     * Step constructor.
     * @param RecipeId $recipeId
     * @param int $index
     * @param string $instruction
     */
    public function __construct(RecipeId $recipeId, int $index, string $instruction)
    {
        $this->recipeId = $recipeId;
        $this->index = $index;
        $this->instruction = $instruction;
    }
}
