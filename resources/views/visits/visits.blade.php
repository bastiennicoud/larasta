@extends ('layout')

@section ('content')

    <div class="container">
        <h1>Visits list</h1>
        <a href="/visits/add">
            <button class="btn btn-success small text-white">Créer une visite</button>
        </a>
        <br>
        <br>
        <table class="larastable table table-striped">
            <thead class="thead-inverse">
                <tr class="clickable-row">
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Entreprise</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Etat de la visite</th>
                    <th colspan="2">Email</th>
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
                        <td class="col-md-1">
                            @if($internship->mailstate == 1)
                                <span class="ok glyphicon glyphicon-ok" style="color:green"></span>
                            @else

                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a class="btn btn-primary btn-small" href="/" role="button" style="color: white">Go back</a>
@stop
@section ('page_specific_js')
    <script src="js/visit.js"></script>
@stop