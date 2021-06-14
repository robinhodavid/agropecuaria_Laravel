	@extends('adminlte::page')

	@section('title', 'SISGA')

	@section('content_header')

	@stop

	@section('content')
	<div class="container">
		<div class="row my-2">  
			<div class="col"> 
				<div role="tabpanel">
					<h3 class="title-header">Reportes Personalizados</h3>
					<ul class="nav nav-tabs" role="tablist">
						<li id="Ganaderia" class="nav-item title-tipo" role="presentation">
							<a class="nav-link active" href="#seccion1" arial-controls="seccion1" data-toggle="tab" role="tab">Ganadería - Catálogo de Ganado</a>
						</li>
						<li  id="Reproduccion" class="nav-item title-tipo" role="presentation">
							<a class="nav-link" href="#seccion2" arial-controls="seccion2" arial-controls="" data-toggle="tab" role="tab">Reproducción</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" role="tabpanel" id="seccion1">
							<form action="{{ route ('print_report', $finca->id_finca) }}" method="POST" target="_blank" >
								@csrf	
								<div class="row my-2">
									<div class="col-2"> <!--Columna Tipo -->
										<label class="col-form-label title-filed" style="margin-top: 16%;">Tipología</label>
						          <select class="form-select width-field" name="tipo" aria-label="select example">
						            <option value="" selected>Tipología</option>
						              @foreach($tipologia as $item)
						                <option value="{{$item->id_tipologia}}"> {{$item->nombre_tipologia}}
						                </option>
						              @endforeach()
						          </select>    
									</div>
									<div class="col" style="background-color: #eaeaea;"> <!--Rango Fecha de Registro -->
										<div class="row">
											<label class="title-filed" style="text-align: center;" >Fecha de Registro</label>
											<div class="col" style="text-align: center;" >
												<label class="title-filed">Desde</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="frdesde"
								                name="frdesde"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="desde" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
											<div class="col" style="text-align: center;">
												<label class="title-filed">Hasta</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="frhasta"
								                name="frhasta"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="hasta" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
										</div>
									</div>
									<div class="col"> <!--Rango Fecha de Nacimiento -->
										<div class="row">
											<label class="title-filed" style="text-align: center;">Rango de Peso</label>
											<div class="col" style="text-align: center;">
													<label class="title-filed">Desde</label>
		       								  	<div class="input-group mb-2">
										            <input 
													    class="form-control" 
													    id="pdesde" 
													    type="number" 
													    name="pdesde" 
													    min="0" 
													    step="any"
													    placeholder="0" 
													    value="{{ old('pesoactual') }}">	  
									        	</div>    
											</div>
											<div class="col" style="text-align: center;">
												<label class="title-filed">Hasta</label>
       								  				<div class="input-group mb-2">
								          				<input 
														    class="form-control" 
														    id="phasta" 
														    type="number" 
														    name="phasta" 
														    min="0" 
														    step="any"
														    placeholder="0" 
														    value="{{ old('pesoactual') }}">  
									       			</div>    
											</div>
										</div>
									</div>
									<div class="col" style="background-color: #eaeaea;"> <!--Rango Fecha de Destete -->
										<div class="row">
											<label class="title-filed" style="text-align: center;">Fecha de Destete</label>
											<div class="col" style="text-align: center;">
													<label class="title-filed">Desde</label>
       								  	<div class="input-group mb-2">
									          <input 
									                type="date" 
									                id="fddesde"
									                name="fddesde"
									                class="form-control" 
									                min="1980-01-01" 
									                max="2031-12-31"
									                aria-label="fddesde" aria-describedby="basic-addon2">
										              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
											<div class="col" style="text-align: center;">
												<label class="title-filed">Hasta</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="fdhasta"
								                name="fdhasta"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="fdhasta" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
										</div>
									</div>
								</div>
								<hr>
								<div class="row my-2">
									<div class="col my-2"> <!-- Col1 -->
			
										<div class="row">
											<div class="col">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="customCheckbox1" value="option1">
													<label for="customCheckbox1" class="custom-control-label title-label" title="Serie del Animal">Serie</label>
												</div>
											</div>
											<div class="col">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="customCheckbox2" value="option2">
													<label for="customCheckbox2" class="custom-control-label title-label" title="Raza del Animal">Raza</label>
												</div>
											</div>
											<div class="col">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="customCheckbox3" value="option3">
													<label for="customCheckbox3" class="custom-control-label title-label" title="Fecha de Nacimiento">F. Nac</label>
											</div>
											</div>
											<div class="col">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="customCheckbox4" value="option4">
													<label for="customCheckbox4" class="custom-control-label title-label" title="Sexo del Animal">Sexo</label>
												</div>
											</div>
											<div class="col">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="customCheckbox5" value="option5">
													<label for="customCheckbox5" class="custom-control-label title-label" title="Tipología del Animal">Tipología</label>
												</div>
											</div>
											<div class="col">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="customCheckbox6" value="option6">
													<label for="customCheckbox6" class="custom-control-label title-label" title="Código de la Madre">C. Madre</label>
												</div>
											</div>
											<div class="col">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="customCheckbox7" value="option7">
													<label for="customCheckbox7" class="custom-control-label title-label" title="Código del Padre">C. Padre</label>
												</div>
											</div>
											
										</div>
										<div class="row">
											<div class="col">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="customCheckbox8" value="option8">
													<label for="customCheckbox8" class="custom-control-label title-label" title="Fecha de Registro">F. Reg.</label>
											</div>
											</div>
											<div class="col">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="customCheckbox9" value="option9">
													<label for="customCheckbox9" class="custom-control-label title-label" title="Peso Nacimiento">P. Nac.</label>
												</div>
											</div>
											<div class="col">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="customCheckbox10" value="option10">
													<label for="customCheckbox10" class="custom-control-label title-label" title="Fecha Último Peso">F. Ult. Pesaje</label>
												</div>
											</div>
											<div class="col">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="customCheckbox11" value="option11">
													<label for="customCheckbox11" class="custom-control-label title-label" title="Fecha de Destete">F. Destete</label>
												</div>
											</div>
											<div class="col">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="customCheckbox12" value="option12">
													<label for="customCheckbox12" class="custom-control-label title-label" title="Peso de Destete">P. Destete</label>
												</div>
											</div>
											<div class="col">
												<div class="custom-control custom-checkbox">
														<input class="custom-control-input" name="campo[]" type="checkbox" id="customCheckbox13" value="option13">
														<label for="customCheckbox13" class="custom-control-label title-label" title="Lote Estratégico">Lote</label>
												</div>
											</div>
											<div class="col">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="customCheckbox14" value="option14">
													<label for="customCheckbox14" class="custom-control-label title-label" title="Peso Actual">P. Actual</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="card-footer clearfix">
									<h6 ><strong>Ordenar por:</strong></h6>	
									<div class="col">
										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderby"
										id="campo1" value="sganims.serie" checked>
										<label class="checkbox-inline title-label"  for="campo1">Serie</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderby"
										id="campo2" value="sganims.id_tipologia">
										<label class="checkbox-inline title-label"  for="campo2">Tipología</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderby"
										id="campo3" value="sganims.codmadre">
										<label class="checkbox-inline title-label"  for="campo3">Código Madre</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderby"
										id="campo4" value="sganims.fecr">
										<label class="checkbox-inline title-label"  for="campo4">Fecha Registro</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderby"
										id="campo5" value="sganims.sexo">
										<label class="checkbox-inline title-label"  for="campo5">sexo</label>
									</div>
									<div class="col">
										<a href="{{ route('admin',$finca->id_finca) }}" class="btn btn-warning aling-boton btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
											<path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
										</svg> </a>
										<button type="submit" class="btn alert-success float-right btn-sm"><i class="fas fa-print"></i></button>
									</div>
								</div> 
							</form>	 
						</div>   
