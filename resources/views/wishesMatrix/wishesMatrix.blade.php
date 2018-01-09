<!-- ///////////////////////////////////              -->
<!-- Benjamin Delacombaz                              -->
<!-- Wishes Matrix layout                             -->
<!-- Version 0.3                                      -->
<!-- Created 18.12.2017                               -->
<!-- Last edit 09.01.2017 by Benjamin Delacombaz      -->


@extends ('layout')

@section ('content')
    <h1>Matrice des souhaits</h1>
    <table class="table-bordered">
        <tr>
            <th></th>
            @foreach ($persons as $person)
                @if ($person->initials!="")
                    <th value="{{ $person->id }}">{{ $person->initials }}</th>
                @endif
            @endforeach
        </tr>
        @foreach ($companies as $companie)
            <tr>
                <td value="{{ $companie->id }}">{{ $companie->companyName }}</td>
                <!-- Create the clickable case for each person -->
                @for ($count = 0; $count < count($persons); $count++)
                    <td class="clickableCase"></td>
                @endfor
            </tr>
        @endforeach
    </table>
@stop

@section ('page_specific_js')
    <script src="/js/wishesMatrix.js"></script>
@stop