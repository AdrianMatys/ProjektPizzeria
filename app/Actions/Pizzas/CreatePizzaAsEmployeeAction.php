<?php

namespace App\Actions\Pizzas;

use App\Http\Requests\AddItemToCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Pizza;
use App\Services\LoggerService;

class CreatePizzaAsEmployeeAction
{
    public function __construct(private AttachIngredientToPizzaAction $attachIngredientToPizzaAction)
    {}
    public function execute(array $pizzaData): void
    {
        $pizza = Pizza::create($pizzaData);

        $this->attachIngredientToPizzaAction->execute($pizzaData['ingredient'], $pizza);
    }

}
