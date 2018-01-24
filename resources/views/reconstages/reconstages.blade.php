<!--
// Nicolas Henry
// SI-T1a
// reconmade.blade.php
-->
@extends ('layout')

@section ('page_specific_css')
    <link rel="stylesheet" type="text/css" href="/css/documents.css">
@stop

@section ('content')
    <h1>Eleves à reconduire</h1>
    <form method="POST" action="reconstages/reconmade">
        {{ csrf_field() }}
        <table class="reconduction">
            <thead>
                <tr>
                    <th>Entreprise</th>
                    <th>Début</th>
                    <th>Responsable administratif</th>
                    <th>Responsable</th>
                    <th>Stagiaire</th>
                    <th>Salaire</th>
                    <th>Etat</th>
                    <th>puces</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach ($internships as $internship)
                    <tr>
                        <td class="{{ $internship->companyName }}">{{ $internship->companyName }}</td>
                        <td class="{{ strftime("%b %g", strtotime($internship->beginDate)) }}">{{ strftime("%b %g", strtotime($internship->beginDate)) }}</td>
                        <td class="{{ $internship->arespfirstname }}-{{ $internship->aresplastname }}">{{ $internship->arespfirstname }} {{ $internship->aresplastname }}</td>
                        <td class="{{ $internship->irespfirstname }}-{{ $internship->iresplastname }}">{{ $internship->irespfirstname }} {{ $internship->iresplastname }}</td>
                        <td class="{{ $internship->studentfirstname }}-{{ $internship->studentlastname }}">{{ $internship->studentfirstname }} {{ $internship->studentlastname }}</td>
                        <td class="{{ $internship->grossSalary }}">{{ $internship->grossSalary }}</td>
                        <td class="{{ $internship->stateDescription }}">{{ $internship->stateDescription }}</td>
                        <td><input class="checkList" name="internshipId-{{ $internship->id }}" value="{{ $internship->id }}" type="checkbox"></td>
                    </tr>
                @endforeach
            </tbody>
        
        </table>
<<<<<<< Updated upstream
        <button id="reconduire" type="submit" class="btn btn-primary">Reconduire</button>
        <div class="checkBox"><input type="checkbox" id="check" >Select All</input></div>
=======
        <button class="btn btn-default" id="reconduire" type="submit">Reconduire</button>
        <div class="checkBox"><input type="checkbox" id="check">Select All</input></div>
>>>>>>> Stashed changes
    </form>
    

@stop

@section ('page_specific_js')
    <script src="js/reconstages.js"></script>
@stop