@include('shared.header')

<table>
    <tr>
        <th>{{__('admin.userName')}}</th>
        <th>{{__('admin.category')}}</th>
        <th>{{__('admin.type')}}</th>
        <th>{{__('admin.details')}}</th>
        <th>{{__('admin.date')}}</th>
    </tr>
        <tr>
            <td>{{ $log->user ? $log->user->email : '---' }}</td>
            <td>{{ $log->type->category->name }}</td>
            <td>{{ $log->type->name }}</td>
            <td>{{ $log->details }}</td>
            <td>{{ $log->created_at }}</td>
        </tr>
</table>

<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>
