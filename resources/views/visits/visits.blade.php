@extends ('layout')
@section ('page_specific_css')
    <link rel="stylesheet" href="/css/visits.css">
@stop
@section ('content')
    <div class="container">
        <h1>Visits list</h1>
        <a href="/visits/#" class="underline-none">
            <button class="btn-success small text-white" disabled>Créer une visite</button>
        </a>
        <br>
        <br>
        <table class="larastable table table-striped">
            <thead class="thead-inverse">
                <tr class="clickable-row">
                    <th class="col-md-2">Nom</th>
                    <th class="col-md-2">Prénom</th>
                    <th class="col-md-3">Entreprise</th>
                    <th class="col-md-1">Date de début</th>
                    <th class="col-md-1">Date de fin</th>
                    <th class="col-md-1">Etat de la visite</th>
                    <th class="col-md-1">Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($internships as $iship)
                    <tr class="clickable-row text-left" data-href="/visits/{{$iship->id}}/manage">
                        <td class="col-md-2">{{ $iship->studentfirstname }}</td>
                        <td class="col-md-2">{{ $iship->studentlastname }}</td>
                        <td class="col-md-3">{!! $iship->companyName !!}</td>
                        <td class="col-md-1 text-center">{{ (new DateTime($iship->beginDate))->format('d M Y') }}</td>
                        <td class="col-md-1 text-center">{{ (new DateTime($iship->endDate))->format('d M Y') }}</td>
                        <td class="col-md-1">{{ $iship->state }}</td>
                        <td class="col-md-1 text-center">
                            @if($iship->mailstate == 1)
                                <span class="ok glyphicon glyphicon-ok tick"></span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
@section ('page_specific_js')
    <script src="js/visit.js"></script>
@stop
