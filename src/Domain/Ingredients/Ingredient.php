<?php declare(strict_types=1);

namespace BlueBook\Domain\Ingredients;

class Ingredient
{
    /**
     * @var IngredientIdInterface
     */
    private $ingredientId;

    /**
     * @var string
     */
    private $name;

    /**
     * Ingredient constructor.
     *
     * @param IngredientIdInterface $ingredientId
     * @param string                $name
     */
    public function __construct(IngredientIdInterface $ingredientId, string $name)
    {
        $this->ingredientId = $ingredientId;
        $this->name = $name;
    }

    /**
     * @return IngredientIdInterface
     */
    public function getIngredientId(): IngredientIdInterface
    {
        return $this->ingredientId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
