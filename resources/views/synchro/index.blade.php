@extends ('layout') @section ('content')

<div class="row">
	<h1>Synchronisation</h1>
<div>
<div class="row">
	<div class="col-lg-2 col-md-2 col-xl-2 col-md-offset-2 col-lg-offset-5 col-offset-xl-2">
		<a href="/synchro/delete" class="btn btn-danger" role="button">Delete</a>
	</div>
	<div class="col-lg-2 col-md-2 col-xl-2 col-md-offset-2 col-lg-offset-2 col-offset-xl-2">
			<a href="/synchro/new" class="btn btn-info" role="button">Add</a>
	</div>
</div>
		<div class="row">
			<div class="col-md-2 col-lg-2 col-xl-2 col-md-offset-1 col-lg-offset-1 col-offset-xl-1">
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

			<div class="col-md-2 col-lg-3 col-xl-2 col-md-offset-2 col-lg-offset-1 col-offset-xl-2">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="text-center">Nom</th>
							<th><button type="button" class="btn btn-link">Check all</button></th>
						</tr>
					</thead>
					<tbody>
						@foreach($obsoleteStudents as $student)
						<tr class="danger">
							<td>{{ $student->lastname . " " . $student->firstname }}</td>
							<td><input type="checkbox" checked></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div class="col-md-2 col-lg-3 col-xl-2 col-md-offset-2 col-lg-offset-1 col-offset-xl-2">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="text-center">Nom</th>
							<th><button type="button" class="btn btn-link">Check all</button></th>
						</tr>
					</thead>
					<tbody>
						@foreach($newStudents as $student)
						<tr class="info">
							<td>{{ $student['lastname'] . " " . $student['firstname'] }}</td>
							<td><input type="checkbox" checked></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>



		@stop