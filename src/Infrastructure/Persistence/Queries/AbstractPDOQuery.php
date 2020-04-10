<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries;

use PDO;
use PDOStatement;
use PDOException;

abstract class AbstractPDOQuery
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    abstract protected function query(): string;

    protected function executeQuery(array $parameters = []): PDOStatement
    {
        $stmt = $this->conn->prepare($this->query());
        $stmt->execute($parameters);
        return $stmt;
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
