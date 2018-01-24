@extends ('layout')

@section ('page_specific_css')
    <link rel="stylesheet" type="text/css" href="/css/documents.css"></script>
@stop

@section ('content')
    <a href="{{'/reconstages'}}">Reconduction page</a></br>
    <h1>Reconduction effectuée</h1>

    <table class="reconduction">
        <tr>
            <th>Entreprise</th>
            <th>Début</th>
            <th>Fin</th>
            <th>Responsable administratif</th>
            <th>Responsable</th>
            <th>Stagiaire</th>
            <th>Salaire</th>
            <th>Nouveau salaire</th>
            <th>Etat</th>
        </tr>
        
    @foreach ($internships as $internship)
    <!-- Les données sont reprises tel que sur la page précédentes mais on y affiche uniquement ceux qui on été traité sur la page précédente. -->
        <tr>
            <td class="{{ $internship->companyName }}">{{ $internship->companyName }}</td>
            <td class="{{ strftime("%b %g", strtotime($internship->beginDate)) }}">{{ strftime("%b %g", strtotime($internship->beginDate)) }}</td>
            <td class="{{ strftime("%b %g", strtotime($internship->endDate)) }}">{{ strftime("%b %g", strtotime($internship->endDate)) }}</td>
            <td class="{{ $internship->arespfirstname }}-{{ $internship->aresplastname }}">{{ $internship->arespfirstname }} {{ $internship->aresplastname }}</td>
            <td class="{{ $internship->irespfirstname }}-{{ $internship->iresplastname }}">{{ $internship->irespfirstname }} {{ $internship->iresplastname }}</td>
            <td class="{{ $internship->studentfirstname }}-{{ $internship->studentlastname }}">{{ $internship->studentfirstname }} {{ $internship->studentlastname }}</td>
            <td class="{{ $internship->grossSalary }}">{{ $internship->grossSalary }}</td>
            <td>New salary</td>
            <td class="{{ $internship->stateDescription }}">Reconduit</td>
        </tr>
    @endforeach
    </table>
    <a href="{{'/'}}"><button>Retour à la page d'accueil</button></a>
@stop
