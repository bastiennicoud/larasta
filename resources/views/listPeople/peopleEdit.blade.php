<!--
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 14/01/2018
 * Time: 18:56
 */
-->

@extends ('layout')

@section ('content')
    <link rel="stylesheet" href="/css/people.css" />

    <!-- Header -->

    <div id = "people_content">

        <!-- FirstName and LastName -->

        <div id="people_Name" class="row">
            <span>{{ $person->firstname }} {{ $person->lastname }}</span>
            @if (($person->role == 2) && ($person->obsolete == 0))
                <span><a href="/listPeople/update/{{ $person->id }}"><button class="btn btn-success" id="people-btn_desactive">Désactiver</button></a></span>
            @endif
        </div>

        <div class="margin10 row"> </div>

        <div class="row bar30">
            <h5>Contact</h5>
        </div>

        <div class="margin10 row"> </div>

        <div id="people_Info" class="row">

            <!-- Adress -->

            <div>
                <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                @if (isset($adress) || ($adress != null) )
                    <span>{{ $adress->address1 }} - </span>
                    @if ($adress->address2 != null)
                        <span>{{ $adress->address2 }} - </span>
                    @endif
                    <span>{{ $adress->postalCode }} - </span>
                    <span>{{ $adress->city }}</span>
                    @if( ($adress->lat != null) && ($adress->lng != null))
                        <a href="http://maps.google.com/?q={{$adress->lat}},{{$adress->lng}}">[Google Maps]</a>
                    @endif
                @else
                    <span>Pas d'addresse</span>
                @endif
            </div>

            <!-- Contacts -->

            @foreach($contacts as $contact)
                <div>
                    @if($contact->contactTypeDescription == 'Email')
                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                    @endif
                    @if($contact->contactTypeDescription == 'Tel Fixe')
                        <span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>
                    @endif
                    @if($contact->contactTypeDescription == 'Tel Portable')
                        <span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
                    @endif
                    <span>{{ $contact->value }}</span>
                </div>
            @endforeach

        </div>

        <div class="margin10 row"> </div>

        <div class="row bar30">
            <h5>Stages</h5>
        </div>

        <div class="margin10 row"> </div>

        @foreach($stages as $stage)
            <div>
                @if (isset($stage->companyName))
                    Entreprise: {{ $stage->companyName }}
                @else
                    Pas de stage
                @endif
            </div>
        @endforeach

        <div class="margin30 row"> </div>

        <div class = "row">
            <a href="/listPeople" id ="btn-return" class="btn btn-success">List Personnes</a>
        </div>

        <div class="margin30 row"> </div>

    </div>
@stop
