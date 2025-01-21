@include('shared.header')

@if($cart)

    <form action="{{ route('client.cart.order')}}" method="POST">
        @csrf
        <button type="submit">{{__('client.orderButton')}}</button>
    </form>
    <p>
    {{__('client.totalPrice')}}: {{$cart->totalPrice}} zł
</p>
<table>
    @foreach($cart->items as $cartItem)
        <tr>
            <td>{{$cartItem->item->name}}</td>
            <td>
                <table>
                    @foreach($cartItem->item->ingredients as $ingredient)
                        <tr>
                            <td>{{ $ingredient->translatedName }}</td>
                        </tr>
                    @endforeach
                </table>
            </td>
            <td>
                {{$cartItem->price}} zł
            </td>
            <td>
                <form action="{{ route('client.cart.patchQuantity', $cartItem->id )}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <label for="quantity">{{__('client.quantity')}}</label>
                    <input type="number" min="0" name="quantity" id="quantity" value="{{$cartItem->quantity}}">
                    <br>
                    <button type="submit">{{__('client.updateQuantity')}}</button>
                </form>
            </td>
            <td>
                <form action="{{ route('client.cart.destroyitem', $cartItem->id )}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">X</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
@else
<h2>{{__('client.emptyCart')}}</h2>
@endif

<style>
table, tr, td, th {
    border: 1px solid black;
    text-align: center;
}
</style>
