@extends ('layout')

@section ('content')

<h1>Synchronisation</h1>

<div class="col-md-3 col-lg-3 col-xl-3">

	<table class="table table-bordered">
		<thead>
			<tr>
				<th class="text-center">Nom</th>
			</tr>
		</thead>
		<tbody>
			@foreach($goodStudents as $student)
			<tr class="success">
				<td>{{ $student->lastname . " " . $student->firstname }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

<div class="col-md-3 col-lg-3 col-xl-3">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th class="text-center">Nom</th>
			</tr>
		</thead>
		<tbody>
			@foreach($obsoleteStudents as $student)
			<tr class="danger">
				<td>{{ $student->lastname . " " . $student->firstname }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

<div class="col-md-3 col-lg-3 col-xl-3 mr-auto">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th class="text-center">Nom</th>
			</tr>
		</thead>
		<tbody>
			@foreach($newStudents as $student)
			<tr class="info">
				<td>{{ $student['lastname'] . " " . $student['firstname'] }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

@stop