@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-7"> <!-- Col1 -->
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col">
              <div class="col title-header">Asiganción de serie</div>
            </div>
            <div class="col">
              <form method="GET" action="{{route('asignarseries',$finca->id_finca) }}" role="search">
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
          <form action="{{ route ('serielote.asignar', $finca->id_finca) }}" method="POST">
            @csrf
            @error('nombrelote')
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <span>
                  <strong>¡Atención! </strong>El campo Lote es obligatorio.
                </span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @enderror
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
            <div class="row">
              <div class="col">
                <div class="table">
                  <table class="table">
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
              </div>  
          </div>  
      </div>
    </div>
  </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              
                <div class="col title-table">{{  $asignarseries->links() }}</div>
              
            </div>
          </div>
    </div>
    <div class="col-md-5">
      <div class="card">
                <div class="card-header">
                   <div class="title-header">Lotes y sublotes</div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <label class="my-3" for="serie">Tipo de Lote</label> 
                <div class="form-check">
                    <input 
                    type="radio" 
                    aria-label="Radio button for following text input"
                    name="tipo"
                    class="form-check-input" 
                    id="tipo_estrategico" value="Estrategico">
                    <label class="form-check-label"  for= "estrategico">Estratégico</label>
                  </div>  
                  <div class="form-check">
                    <input 
                    type="radio" 
                    aria-label="Radio button for following text input"
                    name="tipo"
                    class="form-check-input" 
                    id="tipo_temporada" value="Temporada">
                    <label class="form-check-label"  for="temporada">Temporada</label> 
                  </div>  
                   <div class="form-check"> 
                    <input 
                    type="radio" 
                    aria-label="Radio button for following text input"
                    name="tipo"
                    class="form-check-input" 
                    id="tipo_pastoreo" value="Pastoreo">
                    <label class="form-check-label"   for="pastoreo">Pastoreo</label>
                  </div>    
        <div class="select-lote">
            <label>Lote</label>                   
                  {!! Form::select('nombrelote',[''=>'Seleccione un Lote'],null,['id'=>'nombrelote', 'class'=>'form-select']) !!}
        </div>
        <div class="select-sublote">
            <label>Sub Lote</label>
            {!! Form::select('sublote',[''=>'Seleccione un Sublote'],null,['id'=>'sublote', 'size'=>'5','class'=>'form-select']) !!}
        </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                  <button type="submit" class="btn alert-success aling-boton">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
                  <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 0 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
              </svg> Registrar</button>
                <a href="{{ route ('lote', $finca->id_finca) }}" class="btn btn-warning aling-boton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                </svg> volver</a>
                </div>
                  </form>
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
