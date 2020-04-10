<?php declare(strict_types=1);

namespace BlueBook\Application\Recipes\Controller;

use BlueBook\Application\Recipes\Transformer\RecipesTransformer;
use BlueBook\Domain\Recipes\Repository\RecipesRepositoryInterface;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\ResourceInterface;

class IndexRecipesController
{
    private RecipesTransformer $transformer;

    private RecipesRepositoryInterface $recipesRepository;

    public function __construct(
        RecipesTransformer $transformer,
        RecipesRepositoryInterface $recipesRepository
    ) {
        $this->transformer = $transformer;
        $this->recipesRepository = $recipesRepository;
    }

    public function __invoke(): ResourceInterface
    {
        $recipes = $this->recipesRepository->all();
        return new Collection($recipes, $this->transformer);
    }
}
