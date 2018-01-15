@extends ('../layout')

{{-- Author : Kevin Jordil 2018 --}}

@section ('page_specific_css')
    <link rel="stylesheet" href="/css/travelTime.css">
@stop

@section ('content')

    <h1>
        TravelTime
    </h1>
    <div>
        <form action="/traveltime/calculate" method="post" name="cal">
            {{ csrf_field() }}
            <label for="flockID">ID de classe :</label>
            <input type="text" class="form-control" name="flockID" id="flockID">
            <button type="submit" class="btn">(Re)Calculer</button>
        </form>
    </div>
    <div>
        <form action="/traveltime/load" method="post" name="loa">
            {{ csrf_field() }}
            <label for="flockID">ID de classe :</label>
            <input type="text" class="form-control" name="flockID" id="flockID">
            <button type="submit" class="btn">Charger</button>
        </form>
    </div>

    @if (isset($persons) & isset($companies) & isset($times))
        <table class="table-bordered">
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
                        <td>{{ $times[$i] }}</td>
                    @endfor
                </tr>
            @endforeach

        </table>
    @endif


@stop

@section ('page_specific_js')
    <script src="/js/travelTime.js"></script>
@stop
