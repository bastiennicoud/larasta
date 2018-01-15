@extends ('layout')

@section ('content')
    <h2 class="text-left">Stage de {{ $iship->studentfirstname }} {{ $iship->studentlastname }} chez {{ $iship->companyName }}</h2> <a href="/contract/{{$iship->id}}"><button>Contrat</button></a>
    <table class="table text-left">
        <tr>
            <td class="col-md-2">Du</td>
            <td>{{ strftime("%e %b %g", strtotime($iship->beginDate)) }}</td>
        </tr>
        <tr>
            <td class="col-md-2">Au</td>
            <td>{{ strftime("%e %b %g", strtotime($iship->endDate)) }}</td>
        </tr>
        <tr>
            <td class="col-md-2">Description</td>
            <td>{{ $iship->internshipDescription }}</td>
        </tr>
        <tr>
            <td class="col-md-2">Responsable administratif</td>
            <td>{{ $iship->arespfirstname }} {{ $iship->aresplastname }}</td>
        </tr>
        <tr>
            <td class="col-md-2">Responsable</td>
            <td>{{ $iship->irespfirstname }} {{ $iship->iresplastname }}</td>
        </tr>
        <tr>
            <td class="col-md-2">Etat</td>
            <td>{{ $iship->stateDescription }}</td>
        </tr>
        <tr>
            <td class="col-md-2">Salaire</td>
            <td>{{ $iship->grossSalary }}</td>
        </tr>
        @if (isset($iship->previous_id))
            <tr>
                <td class="col-md-2"><a href="/internships/{{ $iship->previous_id }}/edit">Stage précédent</a></td>
            </tr>
        @endif
    </table>
@stop