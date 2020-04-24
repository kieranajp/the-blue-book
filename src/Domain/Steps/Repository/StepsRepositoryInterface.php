<?php declare(strict_types=1);

namespace BlueBook\Domain\Steps\Repository;

use Ds\Sequence;
use BlueBook\Domain\Steps\Step;
use BlueBook\Domain\Steps\StepId;

interface StepsRepositoryInterface
{
    /**
     * Find all Steps.
     *
     * @return Sequence
     */
    public function all(): Sequence;

    /**
     * Find a Step by its ID.
     *
     * @param StepId $stepId
     * @return Step
     */
    public function find(StepId $stepId): Step;

    /**
     * Persist a Step entity.
     *
     * @param Step $step
     * @return bool
     */
    public function save(Step $step): bool;
}
