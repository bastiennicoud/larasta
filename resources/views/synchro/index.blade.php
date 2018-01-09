@extends ('layout') @section ('content')
<div class="row">
    <h1 class="text-center">Synchro</h1>
</div>

<div class="row">
	<div class="col-md-5 col-lg-5 col-xl-5">
		<table class="table table-bordered table-responsive">
			<thead>
				<tr>
					<th class="text-center">Nom</th>
					<th>Email</th>
					<th>Classe</th>
				</tr>
			</thead>
			<tbody>
				@foreach($students as $student)
				<tr>
					<td>{{ $student['lastname'] . " " . $student['firstname'] }}</td>
					<td>{{ $student['corporate_email'] }}</td>
					<td>{{ $student['current_class']['link']['name'] }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<div class="col-md-5 col-lg-5 col-xl-5 offset-xl-2 offset-lg-2 offset-md-2">
		<table class="table table-bordered table-responsive">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Email</th>
					<th>Classe</th>
				</tr>
			</thead>
			<tbody>
				@foreach($students as $student)
				<tr>
					<td>{{ $student['lastname'] . " " . $student['firstname'] }}</td>
					<td>{{ $student['corporate_email'] }}</td>
					<td>{{ $student['current_class']['link']['name'] }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@stop