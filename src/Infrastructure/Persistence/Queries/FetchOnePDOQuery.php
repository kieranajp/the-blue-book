<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries;

use PDO;
use League\Route\Http\Exception\NotFoundException;

abstract class FetchOnePDOQuery extends AbstractPDOQuery
{
    public function executeQuery(array $parameters = []): array
    {
        $stmt = $this->conn->prepare($this->query());
        $stmt->execute($parameters);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (! $result) {
            throw new NotFoundException();
        }

        return $result;
    }
}
