<?php declare(strict_types=1);

use BlueBook\Domain\Recipes\Recipe;
use BlueBook\Domain\Recipes\RecipeId;

describe(Recipe::class, function () {
    it('initialises with a UUID and name', function () {
        $recipe = new Recipe(
            new RecipeId(),
            'Banana Split',
            'Bonzo\'s favourite',
            5,
            1
        );

        expect($recipe->getRecipeId())->toBeAnInstanceOf(RecipeId::class);
        expect($recipe->getName())->toBe('Banana Split');
        expect($recipe->getDescription())->toBe('Bonzo\'s favourite');
        expect($recipe->getTiming())->toBe(5);
        expect($recipe->getServings())->toBe(1);
    });
});
