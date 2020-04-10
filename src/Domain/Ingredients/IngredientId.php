<?php declare(strict_types=1);

namespace BlueBook\Domain\Ingredients;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class IngredientId
{
    private UuidInterface $uuid;

    public function __construct(?UuidInterface $uuid = null)
    {
        $this->uuid = $uuid ?? Uuid::uuid4();
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public static function fromString(string $value): IngredientId
    {
        return new static(Uuid::fromString($value));
    }
}
