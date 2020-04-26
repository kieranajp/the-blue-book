<?php declare(strict_types=1);

namespace BlueBook\Domain\Recipes;

use BlueBook\Domain\Steps\StepId;

class RecipeStep
{
    private StepId $stepId;

    private int $index;

    private string $instruction;

    public function __construct(StepId $stepId, int $index, string $instruction)
    {
        $this->stepId = $stepId;
        $this->index = $index;
        $this->instruction = $instruction;
    }

    public function getStepId(): StepId
    {
        return $this->stepId;
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function getInstruction(): string
    {
        return $this->instruction;
    }
}
