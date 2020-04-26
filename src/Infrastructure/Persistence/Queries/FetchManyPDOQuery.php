<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries;

use PDO;
use League\Route\Http\Exception\NotFoundException;

abstract class FetchManyPDOQuery extends AbstractPDOQuery
{
    public function executeQuery(array $parameters = []): array
    {
        $stmt = $this->conn->prepare($this->query());
        $stmt->execute($parameters);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (! $results) {
            throw new NotFoundException();
        }

        return $results;
    }
}
