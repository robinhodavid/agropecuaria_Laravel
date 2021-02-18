@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
	<div class="row">
		<div class="col"> <!-- Col1 -->
			<div class="card">
              	<div class="card-header">
              		<div class="row">
                	 	<div class=" col title-header">Editando la Ficha de Gando.: {{ $serie->serie }}</div>
                	 </div>
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
	            <div class="card-body">
	              	<div class="form-registro">
	              	<form action="{{ route('fichaganado.update', [$serie->serie,$finca->id_finca]) }}" method="POST">
		        @method('PUT')
		        @csrf
		        @error('serie')
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <span>
            <strong>¡Atención! </strong>El campo Serie es obligatorio o <strong>Ya existe</strong>
          </span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @enderror
        @error('sexo')
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <span>
            <strong>Atención! </strong>El campo sexo es requerido.
          </span>         
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @enderror
        @error('fnac')
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <span>
            <strong>Atención! </strong>El campo Fecha de Nacimiento es requerido.
          </span>         
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @enderror
        @error('tipologia')
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <span>
            <strong>Atención! </strong>El campo Tipología es requerido
          </span>         
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @enderror
        @error('raza')
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <span>
            <strong>Atención! </strong>El campo Raza es requerido.
          </span>         
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @enderror
        @error('condicion_corporal')
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <span>
            <strong>Atención! </strong>El campo Condición Corporal es requerido.
          </span>         
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @enderror
        @error('fecr')
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <span>
            <strong>Atención! </strong>El campo Fecha de Registro es requerido.
          </span>         
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @enderror
		<div class="row">
		    <div class="col-5">
		        <div class="col-mini-siderbar label-serie text-center my-2">
		          	<label>Serie Nro.:</label>
		           	<input 
		                class="form-control text-center" 
		                id="serie" 
		                type="text" 
		                name="serie"  
		                readonly="true" 
		                value="{{ $serie->serie }}">
		        </div>
          		<div class="col-mini-siderbar label-activo">
            		<div class="form-check form-switch">
	             	<input 
			            class="form-check-input"
			            name="status" 
			            type="checkbox" 
			            id="status" 
			            {!! $serie->status?"checked":"" !!}
			            >
	              	<label class="form-check-label" for="status">Activo</label>
           			</div>
          		</div>  
          		<div class="col-mini-siderbar label-tipologia">
            		<label>Tipología</label>  
            		<label class="col-form-label">Tipología:</label>
			       {!! Form::select('tipologia',[$serie->id_tipologia=>$serie->tipo],null,['id'=>'tipologia' ,'class'=>'form-select']) !!}
			    </div>
         		<div class="col-mini-siderbar label-lote-estrategic">
        			<label class="col-form-label">Lote Estratégico:</label>
		            <select class="form-select" name="lote" aria-label="select example">
		                <option value="" selected>Seleccione una opción</option>
		                <option value="{{ $serie->nombrelote }}" selected>{{ $serie->nombrelote }}</option>
		                @foreach ($lote as $item)
		                <option value="{{ $item->nombre_lote }}">{{ $item->nombre_lote }}
		                    </option>
		              @endforeach()
		            </select>   
          		</div>
	       		<div class="row">
	            <div class="col-mini-siderbar col">   
	                <label class="col-form-label">Edad:</label>
	                    <input 
	                    	class="form-control" 
	                    	id="edad" 
	                    	type="text" 
	                    	name="edad"  
	                    	readonly="true" 
	                    	value="{{ $serie->edad }}">
	          	</div>
	          	<div class="col-mini-siderbar col">
	                <label class="col-form-label">Nro. Monta</label>
	                    <input 
		                  	class="form-control" 
		                  	id="nro_monta" 
		                  	type="text" 
		                  	name="nro_monta"  
		                  	readonly="true" 
		                  	value="{{ $serie->nro_monta }}"> 
	           </div>
	        </div>
			</div>
          		<div class="col">
          			<div class="row">
	          			<div class="col">
	          				<label class="col-form-label">Sexo:</label>
			                <select class="form-select" name="sexo" id="sexo" aria-label="select example">
			                    <option value="">Seleccione una opción</option>
			                    <option value="0" {!! $serie->sexo?"":"selected" !!} >Hembra</option>
			                    <option value="1"{!! $serie->sexo?"selected":"" !!} >Macho</option>
			                </select>
	          			</div>
	          			<div class="col">
	          				<label class="col-form-label">Raza:</label>
			                 	<select class="form-select" name="raza" aria-label="select example">
			                      <option value="">Seleccione una opción</option>
			                          @foreach ($serieraza as $item)
			                            <option value="{{ $item->idraza }}" selected> {{ $item->descripcion." (".$item->nombreraza.")" }} </option>
			                          @endforeach() 
			                          @foreach ($raza as $item)
			                            <option value="{{ $item->idraza }}">{{ $item->descripcion." (".$item->nombreraza.")" }}
			                              </option>
			                          @endforeach() 
			                	</select> 
	          			</div>	
	          		<div class="row">
	               		<div class="col">
	               			<label class="col-form-label">Fec. Nac.:</label>
		           			<div class="input-group mb-3">
		               			<input 
				                	type="date" 
				                    name="fnac"
				                    class="form-control" 
				                    min="1980-01-01" 
				                    max="2031-12-31"
				                    value="{{ $serie->fnac }}"
				                    aria-label="Recipient's username" aria-describedby="basic-addon2">
		                  			<span class="input-group-text" id="basic-addon2">
			                      	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
			                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
			                        <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
			                      	</svg>
			                  		</span>
		              		</div>          
	               		</div>
			               		<div class="col">
			               			 <label class="col-form-label">Fec. Registro:</label>
				              			<div class="input-group mb-3">
				                  			<input 
								                type="date" 
								                name="fecr"
								                class="form-control"
								                value="{{ $serie->fecr }}" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="Recipient's username" aria-describedby="basic-addon2">
							                 	<span class="input-group-text" id="basic-addon2">
								                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
								                      <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
								                      <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
								                    </svg>
							                	</span>
				              			</div>   	
			               		</div>
			               		<div class="col">
			               			<label class="col-form-label">Condición corporal:</label>
			                    <select class="form-select" name="condicion_corporal" aria-label="select example">
			                        <option value="">Seleccione una opción</option>
			                        @foreach ($seriecondicion as $item)
			                            <option value="{{ $item->id_condicion }}" selected> {{ $item->nombre_condicion }} </option>
			                        @endforeach() 
			                        @foreach ($condicion_corporal as $item)
			                            <option value="{{ $item->id_condicion }}">{{ $item->nombre_condicion }}
			                            </option>
			                        @endforeach() 
			                    </select>   
			               		</div>
			               </div>	
              		</div>	
              		<div class="row">
              				<div class="col">
              					 <label class="col-form-label">Cod. Madre</label>
			                  <input 
				                  class="form-control text-input" 
				                  id="codmadre" 
				                  type="text" 
				                  name="codmadre"  
				                  placeholder="Serie Madre" 
				                  value="{{ $serie->codmadre }}">	
              				</div>
      
              				<div class="col">
              					<div class="row">
              					<div class="col">
                    				<label class="col-form-label">Cod. Padre</label>
                				</div>
                				<div class="col">		
	                        		<div class="form-check form-switch">
	                        			<input class="form-check-input form-check-input-paju"
					                        type="checkbox" 
					                        id="espajuela"
					                        name="espajuela"
					                        {!! $serie->espajuela?"checked":"" !!}
					                        >
	                        			<label class="col-form-label" for="espajuela">¿Es Pajuela?</label>
	                   				</div>
                   				</div>
                   				</div>
                   				<select class="form-select" id="pajuela" name="pajuela" aria-label="select example">
			                    	<option value="" selected>Seleccione una opción</option>
				                    @foreach ($pajuela as $item)
				                    <option value="{{ $item->serie }}">{{ $item->serie }}</option>
				                    @endforeach()
                				</select>
              					<select class="form-select" id="seriepadre" name="seriepadre" aria-label="select example">
				                    <option value="" selected>Seleccione una opción</option>
				                    @foreach ($serietoro as $item)
				                      <option value="{{ $item->codpadre }}">{{ $item->codpadre }}</option>
				                    @endforeach()
				              	</select> 
                			</div>
	              	</div>
	              	<div class="row">
	              		  <div class="col">
            <label class="col-form-label">Observación:</label>
                <input 
                class="form-control text-area" 
                id="observa" 
                type="text"
                name="observa"
                maxlength="130"                   
                value="{{ $serie->observa }}">  
              </div>
	              	</div>
          		</div>	
		    </div>
	    </div>
	   </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
          	 <button type="submit" class="btn alert-success mb-2 float-right">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
      </svg> Guardar</button>

      <a href="{{ route('ficha', $finca->id_finca) }}" class="btn btn-warning float-right mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
      </svg> volver</a> 
          </div>
      </form>
	</div>
