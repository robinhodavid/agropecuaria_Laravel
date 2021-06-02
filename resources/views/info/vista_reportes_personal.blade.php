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
	              	<div class="col-md-12 my-2"> <!-- Col1 -->
		                <div class="row">
		                	<div class="col">
			                  ​	<div class="custom-control custom-checkbox">
		                          	<input class="custom-control-input" name="campo" type="checkbox" id="customCheckbox1" value="option1">
		                          	<label for="customCheckbox1" class="custom-control-label title-label" title="Serie del Animal">Serie</label>
	                        	</div>
                        	</div>
                        	<div class="col">
			                  ​	<div class="custom-control custom-checkbox">
		                          	<input class="custom-control-input" name="campo" type="checkbox" id="customCheckbox2" value="option2">
		                          	<label for="customCheckbox2" class="custom-control-label title-label" title="Raza del Animal">Raza</label>
	                        	</div>
                        	</div>
                        	<div class="col">
			                  ​	<div class="custom-control custom-checkbox">
		                          	<input class="custom-control-input" name="campo" type="checkbox" id="customCheckbox3" value="option3">
		                          	<label for="customCheckbox3" class="custom-control-label title-label" title="Tipología del Animal">Tipología</label>
	                        	</div>
                        	</div>
                        	<div class="col">
			                  ​	<div class="custom-control custom-checkbox">
		                          	<input class="custom-control-input" name="campo" type="checkbox" id="customCheckbox4" value="option4">
		                          	<label for="customCheckbox4" class="custom-control-label title-label" title="Código de la Madre">C. Madre</label>
	                        	</div>
                        	</div>
                        	<div class="col">
			                  ​	<div class="custom-control custom-checkbox">
		                          	<input class="custom-control-input" name="campo" type="checkbox" id="customCheckbox5" value="option5">
		                          	<label for="customCheckbox5" class="custom-control-label title-label" title="Código del Padre">C. Padre</label>
	                        	</div>
                        	</div>
                        	<div class="col">
			                  ​	<div class="custom-control custom-checkbox">
		                          	<input class="custom-control-input" type="checkbox" id="customCheckbox6" value="option6">
		                          	<label for="customCheckbox6" class="custom-control-label title-label" title="Fecha de Registro">F. Reg.</label>
	                        	</div>
                        	</div>
                        	<div class="col">
			                  ​	<div class="custom-control custom-checkbox">
		                          	<input class="custom-control-input" type="checkbox" id="customCheckbox6" value="option6">
		                          	<label for="customCheckbox6" class="custom-control-label title-label" title="Fecha de Salida">F. Salida</label>
	                        	</div>
                        	</div>
                        	<div class="col">
			                  ​	<div class="custom-control custom-checkbox">
		                          	<input class="custom-control-input" type="checkbox" id="customCheckbox6" value="option6">
		                          	<label for="customCheckbox6" class="custom-control-label title-label" title="Motivo">Motivo</label>
	                        	</div>
                        	</div>
		                </div>
		                 <div class="row">
		                	<div class="col">
			                  ​	<div class="custom-control custom-checkbox">
		                          	<input class="custom-control-input" name="campo" type="checkbox" id="customCheckbox1" value="option1">
		                          	<label for="customCheckbox1" class="custom-control-label title-label" title="Sexo del Animal">Sexo</label>
	                        	</div>
                        	</div>
                        	<div class="col">
			                  ​	<div class="custom-control custom-checkbox">
		                          	<input class="custom-control-input" name="campo" type="checkbox" id="customCheckbox2" value="option2">
		                          	<label for="customCheckbox2" class="custom-control-label title-label" title="Peso Nacimiento">P. Nac.</label>
	                        	</div>
                        	</div>
                        	<div class="col">
			                  ​	<div class="custom-control custom-checkbox">
		                          	<input class="custom-control-input" name="campo" type="checkbox" id="customCheckbox3" value="option3">
		                          	<label for="customCheckbox3" class="custom-control-label title-label">Tipología</label>
	                        	</div>
                        	</div>
                        	<div class="col">
			                  ​	<div class="custom-control custom-checkbox">
		                          	<input class="custom-control-input" name="campo" type="checkbox" id="customCheckbox4" value="option4">
		                          	<label for="customCheckbox4" class="custom-control-label title-label">C. Madre</label>
	                        	</div>
                        	</div>
                        	<div class="col">
			                  ​	<div class="custom-control custom-checkbox">
		                          	<input class="custom-control-input" name="campo" type="checkbox" id="customCheckbox5" value="option5">
		                          	<label for="customCheckbox5" class="custom-control-label title-label">C. Padre</label>
	                        	</div>
                        	</div>
                        	<div class="col">
			                  ​	<div class="custom-control custom-checkbox">
		                          	<input class="custom-control-input" type="checkbox" id="customCheckbox6" value="option6">
		                          	<label for="customCheckbox6" class="custom-control-label title-label" title="Fecha de Registro">F. Reg.</label>
	                        	</div>
                        	</div>
                        	<div class="col">
			                  ​	<div class="custom-control custom-checkbox">
		                          	<input class="custom-control-input" type="checkbox" id="customCheckbox6" value="option6">
		                          	<label for="customCheckbox6" class="custom-control-label title-label">F. Salida</label>
	                        	</div>
                        	</div>
                        	<div class="col">
			                  ​	<div class="custom-control custom-checkbox">
		                          	<input class="custom-control-input" type="checkbox" id="customCheckbox6" value="option6">
		                          	<label for="customCheckbox6" class="custom-control-label title-label">Motivo</label>
	                        	</div>
                        	</div>
		                </div>
	           		 </div>
	        	</div>    
	            <div class="tab-pane" role="tabpanel" id="seccion2">
		            <div class="col-md-12 my-2"> <!-- Col1 -->
			            <div class="row">
			               	<h6>Seccion 2</h6>
			            </div>
		            </div>  
	            </div>
            <div class="card-footer clearfix">
              	<a href="#" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
              	</svg> volver</a>
              	 <button type="submit" class="btn alert-success float-right"><i class="fas fa-print"></i></button>
            </div> <!-- Cria 1 Vivo-->
          </form>
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
<link rel="stylesheet" href="/daterangepicker/daterangepicker.css">
  
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">

