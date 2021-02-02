@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content') 

<div class="container">
	<div class="row">
		<div class="col card-especie mr-3 border-style"> <!--Form y Validación-->
			<div class="row row-list border-bottom">
				<div class="col title-header">Edición de Lote</div>
			</div>
			 @if(session('msj'))
 				<div class="alert alert-success alert-dismissible fade show" role="alert">
	  			<strong>¡Felicidades!</strong> {{ session('msj') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
			</div>
 			@endif
			<div class="row my-4">
				<div class="form-registro">
					<form action="" method="POST">
						@csrf
						@error('nombre_lote')
				        <div class="alert alert-warning alert-dismissible fade show" role="alert">
				            <span>
				              <strong>Atención! </strong>El nombre del lote es obligatorio o <strong>Ya existe.</strong>
				            </span>
				            
				            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				              <span aria-hidden="true">&times;</span>
				            </button>
				        </div>
				        @enderror
				        <div class="row">
					        <div class="col">
					        	<div class="form-group">
								    <label class="col-form-label">Lote:</label>
							            <input 
							            class="form-control" 
							            id="nombre_lote" 
							            type="text" 
							            name="nombre_lote"  
							            placeholder="Ingrese Nombre del lote" 
							            data-role="tagsinput"
							            value="{{ $lote->nombre_lote }}">

							    	<label class="col-form-label oculto">slug:</label>
							            <input 
							            class="form-control oculto" 
							            id="slug" 
							            type="text" 
							            name="slug"  
							            placeholder="slug"
							            readonly="true" 
							            value="{{ $lote->slug }}">
						  		</div>
					        </div>
					        <div class="col">
					        	<label class="col-form-label">Tipo</label>
					        	<div class="form-check">
					        		<input 
						                type="radio" 
						                aria-label="Radio button for following text input"
						                name="tipo"
						                class="form-check-input" 
						                id="tipo_estrategico" value="Estrategico" 
						                  {!! $lote->tipo=='Estrategico'?"checked":"" !!}>
						                <label class="form-check-label"  for= "estrategico">Estratégico</label>
						  		</div>
						  		 <div class="form-check my-2">
					                <input 
						                type="radio" 
						                aria-label="Radio button for following text input"
						                name="tipo"
						                class="form-check-input" 
						                id="tipo_temporada" value="Temporada"
						                {!! $lote->tipo=='Temporal'?"checked":"" !!}>
					                	<label class="form-check-label"  for="temporal">Temporada</label> 
					            </div> 
					            <div class="form-check"> 
					                <input 
						                type="radio" 
						                aria-label="Radio button for following text input"
						                name="tipo"
						                class="form-check-input" 
						                id="tipo_pastoreo" value="Pastoreo"
						                {!! $lote->tipo=='Pastoreo'?"checked":"" !!}>
					                	<label class="form-check-label"   for="pastoreo">Pastoreo</label>
             					</div>   
					        </div>
				        </div>
				        <div class="row">
				        	<div class="col">
				        		<div class="form-group">
				        		 	<label class="col-form-label">Función del Lote:</label>
						              <input 
						              class="form-control" 
						              id="funcion" 
						              type="text" 
						              name="funcion"  
						              placeholder="Describa la Función del lote" value="{{ $lote->funcion  }}">
				        		</div>
				        	</div>	
				        </div>
						   <button type="submit" class="btn alert-success aling-boton">
						 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
				  		<path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
				  		<path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
						</svg> Guardar</button>
						  	<a href="#" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
				  			<path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
			  				</svg> volver</a>
					</form>
				</div>
			</div>
		</div>
		<div class="col card-especie-grid ml-3 border-style"> <!--Grid -->
			<div class="row row-list border-bottom">
				<div class="col title-header">Listado de Lote</div>
			</div>
		    <table class="table table-especie">
		      	<thead>
		        <tr>
		          <th scope="col">Lote</th>
		          <th scope="col">Tipo</th>
		          <th scope="col">Función</th>
		        </tr>
		      	</thead>
			    <tbody>
			          <tr>
			            <td>
			              {{ $lote->nombre_lote}}
			            </td>
			            <td style="width: 15%;">
			              {{ $lote->tipo}}
			            </td>
			            <td style="width: 60%;">
			              {{ $lote->funcion}}
			            </td>
			          </tr>
			    </tbody>
    		</table>
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
