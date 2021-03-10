@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')
<div class="row mb-2">
	<div class="col">
		<a href="{{ route('catalogoganadoinactivo.reporte', $finca->id_finca) }}" target="_blank" class="btn btn-default float-right"><i class="fas fa-print"></i></a>
		
		<a href="{{route('admin',$finca->id_finca)}}" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
		<path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
		</svg></a>
	</div>
</div>
<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Series Inactivas</h3>
                <div class="card-tools">
	                <form method="GET" action="{{route('series_inactivas',$finca->id_finca) }}" role="search">
	               	 	<div class="card-tools search-table">
	                    <div class="input-group input-group-sm" style="width: 185px;">
	                      <input type="text" name="serie" id="buscaserie" class="form-control float-right" placeholder="Buscar serie...">
	                        <div class="input-group-append">
	                          <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
	                        </div>
	                    </div>
	                	</div>
	              	</form>
                </div>
              </div>
              <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Serie</th>
                      <th>Cod. Madre</th>
                      <th>Cod. Padre</th>
                      <th>Tipología</th>
                      <th>Peso Actual</th>
                      <th>Lote</th>
                      <th>Sublote</th>
                      <th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                  	@foreach($seriesinactivas as $item)
                    <tr>
                      <td title="{{ $item->motivo}}">{{ $item->serie }}</td>
                      <td>{{ $item->codmadre }}</td>
                      <td>{{ $item->codpadre }}</td>
                      <td>{{ $item->tipo }}</td>
                      <td>{{ $item->pesoactual }}</td>
                      <td>{{ $item->nombrelote }}</td>
                      <td>{{ $item->sub_lote }}</td>
                      <td>
                      	<a href="{{ route('fichaganado.editar', [$finca->id_finca, $item->serie]) }}" class="btn alert-success btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg> </a>
                      </td>
                    </tr>
                    @endforeach()
                  </tbody>
                </table>
            </div>
              <!-- /.card-body -->
            <div class="card-footer clearfix">
               		{{ $seriesinactivas->links() }}
            </div>  

            </div>
            <!-- /.card -->
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js" integrity="sha512-zO8oeHCxetPn1Hd9PdDleg5Tw1bAaP0YmNvPY8CwcRyUk7d7/+nyElmFrB6f7vg4f7Fv4sui1mcep8RIEShczg==" crossorigin="anonymous"></script>
	
    <script type="text/javascript">
    $(".alert-dismissible").fadeTo(3000, 500).slideUp(500, function(){
       $(".alert-dismissible").alert('close');
	});
    </script>
    
	{!! Html::script('js/jquery-3.5.1.min.js')!!}
    {!! Html::script('js/dropdown.js')!!} 
       

@stop
