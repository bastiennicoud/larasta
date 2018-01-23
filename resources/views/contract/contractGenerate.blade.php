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
    <div class="container-fluid">
        <h1>Génération de contrat</h1><br>

        <!--
            There is two conditions because when we manually assign a null value in the database it returns null
            and not '0000-00-00 00:00:00' anymore
        -->
        @if ($iDate->contractGenerated == '0000-00-00 00:00:00' || $iDate->contractGenerated == null)
            Rédiger le contrat au : <br>
            <form method="post" action="/contract/{{$iid}}/view">
                {{ csrf_field() }}
                <input type="radio" name="gender" value="male">Masculin<br>
                <input type="radio" name="gender" value="female">Féminin<br><br>
                <button>Générer</button>
            </form>
        @else
            <div class="row content-box">
                <div class="col-lg-6 col-lg-offset-3">
                    <div class="container-fluid text-justify">
                        <?php error_log(print_r($contract[0]->contractText)); ?>
                    </div>
                </div>
            </div>
            <br> Contrat généré le : {{$iDate->contractGenerated}}
            <a href="/contract/{{$iid}}/cancel"><button>Annuler</button></a>
        @endif
    </div>


@stop