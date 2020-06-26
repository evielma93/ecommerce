<form action="{{ $action }}" method="post" enctype="multipart/form-data" >
	@csrf
	<div class="form-group row">
		<label for="name" class="col-md-4 col-form-label text-md-right">
			Nombres
		</label>
		<div class="col-md-6">
			<input id="name" type="text" class="form-control" name="name" value="{!! old('name',  $clients->names ?? null ) !!}" required autocomplete="off" autofocus>
		</div>
	</div>

	<div class="form-group row">
		<label for="name" class="col-md-4 col-form-label text-md-right">
			Apellidos
		</label>
		<div class="col-md-6">
			<input id="surname" type="text" class="form-control" name="surname" value="{!! old('surname',  $clients->surnames ?? null ) !!}" required autocomplete="off">
		</div>
	</div>

	<div class="form-group row">
		<label for="name" class="col-md-4 col-form-label text-md-right">
			RUC/CI/PASAPORTE
		</label>
		<div class="col-md-6">
			<input id="ruc" type="text" class="form-control" name="ruc" value="{!! old('ruc',  $clients->identification ?? null ) !!}" required autocomplete="off">
		</div>
	</div>

	<div class="form-group row">
		<label for="name" class="col-md-4 col-form-label text-md-right">
			E-mail
		</label>
		<div class="col-md-6">
			<input id="email" type="email" class="form-control" name="email" value="{!! old('email',  $clients->email ?? null ) !!}" required autocomplete="off">
		</div>
	</div>

	<div class="form-group row">
		<label for="descripcion" class="col-md-4 col-form-label text-md-right">
			Genero
		</label>
		<div class="col-md-6">
			<select class="form-control" id="gender" name='gender'>
				@foreach($Genders as $Gender)
				@php ($seleccionado = '')
				@if (isset($clients) && ($clients->gender == $Gender->id))
				@php ($seleccionado = 'selected')
				@endif
				<option value="{{ $Gender->id}}" {{$seleccionado}}>
					{{$Gender->name}}
				</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="form-group row">
		<label for="birthdate" class="col-md-4 col-form-label text-md-right">
			Fecha de Nacimiento
		</label>
		<div class="col-md-6">
			<input type="date" name="birthdate" id="birthdate" class="form-control" required  onchange="CalculaEdad2(this.value)" value="{!! old('birthdate',  $clients->birthdate ?? null ) !!}" >
		</div>
	</div>

	<div class="form-group row">
		<label for="age" class="col-md-4 col-form-label text-md-right">
			Edad
		</label>
		<div class="col-md-6">
			<input type="text" name="age" id="age" class="form-control" required value="{!! old('age',  $clients->age ?? null ) !!}" >
		</div>
	</div>

	<div class="form-group row">
		<label for="name" class="col-md-4 col-form-label text-md-right">
			Teléfono
		</label>
		<div class="col-md-6">
			<input id="CellPhone" type="text" class="form-control" name="CellPhone" value="{!! old('CellPhone',  $clients->CellPhone ?? null ) !!}" required autocomplete="off">
		</div>
	</div>

	<div class="form-group row">
		<label for="descripcion" class="col-md-4 col-form-label text-md-right">
			Sector
		</label>
		<div class="col-md-6">
			<select class="form-control" id="sector_id" name='sector_id'>
				@foreach($Sectors as $Sector)
				@php ($seleccionado = '')
				@if (isset($clients) && ($clients->sector_id == $Sector->id))
				@php ($seleccionado = 'selected')
				@endif
				<option value="{{ $Sector->id}}" {{$seleccionado}}>
					{{$Sector->name}}
				</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="form-group row">
		<label for="name" class="col-md-4 col-form-label text-md-right">
			Dirección
		</label>
		<div class="col-md-6">
			<input id="address" type="text" class="form-control" name="address" value="{!! old('address',  $clients->address ?? null ) !!}" required autocomplete="off">
		</div>
	</div>

	<div class="form-group row">
		<div class="col-md-8 offset-md-4">
			<button type="submit" class="btn btn-primary">Guardar</button>
		</div>
	</div>

</form>

