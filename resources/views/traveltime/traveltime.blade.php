@extends ('../layout')

@section ('content')

    <h1>
        TravelTime
    </h1>
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


@stop