<?php

namespace App\Actions\Statistics;

use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class GetStatisticsAction
{
    public function execute(Carbon $timeRange): array
    {
        $statistics = [
            'ingredients' => [],
            'products' => [],
            'pizzas' => []
        ];
        $orderItems = OrderItem::query()->where('created_at', '>', $timeRange)->get();

        foreach ($orderItems as $orderItem) {
            $ingredients = $orderItem->item->ingredients;
            $item_type = $orderItem->item_type;
            $quantity = $orderItem->quantity;

            $statistics = $this->countProducts($statistics, $item_type, $quantity);
            $statistics['ingredients'] = $this->countIngredients($ingredients);

            if ($item_type == 'Pizza') {
                $statistics = $this->countPizzas($statistics, $orderItem->item->name, $quantity);
            }
        }
        return $statistics;
    }

    public function countProducts(array $statistics, string $item_type, int $quantity): array
    {
        if (isset($statistics['products'][$item_type])) {
            $statistics
                ['products']
                [$item_type] += $quantity;
        } else {
            $statistics
                ['products']
                [$item_type] = $quantity;
        }
        return $statistics;
    }

    public function countPizzas(array $statistics, string $pizzaName, int $quantity): array
    {
        if (isset($statistics['pizzas'][$pizzaName])) {
            $statistics
                ['pizzas']
                [$pizzaName] += $quantity;
        } else {
            $statistics
                ['pizzas']
                [$pizzaName] = $quantity;
        }
        return $statistics;
    }

    public function countIngredients(Collection $ingredients): array
    {
        $ingredientsUsage = [];

        foreach ($ingredients as $ingredient) {
            $ingredientName = $ingredient->name;
            $ingredientQuantity = $ingredient->quantityOnPizza;

            if (isset($ingredientsUsage[$ingredientName])) {
                $ingredientsUsage
                [$ingredientName] += $ingredientQuantity;
            } else {
                $ingredientsUsage
                [$ingredientName] = $ingredientQuantity;
            }
        }

        return $ingredientsUsage;
    }
}
