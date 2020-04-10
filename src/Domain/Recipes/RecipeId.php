<?php declare(strict_types=1);

namespace BlueBook\Domain\Recipes;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class RecipeId
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

    public static function fromString(string $value): RecipeId
    {
        return new static(Uuid::fromString($value));
    }
}
