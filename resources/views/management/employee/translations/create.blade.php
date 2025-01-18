@include('shared.header')
<a href="{{ route('management.employee.translations.index') }}">{{__('employee.backToTranslations')}}</a>

<table>
    <tr>
        <th>{{__('employee.ingredient')}}</th>
        <th>{{__('employee.languageCode')}}</th>
        <th>{{__('employee.translatedName')}}</th>
    </tr>
    <tr>
        <form action="{{ route('management.employee.translations.store') }}" method="post">
            @csrf
            <td>
                <select name="ingredient_id" id="ingredient_id">

                    @foreach($ingredients as $ingredient )
                        <option value="{{$ingredient->id}}">{{ $ingredient->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" name="language_code" id="language_code" value="">
            </td>
            <td>
                <input type="text" name="name" id="name" value="">
            </td>
            <td>
                <button type="submit">Add</button>
            </td>
        </form>
    </tr>
</table>

<style>
    table, tr, td, th {
        border: 1px solid black;
        text-align: center;
    }
</style>
