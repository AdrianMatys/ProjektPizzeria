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
            <button class="dropbtn">{{__('navbar.client')}}</button>
            <div class="dropdown-content">
                <a href="{{route('client.cart.index')}}">{{__('navbar.cart')}}</a>
                <a href="{{route('client.menu.index')}}">{{__('navbar.menu')}}</a>
                <a href="{{route('client.orders.index')}}">{{__('navbar.orders')}}</a>
            </div>
        </div>
    @else
        <div class="dropdown">
            <button class="dropbtn">{{__('navbar.client')}}</button>
            <div class="dropdown-content">
                <a href="{{route('client.menu.index')}}">{{__('navbar.menu')}}</a>
                <a href="{{route('login')}}">{{__('navbar.login')}}</a>
                <a href="{{route('register')}}">{{__('navbar.register')}}</a>
            </div>
        </div>
    @endif

    @if(auth()->user() && (auth()->user()->isEmployee() || auth()->user()->isAdmin()) )
        <div class="dropdown">
            <button class="dropbtn">{{__('navbar.employee')}}</button>
            <div class="dropdown-content">
                <a href="{{route('management.employee.ingredients.index')}}">{{__('navbar.ingredients')}}</a>
                <a href="{{route('management.employee.orders.index')}}">{{__('navbar.orders')}}</a>
                <a href="{{route('management.employee.pizzas.index')}}">{{__('navbar.pizzas')}}</a>
                <a href="{{route('management.employee.translations.index')}}">{{__('navbar.translations')}}</a>
            </div>
        </div>
    @endif

    @if(auth()->user() && auth()->user()->isAdmin())
        <div class="dropdown">
            <button class="dropbtn">{{__('navbar.administrator')}}</button>
            <div class="dropdown-content">
                <a href="{{route('management.admin.employees.index')}}">{{__('navbar.employees')}}</a>
                <a href="{{route('management.admin.logs.index')}}">{{__('navbar.logs')}}</a>
                <a href="{{route('management.admin.pizzeria.index')}}">{{__('navbar.pizzeria')}}</a>
                <a href="{{route('management.admin.statistics.index')}}">{{__('navbar.statistics')}}</a>
                <a href="{{route('management.admin.tokens.index')}}">{{__('navbar.tokens')}}</a>
            </div>
        </div>
    @endif

    <div class="dropdown">
        <button class="dropbtn">{{__('navbar.languages')}}</button>
        <div class="dropdown-content">
            <a href="{{ route('set-locale', ['locale' => 'en']) }}">English</a>
            <a href="{{ route('set-locale', ['locale' => 'pl']) }}">Polski</a>
        </div>
    </div>
    @if(auth()->user() && (auth()->user()->isEmployee() || auth()->user()->isAdmin()))
        <form action="{{route('management.admin.logout')}}" method="post" class="dropdown" style="padding: 2px;">
            @csrf
            <button type="submit" style="height: 53px;background-color: #2b2b2b; color:white; border: 0">{{__('navbar.logout')}}</button>
        </form>
    @endif


</div>
<br>

