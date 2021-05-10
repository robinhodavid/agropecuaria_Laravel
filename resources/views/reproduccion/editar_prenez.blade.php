@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-12"> <!-- Col1 -->
      <div class="card">
        <form action="{{ route('prenez.update',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo, $series->id, $prenhez->id]) }}" method="POST" class="form-trans">
        @method('PUT')
        @csrf
        <div class="card-header">
        	<div class="col">
        		<h3 class="card-title title-header">Editar Registro de Preñez</h3>		
        	</div>
        	<div class="col">
        		<div class="form-check aling-boton my-2">
        			<label class="col-form-label mr-3">Método de Preñez:</label>
      
	              	<input 
	                  type="radio" 
	                  aria-label="Radio button for following text input"
	                  name="metodo_prenez"
	                  id="mia" 
	                  value="{{$idtipomonta}}" 
	                  {!! $servicioActivo?"checked":"" !!}>
	                  
	                  <label class="checkbox"  for= "metodo_prenez">Inseminación Artificial / Monta Natural Controlada</label>
	              	<input 
	                  type="radio" 
	                  aria-label="Radio button for following text input"
	                  name="metodo_prenez"
	                  id="nral" 
                    value="{{$idtipomonta}}"
	                  {!! $servicioActivo?"":"checked" !!}>
	                  <label class="checkbox"  for="metodo_prenez">Monta Natural (Libre)</label>
              </div>	
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
        @error('fecharegistro')
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <span>
            <strong>¡Atención! </strong>El campo Fecha Registro es Obligatorio.
          </span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @enderror
         @error('diaprenez')
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <span>
            <strong>¡Atención! </strong>El campo Día de Preñez es Obligatorio.
          </span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @enderror
         @error('mesesprenez')
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <span>
            <strong>¡Atención! </strong>El campo Meses de Preñez es Obligatorio.
          </span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @enderror
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
                  type="date" 
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
						  	aria-label="fecup" aria-describedby="basic-addon2">
							<span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
							<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
							<path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
							</svg></span>
						</div>
	  			</div>
	            <div class="col">
					<label class="col-form-label">IER Parto:</label>
	              	<input 
	              	class="form-control" 
	              	id="ier" 
	              	type="text" 
	              	name="ier"
	              	readonly="true" 
	              	value="{{$prenhez->intestpar}}">
				</div>
				<div class="col">
					<label class="col-form-label">IDA:</label>
	              	<input 
	              	class="form-control" 
	              	id="ida" 
	              	type="text" 
	              	name="ida"
	              	readonly="true" 
	              	value="{{$prenhez->intestpar}}">
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
                    value="{{$prenhez->fepre}}"
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
                    value="{{$prenhez->fecas}}"
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
                    value="{{$prenhez->fecap}}"
                    aria-label="faproparto" aria-describedby="basic-addon2">
                    <span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                    <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                    </svg></span>
                  </div>
                </div>
                <div class="col">
                  <label class="col-form-label">F. Registro:
                  </label>
                  <div class="input-group mb-3">
                    <input 
                    type="date" 
                    id="fecharegistro"
                    name="fecharegistro"
                    min="1980-01-01" 
                    max="2031-12-31"
                    class="form-control fregistro"
                    value="{{$prenhez->fregp}}" 
                    aria-label="fecharegistro" aria-describedby="basic-addon2">
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
                        value="{{$prenhez->dias_prenez}}"
                        > 
                    <label class="col-form-label" id="labelmeses">Meses de Preñez:</label>
                        <input 
                        class="form-control" 
                        id="mesesprenez" 
                        type="number" 
                        name="mesesprenez"
                        min="0"
                        max="12"
                        value="{{$prenhez->mesespre}}"
                        >     
                </div>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
           <button type="submit" class="btn alert-success aling-boton">
             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
              <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
              <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
            </svg> Guardar</button>
            <a href="{{ route('admin',$finca->id_finca) }}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
            </svg> volver</a>
          </div>
        </form>
      </div>
  </div>
  <div class="col-md-12"> <!-- Col1 -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title title-header">Lista de Preñeces Registradas</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        <table class="table">
        <thead>
           <tr>
            <th scope="col">Serie</th>
            <th scope="col">F. Registro</th>
            <th scope="col">F. E. Preñez</th>
            <th scope="col">F. A. Secado</th>
            <th scope="col">F. A. Parto</th>
            <th scope="col">IDA</th>
            <th scope="col">IERP</th>
            <th scope="col" style="text-align: center;">Tiempo Preñez</th>
          </tr>
        </thead>
        <tbody>
      
          <tr>
            <td>
              {{ $prenhez->serie }}
            </td>
            <td>
              {{ $prenhez->fregp }}
            </td>
            <td>
              {{ $prenhez->fepre }}
            </td>
            <td>
              {{ $prenhez->fecas}}
            </td>
            <td>
              {{ $prenhez->fecap }}
            </td>
             <td>
              {{ $prenhez->intdiaabi }}
            </td>
            <td>
              {{ $prenhez->intestpar }}
            </td>
            <td style="text-align: center;">
              {!! $prenhez->dias_prenez==""?$prenhez->mesespre.'-'.("M"):"" !!}
              {!! $prenhez->mesespre==""?$prenhez->dias_prenez.'-'.("D"):"" !!}
            </td>
           
          </tr>
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
@stop

@section('js')
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

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
   @if (session('info')=='ok')
      <script>
        Swal.fire({
        text:'Esta serie posee un Registro de Preñez en Curso',
        icon: 'info',
        title:'¡Registro de Preñez!'
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

@stop
