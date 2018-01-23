@extends ('layout')

@section ('content')
    <a href="{{'/reconstages'}}">Reconduction page</a></br>
    <a href="#">Documents</a>
    <h1>Reconduction effectuée</h1>

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
            <td class="{{ $internsiph->companyName }}">{{ $internsiph->companyName }}</td>
            <td class="{{ strftime("%b %g", strtotime($internsiph->beginDate)) }}">{{ strftime("%b %g", strtotime($internsiph->beginDate)) }}</td>
            <td class="{{ $internsiph->arespfirstname }}-{{ $internsiph->aresplastname }}">{{ $internsiph->arespfirstname }} {{ $internsiph->aresplastname }}</td>
            <td class="{{ $internsiph->irespfirstname }}-{{ $internsiph->iresplastname }}">{{ $internsiph->irespfirstname }} {{ $internsiph->iresplastname }}</td>
            <td class="{{ $internsiph->studentfirstname }}-{{ $internsiph->studentlastname }}">{{ $internsiph->studentfirstname }} {{ $internsiph->studentlastname }}</td>
            <td class="{{ $internsiph->grossSalary }}">{{ $internsiph->grossSalary }}</td>
            <td class="{{ $internsiph->stateDescription }}">{{ $internsiph->stateDescription }}</td>
            <td><input name="internshipId-{{ $internsiph->id }}" value="{{ $internsiph->id }}" type="checkbox"></td>
        </tr>
    @endforeach
    </table>

@stop

@section ('page_specific_js')
    <script src="js/reconstages.js"></script>
@stop