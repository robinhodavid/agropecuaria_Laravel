@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')

<div class="container">
	<div class="row">
        <div class="col-12">
            <div class="card">
	            <div class="card-header">
	                <h3 class="card-title title-header">Asignar serie (s) a un Lote/Sub lote</h3>
	                <div class="card-tools">
		                <form method="GET" action="#" role="search">
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
				                <th scope="col">
				                  
				                </th> 
				                <th scope="col">Serie</th>
				                <th scope="col">Lote</th>
				                <th scope="col">Sub Lote</th>
				                <th scope="col">Tipología</th>
			              </tr>
			            </thead>
	            		<tbody>
		              		@foreach ($asignarseries as $item)
		                	<tr>
			                  	<td>
					                <div class="form-check">        
					                      <input 
					                      class="form-check-input" 
					                      type="checkbox" 
					                      value="{{ $item->id}}" id="id_serie"
					                      name="id[]">
					                </div>  
			                  	</td>
			                    <td>
			                     {{ $item->serie}}
			                    </td>
			                    <td>
			                     {{ $item->nombrelote}}
			                    </td>
			                    <td>
			                      {{ $item->sub_lote}}
			                    </td>
			                    <td>
			                      {{ $item->tipo}}
			                    </td>
		                    </tr>
	             	 		@endforeach()
            			</tbody>
               		</table>
                <div class="col title-table">{{  $asignarseries->links() }}</div>
                </div>

              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
            	<div class="card-header">
            		
            	</div>
            </div>
        </div>
    </div> <!-- /.row-->        

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
