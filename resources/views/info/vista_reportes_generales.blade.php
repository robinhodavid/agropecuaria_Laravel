@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')

@stop

@section('content')
<div class="container">
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item title-tipo" role="presentation">
      <a class="nav-link active" href="#seccion1" arial-controls="seccion1" data-toggle="tab" role="tab">Listado de Reportes</a>
    </li>
  </ul>
@csrf

<div class="row my-4">
      <div class="col"> 
        <div role="tabpanel">        
          <div class="tab-content">
            <div class="tab-pane active" role="tabpanel" id="seccion1">
          <table class="table">
          <thead class="title-table">
            <tr>
              <th scope="col" style="width: 8%;text-align: center;">#</th>
              <th scope="col" style="width: 70%;text-align: left;">Reporte</th>
              <th scope="col" style="width: 12%;text-align: center;">Acción</th>
            </tr>
         </thead>
          <tbody>  
          <tr class="text-body-table">
              <td style="width: 8%;text-align: center;">
                <p>1</p> 
              </td>
               <td style="width: 70%;text-align: left;">
                <p>Ficha de Ganado</p>
              </td>
              <td style="width: 12%;text-align: center;">
                <a href="{{ route('reportes_catalogodeganado', $finca->id_finca) }}" class="btn alert-success btn-sm"><i class="fas fa-search"></i> </a>
                </div>
              </td>
            </tr>    
            <tr class="text-body-table">
              <td style="width: 8%;text-align: center;">
                <p>2</p> 
              </td>
               <td style="width: 70%;text-align: left;">
                <p>Ficha de Pajuela</p>
              </td>
              <td style="width: 12%;text-align: center;">
                <a href="{{ route('reportes_pajuela', $finca->id_finca) }}" class="btn alert-success btn-sm"><i class="fas fa-search"></i> </a>
                </div>
              </td>
            </tr>
            <tr class="text-body-table">
              <td style="width: 8%;text-align: center;">
                <p>3</p> 
              </td>
               <td style="width: 70%;text-align: left;">
                <p>Historial de Salida</p>
              </td>
              <td style="width: 12%;text-align: center;">
                <a href="{{ route('reportes_histsalida', $finca->id_finca) }}" class="btn alert-success btn-sm"><i class="fas fa-search"></i></a>
                </div>
              </td>
            </tr>
            <tr class="text-body-table">
              <td style="width: 8%;text-align: center;">
                <p>4</p> 
              </td>
               <td style="width: 70%;text-align: left;">
                <p>Movimiento de Lote</p>
              </td>
              <td style="width: 12%;text-align: center;">
                <a href="" class="btn alert-success btn-sm"><i class="fas fa-search"></i></a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        </div>
      </div>
  </div>
  </div>
</div>





<!-- /. Cierro aquí los reportes-->

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


  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js" integrity="sha512-zO8oeHCxetPn1Hd9PdDleg5Tw1bAaP0YmNvPY8CwcRyUk7d7/+nyElmFrB6f7vg4f7Fv4sui1mcep8RIEShczg==" crossorigin="anonymous"></script>

  <script type="text/javascript">
    $(".alert-dismissible").fadeTo(3000, 500).slideUp(500, function(){
       $(".alert-dismissible").alert('close');
     });
  </script>
    
  {!! Html::script('js/jquery-3.5.1.min.js')!!}
  {!! Html::script('js/dropdown.js')!!}
  {!! Html::script('daterangepicker/daterangepicker.js')!!}  
<!-- Page script -->
<script>
 //Date range picker
    $('#reservation').daterangepicker()  
</script>



@stop
