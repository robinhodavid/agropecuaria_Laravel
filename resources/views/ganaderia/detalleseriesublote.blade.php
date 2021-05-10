@extends('adminlte::page')

@section('title', 'SISGA')

@section('content_header')
    
@stop

@section('content')
<div class="card">
  <div class="card-header">
    
      <a href="{{ route ('lote', $finca->id_finca) }}" class="btn btn-warning float-left"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
      </svg></a>
      <h3 class="card-title">Series asigandas al Sublote.: {{ $sublote->nombre_lote."-".$sublote->sub_lote }}</h3>

    <form method="GET" action="{{route('seriesensublote', [$finca->id_finca, $sublote->id_sublote])}}" role="search">
        <div class="card-tools search-table clearfix">
            <div class="input-group input-group-sm" style="width: 185px;">
              <input type="text" name="serie" id="buscaserie" class="form-control float-right" placeholder="Buscar serie...">
                <div class="input-group-append">
                  <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </form>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">Serie</th>
              <th scope="col">Lote asignado</th>
               <th scope="col">Sublote asignado</th>
        
            </tr>
          </thead>
          <tbody>          
                @foreach ($seriesensublote as $item)
                <tr>
                  <td>
                    <a href="{{route ('fichaganado.editar', [$finca->id_finca, $item->id]) }}" class="">
                      {{ $item->serie }}
                    </a>
                  </td>
                  <td>
                    {{ $item->nombrelote }}
                  </td>
                  <td>
                    {{ $item->sub_lote }}
                  </td>
                </tr>
                @endforeach()  
          </tbody>
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
