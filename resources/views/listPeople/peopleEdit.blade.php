<!--
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 14/01/2018
 * Time: 18:56

 * !!!! IMPORTANT !!!!
 * ONLY FOR TEACHER ROLE
 * If you want have all contacts informations for teacher -> do nothing
 * If you want have nothing information for teacher so go to the STEP by STEP procedure
 * STEP by STEP: folow the step procedure starting in the Step 1
 * After finished go to PeopleController and follow the same procedure
 */
-->

@extends ('layout')

@section ('content')
    <link rel="stylesheet" href="/css/people.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!--------------------->
    <!-- Section Header --->
    <!--------------------->

    <div id = "people_content">

        <!-- FirstName and LastName -->

        <div id="people_Name" class="row">
            <span>{{ $person->firstname }} {{ $person->lastname }}</span>
            @if (($user->getLevel() >= 2))  <!-- View button only for teacher -->
                <span>
                    <button id="btn-add-section" name="btn-add-section" data-toggle="modal" data-target="#peopleModal" class="btn btn-success people-btn_desactive" />Modifier
                </span>
            @endif
        </div>

        <div class="margin10 row"> </div>

        <div class="row bar30">
            <h5>Contact</h5>
        </div>

        <div class="margin10 row"> </div>

        <div id="people_Info" class="row">

        @if($person->role != 1)  <!-- Nothing to view for teacher! No adress -->

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
                        <!-- If google maps lat and long is not available do not display link -->
                        @if( ($adress->lat != null) && ($adress->lng != null))
                            <a href="http://maps.google.com/?q={{$adress->lat}},{{$adress->lng}}">[Google Maps]</a>
                        @endif
                    @else
                        <span>Pas d'addresse disponible</span>
                    @endif
                </div>
            <!-- Step 1 -->
            <!-- Comment or delete this three lines -->
            <!-- Then go to Step 2 -->
            @else
                <span class="glyphicon glyphicon-home" aria-hidden="true"></span><span> Pas d'addresse</span>
            @endif

        <!-- Contacts -->

            @foreach($contacts as $contact)      <!-- View all contacts for one people -->
                <div>
                    <!-- Mail contact type -->
                    @if($contact->contactTypeDescription == 'Email')
                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                    @endif
                      <!-- Fixe phone contact type -->
                    @if($contact->contactTypeDescription == 'Tel Fixe')
                        <span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>
                    @endif
                    <!-- Mobile phone contact type -->
                    @if($contact->contactTypeDescription == 'Tel Portable')
                        <span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
                    @endif
                    <span>{{ $contact->value }}</span>
                </div>
            @endforeach

            <!-- Step 2 -->
            <!-- Uncommnet this three lines -->
            <!-- Then go to Step 3 -->
            {{--
            @else
                <span class="glyphicon glyphicon-home" aria-hidden="true"></span><span> Pas d'addresse</span>
            @endif --}}


        </div>

        <div class="margin10 row"> </div>

        @if ($person->role == 0)
            <div class="row bar30">
                <h5>Stages</h5>
            </div>

            <div class="margin10 row"> </div>

            @include ('internships.internshipslist',['iships' => $iships])
        @endif

    </div>

    <!--------------------->
    <!-- Section Modal  --->
    <!--------------------->

    {{-- Modal Form Pop up--}}
    <div class="modal fade" id="peopleModal"
         tabindex="-1" role="dialog"
         aria-labelledby="peopleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"
                        id="peopleModalLabel">{{ $person->firstname }} {{ $person->lastname }}</h4>
                </div>
                <form action="/listPeople/update/{{ $person->id }}/" method="post" id="addSection">
                    <div class="modal-body" id="contact-modify">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <!-- Hide values not modifiables to submit at the form -->
                        <input  name = "role" value="{{ $person->role }}"  class="hide"/>
                        <input  name = "locationID" value="{{ $person->location_id }}"  class="hide"/>

                        <!--------------------->
                        <!-- Section Action --->
                        <!--------------------->

                        <div class="row modal-row text-right">
                            <label id = "people-desactivate-Title" class="form-text-label" for="people-activate">Désactiver </label>
                            <input  id ="people-activate" type="checkbox" class="form-check-input" name = "obsolete" value="{{ $person->obsolete }}" placeholder="{{ $person->obsolete }}" @if ($person->obsolete == 1) checked="checked" @endif />
                        </div>

                        <!--------------------->
                        <!-- Section Adress --->
                        <!--------------------->

                        <!-- Nothing to modify for teacher -->
                        @if($person->role != 1)

                            <div class="page-header text-left">Adresse:</div>

                            <div class="row modal-row ">
                                <div class="col-xs-2 col-md-2">Adresse 1</div>
                                <div class="col-xs-10 col-md-10"><input type="text" class="form-control"  name = "adress1" value="{{ $adress->address1 }}" placeholder="Adresse 1" /></div>
                            </div>
                            <div class="row modal-row">
                                <div class="col-xs-2 col-md-2">Adresse 2</div>
                                <div class="col-xs-10 col-md-10"> <input type="text" class="form-control"  name = "adress2" value="{{ $adress->address2 }}" placeholder="Adresse 2" /> </div>
                            </div>
                            <div class="row modal-row">
                                <div class="col-xs-2 col-md-2">Npa</div>
                                <div class="col-xs-10 col-md-10"> <input type="number" class="form-control"  name = "postalCode" value="{{ $adress->postalCode }}" placeholder="NPA Code" /> </div>
                            </div>
                            <div class="row modal-row">
                                <div class="col-xs-2 col-md-2">Ville</div>
                                <div class="col-xs-10 col-md-10"> <input type="text" class="form-control" name = "city"  value="{{ $adress->city }}" placeholder="Ville" /> </div>
                            </div>
                        <!-- Step 3 -->
                        <!-- Comment or delete this line -->
                        <!-- Then go to Step 4 -->
                        @endif

                        <!--------------------------->
                        <!-- Section Contact Mail --->
                        <!--------------------------->

                        <div class="page-header text-left">Mail:</div>

                        <!-- list all value of mails -->
                        <div id="mailContent">
                            @foreach($contacts as $contact)
                                @if($contact->contactTypeDescription == 'Email')
                                    <div class="row modal-row">
                                        <div class="col-xs-2 col-md-2">Mail:</div>
                                        <div class="col-xs-9 col-md-9"><input type="text" class="form-control toValidate"  name = "mail[]" value="{{ $contact->value }}" placeholder="example@domaine.ch" /></div>
                                        <div class="col-xs-1 col-md-1"><button type="button" class="btn btn-danger glyphicon glyphicon-minus" id="mail"></button></div>
                                    </div>
                            @endif
                        @endforeach

                        <!-- add new mail contact -->
                            <div class="row modal-row">
                                <div class="col-xs-2 col-md-2">Mail:</div>
                                <div class="col-xs-9 col-md-9"><input type="text" class="form-control toValidate"  name = "mail[]" value="" placeholder="example@domaine.ch" /></div>
                                <div class="col-xs-1 col-md-1"><button type="button" class="btn btn-success glyphicon glyphicon-plus"  disabled="disabled" id="mail"></button></div>
                            </div>
                        </div>

                        <!-------------------------------->
                        <!-- Section Contact Phone Fix --->
                        <!-------------------------------->

                        <div class="page-header text-left">Télephone fixe:</div>

                        <!-- list all value of mails -->
                        <div id="phoneFixeContent">
                            @foreach($contacts as $contact)
                                @if($contact->contactTypeDescription == 'Tel Fixe')
                                    <div class="row modal-row">
                                        <div class="col-xs-2 col-md-2">Phone:</div>
                                        <div class="col-xs-9 col-md-9"><input type="text" class="form-control toValidate"  name="phoneFixe[]" value="{{ $contact->value }}" placeholder="numero téléphone suisse" /></div>
                                        <div class="col-xs-1 col-md-1"><button type="button" class="btn btn-danger glyphicon glyphicon-minus" id="phoneFixe"></button></div>
                                    </div>
                            @endif
                        @endforeach

                        <!-- add new phone fix contact -->

                            <div class="row modal-row">
                                <div class="col-xs-2 col-md-2">Phone:</div>
                                <div class="col-xs-9 col-md-9"><input type="text" class="form-control toValidate"  name = "phoneFixe[]" value="" placeholder="numero téléphone suisse" /></div>
                                <div class="col-xs-1 col-md-1"><button type="button" class="btn btn-success glyphicon glyphicon-plus"  disabled="disabled" id="phoneFixe"></button></div>
                            </div>
                        </div>
                        <!----------------------------------->
                        <!-- Section Contact Phone Mobile --->
                        <!----------------------------------->

                        <div class="page-header text-left">Télephone portable:</div>

                        <!-- list all value of mails -->
                        <div id="phoneMobileContent">
                            @foreach($contacts as $contact)
                                @if($contact->contactTypeDescription == 'Tel Portable')
                                    <div class="row modal-row">
                                        <div class="col-xs-2 col-md-2">Phone:</div>
                                        <div class="col-xs-9 col-md-9"><input type="text" class="form-control toValidate"  name = "phoneMobile[]" value="{{ $contact->value }}" placeholder="numero téléphone suisse" /></div>
                                        <div class="col-xs-1 col-md-1"><button type="button" class="btn btn-danger glyphicon glyphicon-minus" id="phoneMobile"></button></div>
                                    </div>
                            @endif
                        @endforeach

                        <!-- add new phone mobile contact -->

                            <div class="row modal-row">
                                <div class="col-xs-2 col-md-2">Phone:</div>
                                <div class="col-xs-9 col-md-9"><input type="text" class="form-control toValidate"  name = "phoneMobile[]" value="" placeholder="numero téléphone suisse" /></div>
                                <div class="col-xs-1 col-md-1"><button type="button" class="btn btn-success glyphicon glyphicon-plus"  disabled="disabled" id="phoneMobile"></button></div>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <!-- Enable this line -->
                        <!-- Then you are Finish -->
                        <!-- Then verify the PeopleController and follow the same procedure -->
                        {{-- @endif --}}

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="addNewPeople" type="submit" class="btn btn-primary" disabled="disabled">Ok</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section ('page_specific_js')
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/js/people.js"></script>
@stop
