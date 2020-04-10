<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Persistence\Hydrator;

interface HydratorInterface
{
    /**
     * Convert a database record into an Entity.
     *
     * @param array $record
     * @return mixed
     */
    public function hydrate(array $record);
}
