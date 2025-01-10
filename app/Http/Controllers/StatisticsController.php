<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class StatisticsController extends Controller
{
    public function index()
    {
        $statistics = [
            'daily' => [
                'ingredients' => [],
                'products' => [],
            ],
            'weekly' => [
                'ingredients' => [],
                'products' => [],
                ],
            'monthly' => [
                'ingredients' => [],
                'products' => [],
            ],
        ];
        $orderItems = OrderItem::query()->get();

        $today = now()->startOfDay();
        $week = now()->startOfWeek();
        $month = now()->startOfMonth();

        foreach ($orderItems as $orderItem){
            $ingredients = $orderItem->item->ingredients;
            $createdAt = $orderItem->created_at;




            switch ($orderItem->item_type){
                case 'EditedPizza':
                    if($createdAt >= $today){
                        if(isset($statistics['daily']['products']['EditedPizza'])){
                            $statistics
                            ['daily']
                            ['products']
                            ['EditedPizza'] += 1;
                        }else{
                            $statistics
                            ['daily']
                            ['products']
                            ['EditedPizza'] = 1;
                        }
                    }
                    if($createdAt >= $week){
                        if(isset($statistics['weekly']['products']['EditedPizza'])){
                            $statistics
                            ['weekly']
                            ['products']
                            ['EditedPizza'] += 1;
                        }else{
                            $statistics
                            ['weekly']
                            ['products']
                            ['EditedPizza'] = 1;
                        }
                    }
                    if($createdAt >= $month){
                        if(isset($statistics['monthly']['products']['EditedPizza'])){
                            $statistics
                            ['monthly']
                            ['products']
                            ['EditedPizza'] += 1;
                        }else{
                            $statistics
                            ['monthly']
                            ['products']
                            ['EditedPizza'] = 1;
                        }
                    }
                    break;
                case 'CustomPizza':
                    if($createdAt >= $today){
                        if(isset($statistics['daily']['products']['CustomPizza'])){
                            $statistics
                            ['daily']
                            ['products']
                            ['CustomPizza'] += 1;
                        }else{
                            $statistics
                            ['daily']
                            ['products']
                            ['CustomPizza'] = 1;
                        }
                    }
                    if($createdAt >= $week){
                        if(isset($statistics['weekly']['products']['CustomPizza'])){
                            $statistics
                            ['weekly']
                            ['products']
                            ['CustomPizza'] += 1;
                        }else{
                            $statistics
                            ['weekly']
                            ['products']
                            ['CustomPizza'] = 1;
                        }
                    }
                    if($createdAt >= $month){
                        if(isset($statistics['monthly']['products']['CustomPizza'])){
                            $statistics
                            ['monthly']
                            ['products']
                            ['CustomPizza'] += 1;
                        }else{
                            $statistics
                            ['monthly']
                            ['products']
                            ['CustomPizza'] = 1;
                        }
                    }
                    break;
                case 'Pizza':

                    if($createdAt >= $today){
                        if(isset($statistics['daily']['products']['pizza'][$orderItem->item->name])){
                            $statistics
                            ['daily']
                            ['products']
                            ['pizza']
                            [$orderItem->item->name] += $orderItem->quantity;
                        }else{
                            $statistics
                            ['daily']
                            ['products']
                            ['pizza']
                            [$orderItem->item->name] = $orderItem->quantity;
                        }
                    }
                    if($createdAt >= $week){
                        if(isset($statistics['weekly']['products']['pizza'][$orderItem->item->name])){
                            $statistics
                            ['weekly']
                            ['products']
                            ['pizza']
                            [$orderItem->item->name] += $orderItem->quantity;
                        }else{
                            $statistics
                            ['weekly']
                            ['products']
                            ['pizza']
                            [$orderItem->item->name] = $orderItem->quantity;
                        }
                    }
                    if($createdAt >= $month){
                        if(isset($statistics['monthly']['products']['pizza'][$orderItem->item->name])){
                            $statistics
                            ['monthly']
                            ['products']
                            ['pizza']
                            [$orderItem->item->name] += $orderItem->quantity;
                        }else{
                            $statistics
                            ['monthly']
                            ['products']
                            ['pizza']
                            [$orderItem->item->name] = $orderItem->quantity;
                        }
                    }
                    break;
            }




            foreach ($ingredients as $ingredient){
                $quantity = 0;
                $name = '';

                switch ($orderItem->item_type){
                    case 'EditedPizza':
                        $quantity = $ingredient->ingredient->quantityOnPizza;
                        $name = $ingredient->ingredient->name;
                        break;
                    case 'Pizza':
                    case 'CustomPizza':
                        $quantity = $ingredient->quantityOnPizza;
                        $name = $ingredient->name;
                        break;
                }

                if($createdAt >= $today){
                    if(isset($statistics['daily']['ingredients'][$name])){
                        $statistics
                            ['daily']
                            ['ingredients']
                            [$name] += $quantity;
                    }else{
                        $statistics
                            ['daily']
                            ['ingredients']
                            [$name] = $quantity;
                    }
                }

                if($createdAt >= $week){
                    if(isset($statistics['weekly']['ingredients'][$name])){
                        $statistics
                        ['weekly']
                        ['ingredients']
                        [$name] += $quantity;
                    }else{
                        $statistics
                        ['weekly']
                        ['ingredients']
                        [$name] = $quantity;
                    }
                }

                if($createdAt >= $month){
                    if(isset($statistics['monthly']['ingredients'][$name])){
                        $statistics
                        ['monthly']
                        ['ingredients']
                        [$name] += $quantity;
                    }else{
                        $statistics
                        ['monthly']
                        ['ingredients']
                        [$name] = $quantity;
                    }
                }
            }
        }
        return view('management.admin.statistics.index', compact('statistics'));
    }
}
