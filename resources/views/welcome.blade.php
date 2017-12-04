@extends ('layout')

@section ('content')
    <div class="content">
        <div class="text-center title">
            Larasta <span class="version">{{ config('app.version') }}</span>
        </div>
        <div class="text-center links">
            <a href="/remarks">Remarques</a>
        </div>
    </div>
@stop