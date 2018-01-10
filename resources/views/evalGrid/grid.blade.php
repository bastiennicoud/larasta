<!-- *********************************** -->
<!-- Bastien Nicoud                      -->
<!-- Evaluation grid layout              -->


@extends ('layout')

@section ('content')

    <h1>Grille d'évaluation</h1>

    <br>
    <br>
    <h2>Tests de récuperation de la grille !!! NON FONCTIONNEL !!!</h2>

        <!-- Display all sections -->
    @foreach ($evalGrid as $section)
        <p><strong>{{ $section->sectionName }}</strong></p>

        <!-- Check the type of the section -->
        @if ($section->sectionType == 1)
            <p>Section de type 1</p>
        @elseif ($section->sectionType == 2)
            <p>Section de type 2</p>
        @endif

        <!-- Display the criterias of the section -->
        @foreach ($section->criterias as $criteria)
            <p>{{$criteria->criteriaName}} // {{$criteria->criteriaDetails}} // {{$criteria->maxPoints}}</p>
        @endforeach

    @endforeach

@stop