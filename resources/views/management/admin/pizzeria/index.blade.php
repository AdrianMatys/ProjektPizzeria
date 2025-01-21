@include('shared.header')

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
            <td>{{ $pizzeria->name }}</td>
            <td>{{ $pizzeria->address }}</td>
            <td>{{ $pizzeria->city }}</td>
            <td>{{ $pizzeria->phone_number }}</td>
            <td>{{ $pizzeria->delivery_available ? __('admin.yes') : __('admin.no') }}</td>
            <td>{{ $pizzeria->max_delivery_radius }}</td>
        </tr>
    </table>

    <div class="action-buttons">
        <a href="{{ route('management.admin.pizzeria.edit', $pizzeria) }}" class="btn">
            {{ __('admin.edit') }}
        </a>
    </div>
</div>

<style>
    /* Контейнер таблицы */
    .table-container {
        width: 80%;
        margin: 20px auto;
    }

    /* Стиль таблицы */
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

    /* Кнопка действий */
    .action-buttons {
        text-align: right; /* Размещает кнопку справа */
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
