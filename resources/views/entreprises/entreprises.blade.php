<!--
 * last update : 09.01.2018
 * Update by : antonio.giordano
 * -->

@extends ('layout')

@section ('content')



    {{ $edit = ((isset($_GET['edit']) || isset($_POST['edit'])) && $viewall) }}


    @if($edit)
    <img style='width:32px; float:right' alt='+' src='Images/padlock-open.png' onMouseOver='document.body.style.cursor="pointer"' onMouseOut='document.body.style.cursor="default"' OnClick='document.forms["entreprises"].submit()'/>
    <div id='insert'><img id='plusicon' style='width:16px' alt='+' src='Images/plus.png' onMouseOver='document.body.style.cursor="pointer"' onMouseOut='document.body.style.cursor="default"' OnClick='Edit()'/></div>
    @else
        <img style='width:32px; float:right' alt='+' src='Images/padlock-closed.png' onMouseOver='document.body.style.cursor="pointer"' onMouseOut='document.body.style.cursor="default"' OnClick='window.location="Entreprises.php?edit"'></img>"

    @endif

    <form action="{{('EntreprisesController@entreprises')}}" method="post">
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
            <td>{{ $company->companyName }}</td>
            <td>{{ $company->address1 }}</td>
            <td>{{ $company->address2 }}</td>
            <td>{{ $company->postalCode }}</td>
            <td>{{ $company->city }}</td>
        </tr>
    @endforeach
    </table>
    </form>
@stop
