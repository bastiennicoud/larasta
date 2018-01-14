
<!--
 * Created by PhpStorm.
 * User: antonio.giordano
 * Date: 09.01.2018
 * Time: 09:11
 -->

@extends ('layout')

@section ('content')
    <div class="container-fluid">
        @if($user->getLevel() >= 2)

        @endif
        <div class="body simple-box">
            @foreach ($company as $companie)
                <div class="title row">
                    <h3>{{$companie->companyName}}</h3>
                </div>
                <div class="row content-box">
                    <div class="col-lg-6 text-right">
                        Adresse : <br>
                        {{$companie->address1}}
                        {{$companie->address2}}<br>
                        {{$companie->postalCode}},
                        {{$companie->city}}
                    </div>
                    <div class="col-lg-6 text-left">
                        Type de contrat : <br>
                        {{$companie->contractType}}
                    </div>
                </div>
            @endforeach
            <div class="row content-box">
                <div class="col-lg-6 col-lg-offset-3">
                    <div class="tab-content">
                        <table class="table">
                            <tr>
                                <th class="text-center">Personne</th>
                                <th class="text-center">Contact</th>
                            </tr>
                            @foreach($persons as $person)
                                @if($person->obsolete == 0)
                            <tr>
                                <td>{{$person->firstname}} {{$person->lastname}}</td>
                                <td>
                                    @foreach($contacts as $contact)
                                        @if($contact->firstname == $person->firstname and $contact->lastname == $person->lastname)
                                            @switch($contact->contacttypes_id)
                                                @case(1)
                                                    <a href="mailto:{{$contact->value}}"> <img class='icon' src='/Images/mail.png'/>
                                                    {{$contact->value}}<br></a>
                                                @break
                                                @case(2)
                                                    <img class='icon' src='/Images/phone.png'/>
                                                    {{$contact->value}}<br>
                                                @break
                                                @case(3)
                                                    <img class='icon' src='/Images/smartphone.png'/>
                                                    {{$contact->value}}<br>
                                                @break
                                            @endswitch
                                        @endif
                                    @endforeach

                                </td>
                            </tr>
                                @endif
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>

            <div class="row content-box">
                <div class="col-lg-6 col-lg-offset-3">
                        <div class="table">

                            <table>
                                <tr>
                                    <th class="text-center">Stagiaire</th>
                                    <th class="text-center">de</th>
                                    <th class="text-center">à</th>
                                    <th class="text-center">Responsable Administratif</th>
                                    <th class="text-center">Responsable Stage</th>
                                </tr>

                                    <!-- 'beginDate','endDate','admin_id','intern_id','responsible_id','persons.id') -->
                                    @foreach($trainee as $traine)
                                    <tr>
                                        <td><a href="{{$traine->id}}"> {{$traine->firstname}} {{$traine->lastname}} </a></td>
                                        <td>{{substr($traine->beginDate,0,10)}}</td>
                                        <td>{{substr($traine->endDate,0,10)}}</td>
                                        @foreach($persons as $person)
                                            @if($person->id == $traine->admin_id) <td>{{$person->firstname}} {{$person->lastname}}</td> @endif
                                            @if($person->id == $traine->responsible_id) <td>{{$person->firstname}} {{$person->lastname}}</td> @endif
                                        @endforeach


                                    </tr>
                                    @endforeach
                            </table>
                        </div>

                </div>
            </div>
        </div>
    </div>

    {{Request::segment(2)}}

@stop

