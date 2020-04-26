<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries;

use PDO;
use PDOException;

abstract class WritePDOQuery extends AbstractPDOQuery
{
    public function executeQuery(array $parameters = []): bool
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
