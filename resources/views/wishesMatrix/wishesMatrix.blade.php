<!-- /////////////////////////////////// -->
<!-- Benjamin Delacombaz                 -->
<!-- Wishes Matrix layout                -->
<!-- Version 1.0                         -->
<!-- Created 18.12.2017                  -->
<!-- Last edit 18.12.2017                -->


@extends ('layout')

@section ('content')
    <h1>Matrice des souhaits</h1>
    <table class="table-bordered">
        <tr>
            <td></td>
            <td>BDE</td>
            <td>YKO</td>
            <td>ARD</td>
            <td>GOB</td>
            <td>TPR</td>
            <td>MDE</td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>Ecole Cantonale d'Art de Lausanne</td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
        </tr>
        <tr>
            <td>EESP</td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
        </tr>
        <tr>
            <td>EPCN</td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
        </tr>
        <tr>
            <td>EPFL - VPSI</td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
        </tr>
        <tr>
            <td>ETVJ Ecole Technique de la Vallée de Joux</td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
        </tr>
        <tr>
            <td>Gymnase de Renens</td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
            <td class="clickableCase"></td>
        </tr>
    </table>
@stop

@section ('page_specific_js')
    <script src="/js/wishesMatrix.js"></script>
@stop