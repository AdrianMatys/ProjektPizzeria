@include('shared.return-message')
@include('shared.simplecss')
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <style>
        .header {
            display: flex;
            align-items: center;
            gap: 2rem;
            flex-wrap: wrap;
            padding: 0.5rem 1rem;
        }

        .logo {
            height: 2rem;
            text-decoration: none;
            color: #FF9800;
            font-size: 1.5rem;
            font-weight: bold;
            background: linear-gradient(to right, #f7bf09, #FF9800);
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .language-dropdown {
            position: relative;
        }

        .language-btn {
            background: none;
            border: 1px solid #FF9800;
            color: #FF9800;
            padding: 0.5rem 1rem;
            border-radius: 4rem;
            font-size: 1rem;
            cursor: pointer;
        }

        .language-btn:hover {
            background-color: #FF9800;
            color: white;
        }

        .language-dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 120px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 4px;
            overflow: hidden;
        }

        .language-dropdown-content a {
            color: #FF9800;
            text-decoration: none;
            display: block;
            padding: 0.5rem 1rem;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .language-dropdown-content a:hover {
            background-color: #FF9800;
            color: white;
        }

        .language-dropdown:hover .language-dropdown-content {
            display: block;
        }

        .search-container {
            flex: 1;
            min-width: 200px;
        }

        .search-bar {
            padding: 0.5rem;
            padding-left: 1rem;
            border: 0.1rem solid #FF9800;
            border-radius: 4rem;
            width: 100%;
            min-width: 0;
        }

        .search-bar::placeholder {
            color: #FF9800;
            opacity: 0.7;
        }

        .search-bar:focus {
            border-color: #FF9800;
            outline: none;
        }

        img {
            height: 2.5rem;
            width: 2.5rem;
        }

        .cart-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            position: relative;
        }

        .cart-dropdown {
            display: none;
            position: absolute;
            right: 0;
            background-color: #fff;
            min-width: 20rem;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.2);
            border-radius: 0.5rem;
            padding: 1rem;
            z-index: 1;
        }

        .cart-btn:hover .cart-dropdown {
            display: block;
        }

        .cart-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item-name {
            flex: 1;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-btn {
            background: none;
            border: 1px solid #FF9800;
            color: #FF9800;
            border-radius: 50%;
            width: 1.5rem;
            height: 1.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            line-height: 1;
        }

        .quantity-btn:hover {
            background-color: #FF9800;
            color: white;
        }

        .remove-item {
            color: #FF9800;
            background: none;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .checkout-btn {
            background: #FF9800;
            color: white;
            border: none;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            width: 100%;
            margin-top: 1rem;
            cursor: pointer;
        }

        .checkout-btn:hover {
            background: #FF9800;
        }

        .cart-empty {
            text-align: center;
            padding: 2rem;
            color: #666;
            font-size: 1.1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .cart-empty img {
            width: 4rem;
            height: 4rem;
            opacity: 0.5;
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
            padding-top: 0.5rem;
            border-top: 1px solid #eee;
            font-weight: bold;
        }

        .item-price {
            margin-left: auto;
            margin-right: 1rem;
        }

        .menu {
            color: #FF9800;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .menu-item {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            background-color: #2b2b2b;
            border-radius: 0.25rem;
            transition: background-color 0.3s ease;
            font-size: 0.9rem;
        }

        .menu-item:hover {
            background-color: #191919;
        }

        .options-dropdown {
            position: relative;
            display: inline-block;
            margin-left: -1rem;
        }

        .options-icon {
            height: 1.5rem;
            width: 1.5rem;
            cursor: pointer;
            object-fit: contain;
        }

        .options-icon:hover {
            transform: scale(1.1);
        }

        .dropdown {
            position: relative;
            margin-left: -20px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #424141;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content {
            right: 0;
            min-width: 180px;
            max-width: 300px;
            word-wrap: break-word;
        }

        .dropdown-content a:hover {
            background-color: #323131;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
        .dropdown-content a {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            line-height: 1.5;
        }

        .auth-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .auth-section form {
            display: flex;
            align-items: center;
            margin: 0;
        }

        .auth-btn {
            text-decoration: none;
            background: none;
            border: 1px solid #FF9800;
            color: #FF9800;
            padding: 0.5rem 1rem;
            border-radius: 4rem;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .auth-btn:hover {
            background-color: #FF9800;
            color: white;
        }

        .cart-icon {
            width: 1.5rem;
            height: 1.5rem;
            color: #FF9800;
            transition: transform 0.3s ease;
        }

        .cart-btn:hover .cart-icon {
            transform: scale(1.2) rotate(-5deg);
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.cart = {
                items: [],

                updateDisplay() {
                    const cartDropdown = document.querySelector('.cart-dropdown');
                    const cartCount = document.querySelector('.cart-count');
                    const totalItems = this.items.reduce((sum, item) => sum + item.quantity, 0);
                    cartCount.textContent = totalItems;

                    if (this.items.length === 0) {
                        cartDropdown.innerHTML = `
                            <div class="cart-empty">
                                <img src="/assets/empty-cart.png" alt="Pusty koszyk">
                                <div>Twój koszyk jest pusty</div>
                                <a href="/@Menu.html" class="checkout-btn">Przejdź do menu</a>
                            </div>
                        `;
                        return;
                    }

                    const itemsHTML = this.items.map(item => `
                        <div class="cart-item" data-id="${item.id}" data-type="${item.type}">
                            <span class="cart-item-name">${item.name}</span>
                            <div class="quantity-controls">
                                <button class="quantity-btn minus">-</button>
                                <span>${item.quantity}</span>
                                <button class="quantity-btn plus">+</button>
                            </div>
                            <span class="item-price">${(item.price * item.quantity).toFixed(2)} zł</span>
                            <button class="remove-item">×</button>
                        </div>
                    `).join('');

                    const total = this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                    cartDropdown.innerHTML = `
                        ${itemsHTML}
                        <div class="cart-total">
                            <span>Suma:</span>
                            <span>${total.toFixed(2)} zł</span>
                        </div>
                        <button class="checkout-btn">Zapłać</button>
                    `;
                },

                addItem(id, type, quantity, price, name) {
                    const existingItem = this.items.find(i => i.id === id && i.type === type);
                    if (existingItem) {
                        existingItem.quantity += quantity;
                    } else {
                        this.items.push({ id, type, quantity, price, name });
                    }
                    this.updateDisplay();
                },

                removeItem(id, type) {
                    const index = this.items.findIndex(i => i.id === id && i.type === type);
                    if (index !== -1) {
                        this.items.splice(index, 1);
                        this.updateDisplay();
                    }
                },

                decreaseQuantity(id, type) {
                    const item = this.items.find(i => i.id === id && i.type === type);
                    if (item && item.quantity > 1) {
                        item.quantity--;
                        this.updateDisplay();
                    } else if (item && item.quantity === 1) {
                        this.removeItem(id, type);
                    }
                }
            };

            window.cart.updateDisplay();

            document.querySelector('.cart-dropdown').addEventListener('click', function(e) {
                if (e.target.classList.contains('plus')) {
                    const cartItem = e.target.closest('.cart-item');
                    const itemId = parseInt(cartItem.dataset.id);
                    const itemType = cartItem.dataset.type;
                    window.cart.addItem(itemId, itemType, 1, parseFloat(cartItem.querySelector('.item-price').textContent), cartItem.querySelector('.cart-item-name').textContent);
                } else if (e.target.classList.contains('minus')) {
                    const cartItem = e.target.closest('.cart-item');
                    const itemId = parseInt(cartItem.dataset.id);
                    const itemType = cartItem.dataset.type;
                    window.cart.decreaseQuantity(itemId, itemType);
                } else if (e.target.classList.contains('remove-item')) {
                    const cartItem = e.target.closest('.cart-item');
                    const itemId = parseInt(cartItem.dataset.id);
                    const itemType = cartItem.dataset.type;
                    window.cart.removeItem(itemId, itemType);
                }
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('checkout-btn')) {
                    alert('Przekierowanie do płatności...');
                }
            });
        });

        function animateCart() {
            const cartIcon = document.querySelector('.cart-icon');
            cartIcon.classList.add('animate');
            setTimeout(() => cartIcon.classList.remove('animate'), 500);
        }

        document.querySelector('.cart-btn').addEventListener('click', animateCart);
    </script>
</head>
<body>
<header class="header">
    <a href="/Main.html" class="logo">Pizzeria</a>
    <div class="menu">
        <a href="{{route('client.cart.index')}}" class="menu-item">{{__('navbar.cart')}}</a>
        <a href="{{route('client.menu.index')}}" class="menu-item">{{__('navbar.menu')}}</a>
        <a href="{{route('client.orders.index')}}" class="menu-item">{{__('Order')}}</a>
    </div>
    <div class="search-container">
        <input type="text" class="search-bar orange-text" placeholder="Szukaj...">
    </div>
    <div class="cart-btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="cart-icon">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a1 1 0 0 0 1 .81h9.72a1 1 0 0 0 1-.81L23 6H6"></path>
        </svg>
        <span class="cart-count">2</span>
        <div class="cart-dropdown"></div>
    </div>
    <div class="language-dropdown">
        <button class="language-btn">Language</button>
        <div class="language-dropdown-content">
            <a href="{{ route('set-locale', ['locale' => 'en']) }}">English</a>
            <a href="{{ route('set-locale', ['locale' => 'pl']) }}">Polski</a>
        </div>
    </div>
    <div class="auth-section">
        @if(auth()->check())
            <form action="{{route('logout')}}" method="post" style="display: inline;">
                @csrf
                <button type="submit" class="auth-btn">{{__('Log out')}}</button>
            </form>
        @else
            <a href="{{route('login')}}" class="auth-btn">{{__('Sign in')}}</a>
            <a href="{{route('register')}}" class="auth-btn">{{__('Register')}}</a>
        @endif
    </div>
    <div class="dropdown">
        <button class="dropbtn">...</button>
        <div class="dropdown-content">
            @if(auth()->user() && (auth()->user()->isEmployee() || auth()->user()->isAdmin()))
                <a href="{{route('management.employee.ingredients.index')}}">{{__('navbar.ingredients')}}</a>
                <a href="{{route('management.employee.orders.index')}}">{{__('navbar.orders')}}</a>
                <a href="{{route('management.employee.pizzas.index')}}">{{__('navbar.pizzas')}}</a>
                <a href="{{route('management.employee.translations.index')}}">{{__('navbar.translations')}}</a>
            @endif
            @if(auth()->user() && auth()->user()->isAdmin())
                <a href="{{route('management.admin.employees.index')}}">{{__('navbar.employees')}}</a>
                <a href="{{route('management.admin.logs.index')}}">{{__('navbar.logs')}}</a>
                <a href="{{route('management.admin.pizzeria.index')}}">{{__('navbar.pizzeria')}}</a>
                <a href="{{route('management.admin.statistics.index')}}">{{__('navbar.statistics')}}</a>
                <a href="{{route('management.admin.tokens.index')}}">{{__('navbar.tokens')}}</a>
            @endif
        </div>
    </div>
</header>
</body>
</html>
