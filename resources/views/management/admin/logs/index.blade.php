@include('shared.return-message')

<table>
    <tr>
        <th>User</th>
        <th>Category</th>
        <th>Type</th>
        <th>Date</th>
        <th>Details</th>
    </tr>
    @foreach($logs as $log)
        <tr>
            <td>{{ $log->user->email }}</td>
            <td>{{ $log->type->category->name }}</td>
            <td>{{ $log->type->name }}</td>
            <td>{{ $log->created_at }}</td>
            <td>
                <a href="{{route('management.admin.logs.show', $log)}}">Show details</a>
            </td>
        </tr>
    @endforeach
</table>

<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>
