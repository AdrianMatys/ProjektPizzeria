@include('shared.header')
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    async function addToCart(itemId, itemType, quantity , price) {
        try{
            const response = await fetch('cart/add', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    user_id: {{auth()->user() ? auth()->user()->id : 'null'}},
                    item_id: itemId,
                    item_type: itemType,
                    quantity: quantity,
                    price: price,
                }),
            })
            console.log(response)
            if(response.ok){
                const data = await response.json()
                console.log('Dodano do koszyka: ', data)
                updateCart(data)
            }else{
                console.log('Wystąpił błąd 1', response)
            }
        }catch (error){
            console.error("Wystąpił błąd 2: ", error)
        }
    }
    async function updateCart() {
        try{
            const response = await fetch('cart', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
            })
            console.log(response)
            if(response.ok){
                const data = await response.json()
                console.log('Dane koszyka: ', data)
                let cart = document.getElementById('cart')
                    cart.innerHTML = JSON.stringify(data)
            }else{
                console.log('Wystąpił błąd 1_1')
            }
        }catch (error){
            console.error("Wystąpił błąd 2_2: ", error)
        }
    }
    //addToCart(1, 'pizzas', 1, 10.99)
    updateCart()
</script>
<table>
    <tr>
        <th>name</th>
        <th>ingredients</th>
        <th>Add to cart</th>
        <th>Modify Pizza</th>
    </tr>
    @foreach($pizzas as $pizza)
        <tr>
            <td>{{ $pizza->name }}</td>
            <td>
                @foreach($pizza->ingredients as $ingredient)
                    {{ $ingredient->translations->first()->name ?? $ingredient->name }} ({{ $ingredient->quantityOnPizza}} g)
                @endforeach
            </td>
            <td>
                {{--<a href="{{ route('cart.add', $pizza->id) }}">Add</a>--}}
                @if($pizza->unavailable)
                    unavailable
                @else
                    <input type="button" value="Add" onclick="addToCart({{$pizza->id}}, 'Pizza', 1, 10.99)">
                @endif
            </td>
            <td>
                <a href={{ route("client.pizza.edit", $pizza) }}>Modify</a>
            </td>
        </tr>
    @endforeach
</table>

<a href={{ route("client.pizza.create", $pizza) }}>Custom pizza</a>
<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>

<hr>
<h1>KOSZYK</h1>
<hr>
<div id="cart"></div>

<form action="{{route('cart.order')}}" method="post">
    @csrf
    <button type="submit">Zamów</button>
</form>



