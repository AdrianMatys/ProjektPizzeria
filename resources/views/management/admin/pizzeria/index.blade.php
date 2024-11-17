<table>
    <tr>
        <th>Name</th>
        <th>Address</th>
        <th>City</th>
        <th>Phone number</th>
        <th>Delivery available</th>
        <th>max delivery radius</th>
    </tr>
    <tr>
        <td>{{ $pizzeria->name  }}</td>
        <td>{{ $pizzeria->address  }}</td>
        <td>{{ $pizzeria->city  }}</td>
        <td>{{ $pizzeria->phone_number  }}</td>
        <td>{{ $pizzeria->delivery_available ? "Yes" : "No"  }}</td>
        <td>{{ $pizzeria->max_delivery_radius  }}</td>
    </tr>
</table>
<a href="{{ route('management.admin.pizzeria.edit', $pizzeria) }}">Edytuj</a>

<style>
    table, tr, td, th{
        border:1px solid black;
        text-align: center;
    }
</style>
