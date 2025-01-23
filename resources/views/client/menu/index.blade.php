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

function filterByIngredients() {
    const selectedIngredients = Array.from(document.querySelectorAll('.ingredient-filter-checkbox:checked'))
        .map(checkbox => checkbox.id.replace('filter_ingredient_', ''));

    const products = document.querySelectorAll('.product');
    
    products.forEach(product => {
        if (selectedIngredients.length === 0) {
            // If no ingredients selected, show all products
            product.style.display = 'flex';
            return;
        }

        const ingredientsText = product.querySelector('.product-description').textContent;
        const shouldShow = selectedIngredients.every(ingredientId => {
            const ingredient = document.querySelector(`#filter_ingredient_${ingredientId}`).nextElementSibling.textContent.trim();
            return ingredientsText.includes(ingredient);
        });

        product.style.display = shouldShow ? 'flex' : 'none';
    });
}

function openCreatePizzaModal() {
    const modal = document.getElementById('createPizzaModal');
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    document.body.style.paddingRight = '15px'; // Prevent layout shift
}

function closeCreatePizzaModal() {
    const modal = document.getElementById('createPizzaModal');
    modal.style.display = 'none';
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
}

async function submitCreatePizza(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    
    try {
        const response = await fetch('{{ route("client.pizza.store") }}', {
            method: 'POST',
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        });
        
        if (response.ok) {
            closeCreatePizzaModal();
            window.location.reload();
        } else {
            console.error('Error creating pizza');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}
</script>
<div class="empty">
    <div class="filter-sidebar">
        <h3>{{__('client.filters')}} <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-funnel-fill" viewBox="0 0 16 16">
            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5z"/>
        </svg></h3>

        <!-- Price range filter first -->
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

        <!-- Ingredients filter below -->
        <div class="ingredients-filter">
            <h4>{{__('client.ingredients')}}</h4>
            <div class="ingredients-checkbox-list">
                @foreach($ingredients as $ingredient)
                    <div class="filter-checkbox-item">
                        <input type="checkbox" 
                               id="filter_ingredient_{{$ingredient->id}}" 
                               onchange="filterByIngredients()"
                               class="ingredient-filter-checkbox">
                        <label for="filter_ingredient_{{$ingredient->id}}">
                            {{$ingredient->translatedName}}
                        </label>
                    </div>
                @endforeach
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

            <button onclick="openCreatePizzaModal()" class="button">{{__('client.createCustomPizza')}}</button>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="createPizzaModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeCreatePizzaModal()">&times;</span>
        <h2>{{__('client.createCustomPizza')}}</h2>
        <form onsubmit="submitCreatePizza(event)">
            <div class="form-group">
                <label>{{__('client.ingredients')}}</label>
                <div class="ingredients-selection">
                    @foreach($ingredients as $ingredient)
                        <div class="ingredient-item">
                            <div class="ingredient-checkbox">
                                <input type="checkbox" 
                                       id="ingredient_{{$ingredient->id}}" 
                                       name="ingredients[]" 
                                       value="{{$ingredient->id}}">
                            </div>
                            <label for="ingredient_{{$ingredient->id}}" class="ingredient-label">
                                <span class="ingredient-name">{{$ingredient->translatedName}}</span>
                                <span class="ingredient-price">{{$ingredient->price}} zł</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="create-button">{{__('client.create')}}</button>
        </form>
    </div>
</div>

<style>
    .empty{
        display: flex;
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
        height: calc(100vh - 40px); /* Adjust height to prevent overflow */
        overflow-y: auto;
        border-top-right-radius: 10px;
        border-bottom-right-radius:10px;
    }
    .filter-sidebar h3 {
        color: rgb(0, 0, 0);
        margin-bottom: 15px;
    }
    .price-range-container {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
    .product input[type="button"] {
        background: linear-gradient(to right, #ff4e00, #ff7a00);
        color: white;
        border: none;
        border-radius: 25px;
        padding: 8px 16px;
        margin: 5px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .product input[type="button"]:hover {
        background: linear-gradient(to right, #ff7a00, #ff4e00);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .modal {
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }

    .modal-content {
        background-color: rgb(250, 217, 164);
        margin: 5% auto;
        padding: 30px;
        border-radius: 15px;
        width: 90%;
        max-width: 500px;
        position: relative;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }

    .close {
        position: absolute;
        right: 20px;
        top: 15px;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        color: #666;
        transition: color 0.3s ease;
    }

    .close:hover {
        color: #ff4e00;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        color: rgb(58, 58, 58);
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .form-group textarea {
        height: 100px;
        resize: vertical;
    }

    .ingredients-selection {
        background: white;
        border-radius: 10px;
        padding: 15px;
        max-height: 400px;
        overflow-y: auto;
    }

    .ingredient-item {
        display: flex;
        align-items: center;
        padding: 12px;
        border-bottom: 1px solid #eee;
        transition: background-color 0.2s;
    }

    .ingredient-item:last-child {
        border-bottom: none;
    }

    .ingredient-item:hover {
        background-color: #fff5e6;
    }

    .ingredient-checkbox {
        margin-right: 15px;
    }

    .ingredient-checkbox input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .ingredient-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-grow: 1;
        cursor: pointer;
    }

    .ingredient-name {
        font-size: 1.1em;
        color: #333;
    }

    .ingredient-price {
        color: #ff4e00;
        font-weight: 600;
        font-size: 1.1em;
        margin-left: 15px;
    }

    .create-button {
        background: linear-gradient(to right, #ff4e00, #ff7a00);
        color: white;
        border: none;
        border-radius: 25px;
        padding: 12px 30px;
        font-size: 1.1em;
        font-weight: 600;
        cursor: pointer;
        margin-top: 20px;
        width: 100%;
        transition: all 0.3s ease;
    }

    .create-button:hover {
        background: linear-gradient(to right, #ff7a00, #ff4e00);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 78, 0, 0.2);
    }

    .modal h2 {
        text-align: center;
        color: #333;
        margin-bottom: 25px;
        font-size: 1.8em;
    }

    /* Scrollbar styling */
    .ingredients-selection::-webkit-scrollbar {
        width: 8px;
    }

    .ingredients-selection::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .ingredients-selection::-webkit-scrollbar-thumb {
        background: #ff7a00;
        border-radius: 4px;
    }

    .ingredients-selection::-webkit-scrollbar-thumb:hover {
        background: #ff4e00;
    }

    .ingredients-filter {
        background: white;
        border-radius: 10px;
        padding: 15px;
        margin-top: 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .ingredients-filter h4 {
        margin: 0 0 10px 0;
        color: #333;
    }

    .ingredients-checkbox-list {
        max-height: 300px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .filter-checkbox-item {
        display: flex;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }

    .filter-checkbox-item:last-child {
        border-bottom: none;
    }

    .filter-checkbox-item input[type="checkbox"] {
        margin-right: 10px;
        cursor: pointer;
    }

    .filter-checkbox-item label {
        cursor: pointer;
        color: #444;
        font-size: 0.9em;
    }

    .filter-checkbox-item:hover {
        background-color: #f8f8f8;
    }

    body.modal-open {
        overflow: hidden;
        position: fixed;
        width: 100%;
    }
</style>
