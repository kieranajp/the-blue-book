<?php declare(strict_types=1);

namespace BlueBook\Application\Transformer;

use League\Fractal\TransformerAbstract;

class IngredientsTransformer extends TransformerAbstract
{
    public function transform($ingredient): array
    {
        return [
            'hello' => 'world',
        ];
    }
}
