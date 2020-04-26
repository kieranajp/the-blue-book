<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries\Steps;

use PDOStatement;
use BlueBook\Infrastructure\Persistence\Queries\FetchManyPDOQuery;

class GetSteps extends FetchManyPDOQuery
{
    protected function query(): string
    {
        return <<<SQL
            SELECT * FROM steps;
        SQL;
    }

    public function execute(): array
    {
        return $this->executeQuery();
    }
}
