@include('shared.return-message')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <style>
        .header {
            background-color: rgb(0, 0, 0);
            display: flex;
            align-items: center;
            gap: 2rem;
            flex-wrap: wrap;
            padding: 0.25rem 0.5rem;
            max-height: 5rem;
            min-height: 4rem;
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
        .cart-btn {
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
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
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .item-price span {
            white-space: nowrap;
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
            min-width: 180px;
            max-width: 300px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            right: 0;
            padding: 0.5rem;
            flex-direction: column;
            gap: 0.5rem;
        }

        .dropdown-content button {
            background: none;
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            text-align: left;
            font-size: 0.85rem;
            line-height: 1.5;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .dropdown-content button:hover {
            background-color: #323131;
        }
        .dropbtn{
            background: none;
            color: #FF9800;
            cursor: pointer;
            box-shadow: none;
            border: none;
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

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #FF9800;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        .show {
            display: flex !important;
        }
    </style>
    <script>
        function clearCart() {
            localStorage.removeItem('cartItems');
            if (window.cart) {
                window.cart.items = [];
                window.cart.updateDisplay();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            window.cart = {
                items: JSON.parse(localStorage.getItem('cartItems') || '[]'),

                updateDisplay() {
                    const cartDropdown = document.querySelector('.cart-dropdown');
                    const cartCount = document.querySelector('.cart-count');

                    const totalItems = this.items.reduce((sum, item) => sum + item.quantity, 0);
                    if (cartCount) {
                        cartCount.textContent = totalItems;
                    }

                    if (!cartDropdown) return;

                    if (this.items.length === 0) {
                        cartDropdown.innerHTML = `
                            <div class="cart-empty">

                                <div>{{__('client.emptycart')}}</div>
                                <a href="{{route('client.menu.index')}}" class="checkout-btn">{{__('client.Gotomenu')}}</a>
                            </div>
                        `;
                        return;
                    }

                    const itemsHTML = this.items.map(item => `
                        <div class="cart-item" data-id="${item.id}" data-type="${item.type}">
                            <span class="cart-item-name">${item.name}</span>
                            <div class="quantity-controls">
                                <form action="{{ route('client.cart.patchQuantity', '')}}" method="POST" style="margin: 0; display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantity" value="${item.quantity - 1}">
                                    <button type="submit" class="quantity-btn minus" onclick="this.form.action = this.form.action + '/' + this.closest('.cart-item').dataset.id">-</button>
                                </form>
                                <span>${item.quantity}</span>
                                <form action="{{ route('client.cart.patchQuantity', '')}}" method="POST" style="margin: 0; display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantity" value="${item.quantity + 1}">
                                    <button type="submit" class="quantity-btn plus" onclick="this.form.action = this.form.action + '/' + this.closest('.cart-item').dataset.id">+</button>
                                </form>
                            </div>
                            <span class="item-price">${(item.price * item.quantity).toFixed(2)} {{__('client.waluta')}}</span>
                            <form action="{{ route('client.cart.destroyitem', '')}}" method="POST" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-item" onclick="this.form.action = this.form.action + '/' + this.closest('.cart-item').dataset.id"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                            </svg></button>
                            </form>
                        </div>
                    `).join('');

                    const total = this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                    cartDropdown.innerHTML = `
                        ${itemsHTML}
                        <div class="cart-total">
                            <span>Suma:</span>
                            <span>${total.toFixed(2)} {{__('client.waluta')}}</span>
                        </div>
                       <form action="{{ route('client.cart.order')}}" method="POST">
                            @csrf
                            <button type="submit" class="checkout-btn">{{__('client.pay')}}</button>
                        </form>
                    `;
                },

                saveToLocalStorage() {
                    localStorage.setItem('cartItems', JSON.stringify(this.items));
                },

                addItem(id, type, quantity, price, name) {
                    const existingItem = this.items.find(i => i.id === id && i.type === type);
                    if (existingItem) {
                        existingItem.quantity += quantity;
                    } else {
                        this.items.push({ id, type, quantity, price, name });
                    }
                    this.updateDisplay();
                    this.animateCart();
                    this.saveToLocalStorage();
                },

                removeItem(id, type) {
                    const index = this.items.findIndex(i => i.id === id && i.type === type);
                    if (index !== -1) {
                        this.items.splice(index, 1);
                        this.updateDisplay();
                        this.saveToLocalStorage();
                    }
                },

                decreaseQuantity(id, type) {
                    const item = this.items.find(i => i.id === id && i.type === type);
                    if (item && item.quantity > 1) {
                        item.quantity--;
                        this.updateDisplay();
                        this.saveToLocalStorage();
                    } else if (item && item.quantity === 1) {
                        this.removeItem(id, type);
                    }
                },

                animateCart() {
                    const cartIcon = document.querySelector('.cart-icon');
                    if (cartIcon) {
                        cartIcon.style.transform = 'scale(1.2) rotate(-5deg)';
                        setTimeout(() => {
                            cartIcon.style.transform = 'scale(1) rotate(0)';
                        }, 200);
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
        });

        function toggleDropdown(event) {
            event.stopPropagation();
            document.getElementById("myDropdown").classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn') && !event.target.closest('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</head>
<body>
<header class="header">
    <a href="/" class="logo">Pizzeria</a>
    <div class="menu">
        <a href="{{route('client.menu.index')}}" class="menu-item">{{__('navbar.menu')}}</a>
        <a href="{{route('client.orders.index')}}" class="menu-item">{{__('navbar.order')}}</a>
    </div>
    <div class="search-container">

    </div>
    <a href="{{route('client.cart.index')}}">
    <div class="cart-btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="cart-icon">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a1 1 0 0 0 1 .81h9.72a1 1 0 0 0 1-.81L23 6H6"></path>
        </svg>
        <span class="cart-count">0</span>
        <div class="cart-dropdown"></div>
    </div>
    </a>
    <div class="language-dropdown">
        <button class="language-btn">{{__('navbar.language')}}</button>
        <div class="language-dropdown-content">
            <a href="{{ route('set-locale', ['locale' => 'en']) }}">{{__('navbar.english')}}</a>
            <a href="{{ route('set-locale', ['locale' => 'pl']) }}">{{__('navbar.polish')}}</a>
        </div>
    </div>
    @if(auth()->check())
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="auth-btn">{{__('auth.logout')}}</button>
        </form>
    @else
        <a href="{{ route('login') }}" class="auth-btn">{{__('auth.login')}}</a>
    @endif
    <div class="dropdown">
        <button class="dropbtn" onclick="toggleDropdown(event)"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/></svg>
        </button>
        <div class="dropdown-content" id="myDropdown">
            @if(auth()->user() && (auth()->user()->isEmployee() || auth()->user()->isAdmin()))
                <button onclick="window.location.href='{{route('management.employee.ingredients.index')}}'">{{__('navbar.ingredients')}}</button>
                <button onclick="window.location.href='{{route('management.employee.translations.index')}}'">{{__('navbar.translations')}}</button>
                <button onclick="window.location.href='{{route('management.employee.panel.index')}}'">{{__('navbar.employeePanel')}}</button>
            @endif
            @if(auth()->user() && auth()->user()->isAdmin())
                <button onclick="window.location.href='{{route('management.admin.panel.index')}}'">{{__('navbar.adminPanel')}}</button>
                <button onclick="window.location.href='{{route('management.admin.employees.index')}}'">{{__('navbar.employees')}}</button>
                <button onclick="window.location.href='{{route('management.admin.pizzeria.index')}}'">{{__('navbar.pizzeria')}}</button>
                <button onclick="window.location.href='{{route('management.admin.tokens.index')}}'">{{__('navbar.tokens')}}</button>

            @endif
        </div>
    </div>
</header>
</body>
</html>
