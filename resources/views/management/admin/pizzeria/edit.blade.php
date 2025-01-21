@include('shared.header')

<form action="{{ route('management.admin.pizzeria.update', $pizzeria->id) }}" method="post">
    @csrf
    @method('put')
    <div class="table-container">
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

        <div class="action-buttons">
            <button type="submit" class="btn">{{__('admin.updatePizzeria')}}</button>
        </div>
    </div>
</form>

<style>
    
    .table-container {
        width: 80%;
        margin: 20px auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 12px 20px;
        text-align: center;
    }

    th {
        background-color: #FF6347; 
        color: #fff;
        font-size: 16px;
        text-transform: uppercase;
    }

    td {
        font-size: 14px;
        color: #333;
        border-bottom: 1px solid #ddd;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ffece5;
    }

   
    input[type="text"] {
        width: 90%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
        box-sizing: border-box;
    }

    input[type="checkbox"] {
        transform: scale(1.3);
        cursor: pointer;
    }

   
    .action-buttons {
        text-align: right; 
        margin-top: 10px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #FF6347; 
        color: #fff;
        text-transform: uppercase;
        font-size: 14px;
        font-weight: bold;
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        background-color: #FF4500; 
        transform: translateY(-2px);
    }

    .btn:active {
        background-color: #FF6347;
        transform: translateY(1px);
    }
</style>
