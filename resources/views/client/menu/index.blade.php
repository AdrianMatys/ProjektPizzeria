@include('shared.header')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #FFF5E6;
        color: #4A4A4A;
    }
    
    .container {
        padding: 20px;
    }
    
    .products-table {
        width: 100%;
        background-color: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.08);
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    
    .products-table th {
        background-color: #FF9800;
        color: #FFFFFF;
        padding: 15px;
        text-align: left;
    }
    
    .products-table td {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .products-table tr:last-child td {
        border-bottom: none;
    }
    
    .btn {
        background-color: #FF5722;
        color: #FFFFFF;
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    
    .btn:hover {
        background-color: #F4511E;
    }
    
    .modify-link {
        color: #FF9800;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .modify-link:hover {
        color: #F57C00;
    }
    
    #cart {
        background-color: #FFFFFF;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: inline-block;
        margin-top: 20px;
        color: #FF5722;
        font-weight: 600;
    }
    
    .create-pizza-link {
        display: inline-block;
        background-color: #FF9800;
        color: #FFFFFF;
        padding: 12px 24px;
        text-decoration: none;
        border-radius: 8px;
        margin-top: 20px;
        transition: background-color 0.3s ease;
    }
    
    .create-pizza-link:hover {
        background-color: #F57C00;
    }
</style>

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
            const response = await fetch('cart/json', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
            })
            console.log(response)
            if(response.ok){
                const data = await response.json()
                let itemsLength = 0
                if(data?.cart?.items) itemsLength = data.cart.items.length
                let cart = document.getElementById('cart')
                    cart.innerHTML =  "W koszyku znajdują się " + itemsLength + " produkty"
            }else{
                console.log('Wystąpił błąd 1_1')
            }
        }catch (error){
            console.error("Wystąpił błąd 2_2: ", error)
        }
    }
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
        @foreach($pizzas as $pizza)
            <tr>
                <td>{{ $pizza->name }}</td>
                <td>
                    @foreach($pizza->ingredients as $ingredient)
                        {{ $ingredient->translations->first()->name ?? $ingredient->name }} ({{ $ingredient->quantityOnPizza}} g)
                    @endforeach
                </td>
                <td>
                    @if($pizza->unavailable)
                        {{__('client.unavailable')}}
                    @else
                        <input type="button" class="btn" value="{{__('client.add')}}" onclick="addToCart({{$pizza->id}}, 'Pizza', 1, 10.99)">
                    @endif
                </td>
                <td>
                    <a href={{ route("client.pizza.edit", $pizza) }} class="modify-link">{{__('client.modify')}}</a>
                </td>
            </tr>
        @endforeach
    </table>

    <a href={{ route("client.pizza.create", $pizza) }} class="create-pizza-link">{{__('client.createCustomPizza')}}</a>
    
    <div id="cart"></div>
</div>