<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  
<!-- Select2 -->
<link rel="stylesheet" href="/select2/css/select2.min.css">
<link rel="stylesheet" href="/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">

<link rel="stylesheet" href="/css/bootstrap5/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/admin_custom.css">

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
   
  
<!-- Todo esto para e date picker-->
  <!-- bootstrap color picker -->
  <script src="/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
  <!-- moment -->
  <script src="/moment/moment.min.js"></script>

  <!-- Tempusdominus Bootstrap 4 -->
  <script src="/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!--Todo esto para el date picker-->
  
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js" integrity="sha512-zO8oeHCxetPn1Hd9PdDleg5Tw1bAaP0YmNvPY8CwcRyUk7d7/+nyElmFrB6f7vg4f7Fv4sui1mcep8RIEShczg==" crossorigin="anonymous"></script>

  <script type="text/javascript">
    $(".alert-dismissible").fadeTo(3000, 500).slideUp(500, function(){
       $(".alert-dismissible").alert('close');
	   });
  </script>
    
  {!! Html::script('js/jquery-3.5.1.min.js')!!}
  {!! Html::script('js/dropdown.js')!!}
  {!! Html::script('daterangepicker/daterangepicker.js')!!}  
  {!! Html::script('js/sweetalert2.js')!!}  
  <!-- Page script -->

<script>
    
    $('.form-trans').submit(function(e){
  
      var desde = new Date(document.getElementById('desde').value);    
      var hasta = new Date(document.getElementById('hasta').value);
      
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


@stop



