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
        @include ('visits.visits',['iships' => $iships])
    </div>
@stop