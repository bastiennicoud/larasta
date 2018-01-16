<!--
/**
 * Created by PhpStorm.
 * User: Davide.CARBONI
 * Date: 18.12.2017
 * Time: 09:02
 */
-->
@extends ('layout')

@section ('content')
    <link rel="stylesheet" href="/css/people.css" />

    <!-- Header -->

    <div id = "people_content">

        <div id ="people_header" class="row">

            <form class="form-check" action="/listPeople/category" method="post" id="people_form">

                {{ csrf_field() }}
                <div class="form-check col-lg-3">
                    @if (isset($filterCategory) && in_array(1, $filterCategory))
                        <input class="form-check-input people_check" type="checkbox" value="1" name = "filterCategory[]" id="teacher" checked="checked">
                    @else
                        <input class="form-check-input" type="checkbox" value="1" name = "filterCategory[]" id="teacher">
                    @endif
                    <label class="form-check-label" for="teacher">Professeur</label>
                </div>

                <div class="form-check col-lg-3">
                    @if (isset($filterCategory) && in_array(0, $filterCategory))
                        <input class="form-check-input people_check" type="checkbox" value="0" name = "filterCategory[]" id="student" checked="checked">
                    @else
                        <input class="form-check-input" type="checkbox" value="0" name = "filterCategory[]" id="student">
                    @endif
                    <label class="form-check-label" for="student">Elève</label>
                </div>

                <div class="form-check col-lg-3">
                    @if (isset($filterCategory) && in_array(2, $filterCategory))
                        <input class="form-check-input people_check" type="checkbox" value="2" name = "filterCategory[]" id="company" checked="checked">
                    @else
                        <input class="form-check-input" type="checkbox" value="2" name = "filterCategory[]" id="company">
                    @endif
                    <label class="form-check-label" for="company">Company</label>
                </div>

                <div class="form-check col-lg-3">
                    @if (isset($filterObsolete))
                        <input  class="form-check-input people_check" type="checkbox" value="obsolete" name = "filterObsolete" id="obsolete" checked="checked">
                    @else
                        <input  class="form-check-input" type="checkbox" value="obosolete" name = "filterObsolete" id="obsolete">
                    @endif
                    <label class="form-check-label" for="obsolete">Désactivée</label>
                </div>

                <div class="margin20 col-lg-12"></div>

                <div class="divider col-lg-12"></div>

                <div class="margin20 col-lg-12"></div>

                <div class="form-group col-lg-12">
                    @if (isset($filterName))
                        <input id ="people_inputName" type="text" class="form-control" aria-describedby="searchHelp" placeholder="{{ $filterName }}" name = "filterName" value="{{ $filterName }}" >
                    @else
                        <input id ="people_inputName" type="text" class="form-control" aria-describedby="searchHelp" placeholder="Nom / Prenom" name = "filterName">
                    @endif
                    <small id="searchHelp" class="form-text text-muted">Saisir le nom ou le prenom à rechercher</small>
                </div>

            </form>

        </div>

        <div class="margin30 row"> </div>

        <div id="people_container" class="row">

            <table class="table table-responsive" id="people_table">

                <thead>
                    <tr>
                        <th scope="col">Personne</th>
                        <th scope="col">Rôle</th>
                    </tr>
                </thead>

                <tbody id = "people_tbody">
                @foreach($persons as $person)
                    <tr class="clickable-row" data-href="/listPeople/{{ $person->id }}/info">
                        <td>{{ $person->firstname }} {{ $person->lastname }}</td>
                        @if ($person->role == 0) <td> Elève </td> @endif
                        @if ($person->role == 1) <td> Professeur </td> @endif
                        @if ($person->role == 2) <td> Company </td> @endif
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>

        <div class="margin30 row"> </div>

        <div class = "row">
            <a href="#" id ="btn-return" class="btn btn-success">Top Page</a>
        </div>

        <div class="margin30 row"> </div>

    </div>

    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/js/people.js"></script>
@stop