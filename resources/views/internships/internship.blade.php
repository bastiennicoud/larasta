@extends ('layout')

@section ('content')
    <h1 class="text-left">Stage</h1>
    <table class="table text-left">
        <tr>
            <td class="col-md-2">De</td>
            <td>{{ $iship->studentfirstname }} {{ $iship->studentlastname }}</td>
        </tr>
        <tr>
            <td class="col-md-2">Chez</td>
            <td>{{ $iship->companyName }}</td>
        </tr>
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