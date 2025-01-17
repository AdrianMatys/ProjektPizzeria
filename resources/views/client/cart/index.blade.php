@include('shared.header')

@if($cart)
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
                <td>Quantity: {{$cartItem->quantity}}</td>
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
        bcart: 1px solid black;
        text-align: center;
    }
</style>
