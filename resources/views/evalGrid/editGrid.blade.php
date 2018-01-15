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

    <h1>Grille d'évaluation</h1>

    <h3>ID de la grille d'evaluation : {{ $gridID }}</h3>
    <h3>Vous editez la grille du stage : {{ $evaluationContext->visit->internship->id }}. Visite numéro : {{ $evaluationContext->visit->number }}</h3>

    {{--  Contains all the grid  --}}
    <div class="grid">

        {{--  List all the sections of the evaluation  --}}
        @foreach ($evalGrid as $evalSection)

            <table class="table table-bordered table-striped">

                {{--  Generates the right layout according to the sectionType  --}}
                @if ($evalSection->sectionType == 1)

                    <p>Section de type 1</p>

                    <tr>
                        <th>Compétences professionnelles :</th>
                        <th>Observations attendues</th>
                        <th>Compétences professionnelles :</th>
                        <th>Compétences professionnelles :</th>
                    </tr>

                    <tr>
                        <td></td>
                    </tr>

                @elseif ($evalSection->sectionType == 2)

                    <p>Section de type 2</p>

                @elseif ($evalSection->sectionType == 3)

                    <p>Section de type 3</p>

                @endif

            </table>

        @endforeach

    </div>

@stop

@section ('page_specific_js')
    <script src="/js/evalGrid.js"></script>
@stop