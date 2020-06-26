@extends('layouts.layout_sec')

@section('content')
<div class="row justify-content-center">
	<div class="col-xl-8 col-lg-7">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Creación de Clientes</h6>
			</div>
			<div class="card-body">
				@if($errors->any())
				<div class="alert alert-danger">
					@foreach ($errors->all() as $error)
					- {{$error}} <br>
					@endforeach
				</div>
				@endif
				@if(session('message'))
				<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>{{ session('message') }}</strong>
				</div>
				@endif
				@include('clients.partials.form')

			</div>
		</div>
	</div>

</div>

@endsection
@section('scripts')
<script>
	function CalculaEdad2(fecha){
		axios.post('/calculaEdad/'+fecha).then(function(response){
			$('#age').val(response.data.edad);
		}).catch(function(error){
			console.log(error);
		});
	}
</script>
@endsection