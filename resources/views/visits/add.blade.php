@extends ('layout')

@section ('content')
    <h1>Créer une nouvelle visite</h1>
    <div class="container">
        <div class="col-md-4 col-md-offset-4">
            <form id='textedit' method="post" action="/visits/create">
                {{ csrf_field() }}
                <fieldset>
                    <label for="ex1">number</label>
                    <input type="text" class="form-control" name="number"/>
                    <label for="ex1">date</label>
                    <input type="datetime-local" class="form-control" name="date"/>
                    <label for="ex1">stage</label>
                    <select>
                        @foreach ($internships as $internship)
                                    <option value="{{$internship->id}}">{{$internship->id}}</option>
                        @endforeach
                    </select>
                    <input type="text" class="form-control" name="internship"/>
                    <br>
                    <input type="submit" class="btn btn-primary" value="Créer"/>
                </fieldset>
            </form>
        </div>
    </div>

@stop