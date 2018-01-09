@extends ('../layout')

@section ('content')

    <h1>
        TravelTime
    </h1>
    <table class="table-bordered">
        <tr>
            <th></th>
            @foreach ($persons as $person)
                @if ($person->initials!="")
                    <th>{{ $person->initials }}</th>
                @endif
            @endforeach
        </tr>
        @foreach ($companies as $companie)
            <tr>
                <td>{{ $companie->companyName }}</td>
            </tr>
        @endforeach
    </table>


@stop