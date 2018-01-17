{{--
Author : Kevin Jordil

If this view get
$persons
$companies
$times
$colors

Display an array with all elements
--}}

<!-- Author : Kevin Jordil -->
<!--    TravelTime page    -->

@extends ('../layout')

@section ('page_specific_css')
    <link rel="stylesheet" href="/css/travelTime.css">
@stop

@section ('content')

    <h1>
        TravelTime
    </h1>
    <form action="/wishesMatrix" method="get" class="backForm">
        {{ csrf_field() }}
        <button type="submit" class="btn">Retour</button>
    </form>
    @if ($error)

        <h4>Erreur : {{ $message }}</h4>

    @elseif (isset($persons) & isset($companies) & isset($times))

        <div class="row">
            <table class="table-bordered col-md-9">
                <tr>
                    <th></th>
                    @foreach ($persons as $person)
                        <th>{{ $person->initials }}</th>
                    @endforeach
                </tr>

                @foreach ($companies as $key => $companie)
                    <tr>
                        <td>{{ $companie->companyName }}</td>
                        @for($i = $key*count($persons) ; $i < ($key*count($persons))+count($persons); $i++)
                            <td class="{{ $colors[$i] }}">{{ $times[$i] }}</td>
                        @endfor
                    </tr>
                @endforeach

            </table>
        </div>

        <br/>
        <br/>

        <div class="row">
            <form action="/traveltime/{{ $flockId }}/calculate" method="get">
                {{ csrf_field() }}
                <button type="submit" class="btn">(Re)Calculer</button>
            </form>
        </div>

    @else

        <h4>L'url n'est pas valide</h4>


    @endif


@stop

@section ('page_specific_js')
    <script src="/js/travelTime.js"></script>
@stop
