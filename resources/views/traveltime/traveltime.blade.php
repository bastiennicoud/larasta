@extends ('../layout')

@section ('content')
    <h1>
        TravelTime
    </h1>
    <div>
        <form action="/traveltime/calculate" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Lieu de départ</label>
                <input type="origin" class="form-control" id="origin" name="origin" placeholder="Entrer le lieu de départ">
            </div>
            <div class="form-group">
                <label>Lieu de destination</label>
                <input type="destination" class="form-control" id="destination" name="destination" placeholder="Entrer le lieu de destination">
            </div>
            <button type="submit" class="btn btn-primary">Calculer</button>
        </form>
    </div>
    @if ($error==true)
        <div>
            <p>Il y a eu une erreur !</p>
        </div>
    @elseif ($error==false && $result!=null)
        <div>
            <p>Durée : {{ $result }}</p>
        </div>
    @endif
@stop