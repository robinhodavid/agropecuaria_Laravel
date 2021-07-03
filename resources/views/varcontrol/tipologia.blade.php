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
		          	<form action="{{ route('tipologia.crear', $finca->id_finca) }}" method="POST">
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
					                      value="{{ old('nombre_tipologia') }}">
                					<label class="my-2">Nomenclatura:</label>
                  						<input 
						                  class="form-control" 
						                  id="nomenclatura" 
						                  type="text" 
						                  name="nomenclatura" 
						                  placeholder="Nomenclatura" 
						                  value="{{ old('nomenclatura') }}">
              						<label class="my-2">Descripción:</label>
				                      	<input 
					                      class="form-control" 
					                      id="descripcion" 
					                      type="text" 
					                      name="descripcion"  
					                      placeholder="Descripción de Tipología" 
					                      value="{{ old('descripcion') }}">    
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
								                    value="{{ old('edad') }}"
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
								                    value="{{ old('peso') }}"
								                    min="0">
								        </div>

								        <div class="col-4">
								          <label class="my-2">Nro. Monta:</label>
								                  <input 
								                  class="form-control" 
								                  id="nro_monta" 
								                  type="number" 
								                  name="nro_monta"  
								                  placeholder="Nro de Monta" 
								                  value="{{ old('nro_monta') }}"
								                  min="0" pattern="^[0-9]+">
								        </div>  
  									</div> <!--/.row -->

  									<div class="row my-4"> 
								        <div class="col-2 my-2 col-parm">
								          	<input 
								                  type="radio" 
								                  aria-label="Radio button for following text input"
								                  name="sexo"
								                  id="sexo_hermbra" value="0" checked>
								                  <label class="checkbox-inline"  for= "sexo">Hembra</label>
								                  <input 
								                  type="radio" 
								                  aria-label="Radio button for following text input"
								                  name="sexo"
								                  id="sexo_macho" value="1">
								                  <label class="checkbox-inline"  for="sexo">Macho</label>
								        </div> <!-- /.col-2 -->
								        <div class="col">
								          	<div class="col-mini-siderbar">
								            	<div class="col form-check form-switch float-left">
								                    <input 
								                      class="form-check-input"
								                        name="destatado" 
								                        type="checkbox" 
								                        id="destatado" 
								                        >
								                        <label class="form-check-label" for="destatado">¿Destetado?</label>
								                </div>

								                <div class="col form-check form-switch float-left">
								                    <input 
								                        class="form-check-input"
								                        name="prenada" 
								                        type="checkbox" 
								                        id="prenada"
								                        >
								                        <label class="form-check-label" for="destatado">¿Preñada? o ¿Reproduce?</label>
								                </div>

								                <div class="col form-check form-switch float-left">
								                    <input 
								                        class="form-check-input"
								                        name="parida" 
								                        type="checkbox" 
								                        id="parida" 
								                        >
								                        <label class="form-check-label" for="destatado">¿Parida?</label>
								                </div>

								                <div class="col form-check form-switch float-left">
								                    <input 
								                        class="form-check-input"
								                        name="tienecria" 
								                        type="checkbox" 
								                        id="tienecria"
								                        >
								                        <label class="form-check-label" for="destatado">¿Tiene Cría?</label>
								                </div>
								            </div>    
								        </div><!--/.col -->

								        <div class="col">
								          	<div class="col-mini-siderbar label-activo">
								            	<div class="col form-check form-switch float-left">
								                    <input 
								                        class="form-check-input"
								                        name="criaviva" 
								                        type="checkbox" 
								                        id="criaviva"
								                        >
								                    <label class="form-check-label" for="destatado">¿Cría está viva?</label>
								            	</div>
								                <div class="col form-check form-switch float-left">
								                    <input 
								                        class="form-check-input"
								                        name="ordenho" 
								                        type="checkbox" 
								                        id="ordenho"
								                        >
								                	<label class="form-check-label" for="destatado">¿Está en Ordeño?</label>
								                </div>
								                <div class="col form-check form-switch float-left">
								                        <input 
								                        class="form-check-input"
								                        name="detectacelo" 
								                        type="checkbox" 
								                        id="detectacelo"
								                        >
								                        <label class="form-check-label" for="destatado">¿Detecta Celo?</label>
								                </div>
								          	</div>
								        </div> <!--/.col -->
       							 	</div> <!--row-->
							</div> <!--/.col--> 
	              		</div>
	              	</div> <!--/.row -->
               	    </div><!-- /.card-body -->
              	    <div class="card-footer clearfix">
              		<div class="co my-3">
    					<button type="submit" class="btn alert-success aling-boton">
      						<i class="far fa-save"></i> 
        					Registrar
        				</button>
        			<a href="{{ route('admin',$finca->id_finca) }}" class="btn btn-warning aling-boton"><i class="fas fa-arrow-left"></i>
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
			                    	<th scope="col">Acción</th>
				                	</tr>
				            </thead>
                			<tbody>
                			@foreach ($tipologia as $item)
		                  		<tr>
				                    <td>
				                      {{ $item->nombre_tipologia}}
				                    </td>
				                    <td>
				                      {{ $item->nomenclatura}}
				                    </td>
				                    <td>
				                       {{ $item->descripcion}}
				                    </td>           
		                    		<td>
				                      	<a href="{{ route('tipologia.editar', [$finca->id_finca, $item->id_tipologia]) }}" class="btn alert-success btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
				                      	<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
				                 	 	 <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
				                  	  	</svg> </a>
                    					<form action="{{ route('tipologia.eliminar', [$finca->id_finca, $item->id_tipologia]) }}" class="d-inline form-delete" method="POST">
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
              @foreach ($tipologia as $tipo)
                <tr>
                  <td>
                    {{ $tipo->edad}}
                  </td>
                  <td>
                    {{ $tipo->peso}}
                  </td>
                  <td>
                    {{ $tipo->nro_monta}}
                  </td>
                  <td>
                     {{ $tipo->sexo}}
                  </td>
                  <td>
                     {{ $tipo->destetado}}
                  </td>  
                   <td>
                     {{ $tipo->prenada }}
                  </td> 
                  <td>
                     {{ $tipo->parida }}
                  </td>          
                  <td>
                     {{ $item->tienecria }}
                  </td>        
                  <td>
                     {{ $item->criaviva }}
                  </td>     
                  <td>
                     {{ $item->ordenho }}
                  </td>     
                  <td>
                     {{ $item->detectacelo }}
                  </td>
                 </tr>     
                @endforeach()
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
   {!! Html::script('js/jquery-3.5.1.min.js')!!}
  	{!! Html::script('js/dropdown.js')!!}
  	{!! Html::script('js/sweetalert2.js')!!}	

   @if(session('mensaje')=='ok')
	  	<script>
	  		Swal.fire({
				title: '¡Eliminado!',
				text:  'Registro Eliminado Satisfacoriamente',
				icon:  'success'
			})
	  	</script>
	@endif
	@if (session('mensaje')=='error')
	  	<script>
	  		Swal.fire({
				text:'Está siendo usado por otro recurso',
				icon: 'error',
				title:'¡No Eliminado!'
			})
	  	</script>
  	@endif
    
    <script>
    
    $('.form-delete').submit(function(e){
    	e.preventDefault();
	    Swal.fire({
			title:'¿Está seguro que desea Eliminar el Registro?',
			text:"Este cambio es irreverible",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Eliminar',
			cancelButtonText: 'Cancelar'
		}).then((result)=>{
			if (result.value){
				this.submit();
			}
		})
    });	
    </script>  
  

@stop
