@extends ('layout')

@section ('content')
    <a href="{{'/documents'}}">Documents du stage</a>
    <h1>Nicolas Part</h1>
    <form method="POST" action="reconstages/reconmade">
        {{ csrf_field() }}
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
            
        @foreach ($internships as $internship)
            <tr>
                <td class="{{ $internship->companyName }}">{{ $internship->companyName }}</td>
                <td class="{{ strftime("%b %g", strtotime($internship->beginDate)) }}">{{ strftime("%b %g", strtotime($internship->beginDate)) }}</td>
                <td class="{{ $internship->arespfirstname }}-{{ $internship->aresplastname }}">{{ $internship->arespfirstname }} {{ $internship->aresplastname }}</td>
                <td class="{{ $internship->irespfirstname }}-{{ $internship->iresplastname }}">{{ $internship->irespfirstname }} {{ $internship->iresplastname }}</td>
                <td class="{{ $internship->studentfirstname }}-{{ $internship->studentlastname }}">{{ $internship->studentfirstname }} {{ $internship->studentlastname }}</td>
                <td class="{{ $internship->grossSalary }}">{{ $internship->grossSalary }}</td>
                <td class="{{ $internship->stateDescription }}">{{ $internship->stateDescription }}</td>
                <td><input name="internshipId-{{ $internship->id }}" value="{{ $internship->id }}" type="checkbox"></td>
            </tr>
        @endforeach
        </table>
        <button id="reconduire" type="submit">Reconduire</button>
    </form>
    <input type="checkbox" id="check">Select All</input>

@stop

@section ('page_specific_js')
    <script src="js/reconstages.js"></script>
@stop