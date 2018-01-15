{{--
Bastien Nicoud
Evaluation grid layout

This view requires :
$gridID
$evaluationContext
$evalGrid
--}}


@extends ('layout')

@section ('page_specific_css')
    <script src="/css/evalGrid.css"></script>
@stop

@section ('content')

<div class="container">

    <h1>Grille d'évaluation</h1>

    <h3>ID de la grille d'evaluation : {{ $gridID }}</h3>

    {{--  Contains all the grid  --}}
    <div class="grid">

        {{--  This first table display the context of the evaluation (Internsip dates and actors)  --}}
        <table class="table">
            <thead>
                <tr>
                    <th colspan="6">Informations générales</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Dates du stage</td>
                    <td>{{ $evaluationContext->visit->internship->beginDate }} /// {{ $evaluationContext->visit->internship->endDate }}</td>
                    <td>Date de la visite</td>
                    <td>{{ $evaluationContext->visit->moment }}</td>
                    <td>Numéro de visite</td>
                    <td>{{ $evaluationContext->visit->number }}</td>
                </tr>
                <tr>
                    <td>Nom et prénom du stagiaire</td>
                    <td>{{ $evaluationContext->visit->internship->student->full_name }}</td>
                    <td colspan="2">Nom du responsable de suivi du stagiaire (interne)</td>
                    <td colspan="2">{{ $evaluationContext->visit->internship->teacher->full_name }}</td>
                </tr>
                <tr>
                    <td>Nom de la companie</td>
                    <td>{{ $evaluationContext->visit->internship->companie->companyName }}</td>
                    <td colspan="2">Nom du responsable de suivi du stagiaire (externe)</td>
                    <td colspan="2">{{ $evaluationContext->visit->internship->responsible->full_name }}</td>
                </tr>
                <tr>
                    <td colspan="6">L’ensemble de la procédure d’évaluation se fait en présence de toutes les parties prenantes ! (stagiaire & responsables interne et externe du suivi)</td>
                </tr>
            </tbody>
        </table>

        {{--  List all the sections of the evaluation  --}}
        @foreach ($evalGrid as $evalSection)

            <table class="table">

                {{--  Generates the right layout according to the sectionType  --}}
                @if ($evalSection->sectionType == 1)

                    <p>Section de type 1</p>

                    <thead>

                        <tr>
                            <th>{{ $evalSection->sectionName }} :</th>
                            <th>Observations attendues</th>
                            <th>Points</th>
                            <th>Remarques personnalisées</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($evalSection->criterias as $criteria)
                            <tr>
                                <td>{{ $criteria->criteriaName }}</td>
                                <td>{{ $criteria->criteriaDetails }}</td>
                                <td>{{ $criteria->criteriaValue->points }}</td>
                                <td>{{ $criteria->criteriaValue->managerComments }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td><strong>Note pour les {{ $evalSection->sectionName }} :</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                    </tbody>

                @elseif ($evalSection->sectionType == 2)

                    <p>Section de type 2</p>

                    <thead>

                        <tr>
                            <th>{{ $evalSection->sectionName }} :</th>
                            <th></th>
                            <th>Remarque du responsable de stage</th>
                            <th>Remarque du stagiaire</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($evalSection->criterias as $criteria)
                            <tr>
                                <td>{{ $criteria->criteriaName }}</td>
                                <td>{{ $criteria->criteriaValue->contextSpecifics }}</td>
                                <td>{{ $criteria->criteriaValue->managerComments }}</td>
                                <td>{{ $criteria->criteriaValue->studentComments }}</td>
                            </tr>
                        @endforeach

                    </tbody>

                @elseif ($evalSection->sectionType == 3)

                    <p>Section de type 3</p>

                    <thead>

                            <tr>
                                <th>{{ $evalSection->sectionName }} :</th>
                                <th>Remarque du responsable de stage</th>
                                <th>Remarque du stagiaire</th>
                            </tr>
    
                        </thead>
    
                        <tbody>
    
                            @foreach ($evalSection->criterias as $criteria)
                                <tr>
                                    <td>{{ $criteria->criteriaName }}</td>
                                    <td>{{ $criteria->criteriaValue->managerComments }}</td>
                                    <td>{{ $criteria->criteriaValue->studentComments }}</td>
                                </tr>
                            @endforeach
    
                        </tbody>

                @endif

            </table>

        @endforeach

    </div>

</div>

@stop

@section ('page_specific_js')
    <script src="/js/evalGrid.js"></script>
@stop