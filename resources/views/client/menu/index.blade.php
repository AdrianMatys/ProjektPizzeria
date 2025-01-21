@include('shared.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
async function addToCart(itemId, itemType, quantity, price, name) {
    try {
        const response = await fetch('cart/add', {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                user_id: {{auth()->user() ? auth()->user()->id : 'null'}},
                item_id: itemId,
                item_type: itemType,
                quantity: quantity,
                price: price,
            }),
        });
        if (response.ok) {
            const data = await response.json();
            window.cart.addItem(itemId, itemType, quantity, price, name);
        } else {
            console.log('error 1', response);
        }
    } catch (error) {
        console.error("error 2: ", error);
    }
}
</script>
<div class="products">
    @foreach($pizzas as $pizza)
        @if(!($pizza->unavailable))
            <div class="product">
                <div class="product-title">{{ $pizza->name }}</div>
                <div class="product-description">
                    {{$pizza->ingredients->map(fn($ingredient) => $ingredient->translatedName)->join(', ')}}
                </div>
                <div class="product-price">{{ $pizza->price }} zł</div>
                <div>
                    <input type="button" value="{{__('client.add')}}" onclick="addToCart({{$pizza->id}}, 'Pizza', 1, {{$pizza->price}}, '{{ $pizza->name }}')">
                    <input type="button" value="{{__('client.modify')}}" onclick="window.location.href='{{ route("client.pizza.edit", $pizza)}}'">
                </div>
            </div>
        @endif
    @endforeach
    
    <a href={{ route("client.pizza.create") }} class="button">{{__('client.createCustomPizza')}}</a>
</div>
<style>
    body {
        margin: 0;
        background-image: url('https://cdn.discordapp.com/attachments/1210997818773340291/1331216873903357962/Qs8h9maF1VKIwAAAABJRU5ErkJggg.png?ex=6790cfd3&is=678f7e53&hm=de12bc7651bdd9f349fed15d44eda7efa253d77924e2ed282fc4983cdba54903&'); 
        background-size: contain; 
        background-repeat: repeat;
        background-position: center; 
    }
    .products {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }
    .product {
        background-color:rgb(250, 217, 164);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        text-align: center;
        padding: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .product-info {
        padding: 20px;
    }
    .product-title {
        font-size: 1.1em;
        font-weight: 600;
        margin-bottom: 8px;
        color:rgb(58, 58, 58);
    }
    .product-description {
        font-size: 0.9em;
        color: #666;
        margin-bottom: 15px;
        line-height: 1.4;
    }
    .product-price {
        font-weight: 600;
        color: #FF5722;
        font-size: 1.2em;
    }
    .buttons {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-top: 10px;
    }
    .button {
        background-color: #FF5722;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 15px;
        cursor: pointer;
        text-align: center;
        align-items: center;
        text-decoration: none;
        transition: background-color 0.3s;
    }
    .button:hover {
        background-color: #e64a19;
    }
</style>