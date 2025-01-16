@include('shared.header')

<table>
    <tr>
        <th>name</th>
        <th>email</th>
        <th>role</th>
        <th>created at</th>
        <th>delete</th>
    </tr>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->created_at }}</td>
                <td>
                    <form action="{{ route('management.admin.employees.destroy', $user->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" {{ Auth::user()->id == $user->id ? 'disabled' : '' }}>X</button>
                    </form></td>
            </tr>
        @endforeach
</table>

<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>
