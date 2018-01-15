@extends ('layout')

@section ('content')
    <div class="simple-box col-md-10 text-left">
        <form name="filterInternships" method="post">
            {{ csrf_field() }}
            @foreach ($statefilter as $state)
                <fieldset class="col-md-3">
                    <label for="state{{ $state->id }}">{{ $state->stateDescription }}</label>
                    <input class="autosubmit" type="checkbox" id="state{{ $state->id }}" name="state{{ $state->id }}" @if ($state->checked) checked @endif >
                </fieldset>
            @endforeach
        </form>
    </div>
    <div class="col-md-10">&nbsp;</div>
    <div class="col-md-10">
        @if (count($iships) > 0)
            <table class="table table-bordered table-hover text-left larastable">
                <thead>
                <tr>
                    <th>Entreprise</th>
                    <th>Début</th>
                    <th>Responsable administratif</th>
                    <th>Responsable</th>
                    <th>Stagiaire</th>
                    <th>Etat</th>
                </tr>
                </thead>
                <tbody>
                @foreach($iships as $iship)
                    <tr class="clickable-row" data-href="/internships/{{ $iship->id }}/edit">
                        <td>{{ $iship->companyName }}</td>
                        <td>{{ strftime("%b %g", strtotime($iship->beginDate)) }}</td>
                        <td>{{ $iship->arespfirstname }} {{ $iship->aresplastname }}</td>
                        <td>{{ $iship->irespfirstname }} {{ $iship->iresplastname }}</td>
                        <td>{{ $iship->studentfirstname }} {{ $iship->studentlastname }}</td>
                        <td>{{ $iship->stateDescription }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="alert-info">Aucun stage ne correspond à ce filtre</div>
        @endif
    </div>
@stop