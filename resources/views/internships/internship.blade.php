@extends ('layout')

@section ('content')
    <h2 class="text-left">Stage de {{ $iship->studentfirstname }} {{ $iship->studentlastname }} chez {{ $iship->companyName }}</h2>
    <table class="table text-left larastable">
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
            <td class="col-md-2">Maître de classe</td>
            <td>{{ $iship->initials }}</td>
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
    {{-- Action buttons --}}
    @if(substr($iship->contractGenerated,0,4) == "0000" || $iship->contractGenerated == null)
        <a href="/contract/{{ $iship->id }}">
            <button class="btn btn-primary">Générer le contrat</button>
        </a>
    @else
        <br> Contrat généré le : {{$iship->contractGenerated}}<br>
        <a href="/contract/{{$iship->id}}/cancel">
            <button class="btn btn-danger">Réinitialiser</button>
        </a>
    @endif
@stop