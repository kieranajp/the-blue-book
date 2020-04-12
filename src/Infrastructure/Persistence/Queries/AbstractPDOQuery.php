<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries;

use PDO;
use PDOStatement;
use PDOException;
use League\Route\Http\Exception\NotFoundException;

abstract class AbstractPDOQuery
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    abstract protected function query(): string;

    protected function executeQuery(array $parameters = []): array
    {
        $stmt = $this->conn->prepare($this->query());
        $stmt->execute($parameters);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (! $results) {
            throw new NotFoundException();
        }

        return $results;
    }

    protected function executeWriteQuery(array $parameters = []): bool
    {
        $this->conn->beginTransaction();

        try {
            $this->executeQuery($parameters);
        } catch (PDOException $e) {
            $this->conn->rollBack();

            return false;
        }

        return $this->conn->commit();
    }
}
