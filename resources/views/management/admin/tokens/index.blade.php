@include('shared.header')

<table>
    <tr>
        <th>email</th>
        <th>token</th>
        <th>created at</th>
        <th>Usuń</th>
    @foreach ($tokens as $token)
        <tr>
            <td>{{ $token->email  }}</td>
            <td>{{ $token->token  }}</td>
            <td>{{ $token->created_at  }}</td>
            <td>
                <form method="POST" action="{{ route('management.admin.tokens.destroy', $token->email) }}">
                    @csrf
                    @method('delete')
                    <button type="submit">X</button>
                </form>
            </td>
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
