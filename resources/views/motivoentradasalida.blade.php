@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    <h1>Registro de Motivos Entrada o Salida</h1>
@stop

@section('content')
 
 @if(session('msj'))
 	<div class="alert alert-success alert-dismissible fade show" role="alert">
	  <strong> {{ session('msj') }} </strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
			</button>
	</div>
 @endif
<div class="container">
	<div class="row my-4">
		<div class="form-registro">
			<form action="{{ route('motivo_entrada_salida.crear') }}" method="POST">
				@csrf
				@error('nombre')
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
					  <strong>Atención!</strong> El nombre del Motivo de Entrada o Salida es obligatorio.
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				@enderror
			  <div class="form-group">
			    <label>Nombre:</label>
				    <input 
				    class="form-control" 
				    id="nombremotivo" 
				    type="text" 
				    name="nombremotivo"  
				    placeholder="Ingrese Nombre del Motivo" 
				    value="{{ old('nombremotivo') }}">
				 <!--<small id="emailHelp" class="form-text text-muted">Ej. C1 para identficar Condición 1 </small> -->

			    <label>Nomenclatura:</label>
			    <input 
				    class="form-control" 
				    id="nomenclatura" 
				    type="text" 
				    name="nomenclatura"  
				    placeholder="Sigla o Nomenclatura" 
				    value="{{ old('nomenclatura') }}">
				<input 
      				type="radio" 
      				aria-label="Radio button for following text input"
      				name="tipo"
      				id="tipo_salida" value="Salida" checked>
      				<label class="checkbox-inline"  for= "sexo">Salida</label>
      				
      				<input 
      				type="radio" 
      				aria-label="Radio button for following text input"
      				name="tipo"
      				id="tipo_entrada" value="Entrada">
      				<label class="checkbox-inline"  for="sexo">Entrada</label>    

			  </div>
			  <small id="emailHelp" class="form-text text-muted">Ej. LS para identficar Limpieza del sistema</small>
			  <button type="submit" class="btn alert-success">Registrar</button>
			</form>
		</div>
	</div>
	<div class="row">
		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">Id</th>
		      <th scope="col">Motivo</th>
		      <th scope="col">Nomenclatura</th>
		      <th scope="col">Tipo</th>
		      <th scope="col">Acción</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach ($motivo_entrada_salida as $item)
			    <tr>
			      <th scope="row">
			      	{{ $item->id}}
			      </th>
			      <td>
			      	{{ $item->nombremotivo}}
			      </td>
			      <td>
			      	{{ $item->nomenclatura}}
			      </td>
			      <td>
			      	{{ $item->tipo}}
			      </td>
			      <td>
			      	 <a href="{{ route('motivo_entrada_salida.editar', $item->id) }}" class="btn alert-success btn-sm">Editar</a>
			      	
			      	<form action="{{ route('motivo_entrada_salida.eliminar', $item->id) }}" class="d-inline" method="POST">
					    @method('DELETE')
					    @csrf
					    <button type="submit" class="btn btn-danger btn-sm">
					    Eliminar
					    </button>
					</form> 
			      </td>
			    </tr>
		    @endforeach()
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
