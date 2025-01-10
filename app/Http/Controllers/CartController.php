<?php

namespace App\Http\Controllers;

use App\Actions\Logs\LogCreateNewUserAction;
use App\Actions\Logs\LogNewOrderAction;
use App\Actions\Logs\LogUpdateIngredientAction;
use App\Models\Cart;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pizza;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $user_id = $request->user_id;

        if (!$user_id) {
            return response()->json(['error' => 'Nie znaleziono użytkownika. Upewnij się, że jesteś zalogowany.'], 401);
        }

        $cart = Cart::query()->firstOrCreate(['user_id' => $user_id]);

        $cartItem = CartItem::query()->where(
            [
                'cart_id' => $cart->id,
                'item_id' => $request->item_id,
                'item_type' => $request->item_type,
            ])
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cartItem = CartItem::query()->create([
                'cart_id' => $cart->id,
                'item_id' => $request->item_id,
                'item_type' => $request->item_type,
                'quantity' => $request->quantity,
                'price' => $request->price,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Dodano do koszyka', 'item' => $cartItem]);
    }

    public function order(Request $request, int $user_id, LogNewOrderAction $logNewOrderAction)
    {
        $totalPrice = 0;

        if (!$user_id) {
            return response()->json(['error' => 'Nie znaleziono użytkownika. Upewnij się, że jesteś zalogowany.'], 401);
        }

        $cart = Cart::query()->where('user_id', $user_id)->first();
        $cartItems = CartItem::query()
            ->where('cart_id', $cart->id)
            ->get();

        if($cartItems->isEmpty()){
            return response()->json(['error' => 'Twój koszyk jest pusty. Upewnij się, że jesteś zalogowany i koszyk nie jest pusty.']);
        }

        $order = Order::create([
            'user_id' => $user_id,
            'status' => 'pending',
            'total_price' => 0,
        ]);


        foreach ($cartItems as $cartItem){
            $totalPrice += $cartItem->price * $cartItem->quantity;
            $itemData = [
                'order_id' => $order->id,
                'item_type' => $cartItem->item_type,
                'item_id' => $cartItem->item_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price
            ];

            OrderItem::create($itemData);

        }


        return view('client.orders.completed', compact('cartItems'));
    }

    public function order_old(Request $request, int $user_id, LogNewOrderAction $logNewOrderAction)
    {

        if (!$user_id) {
            return response()->json(['error' => 'Nie znaleziono użytkownika. Upewnij się, że jesteś zalogowany.'], 401);
        }

        $cart = Cart::query()->where('user_id', $user_id)->first();

        $cartItems = CartItem::query()
            ->where('cart_id', $cart->id)
            ->get();
        $totalPrice = 0;
        $data = [
            'user_id' => $user_id,
            'status' => 'pending',
            'total_price' => 0,
        ];
        $order = Order::create($data);
        if ($cartItems) {
            foreach ($cartItems as $cartItem) {
                $itemData = [
                    'order_id' => $order->id,
                    'item_type' => $cartItem->item_type,
                    'item_id' => $cartItem->item_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price
                ];
                $totalPrice += $cartItem->price * $cartItem->quantity;
                OrderItem::create($itemData);
                $ingredients = $cartItem->item->ingredients;

                if ($cartItem->item_type == 'EditedPizza') {
                    $removedIngredients = [];
                    foreach ($ingredients as $deletedIngredient) {
                        if ($deletedIngredient->action == 'added') {
                            $totalQuantity = $deletedIngredient->ingredient->quantityOnPizza * $cartItem->quantity;
                            Ingredient::query()
                                ->where('id', $deletedIngredient->ingredient_id)
                                ->decrement('quantity', $totalQuantity);
                            $dbIngredient = Ingredient::query()
                                ->where('id', $deletedIngredient->ingredient_id)
                                ->first();
                            $this->checkLowStock($dbIngredient->quantity);
                        } else {
                            $removedIngredients[] = $deletedIngredient->ingredient_id;
                        }
                    }
                    $baseIngredients = $cartItem->item->basePizza->ingredients;
                    foreach ($baseIngredients as $baseIngredient) {
                        if (!in_array($baseIngredient->id, $removedIngredients)) {
                            if($baseIngredient->pivot){
                                $baseIngredientQuantity = $baseIngredient->pivot->quantity;
                            }else{
                                $baseIngredientQuantity = $baseIngredient->quantityOnPizza;
                            }
                            $totalQuantity = $baseIngredientQuantity * $cartItem->quantity;
                            Ingredient::query()
                                ->where('id', $baseIngredient->id)
                                ->decrement('quantity', $totalQuantity);
                            $dbIngredient = Ingredient::query()
                                ->where('id', $baseIngredient->id)
                                ->first();
                            $this->checkLowStock($dbIngredient->quantity);
                        }
                    }

                } elseif ($cartItem->item_type == 'Pizza') {
                    foreach ($ingredients as $ingredient) {
                        $totalQuantity = $ingredient->pivot->quantity * $cartItem->quantity;
                        Ingredient::query()
                            ->where('id', $ingredient->id)
                            ->decrement('quantity', $totalQuantity);
                        $dbIngredient = Ingredient::query()
                            ->where('id', $ingredient->id)
                            ->first();
                        $this->checkLowStock($dbIngredient->quantity);
                    }

                } else { // CustomPizza
                    foreach ($ingredients as $ingredient) {
                            $totalQuantity = $ingredient->quantityOnPizza * $cartItem->quantity;
                            Ingredient::query()
                                ->where('id', $ingredient->id)
                                ->decrement('quantity', $totalQuantity);
                            $dbIngredient = Ingredient::query()
                                ->where('id', $ingredient->id)
                                ->first();
                            $this->checkLowStock($dbIngredient->quantity);
                    }
                }
            }

            CartItem::query()
                ->where('cart_id', $cart->id)
                ->delete();
            $order->update(['total_price' => $totalPrice]);

            $logNewOrderAction->execute($user_id, ['cart_id' => $cart->id]);
        } else {
            return response()->json(['error' => 'Twój koszyk jest pusty. Upewnij się, że jesteś zalogowany i koszyk nie jest pusty.'],
                401);
        }
        return view('client.orders.completed', compact('cartItems'));
    }

    public function index(Request $request, int $user_id)
    {

        $cart = Cart::query()
            ->with('items.item')
            ->where('user_id', $user_id)
            ->first();
        if (!$cart) {
            return response()->json(['message' => 'Koszyk jest pusty']);
        }
        return response()->json(['cart' => $cart]);
    }

    private function checkLowStock(int $quantity)
    {
        if ($quantity > 1000) {
            Artisan::call('notify:low-stock');
        }
    }
}
