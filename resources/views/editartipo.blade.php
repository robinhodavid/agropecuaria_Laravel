@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    <h1>Editando Tipología.: {{ $tipologia->nombre_tipologia }}</h1>
@stop

@section('content')
 
 @if(session('msj'))
 	<div class="alert alert-success alert-dismissible fade show" role="alert">
	  <strong>¡Felicidades!</strong> {{ session('msj') }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
			</button>
	</div>
 @endif
<div class="container">
	<div class="row my-4">
		<div class="form-registro col">
			<form action="{{ route('tipologia.update', $tipologia->id_tipologia ) }}" method="POST">
				@method('PUT')
				@csrf
				@error('nombre_tipologia')
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
					  <strong>Atención!</strong> El nombre de Tipología es obligatorio.
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				@enderror
				@error('nomenclatura')
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
					  <strong>Atención!</strong> Debe agregar una Siglas o Nomenclatura
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				@enderror
				@error('edad')
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
					  <strong>Atención!</strong> Debe agregar una edad.
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				@enderror
				@error('peso')
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
					  <strong>Atención!</strong> Debe agregar un peso.
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				@enderror
			  <div class="form-group">
			  	<div class="row">
				  	<div class="col">
					    <label>Nombre de tipología:</label>
					    <input 
					    class="form-control" 
					    id="nombre_tipologia" 
					    type="text" 
					    name="nombre_tipologia"  
					    placeholder="Ingrese Nombre de la Tipología" 
					    value="{{ $tipologia->nombre_tipologia }}">
					    
					    <label>Siglas:</label>
					    <input 
					    class="form-control" 
					    id="nomenclatura" 
					    type="text" 
					    name="nomenclatura"  
					    placeholder="Sigla o Abreviatura" 
					    value="{{ $tipologia->nomenclatura }}">
					    <label>Descripción:</label>
					    <input 
					    class="form-control" 
					    id="descripcion" 
					    type="text" 
					    name="descripcion"  
					    placeholder="Descripción de Tipología" 
					    value="{{ $tipologia->descripcion }}">
				 	</div>    
				 	<div class="col">
						<label>Edad:</label>
					    <input 
					    class="form-control" 
					    id="edad" 
					    type="number" 
					    name="edad"  
					    placeholder="Edad en días" 
					    value="{{ $tipologia->edad }}"
					    min="0" pattern="^[0-9]+">
					    <label>Peso:</label>
					    <input 
					    class="form-control" 
					    id="peso" 
					    type="number" 
					    name="peso" 
					    step="any" 
					    placeholder="Peso en Kg." 
					    value="{{ $tipologia->peso  }}"
					    min="0">
					    <label>Nro. Monta:</label>
					    <input 
					    class="form-control" 
					    id="nro_monta" 
					    type="number" 
					    name="nro_monta"  
					    placeholder="0" 
					    value="{{ $tipologia->nro_monta  }}"
					    min="0" pattern="^[0-9]+">
					</div>
				</div>
				<div class="row">	    
					
			    </div>
		    </div>
			  <div class="col">
			  	<div class="title-param my-4">
			  		<h4>Parámetros de Tipología </h4>
			  	</div>
			  	<div class="input-group-text">
      				<input 
      				type="checkbox" 
      				id="destetado" 
      				name="destetado" 
      				aria-label="Checkbox for following text input" 
      				{!! $tipologia->destetado?"checked":"" !!}>
      				<label class="checkbox-inline" for="destetado">¿Está Destetado?</label>
      				
      				<input 
      				type="radio" 
      				aria-label="Radio button for following text input"
      				name="sexo"
      				id="sexo_hembra"
      				value="0"
      				{!! $tipologia->sexo?"":"checked" !!}> 
      				<label class="checkbox-inline"  for= "sexo">Hembra</label>
      				
      				<input 
      				type="radio" 
      				aria-label="Radio button for following text input"
      				name="sexo"
      				id="sexo_macho"
      				value="1"
      				{!! $tipologia->sexo?"checked":"" !!}> 
      				<label class="checkbox-inline"  for="sexo">Macho</label>

      				<input 
      				type="checkbox" 
      				id="prenada" 
      				name="prenada" 
      				aria-label="Checkbox for following text input"
      				{!! $tipologia->prenada?"checked":"" !!}>
      				<label class="checkbox-inline"  for="prenada">¿Preña(da)?</label>
      				
      				<input 
      				type="checkbox" 
      				id="parida" 
      				name="parida" 
      				aria-label="Checkbox for following text input"
      				{!! $tipologia->parida?"checked":"" !!}>
      				<label class="checkbox-inline"  for="parida">¿Parida?</label>

      				<input 
      				type="checkbox" 
      				id="tienecria" 
      				name="tienecria" 
      				aria-label="Checkbox for following text input"
      				{!! $tipologia->tienecria?"checked":"" !!}>
      				<label class="checkbox-inline"  for="tienecria">¿Tiene Cría?</label>

      				<input 
      				type="checkbox" 
      				id="criaviva" 
      				name="criaviva" 
      				aria-label="Checkbox for following text input"
      				{!! $tipologia->criaviva?"checked":"" !!}>
      				<label class="checkbox-inline"  for="criaviva">¿Cría está Viva?</label>

      				<input 
      				type="checkbox" 
      				id="ordenho" 
      				name="ordenho" 
      				aria-label="Checkbox for following text input"
      				{!! $tipologia->ordenho?"checked":"" !!}>
      				<label class="checkbox-inline"  for="ordenho">¿En Ordeño?</label>

      				<input 
      				type="checkbox" 
      				id="detectacelo" 
      				name="detectacelo" 
      				aria-label="Checkbox for following text input"
      				{!! $tipologia->detectacelo?"checked":"" !!}>
      				<label class="checkbox-inline"  for="detectacelo">¿Detecta Celo?</label>

    			</div>
			  </div>
			  <!--
			  <small id="emailHelp" class="form-text text-muted">En caso de ser varias especies separar con una coma (,) Ej. Especie1, Especie2 </small> -->
			  <button type="submit" class="btn alert-success">Guardar</button>
			     <a href="{{ route('tipologia') }}" class="btn btn-warning btn-sm">volver</a>
			</form>
		</div>
	</div>
		<div class="row">
		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">Id</th>
		      <th scope="col">Tipología</th>
		      <th scope="col">Nomb. Abreviado</th>
		      <th scope="col">Edad</th>
		      <th scope="col">Peso</th>
		      <th scope="col">¿Está Destedado?</th>
		      <th scope="col">Sexo</th>
		      <th scope="col">Nro. Monta</th>
		      <th scope="col">¿Preña?</th>
			  <th scope="col">¿Parida?</th>
			  <th scope="col">¿Tiene Cría?</th>
			  <th scope="col">¿Cría Víva?</th>
			  <th scope="col">¿En Ordeño?</th>
			  <th scope="col">¿Detecta Celo?</th>
			  <th scope="col">Descripción</th>
		    </tr>
		  </thead>
		  <tbody>
			    <tr>
			      <th scope="row">
			      	{{ $tipologia->id_tipologia }}
			      </th>
			      <td>
			      	{{ $tipologia->nombre_tipologia }}
			      </td>
			      <td>
			      	{{ $tipologia->nomenclatura }}
			      </td>
			      <td>
			      	{{ $tipologia->edad }}
			      </td>
			      <td>
			      	{{ $tipologia->peso }}
			      </td>
			      <td>
			      	{{ $tipologia->destetado }}
			      </td>
			      <td>
			      	{{ $tipologia->sexo }}
			      </td>
			      <td>
			      	{{ $tipologia->nro_monta }}
			      </td>
			      <td>
			      	{{ $tipologia->prenada }}
			      </td>
			      <td>
			      	{{ $tipologia->parida }}
			      </td>
			      <td>
			      	{{ $tipologia->tienecria }}
			      </td>
			      <td>
			      	{{ $tipologia->criaviva }}
			      </td>
			      <td>
			      	{{ $tipologia->ordenho }}
			      </td>
			      <td>
			      	{{ $tipologia->detectacelo }}
			      </td>
			      <td>
			      	{{ $tipologia->descripcion }}
			      </td>
			    </tr>
		  </tbody>
		</table>
	</div>
</div>
@stop

@section('css')
<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script type="text/javascript">
    $(".alert-dismissible").fadeTo(3000, 500).slideUp(500, function(){
       $(".alert-dismissible").alert('close');
});

    </script>
    

@stop
