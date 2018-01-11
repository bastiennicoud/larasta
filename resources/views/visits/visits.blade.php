@extends ('layout')

@section ('content')

    <div class="container">
        <h1>Visits list</h1>
        <a class="btn btn-primary btn-small" href="/visits/add">Créer une visite</a>
        <table class="table table-striped">
            <thead class="thead-inverse">
                <tr class="clickable-row">
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Entreprise</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Etat de la visite</th>
                    <th colspan="2">Mail</th>
                </tr>
            </thead>
            <tbody>
                @foreach($internships as $internship)
                    <tr class="clickable-row text-left" data-href="/visits/{{ $internship->id }}/manage">
                        <td class="col-md-1">{{ $internship->firstname }}</td>
                        <td class="col-md-1">{{ $internship->lastname }}</td>
                        <td class="col-md-1">{!! $internship->companyName !!}</td>
                        <td class="col-md-1">{{ (new DateTime($internship->beginDate))->format('d.m.Y') }}</td>
                        <td class="col-md-1">{{ (new DateTime($internship->endDate))->format('d.m.Y') }}</td>
                        <td class="col-md-1">{{ $internship->stateName }}</td>
                        <td class="col-md-1"><span class="glyphicon glyphicon-envelope"></span> |
                            <span id="{{ $internship->stateName }}" class="remove glyphicon glyphicon-remove"></span>
                            <span class="ok glyphicon glyphicon-ok"></span>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    <a class="btn btn-primary btn-small" href="/" role="button">Go back</a>
@stop
@section ('page_specific_js')
    <script src="js/visit.js"></script>
@stop