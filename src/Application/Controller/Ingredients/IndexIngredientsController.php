<?php declare(strict_types=1);

namespace BlueBook\Application\Controller\Ingredients;

use BlueBook\Application\Transformer\IngredientsTransformer;
use BlueBook\Domain\Ingredients\Repository\IngredientsRepositoryInterface;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\ResourceInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class IndexIngredientsController implements LoggerAwareInterface
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
     * @var LoggerInterface
     */
    private $logger;

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
    public function __invoke(): ResourceInterface
    {
        $this->logger->debug('Called this method...');
        $ingredients = $this->ingredientsRepository->all();
        return new Collection($ingredients, $this->transformer);
    }

    /**
     * @inheritdoc
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
