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


<style>
    /* Styl dla tabeli */
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 16px;
        text-align: left;
        background-color: #f9f9f9;
    }
    th, td {
        padding: 12px;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    /* Styl dla przycisków */
    button {
        background-color: #FF9800;
        color: white;
        border: none;
        padding: 10px 15px;
        margin: 5px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #0056b3;
    }

    button:active {
        background-color: #004080;
    }

    /* Styl dla formularza */
    form {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    /* Styl dla linku anulowania */
    a {
        display: inline-block;
        color: #FF9800;
        text-decoration: none;
        margin-top: 10px;
        font-size: 14px;
    }

    a:hover {
        text-decoration: underline;
    }

    /* Styl ogólny dla strony */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        line-height: 1.6;
    }

    /* Styl dla nagłówka */
    h1, h2, h3 {
        text-align: center;
        margin-bottom: 20px;
    }

    /* Dostosowanie pola select */
    select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

</style>
