<?php

namespace App\Http\Controllers\Client;

use App\Actions\Orders\AddItemToCartAction;
use App\Actions\Logs\LogNewOrderAction;
use App\Actions\Orders\CheckIngredientQuantityAction;
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

        return response()->json(['success' => true, 'message' => __('client.addedToCart')]);
    }

    public function order(
        LogNewOrderAction $logNewOrderAction,
        CreateOrderItemsFromCartItemsAction $createOrderItemsFromCartItemsAction,
        CheckIngredientQuantityAction $checkIngredientQuantityAction
    ) {
        /** @var User $user */
        $user = auth()->user();

        if(!$checkIngredientQuantityAction->hasEnough($user->cart->items))
            return redirect()->route('client.menu.index')->with('error', __('client.notEnoughIngredients'));

        $createOrderItemsFromCartItemsAction->execute($user->cart->items, $user->cart->id);

        $cartItemsString = $user->cart->items->map(function ($item) {
            return $item->item->name;
        })->implode(', ');

        $logNewOrderAction->execute($user->id, ['Cart items' => $cartItemsString]);

        return redirect(route('client.menu.index'))->with('success', __('client.orderPlaced'))->with('resetCart', true);
    }

    public function getJson()
    {
        $cart = Cart::query()
            ->with('items.item')
            ->where('user_id', auth()->id())
            ->first();

        if ($cart && $cart->items && $cart->items->isEmpty()) {
            return response()->json(['message' => __('client.emptyCart')]);
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
            return redirect()->route('client.cart.index')->with('error', __('client.couldntRemoveItemFromCart'));
        }

        $cartItem->delete();
        return redirect()->route('client.cart.index')->with('success', __('client.deletedFromCart'));
    }
    public function patchQuantity(Request $request, $cartItemId)
    {
        $cartItem = CartItem::query()->find($cartItemId);

        if (!$cartItem) {
            return redirect()->route('client.cart.index')->with('error', __('client.couldntUpdateItemFromCart'));
        }

        $validated = $request->validate(['quantity' => ['required', 'integer', 'min:1']]);
        $cartItem->update(['quantity' => $validated['quantity']]);

        return redirect()->route('client.cart.index')->with('success', __('client.productQuantityUpdated'));
    }

}
