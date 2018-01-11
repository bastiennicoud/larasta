<!--
/**
 * Created by PhpStorm.
 * User: Davide.CARBONI
 * Date: 18.12.2017
 * Time: 09:02
 */
-->
@extends ('layout');

@section ('content')
    <link rel="stylesheet" href="/css/people.css">

    <!-- Header -->




    <div id = "people_content" class="container">

        <div id ="people_header" class="row">
            <h4>Filtre par:</h4>
            <div>
        </div>

        <div id="people_container" class="row">
            <table class="col-lg-12 col-xs-12 table table-bordered">
                <thead>
                    <tr>
                        <th>Personne</th>
                        <th>Rôle</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($persons as $person)
                    <tr>
                        <td>{{ $person->firstname }} {{ $person->lastname }}</td>
                        <td> {{ $person->role }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <a href="">Retour</a>
@stop