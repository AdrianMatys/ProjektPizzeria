@include('shared.header')

<form action="{{ route('management.admin.tokens.store') }}" method="POST">
    @csrf
    <label for="email">{{__('admin.insertUserEmail')}}:</label>
    <input type="text" name="email" id="email" required>
    <button type="submit">{{__('admin.generateToken')}}</button>
</form>
