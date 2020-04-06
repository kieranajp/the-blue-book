<?php declare(strict_types=1);

namespace BlueBook\Application\Controller\Recipes;

use BlueBook\Domain\Recipes\RecipeId;
use BlueBook\Application\Transformer\RecipesTransformer;
use BlueBook\Domain\Recipes\Repository\RecipesRepositoryInterface;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class ShowRecipeController
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
     * ShowRecipeController constructor.
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
    public function __invoke(ServerRequestInterface $request, array $args): ResourceInterface
    {
        $recipe = $this->recipesRepository->find(RecipeId::fromValue($args['id']));
        return new Item($recipe, $this->transformer);
    }
}