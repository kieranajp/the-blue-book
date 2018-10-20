<?php declare(strict_types=1);

namespace BlueBook\Application\Controller\Ingredients;

use BlueBook\Application\Transformer\IngredientsTransformer;
use BlueBook\Domain\Ingredients\Repository\IngredientsRepositoryInterface;
use League\Fractal\Resource\Collection;

class IndexIngredientsController
{
    /**
     * @var IngredientsTransformer
     */
    private $transformer;

    /**
     * @var IngredientsRepositoryInterface
     */
    private $ingredientsRepository;

    /**
     * IndexIngredientsController constructor.
     *
     * @param IngredientsTransformer         $transformer
     * @param IngredientsRepositoryInterface $ingredientsRepository
     */
    public function __construct(IngredientsTransformer $transformer, IngredientsRepositoryInterface $ingredientsRepository)
    {
        $this->transformer = $transformer;
        $this->ingredientsRepository = $ingredientsRepository;
    }

    /**
     * @return Collection
     */
    public function __invoke()
    {
        $ingredients = $this->ingredientsRepository->all();
        return new Collection($ingredients, $this->transformer);
    }
}
