@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    <h1>Editando el Lote.: {{ $lote->nombre_lote }}  </h1>
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
			<form action="{{ route('lote.update', $lote->id_lote ) }}" method="POST">
				@method('PUT')
				@csrf
				@error('nombre')
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
					  <strong>Atención!</strong> El nombre del lote es obligatorio.
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
					    value="{{ $lote->nombre_lote }}">
					    <label class="col-form-label">slug:</label>
					    <input 
					    class="form-control" 
					    id="slug" 
					    type="text" 
					    name="slug"  
					    placeholder="slug" 
					    value="{{ $lote->slug }}">
					    <label class="col-form-label">Función del Lote:</label>
					    <input 
					    class="form-control" 
					    id="funcion" 
					    type="text" 
					    name="funcion"  
					    placeholder="Describa la Función del lote" value="{{ $lote->funcion  }}">
					</div>   
					<div class="col-4 bck-ground border-top border-right border-left border-bottom border-style">
						<div class="form-check">
						    <input 
			  				type="radio" 
			  				aria-label="Radio button for following text input"
			  				name="tipo"
			  				class="form-check-input" 
			  				id="tipo_estrategico" 
			  				value="Estrategico" 
			  				{!! $lote->tipo=='Estrategico'?"checked":"" !!}>
			  				<label class="form-check-label"  for= "estrategico">Estratégico</label>
		  				</div>	
		  				<div class="form-check">
			  				<input 
			  				type="radio" 
			  				aria-label="Radio button for following text input"
			  				name="tipo"
			  				class="form-check-input" 
			  				id="tipo_temporal" 
			  				value="Temporal"
			  				{!! $lote->tipo=='Temporal'?"checked":"" !!}>
			  				<label class="form-check-label"  for="temporal">Temporal</label> 
			  			</div>	
			  			 <div class="form-check"> 
			  				<input 
			  				type="radio" 
			  				aria-label="Radio button for following text input"
			  				name="tipo"
			  				class="form-check-input" 
			  				id="tipo_pastoreo" 
			  				value="Pastoreo"
			  				{!! $lote->tipo=='Pastoreo'?"checked":"" !!}>
			  				<label class="form-check-label"   for="pastoreo">Pastoreo</label>
			  			</div>	
		  			</div>

					</div>	
			  	</div>
				<button type="submit" class="btn alert-success">Guardar</button>
				<a href="{{ route('lote') }}" class="btn btn-warning btn-sm">volver</a>
			</form>		
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
