<style>
    .dropbtn {
        background-color: #2b2b2b;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    .dropdown {
        position: relative;
        padding: 2px;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #424141;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #323131
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .dropbtn {
        background-color: #191919;
    }

    .menu {
        display: flex;
    }
</style>

<div class="menu">

    @if(auth()->user())
        <div class="dropdown">
            <button class="dropbtn">Client</button>
            <div class="dropdown-content">
                <a href="{{route('cart.index')}}">Cart</a>
                <a href="{{route('client.menu.index')}}">Menu</a>
                <a href="{{route('client.orders.index')}}">Orders</a>
                <a href="{{route('profile.edit')}}">Profile</a>
            </div>
        </div>
    @else
        <div class="dropdown">
            <button class="dropbtn">Client</button>
            <div class="dropdown-content">
                <a href="{{route('client.menu.index')}}">Menu</a>
                <a href="{{route('login')}}">Login</a>
                <a href="{{route('register')}}">Register</a>
            </div>
        </div>
    @endif

    @if(auth()->user() && (auth()->user()->isEmployee() || auth()->user()->isAdmin()) )
        <div class="dropdown">
            <button class="dropbtn">Employee</button>
            <div class="dropdown-content">
                <a href="{{route('management.employee.ingredients.index')}}">Ingredients</a>
                <a href="{{route('management.employee.orders.index')}}">Orders</a>
                <a href="{{route('management.employee.pizzas.index')}}">Pizzas</a>
                <a href="{{route('management.employee.translations.index')}}">Translations</a>
            </div>
        </div>
    @endif

    @if(auth()->user() && auth()->user()->isAdmin())
        <div class="dropdown">
            <button class="dropbtn">Administrator</button>
            <div class="dropdown-content">
                <a href="{{route('management.admin.employees.index')}}">Employees</a>
                <a href="{{route('management.admin.logs.index')}}">Logs</a>
                <a href="{{route('management.admin.pizzeria.index')}}">Pizzeria</a>
                <a href="{{route('management.admin.statistics.index')}}">Statistics</a>
                <a href="{{route('management.admin.tokens.index')}}">Tokens</a>
            </div>
        </div>
    @endif

    <div class="dropdown">
        <button class="dropbtn">Language</button>
        <div class="dropdown-content">
            <a href="{{ route('set-locale', ['locale' => 'en']) }}">English</a>
            <a href="{{ route('set-locale', ['locale' => 'pl']) }}">Polski</a>
        </div>
    </div>
    @if(auth()->user() && (auth()->user()->isEmployee() || auth()->user()->isAdmin()))
        <form action="{{route('management.admin.logout')}}" method="post" class="dropdown" style="padding: 2px;">
            @csrf
            <button type="submit" style="height: 53px;background-color: #2b2b2b; color:white; border: 0">Logout</button>
        </form>
    @endif


</div>
<br>