<!--Seccion2-->						 
						<div class="tab-pane" role="tabpanel" id="seccion2">
							<form action="{{ route ('print_report_reproducion', $finca->id_finca) }}" method="POST" target="_blank" >
							@csrf	 
							<div class="row celos my-2">
								<div class="col-2"> <!--Columna Tipo -->
										<label class="col-form-label title-filed" style="margin-top: 16%;">Responsable</label>
						          <select class="form-select width-field" name="resp" aria-label="select example">
						            <option value="" selected>Responsable</option>
						              @foreach($usuarios as $item)
						                <option value="{{$item->name}}"> {{$item->name}}
						                </option>
						              @endforeach()
						          </select>    
								</div>
								<div class="col" style="background-color: #eaeaea;"> 
									<!--Rango Fecha de Registro -->
									<div class="row">
										<label class="title-filed" style="text-align: center;" >Fecha de Registro</label>
										<div class="col" style="text-align: center;" >
											<label class="title-filed">Desde</label>
     								  <div class="input-group mb-2">
							          <input 
							                type="date" 
							                id="frdesde"
							                name="frdesde"
							                class="form-control" 
							                min="1980-01-01" 
							                max="2031-12-31"
							                aria-label="desde" aria-describedby="basic-addon2">
								              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
								       </div>    
										</div>
										<div class="col" style="text-align: center;">
											<label class="title-filed">Hasta</label>
     								  <div class="input-group mb-2">
							          <input 
							                type="date" 
							                id="frhasta"
							                name="frhasta"
							                class="form-control" 
							                min="1980-01-01" 
							                max="2031-12-31"
							                aria-label="hasta" aria-describedby="basic-addon2">
								              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
								        </div>    
										</div>
									</div>
								</div>
								<div class="col"> <!--Rango Fecha proximo celo -->
										<div class="row">
											<label class="title-filed" style="text-align: center;" >Fecha Próximo Celo</label>
											<div class="col" style="text-align: center;" >
												<label class="title-filed">Desde</label>
       								  <div class="input-group mb-2">
								          <input 
						                type="date" 
						                id="fpcdesde"
						                name="fpcdesde"
						                class="form-control" 
						                min="1980-01-01" 
						                max="2031-12-31"
						                aria-label="fpcdesde" aria-describedby="basic-addon2">
							              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
											<div class="col" style="text-align: center;">
												<label class="title-filed">Hasta</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="fpchasta"
								                name="fpchasta"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="fpchasta" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
										</div>
								</div>
							</div>
							<div class="row servicios my-2">
								<div class="col-2"> <!--Columna Tipo -->
										<label class="col-form-label title-filed" style="margin-top: 16%;">Responsable</label>
						          <select class="form-select width-field" name="resp" aria-label="select example">
						            <option value="" selected>Responsable</option>
						              @foreach($usuarios as $item)
						                <option value="{{$item->name}}"> {{$item->name}}
						                </option>
						              @endforeach()
						          </select>    
								</div>
								<div class="col" style="background-color: #eaeaea;"> <!--Rango Fecha de Registro -->
										<div class="row">
											<label class="title-filed" style="text-align: center;" >Fecha de Registro</label>
											<div class="col" style="text-align: center;" >
												<label class="title-filed">Desde</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="frdesde"
								                name="frdesde"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="desde" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
											<div class="col" style="text-align: center;">
												<label class="title-filed">Hasta</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="frhasta"
								                name="frhasta"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="hasta" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
										</div>
								</div>
									<div class="col"> 
										<div class="row">
											<label class="title-filed" style="text-align: center;" >Rango de Peso</label>
												<div class="col" style="text-align: center;">
													<label class="title-filed">Desde</label>
       								  	<div class="input-group mb-2">
									           <input 
													    class="form-control" 
													    id="pdesde" 
													    type="number" 
													    name="pdesde" 
													    min="0" 
													    step="any"
													    placeholder="0" 
													    value="{{ old('pesoactual') }}">	  
									        </div>    
											</div>
											<div class="col" style="text-align: center;">
												<label class="title-filed">Hasta</label>
       								  <div class="input-group mb-2">
								          <input 
													    class="form-control" 
													    id="phasta" 
													    type="number" 
													    name="phasta" 
													    min="0" 
													    step="any"
													    placeholder="0" 
													    value="{{ old('pesoactual') }}">  
									        </div>    
											</div>
										</div>
									</div>
							</div>

							<div class="row palpaciones my-2">
								<div class="col" style="background-color: #eaeaea;"> <!--Rango Fecha de Registro -->
										<div class="row">
											<label class="title-filed" style="text-align: center;" >Fecha de Registro</label>
											<div class="col" style="text-align: center;" >
												<label class="title-filed">Desde</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="frdesde"
								                name="frdesde"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="desde" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
											<div class="col" style="text-align: center;">
												<label class="title-filed">Hasta</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="frhasta"
								                name="frhasta"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="hasta" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
										</div>
								</div>
								<div class="col-2" > <!--Columna Tipo -->
										<label class="col-form-label title-filed" style="margin-top: 16%;">Diagnóstico</label>
						          <select class="form-select width-field" name="diag" aria-label="select example">
						            <option value="" selected>Diagnóstico</option>
						              @foreach($diagnostico as $item)
						                <option value="{{$item->id_diagnostico}}"> {{$item->nombre}}
						                </option>
						              @endforeach()
						          </select>    
								</div>
								<div class="col" style="background-color: #eaeaea;"> <!--Rango Fecha de Registro -->
										<div class="row">
											<label class="title-filed" style="text-align: center;" >Próxima Cita</label>
											<div class="col" style="text-align: center;" >
												<label class="title-filed">Desde</label>
       								  <div class="input-group mb-2" >
								          <input 
								                type="date" 
								                id="citadesde"
								                name="citadesde"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="citadesde" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
											<div class="col" style="text-align: center;">
												<label class="title-filed">Hasta</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="citahasta"
								                name="citahasta"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="citahasta" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
										</div>
								</div>
								<div class="col-2"> <!--Columna Tipo -->
									<label class="col-form-label title-filed" style="margin-top: 16%;">Patología</label>
					          <select class="form-select width-field" name="patol" aria-label="select example">
					            <option value="" selected>Patología</option>
					              @foreach($patologia as $item)
					                <option value="{{$item->patologia}}"> {{$item->patologia}}
					                </option>
					              @endforeach()
					          </select>  					            
								</div>
							</div>

							<div class="row prenez my-2">
								<div class="col" style="background-color: #eaeaea;"> <!--Rango Fecha de Registro -->
										<div class="row">
											<label class="title-filed" style="text-align: center;" >Fecha de Registro</label>
											<div class="col" style="text-align: center;" >
												<label class="title-filed">Desde</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="frdesde"
								                name="frdesde"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="desde" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
											<div class="col" style="text-align: center;">
												<label class="title-filed">Hasta</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="frhasta"
								                name="frhasta"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="hasta" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
										</div>
								</div>
								<div class="col" style="text-align: center;"> <!--Columna Tipo -->
									<label class="col-form-label title-filed">Días de Preñez</label>
									<div class="row">
										<div class="col" style="text-align: center;">
												<label class="title-filed">Desde</label>
		 								  	<div class="input-group mb-2">
								           <input 
												    class="form-control" 
												    id="dpredesde" 
												    type="number" 
												    name="dpredesde" 
												    min="0"
												    max="270" 
												    placeholder="0" 
												    value="{{ old('dias_prenez') }}">	  
								        </div>    
										</div>
										<div class="col" style="text-align: center;">
											<label class="title-filed">Hasta</label>
     								  <div class="input-group mb-2">
							          <input 
												    class="form-control" 
												    id="dprehasta" 
												    type="number" 
												    name="dprehasta" 
												    min="0"
												    max="270" 
												    placeholder="0" 
												    value="{{ old('dias_prenez') }}">  
								        </div>    
										</div>
									</div>	
								</div>
								<div class="col" style="background-color: #eaeaea;"> <!--Rango Fecha de Registro -->
										<div class="row">
											<label class="title-filed" style="text-align: center;" >Fecha Estimada de Preñez</label>
											<div class="col" style="text-align: center;" >
												<label class="title-filed">Desde</label>
       								  <div class="input-group mb-2" >
								          <input 
								                type="date" 
								                id="fepredesde"
								                name="fepredesde"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="fepredesde" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
											<div class="col" style="text-align: center;">
												<label class="title-filed">Hasta</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="feprehasta"
								                name="feprehasta"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="feprehasta" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
										</div>
								</div>	
								<div class="col"> <!--Rango Fecha de Registro -->
										<div class="row">
											<label class="title-filed" style="text-align: center;" >Fecha Estimada de Parto</label>
											<div class="col" style="text-align: center;" >
												<label class="title-filed">Desde</label>
       								  <div class="input-group mb-2" >
								          <input 
								                type="date" 
								                id="fepartdesde"
								                name="fepartdesde"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="fepartedesde" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
											<div class="col" style="text-align: center;">
												<label class="title-filed">Hasta</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="feparthasta"
								                name="feparthasta"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="feparthasta" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
										</div>
								</div>							
							</div>

							<div class="row parto my-2">
								<div class="col" style="background-color: #eaeaea;"> <!--Rango Fecha de Registro -->
										<div class="row">
											<label class="title-filed" style="text-align: center;" >Fecha de Parto</label>
											<div class="col" style="text-align: center;" >
												<label class="title-filed">Desde</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="fpartdesde"
								                name="fpartdesde"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="fpartdesde" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
											<div class="col" style="text-align: center;">
												<label class="title-filed">Hasta</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="fparthasta"
								                name="fparthasta"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="fparthasta" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
										</div>
								</div>
								<div class="col"> <!--Columna Tipo -->
										<label class="col-form-label title-filed" style="margin-top: 16%;">Condición de Parto</label>
						          <select class="form-select width-field" name="condi" aria-label="select example">
						            <option value="" selected>Condición de Parto</option>
						            <option value="Vi">Nacido Vivo</option>
						            <option value="Mu">Nacido Muerto</option>
						          </select>    
								</div>
								<div class="col"> <!--Columna Tipo -->
										<label class="col-form-label title-filed" style="margin-top: 16%;">Causa Muerte</label>
						          <select class="form-select width-field" name="causa" aria-label="select example">
						            <option value="" selected>Causa Muerte</option>
						              @foreach($causamuerte as $item)
						                <option value="{{$item->nombre}}"> {{$item->nombre}}
						                </option>
						              @endforeach()
						          </select>    
								</div>							
							</div>

							<div class="row aborto my-2">
								<div class="col"> <!--Columna Tipo -->
										<label class="col-form-label title-filed">Causa Muerte</label>
						          <select class="form-select width-field" name="causaabor" aria-label="select example">
						            <option value="" selected>Causa Muerte</option>
						              @foreach($causamuerte as $item)
						                <option value="{{$item->nombre}}"> {{$item->nombre}}
						                </option>
						              @endforeach()
						          </select>    
								</div>
								<div class="col" style="background-color: #eaeaea;"> <!--Rango Fecha de Registro -->
										<div class="row">
											<label class="title-filed" style="text-align: center;" >Fecha de Aborto</label>
											<div class="col" style="text-align: center;" >
												<label class="title-filed">Desde</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="fabordesde"
								                name="fabordesde"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="fabordesde" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
											<div class="col" style="text-align: center;">
												<label class="title-filed">Hasta</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="faborhasta"
								                name="faborhasta"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="faborhasta" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
										</div>
								</div>
								
							</div>

							<div class="row pnc my-2">
								<div class="col-3"> <!--Columna Tipo -->
										<label class="col-form-label title-filed">Causa Muerte</label>
						          <select class="form-select width-field" name="causapnc" aria-label="select example">
						            <option value="" selected>Causa Muerte</option>
						              @foreach($causamuerte as $item)
						                <option value="{{$item->nombre}}"> {{$item->nombre}}
						                </option>
						              @endforeach()
						          </select>    
								</div>
								<div class="col-6" style="background-color: #eaeaea;"> <!--Rango Fecha de Registro -->
										<div class="row">
											<label class="title-filed" style="text-align: center;" >Fecha de Parto No Culminado</label>
											<div class="col" style="text-align: center;" >
												<label class="title-filed">Desde</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="fpncdesde"
								                name="fpncdesde"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="fabordesde" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
											<div class="col" style="text-align: center;">
												<label class="title-filed">Hasta</label>
       								  <div class="input-group mb-2">
								          <input 
								                type="date" 
								                id="fpnchasta"
								                name="fpnchasta"
								                class="form-control" 
								                min="1980-01-01" 
								                max="2031-12-31"
								                aria-label="faborhasta" aria-describedby="basic-addon2">
									              <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>  
									        </div>    
											</div>
										</div>
								</div>								
							</div>

							<hr>
							<div class="row">
								<div class="col-md-12 my-2"> <!-- Col1 -->
									<!--Celos -->
									<div class="row">
										<div class="col">
												<div class="form-check">
												  <input class="form-check-input" type="radio" name="tipo" id="celos"  value="t1" checked>
												  <label class="form-check-label title-label" for="celos">
												    Celos:
												  </label>
												</div>
										</div>
										<div class="col celos">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" name="campo[]" type="checkbox" id="c1" value="c1">
												<label for="c1" class="custom-control-label title-label" title="Serie del Animal">Serie</label>
											</div>
										</div>
										<div class="col celos">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" name="campo[]" type="checkbox" id="c2" value="c2">
												<label for="c2" class="custom-control-label title-label" title="Fecha de Registro">F. R</label>
											</div>
										</div>
										<div class="col celos">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" name="campo[]" type="checkbox" id="c3" value="c3">
												<label for="c3" class="custom-control-label title-label" title="Intervalo Entre Celos">IEC</label>
											</div>
										</div>
										<div class="col celos">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" name="campo[]" type="checkbox" id="c4" value="c4">
												<label for="c4" class="custom-control-label title-label" title="Responsable">Resp.</label>
											</div>
										</div>
										<div class="col celos">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" name="campo[]" type="checkbox" id="c5" value="c5">
												<label for="c5" class="custom-control-label title-label" title="Fecha Estimada Próximo celo">F.E.P.C</label>
											</div>
										</div>
										<div class="col celos">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" name="campo[]" type="checkbox" id="c6" value="c6">
												<label for="c6" class="custom-control-label title-label" title="Intervalo Entre Días Abiertos">I.D.A</label>
											</div>
										</div>
									</div>
									<!--Servicios-->								
									<div class="row">
										<div class="col">
											<div class="form-check">
												  <input class="form-check-input" type="radio" name="tipo" id="servicios" value="t2">
												  <label class="form-check-label title-label" for="servicios">
												    Servicios:
												  </label>
											</div>
										</div>
											<div class="col servicios">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="s1" value="s1">
													<label for="s1" class="custom-control-label title-label" title="Serie del Animal">Serie</label>
												</div>
											</div>
											<div class="col servicios">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="s2" value="s2">
													<label for="s2" class="custom-control-label title-label" title="Fecha de Registro">F. Reg.</label>
												</div>
											</div>
											<div class="col servicios">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="s3" value="s3">
													<label for="s3" class="custom-control-label title-label" title="Toro">Toro</label>
												</div>
											</div>
											<div class="col servicios">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="s4" value="s4">
													<label for="s4" class="custom-control-label title-label" title="Pajuela">Paju</label>
												</div>
											</div>
											<div class="col servicios">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="s5" value="s5">
													<label for="s5" class="custom-control-label title-label" title="Número de Servicios">N. S.</label>
												</div>
											</div>
											<div class="col servicios">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="s6" value="s6">
													<label for="s6" class="custom-control-label title-label" title="Edad del Animal">Edad</label>
												</div>
											</div>
											<div class="col servicios">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="s7" value="s7">
													<label for="s7" class="custom-control-label title-label" title="Peso Actual del Animal">Peso</label>
												</div>
											</div>
											<div class="col servicios">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="s8" value="s8">
													<label for="s8" class="custom-control-label title-label" title="Responsable del Servicio">Resp.</label>
												</div>
											</div>
											<div class="col servicios">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="s9" value="s9">
													<label for="s9" class="custom-control-label title-label" title="Intervalo Entre Servicios">IES.</label>
												</div>
											</div>
											<div class="col servicios">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="s10" value="s10">
													<label for="s10" class="custom-control-label title-label" title="Tipología">Tipo</label>
												</div>
											</div>
									</div> 
									<!--Palapaciones -->
									<div class="row">
										<div class="col">
											<div class="form-check">
												  <input class="form-check-input" type="radio" name="tipo" id="palpaciones" value="t3">
												  <label class="form-check-label title-label" for="palpaciones">
												    Palpaciones
												  </label>
												</div>
										</div>
										<div class="col palpaciones">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="p1" value="p1">
													<label for="p1" class="custom-control-label title-label" title="Serie del Animal">Serie</label>
												</div>
										</div>
										<div class="col palpaciones">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="p2" value="p2">
													<label for="p2" class="custom-control-label title-label" title="Fecha de Registro">F. R.</label>
												</div>
										</div>
										<div class="col palpaciones">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="p3" value="p3">
													<label for="p3" class="custom-control-label title-label" title="Responsable de la palpación">Resp.</label>
												</div>
										</div>
										<div class="col palpaciones">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="p4" value="p4">
													<label for="p4" class="custom-control-label title-label" title="Evaluación">Eval.</label>
												</div>
										</div>
										<div class="col palpaciones">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="p5" value="p5">
													<label for="p5" class="custom-control-label title-label" title="Próxima Cita">Pŕox. C</label>
												</div>
										</div>
										<div class="col palpaciones">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="p6" value="p6">
													<label for="p6" class="custom-control-label title-label" title="Diagnóstico">Diag.</label>
												</div>
										</div>
										<div class="col palpaciones">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="p7" value="p7">
													<label for="p7" class="custom-control-label title-label" title="Patología">Pgía.</label>
												</div>
										</div>
									</div>
									<!--Inicio Renglon de Prenez-->	
									<div class="row">
										<div class="col">
											<div class="form-check">
												  <input class="form-check-input" type="radio" name="tipo" id="prenez" value="t4">
												  <label class="form-check-label title-label" for="prenez">
												    Preñeces
												  </label>
												</div>
										</div>
										<div class="col prenez">
													<div class="custom-control custom-checkbox">
														<input class="custom-control-input" name="campo[]" type="checkbox" id="pre1" value="pre1">
														<label for="pre1" class="custom-control-label title-label" title="Serie del Animal">Serie</label>
													</div>
											</div>
											<div class="col prenez">
													<div class="custom-control custom-checkbox">
														<input class="custom-control-input" name="campo[]" type="checkbox" id="pre2" value="pre2">
														<label for="pre2" class="custom-control-label title-label" title="Fecha Registro de Preñez">F.R</label>
													</div>
											</div>
											<div class="col prenez">
													<div class="custom-control custom-checkbox">
														<input class="custom-control-input" name="campo[]" type="checkbox" id="pre3" value="pre3">
														<label for="pre3" class="custom-control-label title-label" title="Fecha de Preñez">F.P</label>
													</div>
											</div>
											<div class="col prenez">
													<div class="custom-control custom-checkbox">
														<input class="custom-control-input" name="campo[]" type="checkbox" id="pre4" value="pre4">
														<label for="pre4" class="custom-control-label title-label" title="Fecha de Servicio">F.S</label>
													</div>
											</div>
											<div class="col prenez">
													<div class="custom-control custom-checkbox">
														<input class="custom-control-input" name="campo[]" type="checkbox" id="pre5" value="pre5">
														<label for="pre5" class="custom-control-label title-label" title="Toro Pajuela">Paj.</label>
													</div>
											</div>
											<div class="col prenez">
													<div class="custom-control custom-checkbox">
														<input class="custom-control-input" name="campo[]" type="checkbox" id="pre6" value="pre6">
														<label for="pre6" class="custom-control-label title-label" title="Responsable">Resp.</label>
													</div>
											</div>
											<div class="col prenez">
													<div class="custom-control custom-checkbox">
														<input class="custom-control-input" name="campo[]" type="checkbox" id="pre7" value="pre7">
														<label for="pre7" class="custom-control-label title-label" title="Intervalo Entre Días Abiertos">IEDA</label>
													</div>
											</div>
											<div class="col prenez">
													<div class="custom-control custom-checkbox">
														<input class="custom-control-input" name="campo[]" type="checkbox" id="pre8" value="pre8">
														<label for="pre8" class="custom-control-label title-label" title="Intervalo Entre Partos">IEP</label>
													</div>
											</div>
											<div class="col prenez">
													<div class="custom-control custom-checkbox">
														<input class="custom-control-input" name="campo[]" type="checkbox" id="pre9" value="pre9">
														<label for="pre9" class="custom-control-label title-label" title="Fecha Apróximada de Parto">FAP</label>
													</div>
											</div>
											<div class="col prenez">
													<div class="custom-control custom-checkbox">
														<input class="custom-control-input" name="campo[]" type="checkbox" id="pre10" value="pre10">
														<label for="pre10" class="custom-control-label title-label" title="Meses/Días de Preñez">M/D.P</label>
													</div>
											</div>

											<div class="col prenez">
													<div class="custom-control custom-checkbox">
														<input class="custom-control-input" name="campo[]" type="checkbox" id="pre11" value="pre11">
														<label for="pre11" class="custom-control-label title-label" title="Toro Temporada">T.T</label>
													</div>
											</div>
											<div class="col prenez">
													<div class="custom-control custom-checkbox">
														<input class="custom-control-input" name="campo[]" type="checkbox" id="pre12" value="pre12">
														<label for="pre12" class="custom-control-label title-label" title="Metodo de Preñez">M.P</label>
													</div>
											</div>											
									</div>	
									<!--Inicio Renglon de Parto-->	
									<div class="row">
										<div class="col">
											<div class="form-check">
												  <input class="form-check-input" type="radio" name="tipo" id="partos" value="t5">
												  <label class="form-check-label title-label" for="parto">
												    Partos
												  </label>
												</div>
										</div>
											<div class="col parto">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="pa1" value="pa1">
													<label for="pa1" class="custom-control-label title-label" title="Serie del Animal">Serie</label>
												</div>
										  </div>
										  <div class="col parto">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="pa2" value="pa2">
													<label for="pa2" class="custom-control-label title-label" title="Tipología del Animal">Tipo</label>
												</div>
										  </div>
										  <!--
										  <div class="col parto">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="pa3" value="pa3">
													<label for="pa3" class="custom-control-label title-label" title="Condión del Animal">Cond</label>
												</div>
										  </div>
										-->
										  <div class="col parto">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="pa4" value="pa4">
													<label for="pa4" class="custom-control-label title-label" title="Edad del Animal">Edad</label>
												</div>
										  </div>
										  <div class="col parto">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="pa5" value="pa5">
													<label for="pa5" class="custom-control-label title-label" title="Fecha Último Parto">FUP</label>
												</div>
										  </div>
										  <div class="col parto">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="pa6" value="pa6">
													<label for="pa6" class="custom-control-label title-label" title="Fecha de Parto">FP</label>
												</div>
										  </div>
									
											<div class="col parto">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="pa8" value="pa8">
													<label for="pa8" class="custom-control-label title-label" title="Cría 1">C.1</label>
												</div>
										  </div>	
											<div class="col parto">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="pa9" value="pa9">
													<label for="pa9" class="custom-control-label title-label" title="Cría 2">C.2</label>
												</div>
										  </div>
										  <div class="col parto">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="pa10" value="pa10">
													<label for="pa10" class="custom-control-label title-label" title="Observación">Obs</label>
												</div>
										  </div>
										  <div class="col parto">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="pa11" value="pa11">
													<label for="pa11" class="custom-control-label title-label" title="Intervalo Entre Partos">IEP</label>
												</div>
										  </div>
										  <div class="col parto">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="pa12" value="pa12">
													<label for="pa12" class="custom-control-label title-label" title="Condición de Parto">C.P</label>
												</div>
										  </div>
										  <div class="col parto">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="pa13" value="pa13">
													<label for="pa13" class="custom-control-label title-label" title="Causa de Muerte">C.M</label>
												</div>
										  </div>
										  <div class="col parto">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" name="campo[]" type="checkbox" id="pa14" value="pa14">
													<label for="pa14" class="custom-control-label title-label" title="Observación por Muerte">Ob.M</label>
												</div>
										  </div>
									</div>
									<div class="row">
										<div class="col">
											<div class="form-check">
												  <input class="form-check-input" type="radio" name="tipo" id="abortos" value="t6">
												  <label class="form-check-label title-label" for="aborto">
												    Abortos
												  </label>
												</div>
										</div>
										<div class="col aborto">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" name="campo[]" type="checkbox" id="a1" value="a1">
												<label for="a1" class="custom-control-label title-label" title="Serie del Animal">Serie</label>
											</div>
									  </div>
									  <div class="col aborto">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" name="campo[]" type="checkbox" id="a2" value="a2">
												<label for="a2" class="custom-control-label title-label" title="Fecha de Registro">F.R</label>
											</div>
									  </div>
									  <div class="col aborto">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" name="campo[]" type="checkbox" id="a3" value="a3">
												<label for="a3" class="custom-control-label title-label" title="Causa de Aborto">Causa</label>
											</div>
									  </div>
									  <div class="col aborto">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" name="campo[]" type="checkbox" id="a4" value="a4">
												<label for="a4" class="custom-control-label title-label" title="Días de Preñez">Días P</label>
											</div>
									  </div>
									  <div class="col aborto">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" name="campo[]" type="checkbox" id="a5" value="a5">
												<label for="a5" class="custom-control-label title-label" title="Observación de Aborto">Obs.</label>
											</div>
									  </div>	
									</div>
									<div class="row">
										<div class="col">
											<div class="form-check">
												  <input class="form-check-input" type="radio" name="tipo" id="partopnc" value="t7">
												  <label class="form-check-label title-label" for="partonc">
												    Parto no culminados
												  </label>
												</div>
										</div>

										<div class="col pnc">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" name="campo[]" type="checkbox" id="pnc1" value="pnc1">
												<label for="pnc1" class="custom-control-label title-label" title="Serie del Animal">Serie</label>
											</div>
									  </div>
									  <div class="col pnc">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" name="campo[]" type="checkbox" id="pnc2" value="pnc2">
												<label for="pnc2" class="custom-control-label title-label" title="Fecha de Registro">F.R</label>
											</div>
									  </div>
									  <div class="col pnc">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" name="campo[]" type="checkbox" id="pnc3" value="pnc3">
												<label for="pnc3" class="custom-control-label title-label" title="Causa de Aborto">Causa</label>
											</div>
									  </div>
									  <div class="col pnc">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" name="campo[]" type="checkbox" id="pnc4" value="pnc4">
												<label for="pnc4" class="custom-control-label title-label" title="Días de Preñez">Días P</label>
											</div>
									  </div>
									  <div class="col pnc">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" name="campo[]" type="checkbox" id="pnc5" value="pnc5">
												<label for="pnc5" class="custom-control-label title-label" title="Trimestre">Trimestre</label>
											</div>
									  </div>
									   <div class="col pnc">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" name="campo[]" type="checkbox" id="pnc6" value="pnc6">
												<label for="pnc6" class="custom-control-label title-label" title="Observación de Parto no Culminado">Obs.</label>
											</div>
									  </div>		
									</div>
								</div> <!-- /.Fin de COl--->
							</div>

							<div class="card-footer clearfix">
								<h6 ><strong>Ordenar por:</strong></h6>	
									<div class="col celos">
										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderby"
										id="orderbyc1" value="serie" checked>
										<label class="checkbox-inline title-label"  for="orderbyc1">Serie</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderby"
										id="orderbyc2" value="resp">
										<label class="checkbox-inline title-label"  for="orderbyc2">Responsable</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderby"
										id="orderbyc3" value="fecestprocel">
										<label class="checkbox-inline title-label"  for="orderbyc3">Fecha Próximo Celo</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderby"
										id="orderbyc4" value="fechr">
										<label class="checkbox-inline title-label"  for="orderbyc4">Fecha Registro</label>
									</div>
									<div class="col servicios">
										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbys"
										id="orderbys1" value="sgservs.serie" checked>
										<label class="checkbox-inline title-label"  for="orderbys1">Serie</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbys"
										id="orderbys2" value="sgservs.nomi">
										<label class="checkbox-inline title-label"  for="orderbys2">Responsable</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbys"
										id="orderbys3" value="sgservs.fecha">
										<label class="checkbox-inline title-label"  for="orderbys3">Fecha Registro</label>
									</div>
									<div class="col palpaciones">
										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbyp"
										id="orderbyp1" value="sgpalps.serie" checked>
										<label class="checkbox-inline title-label"  for="orderbyp1">Serie</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbyp"
										id="orderbyp2" value="sgpalps.fechr">
										<label class="checkbox-inline title-label"  for="orderbyp2">Fecha Registro</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbyp"
										id="orderbyp3" value="sgpalps.id_diagnostico">
										<label class="checkbox-inline title-label"  for="orderbyp3">Diagnóstico</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbyp"
										id="orderbyp4" value="sgpalps.prcita">
										<label class="checkbox-inline title-label"  for="orderbyp4">Próx Cita</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbyp"
										id="orderbyp5" value="sgpalps.patologia">
										<label class="checkbox-inline title-label"  for="orderbyp5">Patología</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbyp"
										id="orderbyp6" value="sgpalps.resp">
										<label class="checkbox-inline title-label"  for="orderbyp6">Responsable</label>
									</div>
									<div class="col prenez">

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbypre"
										id="orderbypre1" value="serie" checked>
										<label class="checkbox-inline title-label"  for="orderbypre1">Serie</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbypre"
										id="orderbypre2" value="fregp">
										<label class="checkbox-inline title-label"  for="orderbypre2">Fecha Registro</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbypre"
										id="orderbypre3" value="fepre">
										<label class="checkbox-inline title-label"  for="orderbypre3">Fecha Preñez</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbypre"
										id="orderbypre4" value="dias_prenez">
										<label class="checkbox-inline title-label"  for="orderbypre4">Días de Preñez</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbypre"
										id="orderbypre5" value="mesespre">
										<label class="checkbox-inline title-label"  for="orderbypre5">Meses de Preñez</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbyp"
										id="orderbyp6" value="nomi">
										<label class="checkbox-inline title-label"  for="orderbyp6">Responsable</label>
									</div>
									<div class="col parto">

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbypa"
										id="orderbypa1" value="serie" checked>
										<label class="checkbox-inline title-label"  for="orderbypa1">Serie</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbypa"
										id="orderbypa2" value="fecpar">
										<label class="checkbox-inline title-label"  for="orderbypa2">Fecha Parto</label>
									</div>
									<div class="col aborto">

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbya"
										id="orderbya1" value="serie" checked>
										<label class="checkbox-inline title-label"  for="orderbya1">Serie</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbya"
										id="orderbya2" value="fecr">
										<label class="checkbox-inline title-label"  for="orderbya2">Fecha Aborto</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbya"
										id="orderbya3" value="causa">
										<label class="checkbox-inline title-label"  for="orderbya3">Causa</label>
									</div>
									<div class="col pnc">

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbypnc"
										id="orderbypnc1" value="serie" checked>
										<label class="checkbox-inline title-label"  for="orderbypnc1">Serie</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbypnc"
										id="orderbypnc2" value="fecregistro">
										<label class="checkbox-inline title-label"  for="orderbypnc2">Fecha Parto No Culminado</label>

										<input 
										type="radio" 
										aria-label="Radio button for following text input"
										name="orderbypnc"
										id="orderbypnc3" value="causa">
										<label class="checkbox-inline title-label"  for="orderbypnc3">Causa</label>
									</div>

								<a href="{{ route('admin',$finca->id_finca) }}" class="btn btn-warning aling-boton btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
									<path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
								</svg> </a>
								<button type="submit" class="btn alert-success float-right btn-sm"><i class="fas fa-print"></i></button>
							</div> 
						</form>      
					</div>
				</div>
			</div>
		</div>
	</div>


