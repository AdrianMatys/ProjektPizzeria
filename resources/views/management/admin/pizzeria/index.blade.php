@include('shared.header')

<table>
    <tr>
        <th>{{__('admin.pizzeriaName')}}</th>
        <th>{{__('admin.address')}}</th>
        <th>{{__('admin.city')}}</th>
        <th>{{__('admin.phoneNumber')}}</th>
        <th>{{__('admin.deliveryAvailable')}}</th>
        <th>{{__('admin.deliveryRadius')}}</th>
    </tr>
    <tr>
        <td>{{ $pizzeria->name  }}</td>
        <td>{{ $pizzeria->address  }}</td>
        <td>{{ $pizzeria->city  }}</td>
        <td>{{ $pizzeria->phone_number  }}</td>
        <td>{{ $pizzeria->delivery_available ? __('admin.yes') : __('admin.no') }}</td>
        <td>{{ $pizzeria->max_delivery_radius  }}</td>
    </tr>
</table>
<a href="{{ route('management.admin.pizzeria.edit', $pizzeria) }}">{{__('admin.edit')}}</a>

<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>
