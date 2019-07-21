<?php declare(strict_types=1);

namespace BlueBook\Domain\Ingredients;

use MsgPhp\Domain\Infrastructure\Uuid\DomainIdTrait;

final class IngredientId implements IngredientIdInterface
{
    use DomainIdTrait;
}
