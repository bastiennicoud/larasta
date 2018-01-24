{{-- Menu for admin functions --}}
@extends ('layout')

@section ('content')
<table>
    <tr>
        <td class='invisiblecell' width=20px>&nbsp;</td>
    </tr>
    <tr height=150px>
        <td class='invisiblecell'>&nbsp;</td>
        <td class='tile clickable-row' data-href="/about"><h4>Snapshots </h4></td>
        <td class='invisiblecell'>&nbsp;</td>
        <td class='tile clickable-row' data-href="/synchro"><h4>Synchro Intranet</h4></td>
        <td class='invisiblecell'>&nbsp;</td>
        <td class='tile clickable-row' data-href="/reconstages"><h4>Renouvellement des stages en cours</h4></td>
        <td class='invisiblecell'>&nbsp;</td>
        <td class='tile clickable-row' data-href="/about"><h4>Edition de contrat</h4></td>
        <td class='invisiblecell'>&nbsp;</td>
        <td class='tile clickable-row' data-href="/editGrid"><h4>Modification Structure Grille Evaluation</h4></td>
    </tr>
    <tr>
        <td class='invisiblecell' width=20px>&nbsp;</td>
    </tr>
    <tr height=150px>
        <td class='invisiblecell'>&nbsp;</td>
        <td class='tile clickable-row' data-href="/editGrid"><h4>Edition Grille</h4></td>
    </tr>
</table>
@stop

@section('page_specific_css')
    <link rel="stylesheet" href="/css/mpmenu.css">
@stop