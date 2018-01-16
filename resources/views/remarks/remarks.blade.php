@extends ('layout')

@section ('content')
    <h1>Remarques</h1>
    @include ('remarks.remarkslist',['remarks' => $remarks])
    <form method="post" action="/remarks/add" class="col-md-10 text-left">
        {{ csrf_field() }}
        <fieldset>
            <legend>Ajouter une remarque</legend>
            <input type="text" name="newremtext"/>
            <input type="submit" value="Ok"/>
        </fieldset>
    </form>
    </div>
@stop

