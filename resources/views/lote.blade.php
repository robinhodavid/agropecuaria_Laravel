@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    <h1>Información de Lote</h1>
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
			<form action="{{ route('lote.crear') }}" method="POST">
				@csrf
				@error('nombre_lote')
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
					  <span>
					  	<strong>Atención! </strong>El nombre del lote es obligatorio o <strong>Ya existe</strong>
					  </span>
					  
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				@enderror
				<div class="form-group">
					<div class="row -my-4">
						<div class="col-8 border-top border-right border-left">
				  			<h5>Datos</h5>
				  		</div>
				  		<div class="col-4 bck-ground border-top border-right border-left">
				  			<h5>Tipo</h5>
				  		</div>
				  		<div class="col-8 border-top border-right border-left border-bottom border-style">
					    <label class="col-form-label">Lote:</label>
					    <input 
					    class="form-control" 
					    id="nombre_lote" 
					    type="text" 
					    name="nombre_lote"  
					    placeholder="Ingrese Nombre del lote" 
					    data-role="tagsinput"
					    value="{{ old('nombre_lote') }}">

					    <label class="col-form-label oculto">slug:</label>
					    <input 
					    class="form-control oculto" 
					    id="slug" 
					    type="text" 
					    name="slug"  
					    placeholder="slug"
					    value="{{ old('slug') }}">
					    
					    <label class="col-form-label">Función del Lote:</label>
					    <input 
					    class="form-control" 
					    id="funcion" 
					    type="text" 
					    name="funcion"  
					    placeholder="Describa la Función del lote" value="{{ old('funcion') }}">
					</div>   
					<div class="col-4 bck-ground border-top border-right border-left border-bottom border-style">
						<div class="form-check">
						    <input 
			  				type="radio" 
			  				aria-label="Radio button for following text input"
			  				name="tipo"
			  				class="form-check-input" 
			  				id="tipo_estrategico" value="Estrategico" checked>
			  				<label class="form-check-label"  for= "estrategico">Estratégico</label>
		  				</div>	
		  				<div class="form-check">
			  				<input 
			  				type="radio" 
			  				aria-label="Radio button for following text input"
			  				name="tipo"
			  				class="form-check-input" 
			  				id="tipo_temporada" value="Temporada">
			  				<label class="form-check-label"  for="temporal">Temporada</label> 
			  			</div>	
			  			 <div class="form-check"> 
			  				<input 
			  				type="radio" 
			  				aria-label="Radio button for following text input"
			  				name="tipo"
			  				class="form-check-input" 
			  				id="tipo_pastoreo" value="Pastoreo">
			  				<label class="form-check-label"   for="pastoreo">Pastoreo</label>
			  			</div>	
		  			</div>

					</div>	
			  	</div>
				<button type="submit" class="btn alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
                 <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 0 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
                </svg> Registrar</button>
				<a href="{{ route('asignarseries') }}" class="btn alert-success">Asignar serie</a>
				
			</form>		
		</div>
	</div>
</div>

<div class="container">
	<div class="row my-4">
		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">Lote</th>
		      <th scope="col">Tipo</th>
		      <th scope="col">Función</th>
		      <th scope="col">Acción</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach ($lote as $item)
			    <tr>
			      <td>
			      	<a href="{{ route ('seriesenlote', $item->id_lote) }}" class="">
			      	{{ $item->nombre_lote}}
			      	</a>
			      </td>
			      <td>
			      	{{ $item->tipo}}
			      </td>
			      <td>
			      	{{ $item->funcion}}
			      </td>
			      <td>
			      	<a href="{{ route('lote.editar', $item->id_lote) }}" class="btn alert-success btn-sm">Editar</a>
			      	<form action="{{ route('lote.eliminar', $item->id_lote) }}" class="d-inline" method="POST">
					    @method('DELETE')
					    @csrf
					    <button type="submit" class="btn btn-danger btn-sm">
					    Eliminar
					    </button>
					</form> 
					<a href="{{ route('sublote', $item->id_lote) }}" class="btn alert-success btn-sm">Sub lote</a>
			      </td>
			    </tr>
		    @endforeach()
		  </tbody>
		</table>
		<div class="link">
			{{  $lote->links() }}
		</div>
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
