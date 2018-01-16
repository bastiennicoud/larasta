@extends ('layout')

@section ('content')
    <h1>Remarques</h1>
    @include ('remarks.remarkslist',['remarks' => $remarks])
    <table class="table table-borderless col-md-10">
        <tr>
            <td class="col-md-1">&nbsp;</td>
            <td class="col-md-1">&nbsp;</td>
            <td class="col-md-8 text-left">
                <form method="post" action="/remarks/filter">
                    {{ csrf_field() }}
                    <input type="text" name="needle"/>
                    <input type="submit" value="Rechercher"/>
                </form>
            </td>
        </tr>
    </table>
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

