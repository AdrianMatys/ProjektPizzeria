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
            if(response.ok){
                const data = await response.json()
                updateCart(data)
            }else{
                console.log('error 1', response)
            }
        }catch (error){
            console.error("error 2: ", error)
        }
    }
    async function updateCart() {
        try{
            const response = await fetch('cart/json', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
            })
            if(response.ok){
                const data = await response.json()
                let itemsLength = 0
                if(data?.cart?.items) itemsLength = data.cart.items.length
                let cart = document.getElementById('cart')
                    cart.innerHTML =  itemsLength + " {{__('client.productsInCart')}}"
            }else{
                console.log('Error 1.1')
            }
        }catch (error){
            console.error("error 2.2: ", error)
        }
    }
    updateCart()
</script>
<table>
    <tr>
        <th>{{__('client.name')}}</th>
        <th>{{__('client.ingredients')}}</th>
        <th>{{__('client.addToCart')}}</th>
        <th>{{__('client.modifyPizza')}}</th>
    </tr>
    @foreach($pizzas as $pizza)
        <tr>
            <td>{{ $pizza->name }}</td>
            <td>
                {{$pizza->ingredients->map(fn($ingredient) => $ingredient->translatedName)->join(', ')}}
            </td>
            <td>
                @if($pizza->unavailable)
                    {{__('client.unavailable')}}
                @else
                    <input type="button" value="{{__('client.add')}}" onclick="addToCart({{$pizza->id}}, 'Pizza', 1, 10.99)">
                @endif
            </td>
            <td>
                <a href={{ route("client.pizza.edit", $pizza) }}>{{__('client.modify')}}</a>
            </td>
        </tr>
    @endforeach
</table>

<a href={{ route("client.pizza.create", $pizza) }}>{{__('client.createCustomPizza')}}</a>
<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>

<hr>
<div id="cart"></div>