</div>
</div>
<div class="row">
		<div class="col-md-6">
			<div class="card">
	              <div class="card-header">
	              	<div class="row">
	              		<div class="col-md-4">
	              			<div class=" col title-header">Parámetros de Peso</div>
	              		</div>
	              		<div class="col-md-8">
	              			<a href="{{ route ('pesoespecifico.mostrar', [$finca->id_finca, $serie->serie] ) }}" class="enlace my-2  float-right" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-check" viewBox="0 0 16 16">
				          <path d="M10.854 7.854a.5.5 0 0 0-.708-.708L7.5 9.793 6.354 8.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
				          <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/> </svg> Registro de peso </a>  
	              		</div>
	              	</div>
	                
	              </div>
	              <!-- /.card-header -->
	              <div class="card-body">
	              	<div class="row">
				        <div class="col-mini-siderbar col">
				            <label class="col-form-label">Peso Inicial:</label>
				                <input 
				                  class="form-control" 
				                  id="pesoi" 
				                  type="text" 
				                  name="pesoi"  
				                  readonly="true" 
				                  value="{{ $serie->pesoi }}">     
				        </div>
			          	<div class="col-mini-siderbar col">
			             	<label class="col-form-label">Peso Actual:</label>
			                  	<input 
				                  class="form-control" 
				                  id="pesoactual" 
				                  type="text" 
				                  name="pesoactual"  
				                  readonly="true" 
				                  value="{{ $serie->pesoactual }}">     
			          	</div>
        			</div>
        			<div class="row">
				        <div class="col-mini-siderbar col">
				              <label class="col-form-label">Peso Destete:</label>
				                  <input 
				                  class="form-control" 
				                  id="pesodestete" 
				                  type="text" 
				                  name="pesodestete"  
				                  readonly="true" 
				                  value="{{ $serie->pesodestete }}">     
				          </div>
				          <div class="col-mini-siderbar col">
				              <label class="col-form-label">GDP:</label>
				                  <input 
				                  class="form-control" 
				                  id="ultgdp" 
				                  type="text" 
				                  name="ultgdp"  
				                  readonly="true" 
				                  value="{{ $serie->ultgdp }}">     
				          </div>
				    </div>	
	              </div>
	              <!-- /.card-body -->
	              <div class="card-footer clearfix">

	              </div>
	        </div> <!--Col2 -->
		</div>
		<div class="col-md-6">
			<div class="card">
	              <div class="card-header">
	                <div class=" col title-header">Parámetros Tipológicos</div>
	              </div>
	              <!-- /.card-header -->
	              <div class="card-body">
	              	    <div class="row">
          					<div class="col-mini-siderbar label-activo">
            					<div class="form-check form-switch">
              						<input 
						              class="form-check-input"
						              name="destatado" 
						              type="checkbox" 
						              id="destatado" 
						              disabled
						              {!! $serie->destatado?"checked":"" !!}
						              >
              						<label class="form-check-label" for="destatado">¿Destetado?</label>
            					</div>
            				<div class="form-check form-switch">
						            <input 
						              class="form-check-input"
						              name="prenada" 
						              type="checkbox" 
						              id="prenada"
						              disabled
						              {!! $serie->prenada?"checked":"" !!}
						              >
              						<label class="form-check-label" for="destatado">¿Preñada? o ¿Reproduce?</label>
           					</div>
           					<div class="form-check form-switch">
						            <input 
						              class="form-check-input"
						              name="parida" 
						              type="checkbox" 
						              id="parida"
						              disabled 
						              {!! $serie->parida?"checked":"" !!}
						              >
              						<label class="form-check-label" for="destatado">¿Parida?</label>
            				</div>
            				<div class="form-check form-switch">
						              <input 
						              class="form-check-input"
						              name="tienecria" 
						              type="checkbox" 
						              id="tienecria"
						              disabled 
						              {!! $serie->tienecria?"checked":"" !!}
						              >
              						<label class="form-check-label" for="destatado">¿Tiene Cría?</label>
            				</div>
            				<div class="form-check form-switch">
						            <input 
						              class="form-check-input"
						              name="criaviva" 
						              type="checkbox" 
						              id="criaviva"
						              disabled 
						              {!! $serie->criaviva?"checked":"" !!}
						              >
              						<label class="form-check-label" for="destatado">¿Cría está viva?</label>
            				</div>
           					<div class="form-check form-switch">
						            <input 
						              class="form-check-input"
						              name="ordenho" 
						              type="checkbox" 
						              id="ordenho"
						              disabled 
						              {!! $serie->ordenho?"checked":"" !!}
						              >
              						<label class="form-check-label" for="destatado">¿Está en Ordeño?</label>
            				</div>
            				<div class="form-check form-switch">
					              	<input 
						              class="form-check-input"
						              name="detectacelo" 
						              type="checkbox" 
						              id="detectacelo"
						              disabled 
						              {!! $serie->detectacelo?"checked":"" !!}
						              >
              						<label class="form-check-label" for="destatado">¿Detecta Celo?</label>
            				</div>
         					</div>  
   					 </div>
	            </div>
	              <!-- /.card-body -->
	              <div class="card-footer clearfix">

	              </div>
	        </div> <!--Col2 -->
		</div>
