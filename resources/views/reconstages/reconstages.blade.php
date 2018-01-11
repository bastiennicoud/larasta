@extends ('layout')

@section ('content')

    <h1>Nicolas Part</h1>

    <table>
        <tr>
            <th>Entreprise</th>
            <th>Début</th>
            <th>Responsable administratif</th>
            <th>Responsable</th>
            <th>Stagiaire</th>
            <th>Salaire</th>
            <th>Etat</th>
            <th>puces</th>
        </tr>
    @foreach ($internsiphs as $internsiph)
        <tr>
            <td>{{ $internsiph->companyName }}</td>
            <td>{{ strftime("%b %g", strtotime($internsiph->beginDate)) }}</td>
            <td>{{ $internsiph->arespfirstname }} {{ $internsiph->aresplastname }}</td>
            <td>{{ $internsiph->irespfirstname }} {{ $internsiph->iresplastname }}</td>
            <td>{{ $internsiph->studentfirstname }} {{ $internsiph->studentlastname }}</td>
            <td>{{ $internsiph->grossSalary }}</td>
            <td>{{ $internsiph->stateDescription }}</td>
            <td><input type="checkbox"></td>
        </tr>
    @endforeach
    </table>

    <button>Reconduire</button>
    
    <input type="checkbox" id="check">Select All</input>

@stop

@section ('page_specific_js')
    <script src="js/reconstages.js"></script>
@stop