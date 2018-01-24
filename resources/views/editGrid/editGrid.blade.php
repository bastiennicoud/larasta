{{--
Author: Julien Richoz
Created: 16.12.2017
Modified: 24.01.2018
Contact: julien.richoz@cpnv.ch

Description: View that displays the evaluation grid and let a superuser edit the fields.
Can also add/remove criteria or section.
--}}


<meta name="csrf-token" content="{{ csrf_token() }}">
@section ('page_specific_css')
    <link rel="stylesheet" href="/css/editGrid.css">
@stop

@extends ('layout')
@section ('content')

    <h1>Edition de la grille d'évaluation</h1><br><br>
    <div class="container-narrow">

{{-- -------------------------------------------------------------------- *** BUTTON NEW SECTION *** ---------------------------------------------------------------------------------  --}}

        <p>
            {{-- button to add a new section --> In link with modal form pop-up at the end of the document --}}
            <button id="btn-add-section" name="btn-add-section" class="btn btn-primary btn" data-toggle="modal" data-target="#favoritesModal">Create New Section</button>
        </p>
        <br><br>
        <div>

{{-- -------------------------------------------------------------------- *** CREATING SECTION VIEW *** ---------------------------------------------------------------------------------  --}}

            {{-- loop to create a table per each section --}}
            @foreach($sections as $section)
                <table id="rmBlockSection_{{$section->id}}" class="table">

