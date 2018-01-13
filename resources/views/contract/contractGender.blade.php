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
    <!--
        Zone d'édition de rich text
        Ne fonctionne pas encore, net::ERR_ARBOTED quand on tente d'accéder au script
        Si on appelle le script après, cela renvoie une erreur 404
    -->

    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>

    <textarea>Next, start a free trial!</textarea>


@stop