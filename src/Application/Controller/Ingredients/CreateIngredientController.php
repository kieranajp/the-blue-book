<?php declare(strict_types=1);

namespace BlueBook\Application\Controller\Ingredients;

use BlueBook\Application\Transformer\IngredientsTransformer;
use BlueBook\Domain\Ingredients\Ingredient;
use BlueBook\Domain\Ingredients\IngredientId;
use BlueBook\Domain\Ingredients\Repository\IngredientsRepositoryInterface;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceInterface;
use Psr\Http\Message\RequestInterface;

class CreateIngredientController
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
     * CreateIngredientController constructor.
     *
     * @param IngredientsTransformer         $transformer
     * @param IngredientsRepositoryInterface $ingredientsRepository
     */
    public function __construct(IngredientsTransformer $transformer, IngredientsRepositoryInterface $ingredientsRepository)
    {
        $this->transformer = $transformer;
        $this->ingredientsRepository = $ingredientsRepository;
    }

    public function __invoke(RequestInterface $request): ResourceInterface
    {
        $payload = json_decode($request->getBody()->getContents());

        $ingredient = new Ingredient(
            new IngredientId(),
            $payload->name
        );

        $this->ingredientsRepository->save($ingredient);

        return new Item($ingredient, $this->transformer);
    }
}
