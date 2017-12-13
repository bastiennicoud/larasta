@extends ('layout')

@section ('content')
        <h1>
            Larasta
        </h1>
        <span class="version">Version: {{ config('app.version') }}</span>
        <div>
            <a href="/visits">Visits (management)</a>
            <br>
            <a href="/remarks">Remarques</a>
            <a href="/evalgrid">Grille d'évaluation</a>
        </div>
        <div>
            <a href="/synchro">Synchro</a>
        </div>
    </div>
@stop