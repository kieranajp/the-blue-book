<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Repository;

use PDO;
use Ds\Vector;
use Ds\Sequence;
use Psr\Log\LoggerInterface;
use BlueBook\Domain\Steps\Step;
use BlueBook\Domain\Steps\StepId;
use BlueBook\Domain\Steps\Repository\StepsRepositoryInterface;
use BlueBook\Infrastructure\Persistence\Queries\Steps\GetSteps;
use BlueBook\Infrastructure\Persistence\Queries\Steps\SaveStep;
use BlueBook\Infrastructure\Persistence\Queries\Steps\GetStepById;
use BlueBook\Infrastructure\Persistence\Hydrator\HydratorInterface;

class PDOStepsRepository implements StepsRepositoryInterface
{
    private PDO $connection;

    private HydratorInterface $hydrator;

    private LoggerInterface $logger;

    public function __construct(PDO $connection, HydratorInterface $hydrator, LoggerInterface $logger)
    {
        $this->connection = $connection;
        $this->hydrator = $hydrator;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function all(): Sequence
    {
        $results = (new GetSteps($this->connection))->execute();
        return (new Vector($results))->map(fn(array $step): Step => $this->hydrator->hydrate($step));
    }

    /**
     * @inheritdoc
     */
    public function find(StepId $stepId): Step
    {
        $results = (new GetStepById($this->connection))->execute($stepId);
        return $this->hydrator->hydrate($results);
    }

    /**
     * @inheritdoc
     */
    public function save(Step $step): bool
    {
        return (new SaveStep($this->connection))->execute($step);
    }
}