</div>

@stop

@section('css')

<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

<!-- daterange picker -->
<link rel="stylesheet" href="/css/daterangepicker.css">
<link rel="stylesheet" href="/css/tempusdominus-bootstrap-4.css">
<link rel="stylesheet" href="/css/bootstrap5/css/bootstrap.min.css">

<link rel="stylesheet" href="/css/admin_custom.css">

@stop

@section('js')

{!! Html::script('js/jquery.min.js')!!}
{!! Html::script('css/bootstrap5/js/bootstrap.min.js') !!}
<!--{!! Html::script('js/moment.min.js')!!}-->
<!--{!! Html::script('js/package.js')!!}-->
<!--{!! Html::script('js/website.js')!!}-->
<!--{!! Html::script('js/daterangepicker.js')!!}-->
<!--{!! Html::script('js/tempusdominus-bootstrap-4.min.js')!!}-->
{!! Html::script('js/sweetalert2.js')!!}  
{!! Html::script('js/metodos.js')!!}
  


<!-- Page script -->
<script>
  $(function () {
    
/*  	  //Date range picker
    $('#fecharegistro').datetimepicker({
        //format: 'L'
        locale: {
        format: 'YYYY-MM-DD'
      }
    });
*/
 		//Date range picker Fecha de Registro
    
    $('#fecharegistro').daterangepicker({
      locale: {
        format: 'YYYY-MM-DD'
      }
    }); 

    //Date range picker Fecha de Nacimiento
    $('#fechanacimiento').daterangepicker({
      locale: {
        format: 'YYYY-MM-DD'
      }
    }); 

    //Date range picker Fecha de Destete
    $('#fechadestete').daterangepicker({
      locale: {
        format: 'YYYY-MM-DD'
      }
    }); 

  })
