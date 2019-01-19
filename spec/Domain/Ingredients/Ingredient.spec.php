<?php declare(strict_types=1);

use BlueBook\Domain\Ingredients\Ingredient;
use BlueBook\Domain\Ingredients\IngredientId;

describe(Ingredient::class, function () {
    it('initialises with a UUID and name', function () {
        $ingredient = new Ingredient(new IngredientId(), 'banana');

        expect($ingredient->getIngredientId())->toBeAnInstanceOf(IngredientId::class);
        expect($ingredient->getName())->toBe('banana');
    });
});
