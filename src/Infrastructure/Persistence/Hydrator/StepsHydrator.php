<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Hydrator;

use BlueBook\Domain\Steps\Step;
use BlueBook\Domain\Steps\StepId;
use Ramsey\Uuid\Uuid;

class StepsHydrator implements HydratorInterface
{
    /**
     * @inheritdoc
     */
    public function hydrate(array $step): Step
    {
        return new Step(
            new StepId(Uuid::fromString($step['uuid'])),
            $step['index'],
            $step['instruction']
        );
    }
}
