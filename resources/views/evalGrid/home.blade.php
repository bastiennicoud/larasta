<!-- *********************************** -->
<!-- Bastien Nicoud                      -->
<!-- Evaluation grid home                -->


@extends ('layout')

@section ('content')

    <h1>Grille d'évaluation <small>Bastien</small></h1>

    <hr>

    <p>Cette page affiche les diférents contoles pour créer, remplir, modifier, supprimer une evaluation de stage</p>
    <p>Toute les actions suivantes devront être spécifiques a l'utilisateur connecté</p>

    <div>
        <a class="btn btn-success" href="neweval/30">Novelle grille d'evaluation (visite 30, juste pour le dev)<a>
        <hr>
        <p><strong>Mes grilles d'évaluation</strong></p>
        <!-- Lists all the user actives evaluations -->
        @foreach ($evaluations as $eval)
            <p>ID :{{ $eval->id }} </p>
        @endforeach
    <div>

@stop