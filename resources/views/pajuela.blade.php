@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
	<div class="row">
		<div class="col card-especie mr-3 border-style"> <!--Form y Validación-->
		
			<div class="row row-list border-bottom">
				<div class="col title-header">Registro de Pajuela</div>
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
					<form action="{{ route ('pajuela.crear', $finca->id_finca) }}" method="POST">
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
						                placeholder="Ingrese el Nro. de Pajuela" 
						                value="{{ old('serie') }}"> 
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
						                value="{{ old('nomb') }}">
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
						                placeholder="Describa la Función del lote" value="{{ old('nombrelargo') }}">
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
						                >   
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
						                > 
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
						                placeholder="Ubicación" value="{{ old('ubica') }}">
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
						                placeholder="Origen" value="{{ old('orig') }}">
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
		                    value="{{ old('cant') }}">
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
		          		<label class="col-form-label">Unidad:</label>
		                    <input 
		                    class="form-control" 
		                    id="unid" 
		                    type="text" 
		                    name="unid"  
		                    placeholder="Unidad" value="{{ old('unid') }}"> 
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
<div class="row my-3">
	<div class="col">
		<button type="submit" class="btn alert-success aling-boton">
			  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
		     	  <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 0 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
			  </svg> Registrar</button>
			  <a href="{{ route('admin',$finca->id_finca) }}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
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
      		<form method="GET" action="{{route('pajuela', $finca->id_finca)}}" role="search">
	      		<div class="card-tools search-table">
              		<div class="input-group input-group-sm" style="width: 180px;">
	                	<input type="text" name="pajuela" id="pajuela" class="form-control float-right" placeholder="Buscar pajuela...">
	                    <div class="input-group-append">
	                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
	                	</div>
            		</div>
	            </div>
            </form>
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
		                <a href="{{ route ('pajuela.editar', [$finca->id_finca, $item->id] ) }}" class="btn alert-success btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
		                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
		           	    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
		        		</svg> </a>
		                    
		                <form action="{{ route ('pajuela.eliminar', [$finca->id_finca, $item->id]) }}" class="d-inline" method="POST">
			              	@method('DELETE')
			              	@csrf
			              	<button type="submit" class="btn btn-danger btn-sm">
			              	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
			              	<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
				            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
				            </svg> 
		                </button>
		                </form>
		            </td>
		          </tr>
		       @endforeach()
		      </tbody>
    		</table>
    		<div class="col title-table">{{$pajuela->links()}}</div>	
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
