@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    <h1>Registro de Diagnóstico Palpaciones</h1>
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
			<form action="{{ route('diagnostico_palpaciones.crear') }}" method="POST">
				@csrf
				@error('nombre')
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
					  <strong>Atención!</strong> El nombre corto del diágnostico es obligatorio.
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				@enderror
			  <div class="form-group">
			    <label>Nombre corto de Diágnostico:</label>
				    <input 
				    class="form-control" 
				    id="nombre" 
				    type="text" 
				    name="nombre"  
				    placeholder="Ingrese Nombre corto para el Diágnostico" 
				    value="{{ old('nombre') }}">
				 <small id="emailHelp" class="form-text text-muted">Ej. PÑ  </small> 

			    <label>Descripción:</label>
			    <input 
				    class="form-control" 
				    id="descrip" 
				    type="text" 
				    name="descrip"  
				    placeholder="Descripción de Diágnostico" 
				    value="{{ old('descrip') }}">
			  </div>
			  <small id="emailHelp" class="form-text text-muted">Describa el Diágnostico de palpaciones asociado. Ej. PÑ: Especifica que la serie está Preñada al momento de la palpación.</small>
			  <button type="submit" class="btn alert-success">Registrar</button>
			</form>
		</div>
	</div>
	<div class="row">
		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">Id</th>
		      <th scope="col">Nombre Diagnóstico</th>
		      <th scope="col">Descripción</th>
		      <th scope="col">Acción</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach ($diagnostico_palpaciones as $item)
			    <tr>
			      <th scope="row">
			      	{{ $item->id_diagnostico}}
			      </th>
			      <td>
			      	{{ $item->nombre}}
			      </td>
			        <td>
			      	{{ $item->descrip}}
			      </td>
			      <td>
			      	 <a href="{{ route('diagnostico_palpaciones.editar', $item->id_diagnostico) }}" class="btn alert-success btn-sm">Editar</a>

			      	<form action="{{ route('diagnostico_palpaciones.eliminar', $item->id_diagnostico) }}" class="d-inline" method="POST">
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
