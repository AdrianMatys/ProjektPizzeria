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

function filterByPrice() {
    const minPrice = document.getElementById('minPriceRange').value;
    const maxPrice = document.getElementById('maxPriceRange').value;
    
    document.getElementById('currentMinPrice').textContent = minPrice + ' zł';
    document.getElementById('currentMaxPrice').textContent = maxPrice + ' zł';
    
    const products = document.querySelectorAll('.product');
    products.forEach(product => {
        const price = parseFloat(product.querySelector('.product-price').textContent);
        if (price >= minPrice && price <= maxPrice) {
            product.style.display = 'flex';
        } else {
            product.style.display = 'none';
        }
    });
}
</script>
<div class="empty">
    <div class="filter-sidebar">
        <h3>{{__('client.filters')}} <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-funnel-fill" viewBox="0 0 16 16">
  <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5z"/>
</svg></h3>
        <div class="price-range-container">
            <div class="price-labels">
                <span id="currentMinPrice">0 {{__('client.waluta')}}</span>
                <span id="currentMaxPrice">100 {{__('client.waluta')}}</span>
            </div>
            <div class="slider-container">
                <input type="range" id="minPriceRange" min="0" max="100" value="0" oninput="filterByPrice()">
                <input type="range" id="maxPriceRange" min="0" max="100" value="100" oninput="filterByPrice()">
            </div>
        </div>
    </div>
<div class="container">
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
</div>
</div>
<style>
    .empty{
        display: flex;
    }
    body {
        margin: 0;
        background-image: url('https://cdn.discordapp.com/attachments/1210997818773340291/1331216873903357962/Qs8h9maF1VKIwAAAABJRU5ErkJggg.png?ex=6790cfd3&is=678f7e53&hm=de12bc7651bdd9f349fed15d44eda7efa253d77924e2ed282fc4983cdba54903&');
        background-size: contain;
        background-repeat: repeat;
        background-position: center;
    }
    .container {
        display: flex;
        gap: 20px;
        padding: 20px;
        height: fit-content;
    }
    .filter-sidebar {
        width: 250px;
        background: linear-gradient(to right, rgb(247, 152, 0), rgb(245, 175, 61));
        padding: 20px;
        position: sticky;
        top: 20px;
        height: 100vh;
    }
    .filter-sidebar h3 {
        color: rgb(0, 0, 0);
        margin-bottom: 15px;
    }
    .price-range-container {
        padding: 20px 10px;
    }
    .price-labels {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .slider-container {
        position: relative;
        width: 100%;
        height: 40px;
    }
    .slider-container input[type="range"] {
        position: absolute;
        width: 100%;
        pointer-events: none;
        -webkit-appearance: none;
        z-index: 2;
        height: 10px;
        background: none;
    }
    .slider-container input[type="range"]::-webkit-slider-thumb {
        pointer-events: all;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        -webkit-appearance: none;
        background-color:rgb(34, 167, 255);
        cursor: pointer;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        margin-top: -7px;
        opacity: 1;
    }
    .slider-container input[type="range"]::-moz-range-thumb {
        pointer-events: all;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: #FF5722;
        cursor: pointer;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        margin-top: -7px;
    }
    .slider-container input[type="range"]::-ms-thumb {
        pointer-events: all;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: #FF5722;
        cursor: pointer;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        margin-top: -7px;
    }
    .slider-container::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 6px;
        background: #e0e0e0;
        border-radius: 3px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1;
    }
    #minPriceRange {
        top: 50%;
        transform: translateY(-50%);
    }
    #maxPriceRange {
        top: 50%;
        transform: translateY(-50%);
    }
    .products {
        flex: 1;
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
