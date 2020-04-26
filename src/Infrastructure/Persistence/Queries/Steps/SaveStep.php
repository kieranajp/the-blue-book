<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries\Steps;

use BlueBook\Domain\Steps\Step;
use BlueBook\Infrastructure\Persistence\Queries\WritePDOQuery;

class SaveStep extends WritePDOQuery
{
    protected function query(): string
    {
        return <<<SQL
            INSERT INTO steps VALUES (:id, :name);
        SQL;
    }

    public function execute(Step $step): bool
    {
        return $this->executeQuery([
            ':id'   => (string) $step->getStepId(),
            ':index' => (int) $step->getIndex(),
            ':instruction' => (string) $step->getInstruction(),
        ]);
    }
}
