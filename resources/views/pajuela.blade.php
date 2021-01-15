@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    <h1>Ficha de Pajuela</h1>
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
			<form action="{{ route ('pajuela.crear') }}" method="POST">
				@csrf
				@error('serie')
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <span>
				  	<strong>¡Atención! </strong>El campo Serie de Pajuela es obligatorio o <strong>Ya existe</strong>
				  </span>
				  
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
				@enderror
				@error('raza')
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <span>
				  	<strong>Atención! </strong>El campo Raza es obligatorio.
				  </span>				  
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
				@enderror
				<div class="form-group">
					<div class="row">
					<div class="col-6 border-top border-right border-left border-bottom">
						<div class="col">
							<label class="col-form-label oculto">idfinca:</label>
						    <input 
						    class="form-control oculto" 
						    id="id_finca" 
						    type="text" 
						    name="id_finca"  
						    placeholder="Ingrese el Nro. de Pajuela" 
						    value="{{ $finca->id_finca }}">	
							<label class="col-form-label">Serie:</label>
						    <input 
						    class="form-control" 
						    id="serie" 
						    type="text" 
						    name="serie"  
						    placeholder="Ingrese el Nro. de Pajuela" 
						    value="{{ old('serie') }}">	

						    <label class="col-form-label">Nombre Corto:</label>
						    <input 
						    class="form-control" 
						    id="nomb" 
						    type="text" 
						    name="nomb"  
						    placeholder="Nombre Corto"
						    value="{{ old('nomb') }}">
						    
						    <label class="col-form-label">Nombre Largo:</label>
						    <input 
						    class="form-control" 
						    id="nombrelargo" 
						    type="text" 
						    name="nombrelargo"  
						    placeholder="Describa la Función del lote" value="{{ old('nombrelargo') }}">

						    <label class="col-form-label">Ubicación:</label>
						    <input 
						    class="form-control" 
						    id="ubica" 
						    type="text" 
						    name="ubica"  
						    placeholder="Ubicación" value="{{ old('ubica') }}">
						</div>
			  		</div>
				  		<div class="col-6 border-top border-right  border-bottom border-style">
					    
					    <div class="col">
					    	<label>Raza</label>	
		            		<select class="form-select" name="raza" aria-label="select example">
                          		<option value="" selected>Seleccione una Raza</option>
                          		@foreach ($raza as $item)
	                          		<option value="{{ $item->nombreraza }}">{{ $item->descripcion." (".$item->nombreraza.")" }}
	                          		</option>
                          		@endforeach()	
                            </select>
					    	<label class="col-form-label">Fecha Registro:</label>
						    <input 
						    class="form-control" 
						    id="fecr" 
						    type="date" 
						    name="fecr"  
						    >  	
						    <label class="col-form-label">Fecha Nacimiento:</label>
						    
						    <input 
						    class="form-control" 
						    id="fnac" 
						    type="date" 
						    name="fnac"  
						    >
						    <label class="col-form-label">Origen:</label>
						    <input 
						    class="form-control" 
						    id="orig" 
						    type="text" 
						    name="orig"  
						    placeholder="Origen" value="{{ old('orig') }}">
					    </div>
					 	</div>
					</div>   
			  	</div>
			  	<div class="row mb-4">
			  		<div class="form-group">
			  			<div class="col border-top border-right border-left border-bottom">
			  				<div class="row mb-4">
			  					<div class="col-3">
					  				<label class="col-form-label">Cantidad:</label>
								    <input 
								    class="form-control" 
								    id="cant" 
								    type="number" 
								    name="cant"
								    min="0" 
								    pattern="^[0-9]+" 
								    placeholder="Cantidad" 
								    value="{{ old('cant') }}">	
								</div>
				  				<div class="col-3">
					  				<label class="col-form-label">Cant. Máx:</label>
								    <input 
								    class="form-control" 
								    id="maxi" 
								    type="number" 
								    name="maxi" 
								    min="0" 
								    pattern="^[0-9]+" 
								    placeholder="Cantidad Máxima" 
								    value="{{ old('maxi') }}">	
								</div>
								<div class="col-3">
								    <label class="col-form-label">Cant. Min:</label>
								    <input 
								    class="form-control" 
								    id="min" 
								    type="number" 
								    name="mini"  
								    min="0" 
								    pattern="^[0-9]+"
								    placeholder="Cantidad Mínima" 
								    value="{{ old('mini') }}">
							    </div>
							    <div class="col-3">	
								    <label class="col-form-label">Unidad:</label>
								    <input 
								    class="form-control" 
								    id="unid" 
								    type="text" 
								    name="unid"  
								    placeholder="Unidad" value="{{ old('unid') }}">
				  				</div>
				  				
				  				<div class="col">
			  					<label class="col-form-label">Observación:</label>
								    <input 
								    class="form-control text-area" 
								    id="obser" 
								    type="text"
								    name="obser"
								    maxlength="130"								    
								    value="{{ old('obser') }}">
			  					</div>
			  				</div>
			  			</div>
			  		</div>
			  	</div>
		<button type="submit" class="btn alert-success">Registrar</button>

			</form>		
		</div>
	</div>
</div>

<div class="container">
	<div class="row my-4 border-top border-right  border-bottom border-style">
		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">Serie</th>
		      <th scope="col">Raza</th>
		      <th scope="col">F. de Reg</th>
		      <th scope="col">F. de Nac</th>
		      <th scope="col">Ubica</th>
		      <th scope="col">C. Disonble</th>
		      <th scope="col">C. Mínima</th>
		      <th scope="col">C. Máxima</th>
		      <th scope="col">Unid</th>
		      <th scope="col">Observaciones</th>
		      <th scope="col">Acción</th>
		    </tr>
		  </thead>
		  <tbody> 	
		  	@foreach($pajuela as $item)
			    <tr>
			      <td>
			      	<a href=" " class="">
			      	{{ $item->serie }}
			      	</a>
			      </td>
			      <td>
					{{ $item->nombreraza }}		      
			      </td>
			      <td>
			      	{{ $item->fecr }}	
			      </td>
			      <td>
			      	{{ $item->fnac }}
			      </td>
			      <td>
			      	{{ $item->ubica }}
			      </td>
			      <td>
			      	{{ $item->cant }}
			      </td>
			      <td>
			      	{{ $item->mini }}
			      </td>
			      <td>
			      	{{ $item->maxi }}
			      </td>
			      <td>
			      	{{ $item->unid }}
			      </td>
			       <td>
			      	{{ $item->obser }}
			      </td>
			      <td>
			      	<a href="{{ route('pajuela.editar', $item->id) }}" class="btn alert-success btn-sm">Editar</a>
			      	<form action="{{ route('pajuela.eliminar', $item->id) }}" class="d-inline" method="POST">
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
			<div class="link">
		{{  $pajuela->links() }}
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
