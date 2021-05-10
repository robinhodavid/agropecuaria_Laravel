@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12"> <!-- Col1 -->
			<div class="card">
              	<div class="card-header">
                	<div class="col title-header">Ficha de Tipología</div>
              	</div>
              	@if(session('msj'))
	 			<div class="alert alert-success alert-dismissible fade show" role="alert">
			  		<strong>¡Felicidades!</strong> {{ session('msj') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
					</button>
				</div>
	 			@endif
              	<!-- /.card-header -->
              	<div class="form-registro">
		          	<form action="{{ route('tipologia.update', [$tipologia->id_tipologia, $finca->id_finca] ) }}" method="POST">
           			 @method('PUT')
			            @csrf
			            @error('nombre_tipologia')
			                <div class="alert alert-warning alert-dismissible fade show" role="alert">
			                  <strong>Atención!</strong> El nombre de Tipología es obligatorio.
			                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                    <span aria-hidden="true">&times;</span>
			                  </button>
			                </div>
			            @enderror
			            @error('nomenclatura')
			                <div class="alert alert-warning alert-dismissible fade show" role="alert">
			                  <strong>Atención!</strong> Debe agregar una Siglas o Nomenclatura
			                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                    <span aria-hidden="true">&times;</span>
			                  </button>
			                </div>
			            @enderror
			            @error('edad')
			                <div class="alert alert-warning alert-dismissible fade show" role="alert">
			                  <strong>Atención!</strong> Debe agregar una edad.
			                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                    <span aria-hidden="true">&times;</span>
			                  </button>
			                </div>
			            @enderror
			            @error('peso')
			                <div class="alert alert-warning alert-dismissible fade show" role="alert">
			                  <strong>Atención!</strong> Debe agregar un peso.
			                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                    <span aria-hidden="true">&times;</span>
			                  </button>
			                </div>
			            @enderror
			           	@error('nro_monta')
			                <div class="alert alert-warning alert-dismissible fade show" role="alert">
			                  <strong>Atención!</strong> El campo Nro. de Monta no puede ser vacío, agregue un valor.
			                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                    <span aria-hidden="true">&times;</span>
			                  </button>
			                </div>
			            @enderror
              	    <div class="card-body">
	              		<div class="row">
		              		<div class="col">
	    						<div class="col title-header">Registro de Tipología</div>
		              			 	<div class="form-group">
	               					 	<label>Nombre de tipología:</label>
						                    <input 
						                      class="form-control" 
						                      id="nombre_tipologia" 
						                      type="text" 
						                      name="nombre_tipologia"  
						                      placeholder="Ingrese Nombre de la Tipología" 
						                      value="{{ $tipologia->nombre_tipologia }}">

	                					<label class="my-2">Nomenclatura:</label>
						                    <input 
								                class="form-control" 
								                id="nomenclatura" 
								                type="text" 
								                name="nomenclatura" 
								                placeholder="Nomenclatura" 
								                value="{{ $tipologia->nomenclatura }}">
	              						<label class="my-2">Descripción:</label>
	                      					<input 
						                       class="form-control" 
						                       id="descripcion" 
						                       type="text" 
						                       name="descripcion"  
						                       placeholder="Descripción de Tipología" 
						                       value="{{ $tipologia->descripcion }}">  
	         						</div> <!--/. form-group-->
		              		</div> <!--/.col-->

		              		<div class="col">
		              			<div class="col title-header">Parámetros tipológicos</div>
	          			        <div class="row">
							        <div class="col-4">
							          	<label class="my-2">Edad:</label>
							                  <input 
							                  class="form-control" 
							                  id="edad" 
							                  type="number" 
							                    name="edad"  
							                    placeholder="Edad en días" 
							                    value="{{ $tipologia->edad }}"
							                    min="0" pattern="^[0-9]+">
							        </div>
							        <div class="col-4">
							          	<label class="my-2">Peso:</label>
							                    <input 
							                    class="form-control" 
							                    id="peso" 
							                    type="number" 
							                    name="peso" 
							                    step="any" 
							                    placeholder="Peso en Kg." 
							                    value="{{ $tipologia->peso }}"
							                    min="0">
							        </div>
							        <div class="col-4">
							          	<label class="my-2">Nro. Monta:</label>
							                  <input 
							                  class="form-control" 
							                  id="nro_monta" 
							                  type="number" 
							                  name="nro_monta"  
							                  placeholder="0" 
							                  value="{{ $tipologia->nro_monta }}"
							                  min="0" pattern="^[0-9]+">
							        </div>  
								</div> <!--/.row -->
	  							<div class="row my-4">
								    <div class="col-2 my-2 col-parm">
								          	<input 
								                  type="radio" 
								                  aria-label="Radio button for following text input"
								                  name="sexo"
								                  id="sexo_hermbra"  value="0"
								                    {!! $tipologia->sexo?"":"checked" !!}> 
								                  <label class="checkbox-inline"  for= "sexo">Hembra</label>
								                  <input 
								                  type="radio" 
								                  aria-label="Radio button for following text input"
								                  name="sexo"
								                  id="sexo_macho" value="1"
								                    {!! $tipologia->sexo?"checked":"" !!}> 
								                  <label class="checkbox-inline"  for="sexo">Macho</label>
								    </div>
				        			<div class="col">
				          					<div class="col-mini-siderbar">
				            					<div class="col form-check form-switch float-left">
							                      	<input 
							                      		class="form-check-input"
								                        name="destatado" 
								                        type="checkbox" 
								                        id="destatado" 
								                        {!! $tipologia->destetado?"checked":"" !!}>
							                        	<label class="form-check-label" for="destatado">¿Destetado?</label>
				                      			</div>
				                      			<div class="col form-check form-switch float-left">
							                        <input 
								                        class="form-check-input"
								                        name="prenada" 
								                        type="checkbox" 
								                        id="prenada"
								                        {!! $tipologia->prenada?"checked":"" !!}>
								                        <label class="form-check-label" for="destatado">¿Preñada? o ¿Reproduce?</label>
				                      			</div>
				                      			<div class="col form-check form-switch float-left">
							                        <input 
								                        class="form-check-input"
								                        name="parida" 
								                        type="checkbox" 
								                        id="parida" 
								                        {!! $tipologia->parida?"checked":"" !!}>
								                        <label class="form-check-label" for="destatado">¿Parida?</label>
				                    			</div>
				                    			<div class="col form-check form-switch float-left">
							                        <input 
								                        class="form-check-input"
								                        name="tienecria" 
								                        type="checkbox" 
								                        id="tienecria"
								                        {!! $tipologia->tienecria?"checked":"" !!}>
								                        <label class="form-check-label" for="destatado">¿Tiene Cría?</label>
				                    			</div>
				                  			</div>    
				        			</div> <!--/.col-->
				       				<div class="col">
				          					<div class="col-mini-siderbar label-activo">
				            					<div class="col form-check form-switch float-left">
							                        <input 
								                        class="form-check-input"
								                        name="criaviva" 
								                        type="checkbox" 
								                        id="criaviva"
								                        {!! $tipologia->criaviva?"checked":"" !!}>
								                        <label class="form-check-label" for="destatado">¿Cría está viva?</label>
				                      			</div>
				                     		 	<div class="col form-check form-switch float-left">
							                        <input 
								                        class="form-check-input"
								                        name="ordenho" 
								                        type="checkbox" 
								                        id="ordenho"
								                        {!! $tipologia->ordenho?"checked":"" !!}>
								                        <label class="form-check-label" for="destatado">¿Está en Ordeño?</label>
				                     		 	</div>
				                     			<div class="col form-check form-switch float-left">
				                       				<input 
								                        class="form-check-input"
								                        name="detectacelo" 
								                        type="checkbox" 
								                        id="detectacelo"
								                        {!! $tipologia->detectacelo?"checked":"" !!}>
								                        <label class="form-check-label" for="destatado">¿Detecta Celo?</label>
				                      			</div>
				          					</div>
				        			</div> <!--/.col -->
	           					</div>
	    					</div> <!--/.col-->
	              		</div> <!--/.row -->
               	    </div><!-- /.card-body -->
              	    
              	    <div class="card-footer clearfix">
	              		<div class="co my-3">
	    					<button type="submit" class="btn alert-success aling-boton">
					          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
					            <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
					            <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
					          </svg> Guardar</button>
	        				<a href="{{ route('tipologia', $finca->id_finca) }}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
		        			<path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
		      				</svg> 
		      				volver</a>
	  					</div>          
				    </div>
					</form> <!--/.form -->
				</div> <!--/.form-registro -->
        	</div><!-- /.card-->
    	</div> <!--/.col1-->
	</div> <!--row -->
	<div class="row my-2">
  		<div class="col"> 
    		<div role="tabpanel">
			    <ul class="nav nav-tabs" role="tablist">
			      <li class="nav-item title-tipo" role="presentation">
			        <a class="nav-link active" href="#seccion1" arial-controls="seccion1" data-toggle="tab" role="tab">Listado de Tipología</a>
			      </li>
			      <li class="nav-item title-tipo" role="presentation">
			        <a class="nav-link" href="#seccion2" arial-controls="seccion2" arial-controls="" data-toggle="tab" role="tab">Parámetros Tipológicos</a>
			      </li>
			    </ul>
    			<div class="tab-content">
      				<div class="tab-pane active" role="tabpanel" id="seccion1">
        				<table id="listipo" class="table table-tipologia">
			              	<thead class="bck-ground">
			                  <tr>
			                    <th scope="col">Tipología</th>
			                    <th scope="col">Nomenclatura</th>
			                    <th scope="col">Descripción</th>
			                  </tr>
			              	</thead>
		                <tbody>
		                  <tr>
		                    <td>
		                      {{ $tipologia->nombre_tipologia}}
		                    </td>
		                    <td>
		                      {{ $tipologia->nomenclatura}}
		                    </td>
		                    <td>
		                       {{ $tipologia->descripcion}}
		                    </td>           
		                    
		                  </tr>
		                </tbody>
            			</table>
      				</div>
     				<div class="tab-pane" role="tabpanel" id="seccion2">
        			<table id="parmtipo" class="table table-tipologia">
            <thead class="bck-ground">
                <tr>
                  <th scope="col">Edad</th>
                  <th scope="col">Peso</th>
                  <th scope="col">Nro.Monta</th>
                  <th scope="col">Sexo</th>
                  <th scope="col">¿Destetado?</th>
                  <th scope="col">¿Preñada/Reproduce?</th>
                  <th scope="col">¿Parida</th>
                  <th scope="col">¿Tiene Cría?</th>
                  <th scope="col">¿Cría está viva?</th>
                  <th scope="col">¿Está en ordeño?</th>
                  <th scope="col">¿Detecta celo?</th>
                </tr>
             </thead>
          <tbody>
                <tr>
                  <td>
                    {{ $tipologia->edad}}
                  </td>
                  <td>
                    {{ $tipologia->peso}}
                  </td>
                  <td>
                    {{ $tipologia->nro_monta}}
                  </td>
                  <td>
                     {{ $tipologia->sexo}}
                  </td>
                  <td>
                     {{ $tipologia->destetado}}
                  </td>  
                   <td>
                     {{ $tipologia->prenada }}
                  </td> 
                  <td>
                     {{ $tipologia->parida }}
                  </td>          
                  <td>
                     {{ $tipologia->tienecria }}
                  </td>        
                  <td>
                     {{ $tipologia->criaviva }}
                  </td>     
                  <td>
                     {{ $tipologia->ordenho }}
                  </td>     
                  <td>
                     {{ $tipologia->detectacelo }}
                  </td>
                 </tr>     
                
              </tbody>    
      </table>
      </div>
    </div>
    </div>
  </div>
</div>

</div><!-- /.container-->	
@stop

@section('css')
<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  	
  	<link rel="stylesheet" href="/css/bootstrap5/css/bootstrap.min.css">
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
