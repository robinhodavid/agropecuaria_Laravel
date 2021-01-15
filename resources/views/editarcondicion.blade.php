@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    <h1>Editando Condición.:  {{ $condicion_corporal->nombre_condicion }}</h1>
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
			<form action="{{ route('condicion_corporal.update', $condicion_corporal->id_condicion) }}" method="POST">
				@method('PUT')
				@csrf
				@error('nombre')
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
					  <strong>Atención!</strong> El nombre de la condicón corporal es obligatorio.
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				@enderror
			  <div class="form-group">
			    <label>Condición:</label>
				    <input 
				    class="form-control" 
				    id="nombrecondicion" 
				    type="text" 
				    name="nombre_condicion"  
				    placeholder="Ingrese Nombre corto Condición Corporal" 
				    value="{{ $condicion_corporal->nombre_condicion }}">
				 <small id="emailHelp" class="form-text text-muted">Ej. C1 para identficar Condición 1 </small> 

			    <label>Descripción:</label>
			    <input 
				    class="form-control" 
				    id="descripcion" 
				    type="text" 
				    name="descripcion"  
				    placeholder="Descripción para Condición Corporal" 
				    value="{{ $condicion_corporal->descripcion }}">
			  </div>
			  <small id="emailHelp" class="form-text text-muted">Especifique el nombre largo de la condición y su descripción. Ej. Condición 1: Especifica la Condición Óptima del Animal.</small>
			  <button type="submit" class="btn alert-success">Guardar</button>
			  <a href="{{ route('condicion_corporal') }}" class="btn btn-warning">volver</a>
			</form>
		</div>
	</div>
	<div class="row">
		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">Id</th>
		      <th scope="col">Nombre Condición</th>
		      <th scope="col">Descripción</th>
		    </tr>
		  </thead>
		  <tbody>
			    <tr>
			      <th scope="row">
			      	{{ $condicion_corporal->id_condicion}}
			      </th>
			      <td>
			      	{{ $condicion_corporal->nombre_condicion}}
			      </td>
			        <td>
			      	{{ $condicion_corporal->descripcion}}
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
