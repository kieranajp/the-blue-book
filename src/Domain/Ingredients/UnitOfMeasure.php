<?php declare(strict_types=1);

namespace BlueBook\Domain\Ingredients;

final class UnitOfMeasure
{
    public function __construct(string $name, string $abbr)
    {
        $this->name = $name;
        $this->abbr = $abbr;
    }
}
