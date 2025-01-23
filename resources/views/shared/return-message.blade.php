@if (session()->has('success'))
    <div class="notification success">
        {{ session('success') }}
    </div>
@endif
@if (session()->has('error'))
    <div class="notification error">
        {{ session('error') }}
    </div>
@endif
@if (session()->has('errors') && $errors->any())
    <div class="notification error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session()->has('resetCart'))
    <script>
        localStorage.removeItem('cartItems');
        if (window.cart) {
            window.cart.items = [];
            window.cart.updateDisplay();
        }
    </script>
@endif

<style>
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        padding: 15px 20px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        display: inline-block;
        background-color: rgba(0, 0, 0, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        animation: slide-in 0.5s ease-in-out, fade-out 3s 4s forwards;
    }

    .notification.success {
        background-color: #3c763d;
        border-color: #d6e9c6;
    }

    .notification.error {
        background-color: #d9534f;
        border-color: #ebccd1;
    }

    @keyframes slide-in {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fade-out {
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }
</style>
