<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries;

use PDO;

abstract class AbstractPDOQuery implements QueryInterface
{
    protected PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    abstract protected function query(): string;
}
