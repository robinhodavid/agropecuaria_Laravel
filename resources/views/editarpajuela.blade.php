@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
	<div class="row">
		<div class="col card-especie mr-3 border-style"> <!--Form y Validación-->

			<div class="row row-list border-bottom">
				<div class="col title-header">Edición de Pajuela</div>
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
					<form action="{{ route ('pajuela.update', [$pajuela->id, $finca->id_finca]) }}" method="POST">
						@method('PUT')
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
				        <div class="row">
				        	<div class="col-3">
				        		<div class="form-group">
				        			<label class="col-form-label">Serie:</label>
						                <input 
						                class="form-control" 
						                id="serie" 
						                type="text" 
						                name="serie"
						                readonly="true"  
						                placeholder="Ingrese el Nro. de Pajuela" 
						                value="{{ $pajuela->serie }}"> 
				        		</div>
				        	</div>
				        	<div class="col-3">
				        		<div class="form-group">
				        			<label class="col-form-label">Nombre Corto:</label>
						                <input 
						                class="form-control" 
						                id="nomb" 
						                type="text" 
						                name="nomb"  
						                placeholder="Nombre Corto"
						                value="{{ $pajuela->nomb }}">
				        		</div>
				        	</div>
				        	<div class="col-6">
				        		<div class="form-group">
				        		<label class="col-form-label">Nombre Largo:</label>
						                <input 
						                class="form-control" 
						                id="nombrelargo" 
						                type="text" 
						                name="nombrelargo"  
						                placeholder="Nombre largo de Pajuela" value="{{ $pajuela->nombrelargo }}">
				        		</div>
				        	</div>
				        </div>
				        <div class="row">
				        	<div class="col"> 
				        		<div class="form-group">
					        		<!--Se utiliza para filtrar la raza segun la especie-->   
							        <label class="col-form-label">Especie:</label> 
	                    				<select class="form-select" name="especie" aria-label="select example">
	                              			<option value="" selected>Seleccione una opción</option>
		                              		@foreach ($especie as $item)
		                                		<option value="{{ $item->id }}">{{ $item->nombre." (".$item->nomenclatura.")" }}
				                                </option>
				                            @endforeach() 
	                            		</select> 
                            	</div>	
				        	</div>
				        	<div class="col">
				        		<div class="form-group">
				        		<label class="col-form-label">Raza:</label> 
                    				<select class="form-select" name="raza" aria-label="select example">
                              			<option value="" selected>Seleccione una Raza</option>
                              			<option value="{{$pajuela->nombreraza}}" selected>{{$pajuela->nombreraza}}</option>
	                              		
	                              		@foreach ($raza as $item)
	                                		<option value="{{ $item->nombreraza }}">{{ $item->descripcion." (".$item->nombreraza.")" }}
			                                </option>
			                            @endforeach() 
                            		</select>  
                            	</div>	  
				        	</div>
				        </div>
				        <div class="row">
				        	<div class="col">
				        		<div class="form-group">
				        			<label class="col-form-label">Fecha Registro:</label>
						                <input 
						                class="form-control" 
						                id="fecr" 
						                type="date" 
						                name="fecr"  
						                value="{{ $pajuela->fecr }}">   
				        		</div>
				        		
				        	</div>
				        	<div class="col">
				        		<div class="form-group">
				        			<label class="col-form-label">Fecha Nacimiento:</label>
						                <input 
						                class="form-control" 
						                id="fnac" 
						                type="date" 
						                name="fnac"  
						                value="{{ $pajuela->fnac  }}"> 
				        		</div>
				        	</div>
				        </div>
				        <div class="row">
				        	<div class="col">
				        		<div class="form-group">
				        			<label class="col-form-label">Ubicación:</label>
						                <input 
						                class="form-control" 
						                id="ubica" 
						                type="text" 
						                name="ubica"  
						                placeholder="Ubicación" value="{{ $pajuela->ubica }}">
				        		</div>
				        	</div>
				        	<div class="col">
				        		<div class="form-group">
				        			<label class="col-form-label">Origen:</label>
						                <input 
						                class="form-control" 
						                id="orig" 
						                type="text" 
						                name="orig"  
						                placeholder="Origen" value="{{ $pajuela->orig }}">
								</div>
				        	</div>
				        </div> 
						 
				</div>
			</div>
		</div>
		<div class="col card-especie-grid ml-3 border-style"> <!--Grid -->

			<div class="row row-list border-bottom">
				<div class="col title-header">Stock de Pajuela</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="form-group">
						<label class="col-form-label">Cantidad:</label>
		                    <input 
		                    class="form-control" 
		                    id="cant" 
		                    type="number" 
		                    name="cant"
		                    min="0" 
		                    pattern="^[0-9]+" 
		                    placeholder="Cantidad" 
		                    value="{{ $pajuela->cant }}">
		           		<label class="col-form-label">Cant. Máx:</label>
		                    <input 
		                    class="form-control" 
		                    id="maxi" 
		                    type="number" 
		                    name="maxi" 
		                    min="0" 
		                    pattern="^[0-9]+" 
		                    placeholder="Cantidad Máxima" 
		                    value="{{ $pajuela->maxi }}">
		           		<label class="col-form-label">Cant. Min:</label>
		                    <input 
		                    class="form-control" 
		                    id="min" 
		                    type="number" 
		                    name="mini"  
		                    min="0" 
		                    pattern="^[0-9]+"
		                    placeholder="Cantidad Mínima" 
		                    value="{{ $pajuela->mini }}">
		          		<label class="col-form-label">Unidad:</label>
		                    <input 
		                    class="form-control" 
		                    id="unid" 
		                    type="text" 
		                    name="unid"  
		                    placeholder="Unidad" value="{{ $pajuela->unid }}"> 
		                <label class="col-form-label">Observación:</label>
		                    <input 
		                    class="form-control text-area" 
		                    id="obser" 
		                    type="text"
		                    name="obser"
		                    maxlength="130"                   
		                    value="{{ $pajuela->obser }}">
					</div>
				</div>
			</div>
		</div>
	</div>

