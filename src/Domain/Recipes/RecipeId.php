<?php declare(strict_types=1);

namespace BlueBook\Domain\Recipes;

use MsgPhp\Domain\Infrastructure\Uuid\DomainIdTrait;

final class RecipeId implements RecipeIdInterface
{
    use DomainIdTrait;
}
