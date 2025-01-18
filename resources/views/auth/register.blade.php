@include('shared.header')

<form action="{{route('register')}}" method="post">
    @csrf
    <label for="name">{{__('auth.nameInput')}}</label>
    <input type="text" name="name" id="name">
    <br>
    <label for="email">Email</label>
    <input type="email" name="email" id="email">
    <br>
    <label for="password">{{__('auth.passwordInput')}}</label>
    <input type="password" name="password" id="password">
    <br>
    <label for="password_confirmation">{{__('auth.confirmPasswordInput')}}</label>
    <input type="password" name="password_confirmation" id="password_confirmation">
    <br>
    <label for="registrationToken">{{__('auth.registerationToken')}}</label>
    <input type="text" name="registrationToken" id="registrationToken">
    <br>
    <button type="submit">{{__('auth.registerButton')}}}</button>
</form>
