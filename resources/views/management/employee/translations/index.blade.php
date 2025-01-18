@include('shared.header')

<td><a href={{ route("management.employee.translations.create") }}>{{__('employee.addNewTranslation')}}</a></td>
<br><br>
<table>
    <tr>
        <th>{{__('employee.ingredientName')}}</th>
        <th>{{__('employee.availableLanguages')}}</th>
        <th>{{__('employee.details')}}</th>
    </tr>
    @foreach($translations as $translation)
        <tr>
            <td>{{ $translation->ingredient->name }}</td>
            <td>
                @foreach($translation->ingredient->translations as $ingredientTranslation)
                    {{ $ingredientTranslation->language_code }}
                @endforeach
            </td>
            <td>
                <a href="{{route('management.employee.translations.show', $translation)}}">{{__('employee.showDetails')}}</a>
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
