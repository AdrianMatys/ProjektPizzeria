@include('shared.header')

<a href="{{ route('management.employee.translations.index') }}">{{__('employee.backToTranslations')}}</a>
<br><br>
<table>
    <tr>
        <th>{{__('employee.ingredientName')}}</th>
        <th>{{__('employee.translatedName')}}</th>
        <th>{{__('employee.languageCode')}}</th>
        <th>{{__('employee.edit')}}</th>
        <th>{{__('employee.delete')}}</th>
    </tr>
    @foreach($translations as $translation)
        <tr>
            <td>
                {{ $translation->ingredient->name }}
            </td>
            <td>
                {{ $translation->name }}
            </td>
            <td>
                {{ $translation->language_code }}
            </td>
            <td>
                <a href="{{route('management.employee.translations.edit', $translation)}}">{{__('employee.editTranslation')}}</a>
            </td>
            <td>
                <form action="{{ route('management.employee.translations.destroy', $translation->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit">X</button>
                </form>
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
