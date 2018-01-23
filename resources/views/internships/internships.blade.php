@extends ('layout')

@section ('content')
    <div class="simple-box col-md-10 text-left">
        <form name="filterInternships" method="post">
            {{ csrf_field() }}
            <fieldset>
                <legend>Dans l'état</legend>
                @foreach ($filter->getStateFilter() as $state)
                    <fieldset class="col-md-3">
                        <label for="state{{ $state->id }}">{{ $state->stateDescription }}</label>
                        <input class="autosubmit" type="checkbox" id="state{{ $state->id }}" name="state{{ $state->id }}" @if ($state->checked) checked @endif >
                    </fieldset>
                @endforeach
            </fieldset>
            <fieldset>
                <legend> et </legend>
                <fieldset class="col-md-3">
                    <label for="inprogress">En cours</label>
                    <input class="autosubmit" type="checkbox" id="inprogress" name="inprogress" @if ($filter->getInProgress()) checked @endif >
                </fieldset>
                <fieldset class="col-md-3">
                    <label for="mine">Sous ma responsabilité</label>
                    <input class="autosubmit" type="checkbox" id="mine" name="mine" @if ($filter->getMine()) checked @endif >
                </fieldset>
            </fieldset>
        </form>
    </div>
    <div class="col-md-10">&nbsp;</div>
    <div class="col-md-10">
        @include ('internships.internshipslist',['iships' => $iships])
    </div>
@stop