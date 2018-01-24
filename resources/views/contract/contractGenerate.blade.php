<?php
/**
 * Author :         Quentin Neves
 * Created :        12.12.2017
 * Updated :        24.01.2018
 * Description :    Check if the contract had already been generated and display it's date or the generation form
 */
?>
@extends ('layout')

@section ('content')
    <div class="container-fluid">

        <!--
            There is two conditions because when we manually assign a null value in the database it returns null
            and not '0000-00-00 00:00:00' anymore
        -->
        @if ($iDate->contractGenerated == '0000-00-00 00:00:00' || $iDate->contractGenerated == null)
            <h1>Génération de contrat</h1><br>
            Rédiger le contrat au : <br>
            <form method="post" action="/contract/{{$iid}}/view">
                {{ csrf_field() }}
                <input type="radio" name="gender" value="male" checked>Masculin<br>
                <input type="radio" name="gender" value="female">Féminin<br><br>
                <button>Générer</button>
            </form>
        @else
            <h1>Contrat généré le : {{$iDate->contractGenerated}}</h1>
            <a href="/internships/{{$iid}}/edit"><button class="btn btn-default">Retour au stage</button></a>
        @endif
    </div>


@stop