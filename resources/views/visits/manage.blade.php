@extends ('layout')

@section ('content')
    <h1>Manage</h1>
    <button class="btn btn-primary" onclick="mailto()">
        Envoyer un e-mail
    </button>
    <br>
    <br>
    <table class="table table-bordered col-md-10">
        <tr>
            <th class="col-md-1">Prénom de l'élève</th>
            <th class="col-md-1">Nom de l'élève</th>
            <th class="col-md-1">Entreprise</th>
            <th class="col-md-1">Date de la visite</th>
            <th class="col-md-1">Heure de la visite</th>
            <th class="col-md-1">Date de début de stage</th>
            <th class="col-md-1">Date de fin de stage</th>
            <th class="col-md-1">email</th>
        </tr>
        <tr class="clickable-row text-left" data-href="/remarks/{{ 'bonjour' }}/edit">
            <td class="col-md-1">{!! $internship->firstname !!}</td>
            <td class="col-md-1">{!! $internship->lastname !!}</td>
            <td class="col-md-1">{!! $internship->companyName !!}</td>
            <td class="col-md-1">{{ (new DateTime($internship->moment))->format('d.m.Y') }}</td>
            <td class="col-md-1">{{ (new DateTime($internship->moment))->format('H:i:s') }}</td>
            <td class="col-md-1">{{ (new DateTime($internship->beginDate))->format('d.m.Y') }}</td>
            <td class="col-md-1">{{ (new DateTime($internship->endDate))->format('d.m.Y') }}</td>
            <td class="col-md-1"><span class="mailstate">{!! $internship->mailstate !!}</span></td>
        </tr>
        <tr>
            <th colspan="7" class="text-right">Etat de la visite</th>
            <td>{{ $internship->stateName }}</td>
            {{$contact->value}}
        </tr>
    </table>
    <form method="post" action="/remarks/add" class="col-md-10 text-left">
        {{ csrf_field() }}
        <fieldset>
            <legend>Ajouter une remarque</legend>
            <input type="text" name="newremtext"/>
            <input type="submit" value="Ok"/>
        </fieldset>
    </form>
    </div>
    <script>
        //Fonction that open mail app and redirect the user to the main view
        function mailto()
        {

            // var url = '/visits/'+{{$internship->internships_id}}+'/mail';
            // var email = email + {{$contact->value}};

            // var mailto_link = 'mailto:' + email;

            var url = '/visits/'+{{$internship->internships_id}}+'/mail';
            //var mail = {{$contact->value}};

                location.href = "mailto:jeanyvesle@hotmail.com?subject=Hello world&body=Line one%0DLine two";
                window.setTimeout(function(){ location.href = url },  1000);
        }
    </script>
@stop
@section ('page_specific_js')
    <script src="/js/visit.js"></script>
@stop
