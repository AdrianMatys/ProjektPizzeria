<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #fdf3e7; 
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100vh;
    }
    header {
        width: 100%;
        background-color: #f77f00; 
        color: white;
        text-align: center;
        padding: 1rem 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        font-size: 1.5rem;
        font-weight: bold;
    }
    .container {
        background-color: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        width: 100%;
        max-width: 400px;
        margin-top: 1%;
        margin-bottom: 1rem;
        animation: fadeIn 1s ease-in-out; 
    }
    form {
        display: flex;
        flex-direction: column;
    }
    label {
        margin-bottom: 0.5rem;
        color: #4a4a4a;
        font-weight: bold;
    }
    input {
        padding: 0.75rem;
        margin-bottom: 1.5rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 1rem;
        transition: box-shadow 0.3s ease;
    }
    input:focus {
        box-shadow: 0 0 8px rgba(247, 127, 0, 0.8); 
        outline: none;
    }
    button {
        background-color: #f77f00;
        color: white;
        padding: 0.75rem;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.3s ease, background-color 0.3s ease;
    }
    button:hover {
        background-color: #f67e00;
        transform: scale(1.05); 
    }
    button:active {
        transform: scale(0.95); 
    }
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

@include('shared.header')

<div class="container">
    <form action="{{route('register')}}" method="post">
        @csrf
        <label for="name">{{__('auth.nameInput')}}</label>
        <input type="text" name="name" id="name" placeholder="{{__('auth.Yourname')}}">
        
        <label for="email">{{__('auth.email')}}</label>
        <input type="email" name="email" id="email" placeholder="{{__('auth.Youremail')}}">
        
        <label for="password">{{__('auth.passwordInput')}}</label>
        <input type="password" name="password" id="password" placeholder="{{__('auth.Yourpassword')}}">
        
        <label for="password_confirmation">{{__('auth.confirmPasswordInput')}}</label>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="{{__('auth.confirmPasswordInput')}}">
        
        <label for="registrationToken">{{__('auth.registerationToken')}}</label>
        <input type="text" name="registrationToken" id="registrationToken" placeholder="`{{__('auth.registerationToken')}}">
        
        <button type="submit">{{__('auth.registerButton')}}</button>
    </form>
</div>
