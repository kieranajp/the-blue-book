<?php declare(strict_types=1);

namespace BlueBook\Infrastructure\Hydrator;

interface HydratorInterface
{
    public function hydrate(array $record);
}
