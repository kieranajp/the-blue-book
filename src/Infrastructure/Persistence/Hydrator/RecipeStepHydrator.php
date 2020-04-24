<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Hydrator;

use Ramsey\Uuid\Uuid;
use BlueBook\Domain\Steps\StepId;
use BlueBook\Domain\Recipes\RecipeStep;

class RecipeStepHydrator implements HydratorInterface
{
    /**
     * @inheritdoc
     */
    public function hydrate(array $step): RecipeStep
    {
        return new RecipeStep(
            new StepId(Uuid::fromString($step['uuid'])),
            (int) $step['index'],
            (string) $step['instruction'],
        );
    }
}
