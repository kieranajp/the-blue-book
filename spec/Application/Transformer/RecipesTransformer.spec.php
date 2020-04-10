<?php declare(strict_types=1);

use BlueBook\Application\Transformer\RecipesTransformer;
use BlueBook\Domain\Recipes\Recipe;
use BlueBook\Domain\Recipes\RecipeId;

describe(RecipesTransformer::class, function () {

    it('transforms an recipe', function () {
        $recipe = new Recipe(
            new RecipeId(),
            'Banana Split',
            'Bonzo\'s favourite',
            5,
            1
        );
        $transformed = (new RecipesTransformer())->transform($recipe);

        expect($transformed)->toBeAn('array');
        expect($transformed)->toContainKey('name');
        expect($transformed['name'])->toBe('Banana Split');
    });
});
