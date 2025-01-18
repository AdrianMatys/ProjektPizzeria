@include('shared.header')

<form action="{{ route('management.admin.pizzeria.update', $pizzeria->id) }}" method="post">
    @csrf
    @method('put')
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
            <td><input type="text" name="name" id="name" value="{{ $pizzeria->name }}"></td>
            <td><input type="text" name="address" id="address" value="{{ $pizzeria->address }}"></td>
            <td><input type="text" name="city" id="city" value="{{ $pizzeria->city }}"></td>
            <td><input type="text" name="phone_number" id="phone_number" value="{{ $pizzeria->phone_number }}"></td>
            <td>
                <input type="hidden" name="delivery_available" value="0">
                <input type="checkbox" name="delivery_available" id="delivery_available" value="1" {{ $pizzeria->delivery_available ? 'checked' : '' }}>
            </td>
            <td><input type="text" name="max_delivery_radius" id="max_delivery_radius" value="{{ $pizzeria->max_delivery_radius }}"></td>
        </tr>
    </table>
    <button type="submit">{{__('admin.updatePizzeria')}}</button>
</form>
<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
    </style>
