@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
  <div class="row"> <!-- Datos de Preñez-->
    <div class="col-md-12"> <!-- Col1 -->
      <div class="card">
        <form action="{{ route('parto.crear', [$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo, $series->id]) }}" method="POST" class="form-trans">
        @csrf
        <div class="card-header">
        	<div class="col">
        		<h3 class="card-title title-header">Registro de Parto</h3>		
        	</div>
        	<div class="col">
        		<div class="form-check aling-boton my-2">
        			<label class="col-form-label mr-3">Método de Preñez:</label>
	              	<input 
	                  type="radio" 
	                  aria-label="Radio button for following text input"
	                  name="metodo_prenez"
	                  id="inseminacion" 
	                  readonly="true" 
                    value="{{$servicioActivo}}" 
	                  {!! $servicioActivo?"checked":"" !!}>
	                  
	                  <label class="checkbox"  for= "metodo_prenez">Inseminación Artificial / Monta Natural Controlada</label>
	              	<input 
	                  type="radio" 
	                  aria-label="Radio button for following text input"
	                  name="metodo_prenez"
	                  id="monta_natural"
                    readonly="true"
                    value="{{$servicioActivo}}"
	                  {!! $servicioActivo?"":"checked" !!}>
	                  <label class="checkbox"  for="metodo_prenez">Monta Natural (Libre)</label>
	           </div>	
        	</div>
        </div>
          <!-- /.card-header -->
          <div class="card-body">
              <div class="row">
                <div class="col oculto">
                  <label class="col-form-label oculto">idSerie:</label>
                        <input 
                        class="form-control oculto" 
                        id="idserie" 
                        type="text" 
                        name="idserie"
                        readonly="true" 
                        value="{{$series->id}}">   
                </div>
                <div class="col oculto">
                  <label class="col-form-label oculto">tgesta:</label>
                        <input 
                        class="form-control oculto" 
                        id="tgesta" 
                        type="text" 
                        name="tgesta"
                        readonly="true" 
                        value="{{$tgesta}}">   
                </div>
                <div class="col oculto">
                  <label class="col-form-label oculto">tsecado:</label>
                        <input 
                        class="form-control oculto" 
                        id="tsecado" 
                        type="text" 
                        name="tsecado"
                        readonly="true" 
                        value="{{$tsecado}}">   
                </div>
                <div class="col">
                  <label class="col-form-label">Serie:</label>
                        <input 
                        class="form-control" 
                        id="serie" 
                        type="text" 
                        name="serie"
                        readonly="true" 
                        value="{{$series->serie}}">   
                </div>
                <div class="col">
                  <label class="col-form-label">Fec. Nac.:
                  </label>
                  <div class="input-group mb-3">
                  <input 
                  type="text" 
                  name="fnac"
                  id="fnac"
                  min="1980-01-01" 
                  max="2031-12-31"
                  class="form-control" 
                  readonly="true"
                  value="{{$series->fnac}}"
                  title="{{$series->fnac}}"
                  aria-label="fnac" aria-describedby="basic-addon2">
                  <span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
                  <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                  <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                  </svg></span></div>
                </div>
                <div class="col">
                  <label class="col-form-label">Edad (A-M):</label>
                        <input 
                        class="form-control" 
                        id="edad" 
                        type="text" 
                        name="edad"
                        readonly="true"
                        value="{{$edad}}">   
                </div>
                <div class="col">
                  <label class="col-form-label">Raza:</label>
                        <input 
                        class="form-control" 
                        id="raza" 
                        type="text" 
                        name="raza"
                        readonly="true"
                        value="{{$raza->nombreraza}}">   
                </div>
                <div class="col">
                  <label class="col-form-label">Peso Actual:</label>
                        <input 
                        class="form-control" 
                        id="pesoactual" 
                        type="text" 
                        name="pesoactual"
                        readonly="true" 
                        value="{{$series->pesoactual}}">
                </div>
              </div>
            <div class="row">
            	<div class="col">
                  <label class="col-form-label">Condición Corporal:</label>
                        <input 
                        class="form-control" 
                        id="condicorpo" 
                        type="text" 
                        name="condicorpo"
                        readonly="true"
                        value="{{$condicorpo->nombre_condicion}}">   
              </div>
            <div class="col">
    	  				<label class="col-form-label">Fec. Ultimo Servicio:</label>
    				    	<div class="input-group mb-3">
    						  	<input 
    						  	type="date" 
    						  	id="fecus"
    						  	name="fecus"
    						  	min="1980-01-01" 
    					  		max="2031-12-31"
    						  	class="form-control" 
    						  	readonly="true"
    						  	value="{{$series->fecus}}"
                                title="{{$series->fecus}}"
    						  	aria-label="fecu" aria-describedby="basic-addon2">
    							<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
    							<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
    							<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
    							</svg></span>
    						</div>
	  			</div>
		        <div class="col">
	  				<label class="col-form-label">Fec. Ultimo Parto:</label>
				    	<div class="input-group mb-3">
						  	<input 
						  	type="date" 
						  	id="fecup"
						  	name="fecup"
						  	min="1980-01-01" 
					  		max="2031-12-31"
						  	class="form-control" 
						  	readonly="true"
						  	value="{{$series->fecup}}"
                            title="{{$series->fecup}}"
						  	aria-label="fecup" aria-describedby="basic-addon2">
							<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
							<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
							<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
							</svg></span>
						</div>
	  			</div>
	            <div class="col">
					<label class="col-form-label">IEEP:</label>
	              	<input 
	              	class="form-control" 
	              	id="ier" 
	              	type="text" 
	              	name="ier"
	              	readonly="true" 
	              	value="{{$ieep}}">
				</div>
				<div class="col">
					<label class="col-form-label">IDA:</label>
	              	<input 
	              	class="form-control" 
	              	id="ida" 
	              	type="text" 
	              	name="ida"
	              	readonly="true" 
	              	value="{{$ida}}">
				</div>
            </div>  
            <div class="row">
                <div class="col">
	                <label class="col-form-label">F. Estimada de Preñez:
	                </label>
                  <div class="input-group mb-3">
                    <input 
                    type="date" 
                    id="festipre"
                    name="festipre"
                    min="1980-01-01" 
                    max="2031-12-31"
                    class="form-control" 
                    readonly="true"
                    value="{{$festipre}}"
                    title="{{$festipre}}"
                    aria-label="festipre" aria-describedby="basic-addon2">
                    <span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                    <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                    </svg></span>
                </div>	
                </div>
                <div class="col">
                    <label class="col-form-label">F. Apróx de Secado:
                  	</label>
                  	<div class="input-group mb-3">
                    <input 
                    type="date" 
                    id="faprosecado"
                    name="faprosecado"
                    min="1980-01-01" 
                    max="2031-12-31"
                    class="form-control" 
                    readonly="true"
                    value="{{$faprosecado}}"
                    title="{{$faprosecado}}"
                    aria-label="faprosecado" aria-describedby="basic-addon2">
                    <span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                    <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                    </svg></span>
                  </div>
                </div>
                <div class="col">
                	<label class="col-form-label">F. Apróx de Parto:</label>
                  	<div class="input-group mb-3">
                    <input 
                    type="date" 
                    id="faproparto"
                    name="faproparto"
                    min="1980-01-01" 
                    max="2031-12-31"
                    class="form-control" 
                    readonly="true"
                    value="{{$faproparto}}"
                    aria-label="faproparto" aria-describedby="basic-addon2">
                    <span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                    <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                    </svg></span>
                  </div>
                </div>
                <div class="col">
                	<label class="col-form-label" id="labeldias">Días de Preñez:</label>
                        <input 
                        class="form-control" 
                        id="diaprenez" 
                        type="number" 
                        name="diaprenez"
                        min="0"
                        max="365"
                        readonly="true" 
                        value="{{$diasprenez}}"
                        > 
                    <label class="col-form-label" id="labelmeses">Meses de Preñez:</label>
                        <input 
                        class="form-control" 
                        id="mesesprenez" 
                        type="number" 
                        name="mesesprenez"
                        min="0"
                        max="12"
                        readonly="true"
                        value="{{$mesesprenez}}"
                        >     
                </div>
                  <div class="col">
                  <label class="col-form-label" id="labeldias">Nro.Parto:</label>
                        <input 
                        class="form-control" 
                        id="nroparto" 
                        type="number" 
                        name="nroparto"
                        min="0"
                        max="365"
                        readonly="true"
                        value="{{$series->npartorepor}}"
                        > 
                </div>
                <div class="col">
                   <label class="col-form-label" id="labelmeses">Nro. Aborto:</label>
                        <input 
                        class="form-control" 
                        id="nroaborto" 
                        type="number" 
                        name="nroaborto"
                        min="0"
                        max="12"
                        readonly="true"
                        value="{{$series->nabortoreport}}" 
                        >     
                </div>
            </div>
          </div>
          <!-- /.card-body -->
      </div>
  </div>
  <div class="row my-2">  
      <div class="col"> 
        <div role="tabpanel">
          <div class="form-group">
            <div class="custom-control custom-checkbox aling-boton">
              <input class="custom-control-input" name="tipoparto" type="checkbox" id="customCheckbox1">
              <label for="customCheckbox1" class="custom-control-label">Parto Morochos</label>
            </div>  
          </div>
          <h3 class="title-header">Ficha de Nacimiento</h3>
          <ul class="nav nav-tabs tab-cri" role="tablist">
            <li id="cria1" class="nav-item title-tipo" role="presentation">
              <a class="nav-link active" href="#seccion1" arial-controls="seccion1" data-toggle="tab" role="tab">Cría 1</a>
            </li>
            <li  id="cria2" class="nav-item title-tipo" role="presentation">
              <a class="nav-link" href="#seccion2" arial-controls="seccion2" arial-controls="" data-toggle="tab" role="tab">Cría 2</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" role="tabpanel" id="seccion1">
              <div class="col-md-12 my-2"> <!-- Col1 -->
                <div class="row">
                  <div class="form-check title-tipo">
                    <label class="col-form-label mr-3">Condición de Nacimiento:</label>
                    <input 
                      type="radio" 
                      aria-label="Radio button for following text input"
                      name="condicionnac1"
                      value="1"
                      id="vivo" 
                      checked>
                    <label class="checkbox"  for= "metodo_prenez">Vivo</label>
                    <input 
                      type="radio" 
                      aria-label="Radio button for following text input"
                      name="condicionnac1"
                      value="0"
                      id="muerto"
                      >
                      <label class="checkbox"  for="metodo_prenez">Muerto</label>
                  </div> 
                </div>
                <div class="card becerrovivo">
                  <div class="card-header">
                    <div class="form-check title-tipo">
                      <h3 class="title-header">Registro de Nacido Vivo</h3> 
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
                  @error('seriecria1')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Serie de la Cría es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  
                  @error('razacria1')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Raza de la Cría es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  @error('pesoicria1')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Peso de la Cría es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  @error('lotecria1')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Lote Estratégico es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  @error('condicorpocria1')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Condición Corporal es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  @error('fnac')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Fecha de Nacimiento es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label class="col-form-label title-tipo">Serie Cría: </label>
                            <input 
                              class="form-control" 
                              id="seriecria1" 
                              type="text" 
                              placeholder="Serie Cría"
                              name="seriecria1"
                              value=""
                             >
                        </div>
                        <div class="col">
                            <label class="col-form-label title-tipo">Sexo:</label>
                              <select class="form-select" name="sexocria1" 
                                id="sexo" aria-label="select example">
                                    <option value="0" selected>Hembra</option>
                                    <option value="1">Macho</option>
                              </select> 
                        </div>
                        <div class="col">
                            <label class="col-form-label">Color de Pelaje:</label>
                                <select class="form-select" name="colorpelaje" aria-label="select example">
                                <option value="" selected>Seleccione una opción</option>
                                @foreach ($colorpelaje as $item)
                                <option value="{{ $item->nombre }}">{{ $item->nombre}}
                                </option>
                                @endforeach()   
                                </select>  
                        </div>
                        <div class="col">
                            <label class="col-form-label title-tipo">Raza:</label>
                              <select class="form-select" name="razacria1" aria-label="select example">
                                <option value="" selected>Seleccione una opción</option>
                                @foreach ($razacria as $item)
                                <option value="{{ $item->nombreraza }}">{{ $item->descripcion." (".$item->nombreraza.")" }}
                                </option>
                                @endforeach() 
                              </select>  
                        </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <label class="col-form-label title-tipo">Peso Nac. (kg):</label>
                          <input 
                          class="form-control" 
                          id="pesoicria1" 
                          type="number" 
                          name="pesoicria1" 
                          min="0" 
                          step="any"
                          placeholder="Peso de Nacimiento" 
                          value=""> 
                      </div>
                      <div class="col">
                        <label class="col-form-label title-tipo">Lote Estratégico:</label>
                          <select class="form-select" name="lotecria1" aria-label="select example">
                            <option value="{{$series->nombrelote}}" selected>{{$series->nombrelote}}</option>
                            @foreach ($loteEstrategico as $item)
                                <option value="{{ $item->nombre_lote }}">{{ $item->nombre_lote }}
                                </option>
                              @endforeach()
                         </select> 
                      </div>
                      <div class="col">
                        <label class="col-form-label title-tipo">Condición Corporal:</label>
                        <select class="form-select" name="condicorpocria1" aria-label="select example">
                          <option value="" selected>Seleccione una opción</option>
                          @foreach ($condiCorpoCria as $item)
                          <option value="{{ $item->nombre_condicion }}">{{ $item->nombre_condicion }}
                          </option>
                          @endforeach() 
                        </select>
                      </div>
                      <div class="col">
                        <label class="col-form-label title-tipo">Fec. Nac.:</label>
                        <div class="input-group mb-3">
                          <input 
                          type="date" 
                          name="fnac"
                          min="1980-01-01" 
                          max="2031-12-31"
                          class="form-control" 
                          aria-label="fnac" aria-describedby="basic-addon2">
                          <span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
                          <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                          <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                          </svg></span>
                        </div>
                      </div> 
                    </div>
                    <div class="row">
                      <div class="col">
                        <label class="col-form-label title-tipo">Observación:</label>
                          <input 
                          class="form-control text-area" 
                          id="observa" 
                          type="text"
                          name="observa"
                          maxlength="180"                   
                          value="{{ old('observa') }}">
                      </div>  
                    </div>
                  </div> <!-- /.card-body -->
            
                </div>
                <div class="card becerromuerto"> <!-- Registro por Nacimiento Muerto -->
                  <div class="card-header">
                    <div class="form-check title-tipo">
                      <h3 class="title-header">Registro de Nacido Muerto</h3> 
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
                   @error('fnacmuerte')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Fecha de Nacido es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  @error('muerterazacria1')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Raza es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                   @error('causamuerte1')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Causa de Muerte es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  @error('observamuerte1')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Observacioón es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                      <label class="col-form-label title-tipo">Fec. Nac.:</label>
                      <div class="input-group mb-3">
                        <input 
                        type="date" 
                        name="fnacmuerte"
                        min="1980-01-01" 
                        max="2031-12-31"
                        class="form-control" 
                        aria-label="fnac" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                        <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                        </svg></span>
                      </div>
                    </div>
                    <div class="col">
                       <label class="col-form-label title-tipo">Raza:</label>
                        <select class="form-select" name="muerterazacria1" aria-label="select example">
                          <option value="" selected>Seleccione una opción</option>
                          @foreach ($razacria as $item)
                          <option value="{{ $item->nombreraza }}">{{ $item->descripcion." (".$item->nombreraza.")" }}
                          </option>
                          @endforeach() 
                        </select>  
                    </div>
                    <div class="col">
                        <label class="col-form-label title-tipo">Causa:</label>
                        <select class="form-select" name="causamuerte1" aria-label="select example">
                          <option value="" selected>Seleccione una opción</option>
                          @foreach ($causamuerte as $item)
                          <option value="{{ $item->nombre }}">{{ $item->nombre }}
                          </option>
                          @endforeach() 
                          
                        </select>  
                    </div> 
                    </div>
                    <div class="row">
                      <div class="col">
                        <label class="col-form-label title-tipo">Observación:</label>
                        <input 
                        class="form-control text-area" 
                        id="observamuerte1" 
                        type="text"
                        name="observamuerte1"
                        maxlength="180"                   
                        value="{{ old('observa') }}"> 
                      </div>
                    </div>
                  </div> <!-- /.card-body -->
                </div>
              </div>  
            </div>
            <div class="tab-pane" role="tabpanel" id="seccion2">
                <div class="col-md-12 my-2"> <!-- Col1 -->
                <div class="row">
                  <div class="form-check title-tipo">
                    <label class="col-form-label mr-3">Condición de Nacimiento:</label>
                    <input 
                      type="radio" 
                      aria-label="Radio button for following text input"
                      name="condicionnac2"
                      value="1"
                      id="vivo2" 
                      checked>
                    <label class="checkbox"  for= "metodo_prenez">Vivo</label>
                    <input 
                      type="radio" 
                      aria-label="Radio button for following text input"
                      name="condicionnac2"
                      value="0"
                      id="muerto2"
                      >
                      <label class="checkbox"  for="metodo_prenez">Muerto</label>
                  </div> 
                </div>
                <div class="card becerrovivo">
                  <div class="card-header">
                    <div class="form-check title-tipo">
                      <h3 class="title-header">Registro de Nacido Vivo</h3> 
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
                   @error('seriecria2')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Serie de la Cría es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  @error('sexocria2')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Sexo de la Cría es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  @error('razacria2')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Raza de la Cría es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  @error('pesoicria2')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Peso de la Cría es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  @error('lotecria2')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Lote Estratégico es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  @error('condicorpocria2')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Condición Corporal es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  @error('fnac2')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Fecha de Nacimiento es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <label class="col-form-label title-tipo">Serie Cría: </label>
                        <input 
                          class="form-control" 
                          id="seriecria2" 
                          type="text" 
                          placeholder="Serie Cría"
                          name="seriecria2"
                          value=""
                         >
                      </div>
                      <div class="col">
                        <label class="col-form-label title-tipo">Sexo:</label>
                          <select class="form-select" name="sexocria2" 
                            id="sexo" aria-label="select example">
                                <option value="0" selected>Hembra</option>
                                <option value="1">Macho</option>
                          </select> 
                      </div>
                        <div class="col">
                            <label class="col-form-label">Color de Pelaje:</label>
                                <select class="form-select" name="colorpelaje1" aria-label="select example">
                                <option value="" selected>Seleccione una opción</option>
                                @foreach ($colorpelaje as $item)
                                <option value="{{ $item->nombre }}">{{ $item->nombre}}
                                </option>
                                @endforeach()   
                                </select>  
                        </div>
                      <div class="col">
                        <label class="col-form-label title-tipo">Raza:</label>
                          <select class="form-select" name="razacria2" aria-label="select example">
                            <option value="" selected>Seleccione una opción</option>
                            @foreach ($razacria as $item)
                            <option value="{{ $item->nombreraza }}">{{ $item->descripcion." (".$item->nombreraza.")" }}
                            </option>
                            @endforeach() 
                          </select>  
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <label class="col-form-label title-tipo">Peso Nac. (kg):</label>
                          <input 
                          class="form-control" 
                          id="pesoicria2" 
                          type="number" 
                          name="pesoicria2" 
                          min="0" 
                          step="any"
                          placeholder="Peso de Nacimiento" 
                          value=""> 
                      </div>
                      <div class="col">
                        <label class="col-form-label title-tipo">Lote Estratégico:</label>
                          <select class="form-select" name="lotecria2" aria-label="select example">
                            <option value="{{$series->nombrelote}}" selected>{{$series->nombrelote}}</option>
                            @foreach ($loteEstrategico as $item)
                                <option value="{{ $item->nombre_lote }}">{{ $item->nombre_lote }}
                                </option>
                              @endforeach()
                         </select> 
                      </div>
                      <div class="col">
                        <label class="col-form-label title-tipo">Condición Corporal:</label>
                        <select class="form-select" name="condicorpocria2" aria-label="select example">
                          <option value="" selected>Seleccione una opción</option>
                          @foreach ($condiCorpoCria as $item)
                          <option value="{{ $item->nombre_condicion }}">{{ $item->nombre_condicion }}
                          </option>
                          @endforeach() 
                        </select>
                      </div>
                      <div class="col">
                        <label class="col-form-label title-tipo">Fec. Nac.:</label>
                        <div class="input-group mb-3">
                          <input 
                          type="date" 
                          name="fnac2"
                          min="1980-01-01" 
                          max="2031-12-31"
                          class="form-control" 
                          aria-label="fnac" aria-describedby="basic-addon2">
                          <span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
                          <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                          <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                          </svg></span>
                        </div>
                      </div> 
                    </div>
                    <div class="row">
                      <div class="col">
                        <label class="col-form-label title-tipo">Observación:</label>
                          <input 
                          class="form-control text-area" 
                          id="observa2" 
                          type="text"
                          name="observa2"
                          maxlength="180"                   
                          value="{{ old('observa') }}">
                      </div>  
                    </div>
                  </div> <!-- /.card-body -->
                </div>
                <div class="card becerromuerto"> <!-- Registro por Nacimiento Muerto -->
                  <div class="card-header">
                    <div class="form-check title-tipo">
                      <h3 class="title-header">Registro de Nacido Muerto</h3> 
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
                   @error('fnacmuerte2')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Fecha de Nacido es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  @error('muerterazacria2')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Raza es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                   @error('causamuerte2')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>El campo Causa de Muerte es Requerido.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @enderror
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                      <label class="col-form-label title-tipo">Fec. Nac.:</label>
                      <div class="input-group mb-3">
                        <input 
                        type="date" 
                        name="fnacmuerte2"
                        min="1980-01-01" 
                        max="2031-12-31"
                        class="form-control" 
                        aria-label="fnac" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                        <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                        </svg></span>
                      </div>
                    </div>
                    <div class="col">
                       <label class="col-form-label title-tipo">Raza:</label>
                        <select class="form-select" name="muerterazacria2" aria-label="select example">
                          <option value="" selected>Seleccione una opción</option>
                          @foreach ($razacria as $item)
                          <option value="{{ $item->nombreraza }}">{{ $item->descripcion." (".$item->nombreraza.")" }}
                          </option>
                          @endforeach() 
                        </select>  
                    </div>
                    <div class="col">
                        <label class="col-form-label title-tipo">Causa:</label>
                        <select class="form-select" name="causamuerte2" aria-label="select example">
                          <option value="" selected>Seleccione una opción</option>
                          @foreach ($causamuerte as $item)
                          <option value="{{ $item->nombre }}">{{ $item->nombre }}
                          </option>
                          @endforeach() 
                        </select>  
                    </div> 
                    </div>
                    <div class="row">
                      <div class="col">
                        <label class="col-form-label title-tipo">Observación:</label>
                        <input 
                        class="form-control text-area" 
                        id="observamuerte2" 
                        type="text"
                        name="observamuerte2"
                        maxlength="180"                   
                        value="{{ old('observa') }}"> 
                      </div>
                    </div>
                  </div> <!-- /.card-body -->
                  
                </div>
              </div>  
            </div>
            <div class="card-footer clearfix">
              <button type="submit" class="btn alert-success aling-boton">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
                  <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 0 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
              </svg> Registrar</button>
              <a href="{{ route('ciclo.detalle',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo]) }}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
              </svg> volver</a>
            </div> <!-- Cria 1 Vivo-->
          </form>
          </div>
        </div>
      </div>
  </div>
  <div class="col-md-12"> <!-- Listado de Nacimiento para la serie -->
      <div class="card ">
        <div class="card-header">
          <h3 class="card-title title-header">Lista de Partos Registrados</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th colspan="5" style="text-align: center; background-color: #eaeaea;">Cría 1</th>
          
            <th colspan="5" style="text-align: center; background-color: #fff;">Cría 2</th>
            <th colspan="2" style="text-align: center; background-color: #eaeaea;">Datos por Mortalidad</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
           <tr>
            <th scope="col">Serie</th>
            <th scope="col">Tipología</th>
            <th scope="col">Tipología A. Parto</th>
            <th scope="col">F. Parto Anterior</th>
            <th scope="col">F. Parto</th>
            <th scope="col">Serie</th>
            <th scope="col">Sexo</th>
            <th scope="col">Lote</th>
            <th scope="col">Peso</th>
            <th scope="col">Observación</th>
            <th scope="col">Serie</th>
            <th scope="col">Sexo</th>
            <th scope="col">Lote</th>
            <th scope="col">Peso</th>
            <th scope="col">Observación</th>
            <th scope="col">Causa de Muerte</th>
            <th scope="col">Observación</th>
            <th scope="col">IEEP</th>
            <th scope="col">Acción</th>
          </tr>
        </thead>
        <tbody>
         @foreach($parto as $item)
          <tr>
            <td>
              {{ $item->serie }}
            </td>
            <td>
              {{ $item->tipo }}
            </td>
            <td>
              {{ $item->tipoap }}
            </td>
            <td>
              {{ $item->fecup}}
            </td>
            <td>
              {{ $item->fecpar }}
            </td>
            <td>
              {{ $item->becer}}
            </td>
            <td style="text-align: center; ">
              
              {!! $item->sexo?"M":"H" !!}
            </td>
            <td>
              {{ $item->lotebecerro }}
            </td>
            <td>
              {{ $item->pesoib }}
            </td>
            <td>
              {{ $item->obspar }}
            </td>
          
             <td>
              {{ $item->becer1}}
            </td>
            <td>
              {{ $item->sexo1 }}
            </td>
            <td>
              {{ $item->lotebecerro1 }}
            </td>
            <td>
              {{ $item->pesoib1 }}
            </td>
            <td>
              {{ $item->obspar1 }}
            </td>
             <td>
              {!! $item->causanm==null?$item->causanm1:$item->causanm !!}
            </td>
            <td>
              {!! $item->obsernm==null?$item->obsernm1:$item->obsernm !!}
            </td>
            <td>
              {{ $item->intestpar }}
            </td>
            <td>
              <form action="{{route('parto.eliminar',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo, $series->id, $item->id]) }}" class="d-inline form-delete" method="POST">
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
        <!-- /.card-body -->
        <div class="card-footer clearfix">
       
        </div>
      </div>
  </div>
