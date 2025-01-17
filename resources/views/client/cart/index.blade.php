@include('shared.header')

@if($cart)

    <form action="{{ route('client.cart.order')}}" method="POST">
        @csrf
        <button type="submit">Order</button>
    </form>
    <table>
        @foreach($cart->items as $cartItem)
            <tr>
                <td>{{$cartItem->item->name}}</td>
                <td>
                    <table>
                        @foreach($cartItem->item->ingredients as $ingredient)
                            <tr>
                                <td>{{ $ingredient->translations->first()->name ?? $ingredient->name }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
                <td>
                    <form action="{{ route('client.cart.patchQuantity', $cartItem->id )}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <label for="quantity">Quantity</label>
                        <input type="number" min="0" name="quantity" id="quantity" value="{{$cartItem->quantity}}">
                        <br>
                        <button type="submit">Update quantity</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('client.cart.destroyitem', $cartItem->id )}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@else
    <h2>Brak produktów w koszyku</h2>
@endif

<style>
    table, tr, td, th {
        border: 1px solid black;
        text-align: center;
    }
</style>
