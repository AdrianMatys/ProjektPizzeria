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
            <td>
                <table>
                    @foreach ($log->details as $key => $value)
                        @if (is_array($value))
                            <tr>
                                <td>{{ $key }}</td>
                                <td>
                                    <pre>{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $value }}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </td>
            <td>{{ $log->created_at }}</td>
        </tr>
</table>

<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>
