<?php declare(strict_types=1);

namespace BlueBook\Application\Steps\Controller;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\ResourceInterface;
use BlueBook\Application\Steps\Transformer\StepsTransformer;
use BlueBook\Domain\Steps\Repository\StepsRepositoryInterface;

class IndexStepsController
{
    private StepsTransformer $transformer;

    private StepsRepositoryInterface $stepsRepository;

    public function __construct(
        StepsTransformer $transformer,
        StepsRepositoryInterface $stepsRepository
    ) {
        $this->transformer = $transformer;
        $this->stepsRepository = $stepsRepository;
    }

    public function __invoke(): ResourceInterface
    {
        $steps = $this->stepsRepository->all();
        return new Collection($steps, $this->transformer);
    }


}