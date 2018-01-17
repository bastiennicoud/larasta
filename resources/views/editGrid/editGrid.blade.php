<!--Julien Richoz -->

{{--
This files displays the evaluation grid and let a superuser edit certain fields.
He can also add/remove criteria or section
--}}


@extends ('layout')
@section ('content')
    <h1>Edition de la grille d'évaluation</h1>
    <h2>Let's try</h2><br>

    <div class="container-narrow">

    {{-- btn to add a new section --}}
    <p><button id="btn-add-section" name="btn-add-section" class="btn btn-primary btn">Add New Section</button></p><br>
    <div>

        {{-- loop to create a table per each section --}}
        @foreach($sections as $section)
            <table class="table">

                {{--display section's value for section 1--}}
                @if($section->sectionType == 1)
                    <p>Section Type 1</p>
                    <button id="rm-section-{{$section->id}}" name="btn-rm-section" class="btn btn-danger btn-xs" style="float:left;">Delete this Section</button>
                    <thead>
                        <tr>
                            <th>
                                <span title="sectionName">{{$section->sectionName}}</span>
                                <button style="float:right; margin-left: 5px;" class="btn btn-danger btn-xs btn-delete delete-task" value="{{$section->id}}">Del</button>
                                <input type="text" id="{{$section->id}}" value="{{$section->sectionName}}" hidden>
                                <button style="float:right;" class="btn btn-warning btn-xs btn-detail" value="{{$section->id}}">Edit</button>
                                <button style="float:right;" class="btn btn-success btn-xs hidden" value="{{$section->id}}">OK</button>
                            </th>
                            <th>Observations attendues</th>
                            <th>Points</th>
                            <th>Remarques personnalisées</th>
                        </tr>
                    </thead>

                    {{--display criterias value for section 1--}}
                    <tbody style="text-align:left;">
                        @foreach($section->criterias as $criteria)
                            <tr>
                                <td>
                                    <span title="criteriaName">{{$criteria->criteriaName}}</span>
                                    <button style="float:right; margin-left: 5px;" class="btn btn-danger btn-xs btn-delete delete-task" value="{{$criteria->id}}">Del</button>
                                    <input type="text" id="{{$criteria->id}}" value="{{$criteria->criteriaName}}" hidden>
                                    <button style="float:right;" class="btn btn-warning btn-xs btn-detail" value="{{$criteria->id}}">Edit</button>
                                    <button style="float:right;" class="btn btn-success btn-xs hidden" value="{{$criteria->id}}">OK</button>

                                </td>
                                <td>
                                    <span title="criteriaDetails">{{$criteria->criteriaDetails}}</span>
                                    <button style="float:right; margin-left: 5px;" class="btn btn-danger btn-xs btn-delete delete-task" value="{{$criteria->id}}">Del</button>
                                    <input type="text" id="{{$criteria->id}}" value="{{$criteria->criteriaDetails}}" hidden>
                                    <button style="float:right;" class="btn btn-warning btn-xs btn-detail" value="{{$criteria->id}}">Edit</button>
                                    <button style="float:right;" class="btn btn-success btn-xs hidden" value="{{$criteria->id}}">OK</button>
                                </td>
                                <td></td>
                                <td></td>

                            </tr>
                        @endforeach
                    </tbody>

                    {{--display section's value for section 2--}}
                @elseif($section->sectionType==2)
                    <p>Section Type 2</p>
                    <button id="rm-section-{{$section->id}}" name="btn-rm-section" class="btn btn-danger btn-xs" style="float:left;">Delete this Section</button>
                    <thead>
                    <tr>
                        <th>
                            <span  title="sectionName">{{$section->sectionName}}</span>
                            <button style="float:right; margin-left: 5px;" class="btn btn-danger btn-xs btn-delete delete-task" value="{{$section->id}}">Del</button>
                            <input type="text" id="{{$section->id}}" value="{{$section->sectionName}}" hidden>
                            <button style="float:right;" class="btn btn-warning btn-xs btn-detail" value="{{$section->id}}">Edit</button>
                            <button style="float:right;" class="btn btn-success btn-xs hidden" value="{{$section->id}}">OK</button>
                        </th>
                        <th>Remarques du responsable de stage</th>
                        <th>Remarques du stagiaire</th>

                    </tr>
                    </thead>

                    {{--display criteria's value for section 2--}}
                    <tbody id="criteria-list" name="criteria-list" style="text-align:left;">
                        @foreach($section->criterias as $criteria)
                            <tr>
                                <td>
                                    <span title="criteriaName">{{$criteria->criteriaName}}</span>
                                    <button style="float:right; margin-left: 5px;" class="btn btn-danger btn-xs btn-delete delete-task" value="{{$criteria->id}}">Del</button>
                                    <input type="text" id="{{$criteria->id}}" value="{{$criteria->criteriaName}}" hidden>
                                    <button style="float:right;" class="btn btn-warning btn-xs btn-detail" value="{{$criteria->id}}">Edit</button>
                                    <button style="float:right;" class="btn btn-success btn-xs hidden" value="{{$criteria->id}}">OK</button>
                                </td>
                                <td>
                                   {{-- Not sure if need this. Criteria details applies only for section 1
                                   {{$criteria->criteriaDetails}}
                                    --}}
                                </td>
                                <td></td>
                            </tr>
                            @endforeach
                    </tbody>

                {{--display section's value for section 3--}}
                @elseif($section->sectionType==3)
                    <p>Section Type 3</p>
                    <button id="rm-section-{{$section->id}}" name="btn-rm-section" class="btn btn-danger btn-xs" style="float:left;">Delete this Section</button>

                    <thead>
                    <tr>
                        <th>
                            <span  title="sectionName">{{$section->sectionName}}</span>
                            <button style="float:right; margin-left: 5px;" class="btn btn-danger btn-xs btn-delete delete-task" value="{{$section->id}}">Del</button>
                            <input type="text" id="{{$section->id}}" value="{{$section->sectionName}}" hidden>
                            <button style="float:right;" class="btn btn-warning btn-xs btn-detail" value="{{$section->id}}">Edit</button>
                            <button style="float:right;" class="btn btn-success btn-xs hidden" value="{{$section->id}}">OK</button>
                        </th>
                        <th>Remarques du responsable de stage</th>
                        <th>Remarques du stagiaire</th>
                    </tr>
                    </thead>

                    {{--display criteria's value for section 3--}}
                    <tbody style="text-align:left;">
                    @foreach($section->criterias as $criteria)
                        <tr>
                            <td>
                                <span title="criteriaName">{{$criteria->criteriaName}}</span>
                                <button style="float:right; margin-left: 5px;" class="btn btn-danger btn-xs btn-delete delete-task" value="{{$criteria->id}}">Del</button>
                                <input type="text" id="{{$criteria->id}}" value="{{$criteria->criteriaName}}" hidden>
                                <button style="float:right;" class="btn btn-warning btn-xs btn-detail" value="{{$criteria->id}}">Edit</button>
                                <button style="float:right;" class="btn btn-success btn-xs hidden" value="{{$criteria->id}}">OK</button>
                            </td>
                            <td>
                               {{-- Not sure if need this ? Criteria details applies only for section 1  {{$criteria->criteriaDetails}} --}}
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                @endif

            </table>

        @endforeach

    </div>
    </div>

@stop

@section ('page_specific_js')
    <script src="/js/editGrid.js"></script>
@stop