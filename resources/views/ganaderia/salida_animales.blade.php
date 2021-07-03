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
            <h3 class="card-title title-header">Salida de Series</h3>
            <div class="card-tools">
              <form method="GET" action="{{route('salida',$finca->id_finca) }}" role="search">
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
                <form action="{{ route ('serie.salida', $finca->id_finca) }}" method="POST">
                @csrf
                @error('id')
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span>
                      <strong>¡Atención! </strong>Debe seleccionar al menos un Nro. de Serie.
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @enderror
                @error('fecs')
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <span>
                    <strong>Atención! </strong>El Campo Fecha de Salida es requerido.
                  </span>         
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @enderror
                
                @error('destino')
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <span>
                    <strong>Atención! </strong>El Campo destino es requerido.
                  </span>         
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @enderror
                @error('obser')
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <span>
                    <strong>Atención! </strong>El Campo Observacion es requerido.
                  </span>         
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @enderror
            <div class="row">
              <div class="col">
                <div class="table">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col" style="width: 5%;text-align: center;">#
                        </th> 
                        <th scope="col" style="width: 8%;text-align: center;">Serie</th>
                        <th scope="col" style="width: 8%;text-align: center;">C. Mad</th>
                        <th scope="col" style="width: 8%;text-align: center;">C. Pad</th>
                        <th scope="col" style="width: 8%;text-align: center;">C. Paj</th>
                        <th scope="col" style="width: 12%;text-align: center;">Tipología</th>
                        <th scope="col" style="width: 8%;text-align: center;">Edad</th>
                        <th scope="col" style="width: 8%;text-align: center;">P. Ini</th>
                        <th scope="col" style="width: 8%;text-align: center;">P. act</th>
                         <th scope="col" style="width: 8%;text-align: center;">Sexo</th>
                        <th scope="col">Lote</th>   
                      </tr>
                   </thead>
                    <tbody>
                   @foreach($transferseries as $item)
                      <tr>
                        <td style="width: 5%;text-align: center;">
                          <div class="form-check">        
                            <input 
                              class="form-check-input" 
                              type="checkbox" 
                              value="{{ $item->id }}" id="id_serie"
                              name="id[]">
                          </div>  
                        </td>
                        <td style="width: 8%;text-align: center;">
                          {{ $item->serie }}
                        </td>
                        <td style="width: 8%;text-align: center;">
                          {{ $item->codmadre}}
                        </td>
                        <td style="width: 8%;text-align: center;">
                          {{ $item->codpadre}}
                        </td>
                        <td style="width: 8%;text-align: center;">
                         {{ $item->pajuela}}
                        </td>
                        <td style="width: 12%;text-align: center;">
                          {{ $item->tipo }}
                        </td>
                        <td style="width: 8%;text-align: center;">
                          {{ $item->edad }}
                        </td>
                        <td style="width: 8%;text-align: center;">
                           {{ $item->pesoi }}
                        </td>
                        <td style="width: 8%;text-align: center;">
                          {{ $item->pesoactual }}
                        </td>
                        <td style="width: 8%;text-align: center;">
                          {!! $item->sexo?"Macho":"Hembra" !!}  
                        </td>
                        <td style="width: 8%;text-align: center;">
                          {{ $item->nombrelote }}
                        </td>
                      </tr>
                    </tbody>
                    @endforeach()
                  </table>
              </div>  
              <hr>
              <div class="row">
                  <div class="col-4">
                    <label class="col-form-label">Fec. Salida:
                    </label>
                    <div class="input-group mb-3">
                      <input 
                      type="date" 
                      name="fecs"
                      min="1980-01-01" 
                      max="2031-12-31"
                      class="form-control" 
                      aria-label="fnac" aria-describedby="basic-addon2">
                      <span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
                      <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                      <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                      </svg></span> 
                    </div>
                  </div>  
                  
                  <div class="col-4">
                    <label class="col-form-label">Motivo</label>
                    <select class="form-select" name="motivo" aria-label="select example">
                        <option value="" selected>Seleccione una opción</option>
                        @foreach($motivo as $item)
                        <option value="{{ $item->id}}"> {{ $item->nombremotivo }} ({{ $item->nomenclatura }})
                        </option>
                        @endforeach()
                    </select>    
                  </div>

                  <div class="col-4 ">
                    <label class="col-form-label">Destino:</label>
                    <select class="form-select" name="destino" aria-label="select example">
                        <option value="" selected>Seleccione una opción</option>
                        @foreach($destino as $item)
                        <option value="{{ $item->nombre}}"> {{ $item->nombre }}
                        </option>
                        @endforeach()
                    </select>
                  </div>
                  <div class="col">
                    <label class="col-form-label">Observación:</label>
                        <input 
                        class="form-control" 
                        id="obser" 
                        type="text"
                        name="obser"
                        maxlength="130"                   
                        value="{{ old('obser') }}">
                  </div>
              </div> <!--/.row -->
          </div>  
      </div>
    </div>       
  </div>
  <!-- /.card-body -->
  <div class="card-footer clearfix">
    <button type="submit" class="btn alert-success aling-boton">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zm14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5z"/>
      </svg> Retirar</button>
  </div>
</form>
</div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title title-header">Series Retiradas</h3>
          
          <a href="{{ route ('reportes_histsalida', $finca->id_finca) }}" title="Ver Reportes" class="btn btn-default float-right"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-text" viewBox="0 0 16 16">
          <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
          <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
          </svg></a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
                          <div class="table">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col" style="width: 8%;text-align: center;">Serie</th>
                        <th scope="col" style="width: 8%;text-align: center;">F. Sal</th>
                        <th scope="col" style="text-align: center;">Motivo</th>
                        <th scope="col" style="text-align: center;">Destino</th>
                        <th scope="col" style="text-align: center;">Observación</th>
                      </tr>
                   </thead>
                    <tbody>
                   @foreach($salidarealizada as $item)
                      <tr>
                        <td style="width: 8%;text-align: center;">
                          {{ $item->serie }}
                        </td>
                         <td style="width: 12%;text-align: center;">
                          {{ $item->fechs }}
                        </td>
                        <td style="text-align: center;">
                          {{ $item->motivo }}
                        </td>
                        <td style="text-align: center;">
                          {{ $item->destino}}
                        </td>
                        <td style="text-align: center;">
                          {{ $item->obser}}
                        </td>
                      </tr>
                    </tbody>
                    @endforeach()
                  </table>
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
    

@stop
