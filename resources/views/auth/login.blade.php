@include('shared.header')

<form action="{{route('login')}}" method="post">
    @csrf
    <label for="email">Email</label>
    <input type="email" name="email" id="email">
    <br>
    <label for="password">{{__('auth.passwordInput')}}</label>
    <input type="password" name="password" id="password">
    <br>
    <button type="submit">{{__('auth.loginButton')}}</button>
</form>