</div>
<div class="row">
		<div class="col">
			<div class="card">
	              <div class="card-header">
	                <div class=" col title-header">Árbol de Descendencia </div>
	              </div>
	              <!-- /.card-header -->
	              <div class="card-body">
	              	 <div class="row my-3">
      <!--Hijo -->
      <div class="col">
        
        <div class="row hijo div-vacio">
          
        </div>  
        <div class="row div-vacio">
                  
          </div>
          <div class="row div-vacio">
                  
          </div>
          <div class="row div-vacio">
                  
          </div>
          <div class="row div-vacio">
                  
          </div>
          <div class="row div-vacio">
                  
          </div>
          <div class="row div-vacio">
                  
          </div>
          <div class="row div-vacio">
                  
          </div>
          <div class="row div-vacio">
                  
          </div>
          <div class="row div-vacio">
                  
          </div>

          <div class="row hijo nodo">
          <label for="hijo">Serie (Hijo).: {{$serie->serie}}</label>
        </div>  
        <div class="row div-vacio">
                  
          </div>
         <div class="row div-vacio">
                  
          </div>
        <div class="row div-vacio">
                  
          </div>
          <div class="row div-vacio">
                  
          </div>
          <div class="row div-vacio">
                  
          </div>
          <div class="row div-vacio">
                  
          </div>
          <div class="row div-vacio">
                  
          </div>
      </div>
      <!--padres -->
        <div class="col">
        
          <div class="row div-vacio">
              
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
          
        <div class="row nodo">
            <label for="padre">Serie Padre.: 
              <a href="#"> {{$serie->codpadre}}</a> 
            </label>
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
            
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row nodo">
            <label for="madre">Serie Madre.: 
              <a href="#">{{$serie->codmadre}}</a> 
            </label>
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
      </div>
      <!--abuelos -->
        <div class="col">
          <div class="row div-vacio">
            
          </div>
            
          <div class="row nodo">
            @foreach($codabuelopaterno as $item)
            <label for="abuelo">Serie Padre.:
              <a href="#">{{$item->codpadre}}</a>
             </label>
             @endforeach()
          </div>
            
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
            </div>
            <div class="row div-vacio">
                
            </div>
            <div class="row nodo">  
            @foreach($codabuelapaterna as $item)
              <label for="madre">Serie Madre.:  
                <a href="#"> {{$item->codpadre}}</a> 
              </label>
            @endforeach()
            </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
            <div class="row nodo">
            @foreach($codabuelomaterno as $item)
              <label for="padre">Serie Padre.:
                <a href="#">{{$item->codpadre}}</a>
              </label>  
            @endforeach()
            </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
        <div class="row div-vacio">
                
          </div>
            <div class="row nodo">    
            @foreach($codabuelamaterna as $item)  
              <label for="madre">Serie Madre.: 
                <a href=""> {{$item->codmadre}} </a> 
              </label>
            @endforeach()
            </div>  
          <div class="row div-vacio">
                
          </div>
      </div>
      <!--Bisabuelos -->
        <div class="col">
          <div class="row nodo">
            @foreach($codbisabuelospaternospadre as $item)
            <label for="padre">Serie Padre.:
             <a href="#">{{ $item->codpadre }}</a>
            </label>
            @endforeach()
          </div>
          <div class="row div-vacio">
          </div>
          <div class="row nodo">
            @foreach($codbisabuelospaternospadre as $item)
              <label for="madre">Serie Madre.:
               <a href="#">{{ $item->codmadre }}</a>
              </label>
            @endforeach()
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row nodo">
            @foreach($codbisabuelospaternomadre as $item)
            <label for="padre">Serie Padre.: <a href="#">{{ $item->codpadre }}</a></label>
            @endforeach()
          </div>
          <div class="row div-vacio">
              
          </div>
          <div class="row nodo">
            @foreach($codbisabuelospaternomadre as $item)
            <label for="madre">Serie Madre.: <a href="#">{{ $item->codmadre }}</a></label>
            @endforeach()
          </div>
          
          <div class="row div-vacio">
                
          </div>
          <div class="row div-vacio">
                
          </div>
          <div class="row nodo">
          @foreach($codbisabuelosmaternospadre as $item)
          <label for="padre">Serie Padre.: 
            <a href="#">{{ $item->codpadre }}</a>
          </label>
          @endforeach()
          </div>
          <div class="row div-vacio">   
          </div>
          <div class="row nodo">
            @foreach($codbisabuelosmaternospadre as $item)
            <label for="madre">Serie Madre.: <a href="#">{{ $item->codmadre }}</a></label>
            @endforeach()
          </div>
          <div class="row div-vacio">
          </div>
            
            <div class="row nodo">
            @foreach($codbisabuelosmaternomadre as $item)
              <label for="padre">Serie Padre.:<a href="">
                {{ $item->codpadre }}
              </a></label>
            @endforeach()
            </div>
            <div class="row div-vacio">
                
            </div>
            <div class="row nodo">
            @foreach($codbisabuelosmaternomadre as $item) 
              <label for="padre">Serie Madre.:<a href="">
                {{ $item->codmadre }} 
              </a></label>  
            @endforeach()
            </div>
        </div>
      </div>

	              </div>
	              <!-- /.card-body -->
	              <div class="card-footer clearfix">

	              </div>
	        </div> <!--Col2 -->
		</div>
</div>
</div>
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

@stop
