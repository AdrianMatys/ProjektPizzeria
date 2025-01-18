@include('shared.header')
<a href="{{ route('management.employee.translations.index') }}">{{__('employee.backToTranslations')}}</a>

<form action="{{ route('management.employee.translations.update', $translation) }}" method="post">
    @csrf
    @method('put')

    <table id="ingredientsTable">
        <tr>
            <th>{{__('employee.ingredient')}}</th>
            <th>{{__('employee.languageCode')}}</th>
            <th>{{__('employee.translatedName')}}</th>
        </tr>
        <tr>
            <td>
                {{$translation->ingredient->name}}
            </td>
            <td>
                <input type="text" name="language_code" id="language_code" value="{{$translation->language_code}}">
            </td>
            <td>
                <input type="text" name="name" id="name" value="{{$translation->name}}">
            </td>
        </tr>
    </table>
    <button type="submit">{{__('employee.saveTranslation')}}</button>
</form>
<style>
    table, tr, td, th {
        border: 1px solid black;
        text-align: center;
    }
</style>
