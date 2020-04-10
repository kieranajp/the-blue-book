<?php declare(strict_types=1);

namespace BlueBook\Application\Ingredients\Controller;

use BlueBook\Application\Ingredients\Transformer\IngredientsTransformer;
use BlueBook\Domain\Ingredients\Repository\IngredientsRepositoryInterface;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\ResourceInterface;

class IndexIngredientsController
{
    private IngredientsTransformer $transformer;

    private IngredientsRepositoryInterface $ingredientsRepository;

    public function __construct(
        IngredientsTransformer $transformer,
        IngredientsRepositoryInterface $ingredientsRepository
    ) {
        $this->transformer = $transformer;
        $this->ingredientsRepository = $ingredientsRepository;
    }

    public function __invoke(): ResourceInterface
    {
        $ingredients = $this->ingredientsRepository->all();
        return new Collection($ingredients, $this->transformer);
    }
}
