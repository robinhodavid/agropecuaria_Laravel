@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    <h1>Editando Patología.: {{$patologia->patologia }}</h1>
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
			<form action="{{ route('patologia.update', $patologia->id) }}" method="POST">
			@method('PUT')
			@csrf
			@error('nombre')
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <strong>Atención!</strong> El nombre de la Raza es obligatorio.
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
			@enderror
			    <div class="form-group">
				  	<div class="row mb-4">
				  		<div class="col-6">
					  		<label>Nombre:</label>
						    <input 
						    class="form-control" 
						    id="patologia" 
						    type="text" 
						    name="patologia"  
						    placeholder="Ingrese la patalogía" 
						    value="{{ $patologia->patologia }}">
							 <!--<small id="emailHelp" class="form-text text-muted">Ej. C1 para identficar Condición 1 </small> -->
						</div>
						<div class="col-5">
						    <label>Nomenclatura:</label>
						    <input 
							    class="form-control" 
							    id="nomenclatura" 
							    type="text" 
							    name="nomenclatura"  
							    placeholder="Sigla o Nomenclatura" 
							    value="{{ $patologia->nomenclatura }}">
					  	</div>	
					</div>	
					    <label>Descripción:</label>
					    <input 
						    class="form-control" 
						    id="descripcion" 
						    type="text" 
						    name="descripcion"  
						    placeholder="Ingrese una descripción de patología" 
						    value="{{ $patologia->descripcion }}">      
	  			</div>
				 	 <button type="submit" class="btn alert-success">Guardar</button>
				 	  <a href="{{ route('patologia') }}" class="btn btn-warning ">volver</a>
			</form>
		</div>
	</div>
	<div class="row">
		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">Id</th>
		      <th scope="col">Nombre de Patología</th>
		      <th scope="col">Nomenclatura</th>
		      <th scope="col">Descripción</th>
		    </tr>
		  </thead>
		  <tbody>
			    <tr>
			      <th scope="row">
			      	{{ $patologia->id}}
			      </th>
			      <td>
			      	{{ $patologia->patologia}}
			      </td>
			      <td>
					{{ $patologia->nomenclatura}}
			      </td>
			      <td>
					{{ $patologia->descripcion }}
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