</div>
</div>
@stop

@section('css')
<!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/bootstrap5/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/admin_custom.css">
   
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@stop

@section('js')
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

   {!! Html::script('js/jquery-3.5.1.min.js')!!}
   {!! Html::script('js/dropdown.js')!!}
   {!! Html::script('js/sweetalert2.js')!!} 
   {!! Html::script('daterangepicker/daterangepicker.js')!!} 


   <script type="text/javascript">
    $(".alert-dismissible").fadeTo(3000, 500).slideUp(500, function(){
       $(".alert-dismissible").alert('close');
    });
   </script>
   
  @if(session('mensaje')=='ok')
      <script>
        Swal.fire({
        title: '¡Eliminado!',
        text:  'Registro Eliminado Satisfacoriamente',
        icon:  'success'
      })
      </script>
  @endif
  @if (session('mensaje')=='info')
      <script>
        Swal.fire({
        text:'El registro no pudeo ser guardado',
        icon: 'error',
        title:'¡Registro no Salvado!'
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
   @if (session('info')=='ok')
      <script>
        Swal.fire({
        text:'Esta serie No posee un Registro de Preñez Registrado',
        icon: 'info',
        title:'¡Registro de Parto!'
      })
      </script>
   @endif
   @if (session('infoser')=='ok')
      <script>
        Swal.fire({
        text:'Este Registro de Preñez no tiene un Servicio Registrado',
        icon: 'error',
        title:'¡Registro de Preñez Sin Servicio Previo!'
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


    <script>

    $('.form-trans').submit(function(e){
  
      var fecus = new Date(document.getElementById('fecus').value);    
      var fecharegistro = new Date(document.getElementById('fecharegistro').value);
      
      if (fecus > fecharegistro) {
        e.preventDefault();
        Swal.fire({
        text:'La Fecha "Último Servicio" no puede ser posterior a la fecha "Registro" del servicio',
        icon: 'error',
        title:'¡Rango de Fecha No valido!'
        })
      }
    }); 
    </script>  

<!-- Funcion de respaldo para el uso de las fechas -->
<script>
$(function() {
  $('#fecha1').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  });

let fecha1 = document.getElementById("fecha1").value;
//let fecha2 = document.getElementById("fechafinal").value;
console.log(fecha1);
let fecha1Formateada = moment(fecha1,"MM/DD/YYYY").format('YYYY-MM-DD');
//let fecha2Formateada = moment(fecha2,"YYYY/MM/DD").format('YYYY/MM/DD');
console.log(`fecha 1: ${fecha1Formateada}`);
});
</script>


@stop