</script>

<script>
	$('.form-trans').submit(function(e){

		var ddesde = new Date(document.getElementById('fddesde').value);    
		var dhasta = new Date(document.getElementById('fdhasta').value);

		if (ddesde > dhasta) {
			e.preventDefault();
			Swal.fire({
				text:'La Fecha "Hasta" no puede ser anterior a la fecha "Desde"',
				icon: 'error',
				title:'¡Rango de Fecha No valido!'
			})
		}
	}); 
</script>
<script>
	$('.form-trans').submit(function(e){

		var desde = new Date(document.getElementById('frdesde').value);    
		var hasta = new Date(document.getElementById('frhasta').value);

		if (desde > hasta) {
			e.preventDefault();
			Swal.fire({
				text:'La Fecha "Hasta" no puede ser anterior a la fecha "Desde"',
				icon: 'error',
				title:'¡Rango de Fecha No valido!'
			})
		}
	}); 
</script>
<script>
	$('.form-trans').submit(function(e){

		var pdesde = document.getElementById('pdesde').value;    
		var phasta = document.getElementById('phasta').value;

		if (pdesde > phasta) {
			e.preventDefault();
			Swal.fire({
				text:'El Valor del Peso "Hasta" no puede ser menor al valor del Peso "Desde"',
				icon: 'error',
				title:'¡Rango de Peso No valido!'
			})
		}
	}); 
</script>


@stop



