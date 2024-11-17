@include('shared.return-message')
<table>
    <tr>
        <th>email</th>
        <th>token</th>
        <th>Usuń</th>
    @foreach ($tokens as $token)
    <tr>
        <td>{{ $token->email  }}</td>
        <td>{{ $token->token  }}</td>
        <td><a href="{{ route('management.admin.tokens.delete', $token) }}">X</a></td>
    </tr>
    @endforeach
</table>
<a href="{{ route('management.admin.tokens.create') }}">Dodaj nowego pracownika</a>


<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>
