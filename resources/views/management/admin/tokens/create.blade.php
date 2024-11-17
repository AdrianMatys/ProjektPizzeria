@include('shared.return-message')

<form action="{{ route('management.admin.tokens.store') }}" method="POST">
    @csrf
    <label for="email">Wpisz email pracownika:</label>
    <input type="text" name="email" id="email" required>
    <button type="submit">Wygeneruj token pracownikowi</button>
</form>
