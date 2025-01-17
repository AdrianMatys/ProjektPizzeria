<?php

namespace App\Actions\Pizzas;

use App\Http\Requests\AddItemToCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Pizza;
use App\Services\LoggerService;

class UpdatePizzaAsEmployeeAction
{
    public function __construct(private AttachIngredientToPizzaAction $attachIngredientToPizzaAction)
    {}
    public function execute(array $pizzaData,Pizza $pizza): void
    {
        $pizza->update($pizzaData);
        $pizza->ingredients()->detach();

        $this->attachIngredientToPizzaAction->execute($pizzaData['ingredient'], $pizza);

    }

}
