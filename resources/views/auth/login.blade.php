@include('shared.header')

<form action="{{route('login')}}" method="post">
    @csrf
    <label for="email">email</label>
    <input type="email" name="email" id="email">
    <br>
    <label for="password">password</label>
    <input type="password" name="password" id="password">
    <button type="submit">Login</button>
</form>