{{-- ------------------------------------------------------------------------ *** SECTION TYPE 1 *** ---------------------------------------------------------------------------------  --}}

                    {{-- display section's value for sectionType = 1 --}}
                    @if($section->sectionType == 1)
                        <span id="rmSpanSection_{{$section->id}}">Section Type 1</span>
                        <button id="rmSection_{{$section->id}}" name="btn-rm-section" class="fLeft deleteAllSection btn btn-danger btn-xs">Delete this Section</button>
                        <thead>
                        <tr>

                            {{-- displaying elements to modify section's name for sectionType 1--}}
                            <th>
                                <span class="sectionName" name="sectionName" title="sectionName">{{$section->sectionName}}</span>
                                <span class="errorMsg" title="ErrorSection" hidden>45 characters max.</span>
                                <input type="text" class="sectionName" id="{{$section->id}}" value="{{$section->sectionName}}" hidden>
                                <button class="fRight btn btn-warning btn-xs btn-detail" value="{{$section->id}}">Edit</button>
                                <button name="section" class="fRight btn btn-success btn-xs hidden" value="{{$section->id}}">OK</button>
                            </th>
                            <th>Observations attendues</th>
                            <th>Points Max</th>
                            <th>Remarques personnalisées</th>
                            <th></th>
                        </tr>
                        </thead>

                        {{--display all criteria's value for sectionType 1 --}}
                        <tbody class="tbodyLeft">
                        @foreach($section->criterias as $criteria)
                            <tr id="rowCriteria_{{$criteria->id}}">

                                {{-- displaying elements to modify criteria's name for sectionType 1 --}}
                                <td>
                                    <span title="criteriaName">{{$criteria->criteriaName}}</span>
                                    <span class="errorMsg" title="errorCriteriaName" hidden>45 characters max.</span>
                                    <input type="text" name="criteriaName" class="criteriaName" id="{{$criteria->id}}" value="{{$criteria->criteriaName}}" hidden>
                                    <button class="fRight btn btn-warning btn-xs btn-detail" value="criteria" id="{{$criteria->id}}">Edit</button>
                                    <button name="criteria" class="fRight btn btn-success btn-xs hidden" value="{{$criteria->id}}">OK</button>

                                </td>

                                {{-- displaying elements to modify criteria's details for sectionType 1 --}}
                                <td>
                                    <span title="criteriaDetails">{{$criteria->criteriaDetails}}</span>
                                    <span class="errorMsg" title="ErrorCriteriaDetails" hidden>1000 characters max.</span>
                                    <textarea cols="40" rows="5" name="criteriaDetails" class="criteriaDetails" id="{{$criteria->id}}" class="criteriaDetails"  hidden>{{$criteria->criteriaDetails}}</textarea>
                                    <button class="fRight btn btn-warning btn-xs btn-detail" value="{{$criteria->id}}">Edit</button>
                                    <button name="criteria" class="fRight btn btn-success btn-xs hidden" value="{{$criteria->id}}">OK</button>
                                </td>

                                {{-- displaying elements to modify max points for sectionType 1 --}}
                                <td>
                                    <span title="maxPoints">{{$criteria->maxPoints}}</span>
                                    <span class="errorMsg" title="ErrorMaxPointsDetails" hidden>Only int</span>
                                    <input type="text" name = "maxPoints" class="maxPoints" id="{{$criteria->id}}" value="{{$criteria->maxPoints}}" hidden>
                                    <button class="fRight btn btn-warning btn-xs btn-detail" value="{{$criteria->id}}">Edit</button>
                                    <button name="maxPoints" class="fRight btn btn-success btn-xs hidden" value="{{$criteria->id}}">OK</button>
                                </td>
                                <td></td>

                                {{-- Button to Delete Row for sectionType 1 --}}
                                <td class="resizeDel"><button class="btn btn-danger btn-xs btn-delete delete-task" id="delRow_{{$criteria->id}}">Del Row</button></td>
                            </tr>
                        @endforeach
                        <tr>
                            {{-- Button to Add New Criteria for sectionType 1 --}}
                            <td>
                                <button id="addCriteria_{{$section->id}}" name="btn-add-section" class="addCriteria btn btn-primary btn-xs">Add New Criteria</button>
                                <input id="text_{{$section->id}}" name="textAddCriteria" class="textAddCriteria" type="text" hidden>
                                <button id="addCritOk_{{$section->id}}" class="addCrDB fRight btn-primary btn-xs hidden">Ajouter</button>
                                <button id="cancelCritOk_{{$section->id}}" class="cancelCr btn-danger btn-xs btn-xs hidden">Cancel</button>
                            </td>
                        </tr>
                        </tbody>

{{-- ------------------------------------------------------------------------ *** SECTION TYPE 2 *** ---------------------------------------------------------------------------------  --}}

                    {{-- display section's value for section 2 --}}
                    @elseif($section->sectionType==2)
                        <span id="rmSpanSection_{{$section->id}}">Section Type 2</span>
                        <button id="rmSection_{{$section->id}}" name="btn-rm-section" class="fLeft deleteAllSection btn btn-danger btn-xs">Delete this Section</button>
                        <thead>
                        <tr>
                            {{-- displaying elements to modify section's name for sectionType 2 --}}
                            <th>
                                <span  title="sectionName">{{$section->sectionName}}</span>
                                <span class="errorMsg" title="ErrorSection" hidden>45 characters max.</span>
                                <input type="text" name="sectionName" class="sectionName" id="{{$section->id}}" value="{{$section->sectionName}}" hidden>
                                <button class="fRight btn btn-warning btn-xs btn-detail" value="{{$section->id}}">Edit</button>
                                <button name="section" class="fRight btn btn-success btn-xs hidden" value="{{$section->id}}">OK</button>
                            </th>
                            <th>Remarques du responsable de stage</th>
                            <th>Remarques du stagiaire</th>
                            <th></th>
                        </tr>
                        </thead>

                        {{--display criteria's value for section 2--}}
                        <tbody class="tbodyLeft" id="criteria-list">
                        @foreach($section->criterias as $criteria)
                            <tr id="rowCriteria_{{$criteria->id}}">

                                {{-- displaying elements to modify criteria's name for sectionType 2 --}}
                                <td>
                                    <span title="criteriaName">{{$criteria->criteriaName}}</span>
                                    <span class="errorMsg" title="ErrorCriteriaName" hidden>45 characters max.</span>
                                    <input type="text" name="criteriaName" class="criteriaName" id="{{$criteria->id}}" value="{{$criteria->criteriaName}}" hidden>
                                    <button class="fRight btn btn-warning btn-xs btn-detail" value="{{$criteria->id}}">Edit</button>
                                    <button name="criteria" class="fRight btn btn-success btn-xs hidden" value="{{$criteria->id}}">OK</button>
                                </td>
                                <td></td>
                                <td></td>

                                {{-- button to delete Row for sectionType 2 --}}
                                <td class="resizeDel"> <button class="btn btn-danger btn-xs btn-delete delete-task" id="delRow_{{$criteria->id}}">Del Row</button></td>
                            </tr>
                        @endforeach

                        <tr>

                            {{-- button to add New Criteria for sectionType 2 --}}
                            <td>
                                <button id="addCriteria_{{$section->id}}" name="btn-add-section" class="addCriteria btn btn-primary btn-xs">Add New Criteria</button>
                                <input id="text_{{$section->id}}" name="textAddCriteria" class="textAddCriteria" type="text" hidden>
                                <button id="addCritOk_{{$section->id}}" class="addCrDB fRight btn-primary btn-xs hidden">Ajouter</button>
                                <button id="cancelCritOk_{{$section->id}}" class="cancelCr btn-danger btn-xs btn-xs hidden">Cancel</button>
                            </td>
                        </tr>
                        </tbody>

{{-- ------------------------------------------------------------------------ *** SECTION TYPE 3 *** ---------------------------------------------------------------------------------  --}}

                        {{--display section's value for section 3--}}
                    @elseif($section->sectionType==3)
                        <span id="rmSpanSection_{{$section->id}}">Section Type 3</span>
                        <button id="rmSection_{{$section->id}}" name="btn-rm-section" class="fLeft deleteAllSection btn btn-danger btn-xs">Delete this Section</button>

                        <thead>
                        <tr>
                            {{-- displaying elements to modify section's name for sectionType 3 --}}
                            <th>
                                <span  title="sectionName">{{$section->sectionName}}</span>
                                <span class="errorMsg" title="ErrorSection" hidden>45 characters max.</span>
                                <input type="text" name="sectionName" class="sectionName" id="{{$section->id}}" value="{{$section->sectionName}}" hidden>
                                <button class="fRight btn btn-warning btn-xs btn-detail" value="{{$section->id}}">Edit</button>
                                <button name="section" class="fRight btn btn-success btn-xs hidden" value="{{$section->id}}">OK</button>
                            </th>
                            <th>Remarques du responsable de stage</th>
                            <th>Remarques du stagiaire</th>
                            <th></th>
                        </tr>
                        </thead>

                        {{--display criteria's value for section 3--}}
                        <tbody class="tbodyLeft">
                        @foreach($section->criterias as $criteria)

                            {{-- displaying elements to modify criteria's name for sectionType 3 --}}
                            <tr id="rowCriteria_{{$criteria->id}}">
                                <td>
                                    <span title="criteriaName">{{$criteria->criteriaName}}</span>
                                    <span class="errorMsg" title="ErrorCriteriaName" hidden>45 characters max.</span>
                                    <input type="text" name="criteriaName" class="criteriaName" id="{{$criteria->id}}" value="{{$criteria->criteriaName}}" hidden>
                                    <button class="fRight btn btn-warning btn-xs btn-detail" value="{{$criteria->id}}">Edit</button>
                                    <button name="criteria" class="fRight btn btn-success btn-xs hidden" value="{{$criteria->id}}">OK</button>
                                </td>
                                <td></td>
                                <td></td>

                                {{-- button to delete Row for sectionType 3 --}}
                                <td class="resizeDel"> <button class="btn btn-danger btn-xs btn-delete delete-task" id="delRow_{{$criteria->id}}">Del Row</button></td>
                            </tr>
                        @endforeach

                        <tr>
                            {{-- button to add new criterias for sectionType 3 --}}
                            <td>
                                <button id="addCriteria_{{$section->id}}" name="btn-add-section" class="addCriteria btn btn-primary btn-xs">Add New Criteria</button>
                                <input id="text_{{$section->id}}" class="textAddCriteria" type="text" hidden>
                                <button id="addCritOk_{{$section->id}}" class="addCrDB fRight btn-primary btn-xs hidden">Ajouter</button>
                                <button id="cancelCritOk_{{$section->id}}" class="cancelCr btn-danger btn-xs btn-xs hidden">Cancel</button>
                            </td>
                        </tr>
                        </tbody>
                    @endif

                </table>
                <br>
            @endforeach
        </div>

{{-- ------------------------------------------------------------------------ *** MODAL POP-UP FORM --> To add New Section *** ---------------------------------------------------------------------------------  --}}

        {{-- Modal Form Pop up--}}
        <div class="modal fade" id="favoritesModal"
             tabindex="-1" role="dialog"
             aria-labelledby="favoritesModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"
                            id="favoritesModalLabel">Add New Section</h4>
                    </div>
                    <div class="modal-body">

                        {{-- Form to add new section -> name's section + section's type --}}
                        <form action="/editGrid/addSection" method="post" id="addSection">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            {{-- Select Section's Type --}}
                            <label for="newSectionType">Type Section (1-3)</label>
                            <SELECT class="newSectionType form-control" name="sectionType" size="1">
                                <OPTION value="1">1</OPTION>
                                <OPTION value="2">2</OPTION>
                                <OPTION value="3">3</OPTION>
                            </SELECT>
                            <br><br>

                            {{-- Chose name's section --}}
                            <label for="newSectionType">Nom de la section</label>
                            <input name="newSectionName" type=text" class="newSectionName form-control" value="">
                            <br><br>

                            <button id="addNewSections" type="submit" class="btn btn-primary" disabled>Create New Section</button>
                        </form>
                    </div>
                    {{-- Button to close the modal form --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section ('page_specific_js')
    <script src="/js/editGrid.js"></script>
@stop