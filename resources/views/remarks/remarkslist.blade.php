{{-- Subview to list remarks --}}
{{-- Usage:     @include ('remarks.remarkslist',['remarks' => $your_array_of_remarks])  --}}
<table class="table table-bordered col-md-10 larastable">
    <tr>
        <th class="col-md-1">Date</th>
        <th class="col-md-1">Auteur</th>
        <th class="col-md-8">Contenu</th>
    </tr>
    @foreach($remarks as $remark)
        <tr class="clickable-row" data-href="/remarks/{{ $remark->id }}/edit">
            <td class="col-md-1">{{ (new DateTime($remark->remarkDate))->format('d.M.y') }}</td>
            <td class="col-md-1">{{ $remark->author }}</td>
            <td class="col-md-8 text-left">{{ $remark->remarkText }}</td>
        </tr>
    @endforeach
</table>
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
