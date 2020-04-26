<?php declare(strict_types=1);

namespace BlueBook\Application\Steps\Controller;

use BlueBook\Domain\Steps\Step;
use BlueBook\Domain\Steps\StepId;
use BlueBook\Application\Steps\Transformer\StepsTransformer;
use BlueBook\Domain\Steps\Repository\StepsRepositoryInterface;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceInterface;
use Psr\Http\Message\RequestInterface;

class CreateStepController
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

    public function __invoke(RequestInterface $request): ResourceInterface
    {
        $payload = json_decode($request->getBody()->getContents(), true);

        $step = new Step(
            new StepId(),
            $payload['name'],
            $payload['instruction'],
        );

        $this->stepsRepository->save($step);

        return new Item($step, $this->transformer);
    }
}
