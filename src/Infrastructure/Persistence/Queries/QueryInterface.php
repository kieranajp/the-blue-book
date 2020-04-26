<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Queries;

interface QueryInterface
{
    public function executeQuery(array $parameters = []);
}
