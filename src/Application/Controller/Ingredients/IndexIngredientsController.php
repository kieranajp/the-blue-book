<?php declare(strict_types=1);

namespace BlueBook\Application\Controller\Ingredients;

use BlueBook\Application\Transformer\IngredientsTransformer;
use League\Fractal\Resource\Collection;

class IndexIngredientsController
{
    /**
     * @var IngredientsTransformer
     */
    private $transformer;

    public function __construct(IngredientsTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function __invoke()
    {
        return new Collection(['some ingredient'], $this->transformer);
    }
}
