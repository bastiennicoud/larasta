<?php
/**
 * Author : Quentin Neves
 * Created : 12.12.2017
 * Updated : 09.01.2018
 */
?>
@extends ('layout')

@section ('content')
    <h1>Génération de contrat</h1>

    @if ($iDate->contractGenerated == '0000-00-00 00:00:00')
        <div>Rédiger le contrat au : </div>
        <div>
            <form method="post" action="">
                <input type="radio" name="gender" value="male">Masculin<br>
                <input type="radio" name="gender" value="female">Féminin<br>
                <button type="submit">Générer</button>
            </form>
        </div>
    @else
        Contrat généré le : {{$iDate->contractGenerated}}
    @endif


@stop