@include('shared.header')

<table>
    <tr>
        <th>{{__('admin.email')}}</th>
        <th>{{__('admin.token')}}</th>
        <th>{{__('admin.createdAt')}}</th>
        <th>{{__('admin.delete')}}</th>
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
<a href="{{ route('management.admin.tokens.create') }}">{{__('admin.addNewUser')}}</a>


<style>
   

body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background-color: #f4f4f9;
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #ffffff;
    border-radius: 8px;
    overflow: hidden;
}

th, td {
    padding: 10px 12px;
    text-align: left;
}

th {
    background-color:rgb(255, 123, 0);
    color: white;
    text-transform: uppercase;
    font-size: 13px;
    letter-spacing: 0.03em;
    border-bottom: 2px solid #ddd;
}

td {
    border-bottom: 1px solid #ddd;
    font-size: 13px;
}

tr:hover {
    background-color: #f9f9f9;
    cursor: pointer;
}

button {
    background-color: #e53935;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 6px 10px;
    cursor: pointer;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.02em;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #d32f2f;
}

a {
    display: inline-block;
    margin: 10px 0;
    text-decoration: none;
    background-color:rgb(240, 240, 240);
    color: white;
    padding: 8px 16px;
    border-radius: 4px;
    font-size: 12px;
    text-transform: uppercase;
    font-weight: bold;
    transition: background-color 0.3s;
}

a:hover {
    background-color: #218838;
}

/* Адаптивный дизайн */
@media (max-width: 768px) {
    table {
        font-size: 11px;
    }

    th, td {
        padding: 8px;
    }

    button, a {
        font-size: 11px;
    }
}

</style>
