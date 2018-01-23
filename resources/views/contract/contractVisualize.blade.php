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
    <div class="container-fluid">
        <h1>Visualisation de contract</h1>

        <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
        <script>
            tinymce.init({
                selector:'textarea',
                height: "600"
            });
        </script>

        <form id="contractEditor" method="post" action="/contract/{{$iid}}/save">
            {{ csrf_field() }}
            <textarea name="contractText">{{$contract[0]->contractText}}</textarea>
            <br><button>Valider</button>
        </form>
    </div>


@stop