<?php declare(strict_types=1);

namespace BlueBook\Application\Recipes\Controller;

use BlueBook\Domain\Recipes\RecipeId;
use BlueBook\Application\Recipes\Transformer\RecipesTransformer;
use BlueBook\Domain\Recipes\Repository\RecipesRepositoryInterface;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceInterface;
use Psr\Http\Message\ServerRequestInterface;

class ShowRecipeController
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

    public function __invoke(ServerRequestInterface $request, array $args): ResourceInterface
    {
        $includes = $request->getAttribute('includes');

        $recipe = $this->recipesRepository->find(RecipeId::fromValue($args['id']), $includes);
        return new Item($recipe, $this->transformer);
    }
}
