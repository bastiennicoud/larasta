<?php
/**
 * Author :         Quentin Neves
 * Created :        12.12.2017
 * Updated :        17.01.2018
 * Description :    Displays the generated contract in a rich text editor
 */
?>
@extends ('layout')

@section ('content')
    <h1>View contract</h1>

    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>

    <br>
        <?php if(!empty($out)){ echo '<pre style="text-align: left">'; var_dump($out); echo '</pre>';}?>
    <br>

    <form method="post" action="/contract/{{$iid}}/save">
        {{ csrf_field() }}
        <textarea name="contractText">{{$contract[0]->contractText}}</textarea>
        <button>Envoie la sauce negro</button> <!-- TO DELETE -->
    </form>


@stop