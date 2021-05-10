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
          <h3 class="card-title title-header">Series Para Reproducción</h3>
           @if(session('msj'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>¡Felicidades!</strong> {{ session('msj') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
          <form method="GET" action="{{ route ('serieslotemonta',[$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo]) }}" role="search">
            @csrf
            <div class="card-tools search-table">
              <div class="input-group input-group-sm" style="width: 250px;">
                <input type="text" name="serie" id="serie" class="form-control float-right" placeholder="Buscar Serie...">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                  </div>
              </div>
            </div>
        </form>
        </div>
        <!-- /.card-header -->
        <form action="{{ route ('asignarserieslotemonta', [$finca->id_finca, $temp_reprod->id, $ciclo->id_ciclo] ) }}" method="POST">
            @csrf
            @error('lote')
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <span>
                  <strong>¡Atención! </strong>El campo Lote es obligatorio.
                </span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @enderror
        <div class="card-body table-responsive p-0">
          <div class="row ml-2 mr-2">

            <div class="col">
              <label class="col-form-label">Lote de Monta</label>
                <select class="form-select" name="lote" 
                        id="lote" aria-label="select example">
                  <option value=" " selected>Seleccione una opción</option>
                  @foreach($lote as $item)
                    <option value="{{ $item->id_lotemonta}}">{{ $item->nombre_lote}}</option>
                  @endforeach()
                </select>  
            </div>
            <!--
            <div class="col">
              <label class="col-form-label">Sublote de Monta</label>
                <select class="form-select" name="sublote" 
                  id="sexo" aria-label="select example">
                  <option value=" " selected>Seleccione una opción</option>
                    @foreach($sublote as $item)
                      <option value="{{ $item->sub_lote}}">{{ $item->sub_lote}}</option>
                    @endforeach()
                </select> 
            </div>
          -->
            <div class="col">
              <label class="col-form-label form-group">F. Inicial.</label>
                  <div class="input-group mb-3 form-group">
                    <input 
                    type="date" 
                    id="fechainicialciclo"
                    name="fechainicialciclo"
                    min="{{$ciclo->fechainicialciclo}}" 
                    max="2031-12-31"
                    class="form-control" 
                    readonly="true" 
                    aria-label="fechainicialciclo" aria-describedby="basic-addon2"
                    value="{{$ciclo->fechainicialciclo}}">
                  <span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
                  <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                  <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                  </svg></span> 
                </div>  
            </div>
            <div class="col">
              <label class="col-form-label">F. Final.</label>
                  <div class="input-group mb-3">
                    <input 
                    type="date" 
                    name="fechafinalciclo"
                    id="fechafinalciclo"
                    min="{{$ciclo->fechafinalciclo}}" 
                    max="2031-12-31"
                    class="form-control" 
                    readonly="true" 
                    value="{{$ciclo->fechafinalciclo}}"
                    aria-label="fechafinalciclo" aria-describedby="basic-addon2">
                  <span class="input-group-text" id="basic-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week" viewBox="0 0 16 16">
                  <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                  <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                  </svg></span> 
                </div>    
            </div>
            <div class="col">
              <label class="col-form-label">Duración E. (M-D)</label>
                  <input 
                  class="form-control" 
                  id="duracion" 
                  type="text" 
                  name="duracion"  
                  placeholder="(M-D)" 
                  readonly="true" 
                  value="{{ $ciclo->duracion }}">
            </div>
          </div> 

          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th scope="col" style="width: 5%;text-align: center;">#
                  </th> 
                <th style="width: 8%">Serie</th>
                <th style="width: 8%">C. Madre</th>
                <th style="width: 10%">Tipología E.</th>
                <th style="width: 10%">Edad (A-M)</th>
                <th style="width: 10%">P. Act</th>
                <th style="width: 10%">Sexo</th>
                <th style="width: 10%">Lote Est</th>
              </tr>
            </thead>
            <tbody>
             @foreach($seriesrepro as $item)
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
                  <td>
                    {{ $item->serie }}
                  </td>
                  <td>
                    {{ $item->codmadre }}
                  </td>
                  <td>
                    {{ $item->nomenclatura }}
                  </td>
                  <td>
                    {{$item->edad}}
                  </td>
                  <td>
                      {{$item->pesoactual}}
                  </td>
                  <td>
                       {!! $item->sexo?"Macho":"Hembra" !!}  
                  </td>
                  <td>
                    {{ $item->nombrelote}}
                  </td>
              </tr>
           @endforeach()
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
         <div class="card-footer clearfix">
           <div class="row">
             <div class="col-8">
             {{ $seriesrepro->links() }}  
             </div>
             <div class="col-4">
               <button type="submit" class="btn alert-success aling-boton">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zm14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5z"/>
                </svg></button>
                <a href="{{ route('temporada.detalle',[$finca->id_finca, $temp_reprod->id] ) }}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
              </svg></a>
             </div>
           </div>
           </form>
         </div>
      </div>
      <!-- /.card -->
    </div>
</div>

<div class="row">
  <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title title-header">Series Asignadas al Lote de Reproducción</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>

                <th></th>
                <th colspan="1" style="text-align: center;">Reprodución</th>
                <th colspan="2" style="text-align: center;">Tipología</th>
                <th colspan="2" style="text-align: center;">Fecha de Monta</th>
                <th style="text-align: center;"></th>
              </tr>
              <tr>

                <th>Serie</th>
                <th style="text-align: center;">Lote</th>
                 <th style="text-align: center;">Entrante</th>
                <th style="text-align: center;">Saliente</th>
                <th style="text-align: center;">Inicio</th>
                <th style="text-align: center;">Final</th>
              </tr>
            </thead>
            <tbody>
          @foreach($monta as $item)
                <tr> 
                  <td>
                  {{ $item->serie }}
                  </td>
                  <td>
                   {{ $item->nombre_lote }}
                  </td>

                  <td>
                    {{ $item->nombre_tipologia }}
                  </td>
                     <td>
                    {{ $item->tipologia_salida }}
                  </td>
                  <td>
                    {{ $item->finim }}
                  </td>
                  <td>
                    {{ $item->ffinm }}
                  </td>
              </tr>
        @endforeach()
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
         <div class="card-footer clearfix">
           <div class="col">
            
           </div>
           <div class="col">
            
           </div>
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
    {!! Html::script('bootstrap4-duallistbox/jquery.bootstrap-duallistbox.js')!!}   
    
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
