@include('shared.header')

<form action="{{route('register')}}" method="post">
    @csrf
    <label for="name">Name</label>
    <input type="text" name="name" id="name">
    <br>
    <label for="email">email</label>
    <input type="email" name="email" id="email">
    <br>
    <label for="password">password</label>
    <input type="password" name="password" id="password">
    <br>
    <label for="password_confirmation">Confirm password</label>
    <input type="password" name="password_confirmation" id="password_confirmation">
    <br>
    <label for="registrationToken">Registeration Token</label>
    <input type="text" name="registrationToken" id="registrationToken">
    <br>
    <button type="submit">Register</button>
</form>
