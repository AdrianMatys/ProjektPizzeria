<?php

namespace App\Http\Controllers;

use App\Actions\Orders\AddItemToCartAction;
use App\Actions\Logs\LogNewOrderAction;
use App\Actions\Orders\CreateOrderItemsFromCartItemsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddItemToCartRequest;
use App\Models\Cart;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;

class CartController extends Controller
{
    public function addToCart(AddItemToCartRequest $request, AddItemToCartAction $addItemToCartAction)
    {
        $validated = $request->validated();
        $addItemToCartAction->execute($validated);

        return response()->json(['success' => true, 'message' => 'Dodano do koszyka']);
    }

    public function order(
        LogNewOrderAction $logNewOrderAction,
        CreateOrderItemsFromCartItemsAction $createOrderItemsFromCartItemsAction
    ) {
        /** @var User $user */
        $user = auth()->user();

        $createOrderItemsFromCartItemsAction->execute($user->cart->items, $user->cart->id);

        $logNewOrderAction->execute($user->id, ['cart_id' => $user->cart->id]);

        return view('client.orders.completed', ['cartItems' => $user->cart->items]);
    }

    public function getJson()
    {
        $cart = Cart::query()
            ->with('items.item')
            ->where('user_id', auth()->id())
            ->first();

        if ($cart && $cart->items && $cart->items->isEmpty()) {
            return response()->json(['message' => 'Koszyk jest pusty']);
        }

        return response()->json(['cart' => $cart]);
    }

    public function index()
    {
        $cart = Cart::query()
            ->with('items.item')
            ->where('user_id', auth()->id())
            ->first();

        if (!$cart || !$cart->items || $cart->items->isEmpty()) {
            return view('client.cart.index', ['cart' => []]);
        }
        return view('client.cart.index', ['cart' => $cart]);
    }
    public function destroyItem($cartItemId)
    {
        $cartItem = CartItem::query()->find($cartItemId);

        if (!$cartItem) {
            return redirect()->route('client.cart.index')->with('error', 'Nie udało się usunąć przedmiotu z koszyka');
        }

        $cartItem->delete();
        return redirect()->route('client.cart.index')->with('success', 'Produkt został usunięty z koszyka');
    }

}
