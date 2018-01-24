{{-- Subview that displays a list of internships --}}
{{-- Usage:         @include ('internships.internshipslist',['iships' => $your_array_of_internships])  --}}
@if (count($iships) > 0)
    <table class="table table-bordered table-hover text-left larastable">
        <thead>
        <tr>
            <th>Entreprise</th>
            <th>Début</th>
            <th>Responsable administratif</th>
            <th>Responsable</th>
            <th>Stagiaire</th>
            <th>MC</th>
            <th>Etat</th>
        </tr>
        </thead>
        <tbody>
        @foreach($iships as $iship)
            <tr class="clickable-row" data-href="/internships/{{ $iship->id }}/edit">
                <td>{{ $iship->companyName }}</td>
                <td>{{ strftime("%b %g", strtotime($iship->beginDate)) }}</td>
                <td>{{ $iship->arespfirstname }} {{ $iship->aresplastname }}</td>
                <td>{{ $iship->irespfirstname }} {{ $iship->iresplastname }}</td>
                <td>{{ $iship->studentfirstname }} {{ $iship->studentlastname }}</td>
                <td>{{ $iship->mcini }}</td>
                <td>{{ $iship->stateDescription }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div class="alert-info">Aucun stage ne correspond à ce filtre</div>
@endif
