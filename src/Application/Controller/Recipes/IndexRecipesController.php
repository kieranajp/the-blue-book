<?php declare(strict_types=1);

namespace BlueBook\Application\Controller\Recipes;

use BlueBook\Application\Transformer\RecipesTransformer;
use BlueBook\Domain\Recipes\Repository\RecipesRepositoryInterface;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\ResourceInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class IndexRecipesController
{
    /**
     * @var RecipesTransformer
     */
    private $transformer;

    /**
     * @var RecipesRepositoryInterface
     */
    private $recipesRepository;

    /**
     * IndexRecipesController constructor.
     *
     * @param RecipesTransformer         $transformer
     * @param RecipesRepositoryInterface $recipesRepository
     */
    public function __construct(
        RecipesTransformer $transformer,
        RecipesRepositoryInterface $recipesRepository
    ) {
        $this->transformer = $transformer;
        $this->recipesRepository = $recipesRepository;
    }

    /**
     * @return Collection
     */
    public function __invoke(): ResourceInterface
    {
        $recipes = $this->recipesRepository->all();
        return new Collection($recipes, $this->transformer);
    }
}
