@include('shared.header')

<h1>
    {{__('client.orderPlaced')}}
</h1>
<script>
    localStorage.removeItem('cartItems');
    if (window.cart) {
        window.cart.items = [];
        window.cart.updateDisplay();
    }
</script>

<br>
