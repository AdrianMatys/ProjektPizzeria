@include('shared.header')

<table>
    <tr>
        <th>{{__('admin.userName')}}</th>
        <th>{{__('admin.category')}}</th>
        <th>{{__('admin.type')}}</th>
        <th>{{__('admin.date')}}</th>
        <th>{{__('admin.details')}}</th>
    </tr>
    @foreach($logs as $log)
        <tr>
            <td>{{ $log->user ? $log->user->email : '---' }}</td>
            <td>{{ $log->type->category->name }}</td>
            <td>{{ $log->type->name }}</td>
            <td>{{ $log->created_at }}</td>
            <td>
                <a href="{{route('management.admin.logs.show', $log)}}">{{__('admin.showDetails')}}</a>
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
