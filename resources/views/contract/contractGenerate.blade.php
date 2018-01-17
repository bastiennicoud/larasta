<?php
/**
 * Author :         Quentin Neves
 * Created :        12.12.2017
 * Updated :        17.01.2018
 * Description :    Check if the contract had already been generated and display it's date or the generation form
 */
?>
@extends ('layout')

@section ('content')
    <h1>Génération de contrat</h1>

    <!--
        There is two conditions because when we manually assign a null value in the database it returns null
        and not '0000-00-00 00:00:00' anymore
    -->
    @if ($iDate->contractGenerated == '0000-00-00 00:00:00' || $iDate->contractGenerated == null)
        <div>Rédiger le contrat au : </div>
        <div>
            <form method="post" action="/contract/{{$iid}}/view">
                {{ csrf_field() }}
                <input type="radio" name="gender" value="male">Masculin<br>
                <input type="radio" name="gender" value="female">Féminin<br>
                <button>Générer</button>
            </form>
        </div>
    @else
        Contrat généré le : {{$iDate->contractGenerated}}
        <a href="/contract/{{$iid}}/cancel"><button>Annuler</button></a>
    @endif


@stop