<div class="row my-3">
	<div class="col">
		<button type="submit" class="btn alert-success aling-boton">
						 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
				  		<path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
				  		<path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
						</svg> Guardar</button>
						  <a href="{{ route('pajuela',$finca->id_finca) }}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
			  			  <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
						  </svg> volver</a>
	</div>
</div>	
 </form>
<div class="row my-4">
	  <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#listipo"><label class="title-table">Listado de Pajuelas</label></a>
            </li>
        </ul>
      	<div class="row mr-4 ml-4">
        	<table class="table table-tipologia">
      <thead class="bck-ground">
        <tr>
          <th scope="col">Serie</th>
          <th scope="col">Raza</th>
          <th scope="col">F. de Reg</th>
          <th scope="col">F. de Nac</th>
          <th scope="col">Ubica</th>
          <th scope="col">C. Disp</th>
          <th scope="col">C. Míni</th>
          <th scope="col">C. Máx</th>
          <th scope="col">Unid</th>
          <th scope="col">Observación</th>
        </tr>
      </thead>
      <tbody>   
          <tr>
            <td>
              <a href=" " class="">
              {{ $pajuela->serie }}
              </a>
            </td>
            <td>
         	 {{ $pajuela->nombreraza }}         
            </td>
            <td>
              {{ $pajuela->fecr }} 
            </td>
            <td>
              {{ $pajuela->fnac }}
            </td>
            <td>
              {{ $pajuela->ubica }}
            </td>
            <td>
              {{ $pajuela->cant }}
            </td>
            <td>
              {{ $pajuela->mini }}
            </td>
            <td>
              {{ $pajuela->maxi }}
            </td>
            <td>
              {{ $pajuela->unid }}
            </td>
             <td>
              {{ $pajuela->obser }}
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
