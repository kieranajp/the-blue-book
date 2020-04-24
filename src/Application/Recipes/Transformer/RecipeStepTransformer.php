<?php declare(strict_types=1);

namespace BlueBook\Application\Recipes\Transformer;

use League\Fractal\TransformerAbstract;
use BlueBook\Domain\Recipes\RecipeStep;

class RecipeStepTransformer extends TransformerAbstract
{
    public function transform(RecipeStep $step): array
    {
        return [
            'id' => (string) $step->getStepId(),
            'index' => $step->getIndex(),
            'instruction' => $step->getInstruction(),
        ];
    }
}
