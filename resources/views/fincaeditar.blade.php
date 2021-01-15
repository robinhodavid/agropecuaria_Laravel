@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    <h1>Editar Finca.:  {{ $fincas->nombre }}</h1>
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
		<div class="form-registro">
			<form action="{{ route('fincas.update', $fincas->id_finca) }}" method="POST">
				@method('PUT')
				@csrf
				@error('nombre')
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
					  <strong>Atención!</strong> El nombre de la finca es obligatorio.
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				@enderror
			<div class="form-group">   
			    <label>Nombre de la Finca:</label>
			    <input 
			    class="form-control" 
			    id="nombrefinca" 
			    type="text" 
			    name="nombre"  
			    placeholder="Ingrese Nombre de la Finca" 
			    value="{{ $fincas->nombre }}">

			    <label>Especie de la finca:</label>
			    <input 
			    class="form-control" 
			    id="especiefinca" 
			    type="text" 
			    name="especie"  
			    placeholder="Especie en la Finca" 
			    value="{{ $fincas->especie }}">
			  
			    <label class="col-form-label">slug:</label>
			    <input 
			    class="form-control" 
			    id="slug" 
			    type="text" 
			    name="slug"  
			    placeholder="slug" 
			    value="{{ $fincas->slug }}">
			</div>
			<small id="emailHelp" class="form-text text-muted">En caso de ser varias especies separar con una coma (,) Ej. Especie1, Especie2 </small>
			<button type="submit" class="btn alert-success">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
	  		<path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
	  		<path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
			</svg> Guardar</button>
			<a href="{{ route('fincas') }}" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
  			<path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
			</svg> volver</a>
			</form>
		</div>
	</div>
		<div class="row">
		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">Id</th>
		      <th scope="col">Finca</th>
		      <th scope="col">Especie</th>
		    </tr>
		  </thead>
		  <tbody>
			    <tr>
			      <th scope="row">
			      	{{ $fincas->id_finca }}
			      </th>
			      <td>
			      	{{ $fincas->nombre }}
			      </td>
			        <td>
			      	{{ $fincas->especie }}
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
