<!--
 * last update : 09.01.2018
 * Update by : antonio.giordano
 * -->

@extends ('layout')

@section ('content')



    {{ $edit = ((isset($_GET['edit']) || isset($_POST['edit'])) && $viewall) }}

    <form id="entreprises" action="{{('EntreprisesController@entreprises')}}" method="post">

    <div id='insert' class="hidden">
        <img id='endModif' style='width:32px; float:right' alt='+' src='Images/padlock-open.png' onMouseOver='document.body.style.cursor="pointer"' onMouseOut='document.body.style.cursor="default"' OnClick='endModif()' />
    <img id='plusicon' style='width:16px' alt='+' src='Images/plus.png' onMouseOver='document.body.style.cursor="pointer"' onMouseOut='document.body.style.cursor="default"' OnClick='Edit()'/></div>

        <div id="edit">
        <img style='width:32px; float:right' alt='+' src='Images/padlock-closed.png' onMouseOver='document.body.style.cursor="pointer"' onMouseOut='document.body.style.cursor="default"' OnClick='editMode()'/>
        </div>


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
@section('page_specific_js')
    <script src="/js/entreprises.js"></script>
@stop
