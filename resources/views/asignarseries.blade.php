@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    <h1>Asignar series</h1>
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
	<!-- main row -->
	<div class="row ">
		<div class="form-registro">
			<div class="row">
				<div class="col">
					{!! Form::open(['route'=>'asignarseries', 'method'=>'GET', 'class'=>'pull-left', 'role'=>'search']) !!}
						<label for="serie">Nro. Serie</label>
						<div class="input-group mb-4">
							{!! Form::text('serie', null, ['class'=>'form-control form-control-navbar', 'placeholder'=>'Ingrese el número de serie a buscar','id'=>'buscaserie'])!!}
							<button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
						</div>
					{!! Form::close() !!}
				</div>
				<div class="col">
					<div class="check-tipo bck-ground border-top border-right border-left border-bottom border-style">
						<label for="serie">Tipo de Lote</label>	
							<div class="form-check">
							    <input 
				  				type="radio" 
				  				aria-label="Radio button for following text input"
				  				name="tipo"
				  				class="form-check-input" 
				  				id="tipo_estrategico" value="Estrategico">
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
			<form action="{{ route('serielote.asignar') }}" method="POST">
				@csrf
				@error('nombrelote')
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
					  <span>
					  	<strong>¡Atención! </strong>El campo Lote es obligatorio.
					  </span>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				@enderror
				@error('id')
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
					  <span>
					  	<strong>¡Atención! </strong>Debe seleccionar al menos un Nro. de Serie.
					  </span>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				@enderror
	<!--Campo para buscar las series -->
	<div class="row">
			<div class="col">
				<div class="table">
					<table class="table">
					  <thead>
					    <tr>
					      <th scope="col"></th>	
					      <th scope="col">Serie</th>
					      <th scope="col">Lote</th>
					      <th scope="col">Sub Lote</th>
					      <th scope="col">Tipología</th>
					    </tr>
					 </thead>
					  <tbody>
					  	@foreach ($asignarseries as $item)
						    <tr>
						      <td>
						  
								<div class="form-check">      	
							     		<input 
							     		class="form-check-input" 
							     		type="checkbox" 
							     		value="{{ $item->id}}" id="id_serie"
							     		name="id[]">
								</div>  
						      </td>
						       <td>
						      	{{ $item->serie}}
						      </td>
						      <td>
						      	{{ $item->nombrelote}}
						      </td>
						      <td>
						      	{{ $item->sub_lote}}
						      </td>
						      <td>
						      	{{ $item->tipo}}
						      </td>
						    </tr>
					    @endforeach()
					  </tbody>
					</table>
				</div>	
				
			</div>
			<div class="col">
				<div class="select-lote">
					<label>Lote</label>										
		            {!! Form::select('nombrelote',[''=>'Seleccione un Lote'],null,['id'=>'nombrelote', 'class'=>'form-select']) !!}
				</div>
				<div class="select-sublote">
					<label>Sub Lote</label>
					{!! Form::select('sublote',[''=>'Seleccione un Sub Lote'],null,['id'=>'sublote', 'size'=>'5','class'=>'form-select']) !!}
				</div>
				<button type="submit" class="btn alert-success">
					<i class="bi bi-arrow-left-circle">Registrar</i>
				</button>
				<a href="{{ route('lote') }}" class="btn alert-success">Volver</a>
			</div>
	
	</div>
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
  
  {!! Html::script('js/jquery-3.5.1.min.js')!!}
  {!! Html::script('js/dropdown.js')!!}

@stop
