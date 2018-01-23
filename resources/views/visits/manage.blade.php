@extends ('layout')

@section ('content')
    {{-- Link to intern's profile--}}
    <h3>
        <a href="/visits/" class="btn btn-success" style="color:white !important"><span>&lt;</span></a> Visite de stage n°{{$internship->id}} de <a href="#">{{$internship->lastname}}, {{$internship->firstname}}</a></h3>
    <br>
    <form method="post" action="/visits/{{$internship->id}}/update" class="text-left">
        {{ csrf_field() }}
        <table class="larastable table table-bordered col-md-10">
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
            <tr class="text-left">
                <td class="col-md-1">{!! $internship->firstname !!}</td>
                <td class="col-md-1">{!! $internship->lastname !!}</td>
                <td class="col-md-1">{!! $internship->companyName !!}</td>
                <td class="col-md-1">
                    <div id="vdate">
                        {{ (new DateTime($internship->moment))->format('d.m.Y') }}
                    </div>
                    <fieldset>
                        <div id="dateedit" class="hidden">
                            <?php
                                $today = date('Y-m-d');
                                $last = (new DateTime($internship->endDate))->format('Y-m-d');
                            ?>
                            <input type="date" name="upddate" max="{{$last}}" min="{{$today}}" value="{{ (new DateTime($internship->moment))->format('Y-m-d') }}">
                        </div>
                    </fieldset>
                </td>
                <td class="col-md-1">
                    <div id="vhour">
                        {{ (new DateTime($internship->moment))->format('H:i:s') }}
                    </div>
                    <div id="houredit" class="hidden">
                        <input type="time" name="updtime" value="{{ (new DateTime($internship->moment))->format('H:i') }}">
                    </div>
                </td>
                <td class="col-md-1">{{ (new DateTime($internship->beginDate))->format('d.m.Y') }}</td>
                <td class="col-md-1">{{ (new DateTime($internship->endDate))->format('d.m.Y') }}</td>
                <td class="col-md-1">
                    @if($internship->mailstate == 1)
                        <span id="ok" class="ok glyphicon glyphicon-ok" style="color:green"></span class="mok">&nbsp;<span id="mok">envoyé</span>
                    @else
                        <span id="remove" class="remove glyphicon glyphicon-remove" style="color:red"></span>&nbsp;<span id="mremove">pas encore envoyé</span>
                    @endif
                    <select id='selm' name="selm" class="hidden">
                            <option value="1">envoyé</option>
                            <option value="0">pas envoyé</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th colspan="7" class="text-right">Etat de la visite</th>
                <td>
                    <span id="staid">{{ $internship->stateName }}</span>
                    <select id='sel' name="state" class="hidden">
                        @foreach($visitstate as $state)
                            <option value="{{$state->id}}">
                                {{$state->stateName}}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
        </table>
        <div>
            <button id="up" class="btn-info hidden" type="submit">Enregistrer</button>
            <a id="cancel_a" class="btn-info hidden" style="">Annuler</a>
        </div>
    </form>

    @if($internship->visitsstates_id <= 2 || $internship->visitsstates_id == 4)
        <button id="edit" class="btn-info">Editer</button>
        <button id="bmail" class="btn-success" onclick="mailto()">Envoyer un e-mail</button>{{-- Link to evaluation--}}
        @switch(\App\Http\Controllers\EvalController::getEvalState($internship->id))
            @case(1)
            <a href="/evalgrid/neweval/{{ $internship->id }}">
                <button class="beval btn-primary">Démarrer l'évaluation</button>
            </a>
            @break
            @case(2)
            <a href="/evalgrid/grid/edit/{{ $internship->id }}">
                <button class="beval btn-warning">Reprendre l'évaluation</button>
            </a>
            @break
            @case(3)
            <a href="/evalgrid/grid/readonly/{{ $internship->id }}">
                <button class="beval btn-secondary">Afficher l'évaluation</button>
            </a>
            @break
        @endswitch
    @else
        <span class="remove glyphicon glyphicon-remove" style="color:red"></span>&nbsp;La visite a été {!! strtolower($internship->stateName) !!} et ne peut plus être modifiée
        {{-- Link to evaluation--}}
        @switch(\App\Http\Controllers\EvalController::getEvalState($internship->id))
            @case(1)
            <a href="/evalgrid/neweval/{{ $internship->id }}">
                <button class="beval btn-primary">Démarrer l'évaluation</button>
            </a>
            @break
            @case(2)
            <a href="/evalgrid/grid/edit/{{ $internship->id }}">
                <button class="beval btn-warning">Reprendre l'évaluation</button>
            </a>
            @break
            @case(3)
            <a href="/evalgrid/grid/readonly/{{ $internship->id }}">
                <button class="beval btn-secondary">Afficher l'évaluation</button>
            </a>
            @break
        @endswitch
        <br>
    @endif
    <div class="text-left">
        <p id="pdone" class="hidden done">Supprimer la visite de stage <span class="text-danger">Irréversible !</span></p>
        <a id="del" class="hidden" href="/visits/{{ $internship->id }}/delete">
            <button class="btn-danger">Supprimer</button>
        </a>
    </div>
    <br><br>
    <div>
        {{-- Responsible table info --}}
        <table class="larastable table table-bordered col-md-12">
            <tr>
                <th class="col-md-6">email du responsable</th>
            </tr>
            <tr class="text-left">
                <td class="col-md-6"><span class="mailstate">{{$contact->value}}</span></td>
            </tr>
        </table>
                    <form method="post" action="/remarks/add" class="col-md-12 text-left">
                        {{ csrf_field() }}
                        <fieldset>
                            <legend>Ajouter une remarque</legend>
                            <textarea type="text" name="newremtext"></textarea>
                            <input type="submit" value="Ok"/>
                        </fieldset>
                    </form>
        <br>
        <h3>Remarques</h3>
        <table class="larastable table table-striped text-left">
            <thead class="thead-inverse">
            <tr>
                <th>Date</th>
                <th>Créateur</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@stop

    <script>
        //Fonction that open mail app and redirect the user to the main view
        function mailto()
        {
            var email = '{{$contact->value}}';

            var mailto_link = 'mailto:' + email + '?subject=Stagiaire {{$internship->lastname}}, {{$internship->firstname}}&body=Bonjour,%0D%0DDescription';

            console.log(mailto_link);

            var url = '/visits/'+{{$internship->internships_id}}+'/mail';

            location.href = mailto_link;
            window.setTimeout(function(){ location.href = url },  1000);
        }
    </script>

@section ('page_specific_js')
    <script src="/js/remark.js"></script>
    <script src="/js/visit.js"></script>
@stop
