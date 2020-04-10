<?php declare(strict_types=1);

use BlueBook\Application\Transformer\IngredientsTransformer;
use BlueBook\Domain\Ingredients\Ingredient;
use BlueBook\Domain\Ingredients\IngredientId;

describe(IngredientsTransformer::class, function () {

    it('transforms an ingredient', function () {
        $ingredient = new Ingredient(new IngredientId(), 'banana');
        $transformed = (new IngredientsTransformer())->transform($ingredient);

        expect($transformed)->toBeAn('array');
        expect($transformed)->toContainKey('name');
        expect($transformed['name'])->toBe('banana');
    });
});
