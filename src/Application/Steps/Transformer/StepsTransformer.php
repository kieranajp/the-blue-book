<?php declare(strict_types=1);

namespace BlueBook\Application\Steps\Transformer;

use BlueBook\Domain\Steps\Step;
use League\Fractal\TransformerAbstract;

class StepsTransformer extends TransformerAbstract
{
    public function transform(Step $step): array
    {
        return [
            'id' => (string) $step->getStepId(),
            'index' => (int) $step->getStepIndex(),
            'instruction' => (string) $step->getInstruction(),
        ];
    }
}
