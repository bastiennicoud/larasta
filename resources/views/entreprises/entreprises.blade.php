<!--
 * last update : 09.01.2018
 * Update by : antonio.giordano
 * -->

@extends ('layout')

@section ('content')

<div class="container-fluid">
    @if($user->getLevel() >= 2)


            <div class="header">
                <div class="row">
                    <div class="col-md-1 text-left" id="insert">
                        <img id='plusicon' style='width:16px' alt='+' src='Images/plus.png' onMouseOver='document.body.style.cursor="pointer"' onMouseOut='document.body.style.cursor="default"' OnClick='addE()'/>
                    </div>
                </div>
                <div class="row">
                    <form id='textedit' method="post" action="/entreprises/add">
                        {{ csrf_field() }}
                        <br>
                        <div id="input" class="hidden text-left">
                            <div class="col-md-1">
                                Nom de l'entreprise :
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="nameE">
                            </div>
                            <div class="col-md-1">
                                <input type="submit" class="form-control">
                                <br>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

     @endif
    <div class="body">
        <div class="tab-content">
        <table class="table table-responsive" border="solid" >
            <tr>
                <th>Entreprises</th>
                <th>Adresse 1</th>
                <th>Adresse 2</th>
                <th>NPA</th>
                <th>Localité</th>
            </tr>
        @foreach ($companies as $company)
            <tr>
                <td><a href="/entreprise/{{$company->id}}"> {{ $company->companyName }} </a></td>
                <td>{{ $company->address1 }}</td>
                <td>{{ $company->address2 }}</td>
                <td>{{ $company->postalCode }}</td>
                <td>{{ $company->city }}</td>
            </tr>
        @endforeach
        </table>
        </div>
    </div>
</div>



@stop
@section('page_specific_js')
    <script src="/js/entreprises.js"></script>
@stop
