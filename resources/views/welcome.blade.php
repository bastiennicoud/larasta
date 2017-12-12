@extends ('layout')

@section ('content')
        <h1>
            Larasta
        </h1>
        <span class="version">{{ config('app.version') }}</span>
        <div>
            <a href="/remarks">Remarques</a>
            <a href="/evalgrid">Grille d'évaluation</a>
        </div>
    </div>
@stop