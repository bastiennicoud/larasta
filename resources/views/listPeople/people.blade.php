<!--
/**
 * Created by PhpStorm.
 * User: Davide.CARBONI
 * Date: 18.12.2017
 * Time: 09:02
 */
-->
@extends ('larasta.old.resources.views.layout')

@section ('content')
    <link rel="stylesheet" href="/css/people.css">
    <h1>The List of People</h1>
    <div id = "people_content" class="container">
        <div id="people_container" class="row">
            <table id="people_table" class="col-lg-12 col-xs-12">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Ville</th>
                        <th>Npa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Davide</td>
                        <td>Carboni</td>
                        <td>Bullet</td>
                        <td>1453</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <a href="">Retour</a>
@stop