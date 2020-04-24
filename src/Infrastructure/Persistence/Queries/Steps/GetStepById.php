<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries\Steps;

use PDOStatement;
use BlueBook\Domain\Steps\StepId;
use BlueBook\Infrastructure\Persistence\Queries\AbstractPDOQuery;

class GetStepById extends AbstractPDOQuery
{
    protected function query(): string
    {
        return <<<SQL
            SELECT * FROM steps WHERE uuid = :stepId LIMIT 1;
        SQL;
    }

    public function execute(StepId $stepId): array
    {
        return $this->executeQuery([ 'stepId' => (string) $stepId ]);
    }
}
