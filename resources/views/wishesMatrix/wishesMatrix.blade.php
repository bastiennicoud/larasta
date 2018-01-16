<!-- ///////////////////////////////////              -->
<!-- Benjamin Delacombaz                              -->
<!-- Wishes Matrix layout                             -->
<!-- Version 0.4                                      -->
<!-- Created 18.12.2017                               -->
<!-- Last edit 16.01.2017 by Benjamin Delacombaz      -->


@extends ('layout')

@section ('content')
    <div class="alert-info hidden">
        <!-- Info if user doesn't have the good right -->
    </div>
    <h1>Matrice des souhaits</h1>
    <div class="col-md-9">
        <table id="WishesMatrixTable" class="table-bordered col-md-11">
            <tr>
                <th></th>
                <!-- Add each persons where initials is ok -->
                @foreach ($persons as $person)
                    @if ($person->initials!="")
                        <!-- Add access class for authoized to edit a col -->
                        @if ($person->initials == $currentUser->initials) 
                            <th class="access" value="{{ $person->id }}">{{ $person->initials }}</th>
                        @else
                            <th value="{{ $person->id }}">{{ $person->initials }}</th>   
                        @endif
                    @endif
                @endforeach
            </tr>
            @foreach ($companies as $companie)
                <tr>
                    <td value="{{ $companie->id }}">{{ $companie->companyName }}</td>
                    <!-- Create the clickable case for each person -->
                    @foreach ($persons as $person)
                        @if ($person->initials!="")
                        <!-- !!!!!!!!!!!!!!!!!!!!!!!!!PROBLEM BECAUSE NOT EMPTY BECAUSE LARAVEL ADD SYNTAX IN TD !!!!!!!!!!!!!!!!!!!!!! -->
                            <td class="clickableCase">
                            <!-- Add for each persons in the table her wish -->
                                @foreach ($wishes[$person->id] as $wish)
                                    <!-- if wish company is equal to the current company display the rank -->
                                    @if($wish->id == $companie->id)
                                        {{ $wish->rank }}
                                    @endif
                                @endforeach
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </table>
        @if ($currentUser->role != 0)
            <img id="lockTable" src="/images/open-padlock-silhouette_32x32.png"/>
        @endif
    </div>
    <!-- Check if current user is not a student -->
    @if ($currentUser->role != 0)
        <a href="/traveltime/{{$currentUser->flock_id}}/load" class="col-md-3">Travel time</a>
        <label>Modifiable jusqu'au</label> <input type="date" name="editDate"/>
    @endif
    <input type="button" name="validButton" value="Enregistrer"/>
@stop

@section ('page_specific_js')
    <script src="/js/wishesMatrix.js"></script>
@stop