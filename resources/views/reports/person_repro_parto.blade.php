<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reporte Personalizado - Reproducción </title>

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        -->
        <!--<link rel="stylesheet" href="{{ env('APP_URL') }}/css/admin_custom.css"> -->
        <!-- Styles -->
        <style>
            /*
            * Estilos del membrete del reporte.
            */
            /**********************************/
            
            *
            {
               font-family: Arial, Helvetica, sans-serif;
               font-size: 15px;
            }
            .title-membrete
            {
               font-size: 20px;
               font-weight: 500;
               text-align: left;
               margin-right: 470px; 
            }
            .title-system
            {
               font-size: 13px;
               font-style: 500;    
            }
             
            .title-report-name
            {
                font-size: 13px;
                font-weight: 500px;
                font-family: Arial, Helvetica, sans-serif;
                margin-right: 390px;
                line-height: 25px;
            }
            /**********************************/
            /*
            * Estilos De la tabla
            */
            th
            {
                text-align: center;
                vertical-align: middle;
                border: 1px solid #eaeaea;
                background-color: #eaeaea;
                color: #333;
                padding-left: 26px;
                padding-right: 26px;
                margin-top: 160px;
                font-size: 14px;
            } 
           td
            {
                text-align: center; 
            }   
            .resumen-data 
            {
                margin-top: 40px;
                background-color: #eaeaea;
                border:1px solid #aeaeae;
                border-radius: 3px; 
                width: 17%;
            }
            .content-resumen-data 
            {
               font-size: 15px;
              line-height: 2;
              margin-left: 10px;   
              font-weight: 600;   
            }
            
        </style>
    </head>
    <body>
        <div>
            <div>
                <label class="title-membrete">{{$finca->nombre}}</label>  
                <label>SISGA</label>
            </div>
            <div>
                <label class="title-report-name">Reporte Personalizado: Reproducción - Partos</label>
                <label>{{ $fechadereporte }}</label>        
            </div>
            <div>
              @if($indicador==0)
                <h5 style="text-align: left;"> No se seleccionó ningún campo para este reporte</h5>             
              @else
                <div>
                  <table class="table table-bordered">
                      @if( ($option->count()>0) )
                      <thead>                  
                        <tr class="title-header-table">  
                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                              <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pa1")
                                <th>
                                  Serie
                                </th>                                  
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pa2")
                                <th>
                                 Tipología                            
                                </th>
                              @endif
                            @endforeach()   
                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pa3")
                                <th>
                                  Estado
                                </th>                                  
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pa4")
                                <th>
                                 Edad                       
                                </th>
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pa5")
                                <th>
                                  F.U. Parto                         
                                </th>
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pa6")
                                <th>
                                  F. Parto                               
                                </th>
                              @endif
                            @endforeach()
                           
                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pa8")
                                <th>
                                  Cría 1                            
                                </th>
                              @endif
                            @endforeach()

                             <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pa9")
                                <th>
                                  Cría 2                             
                                </th>
                              @endif
                            @endforeach()

                             <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pa10")
                                <th>
                                  Obs. Parto
                                </th>
                              @endif
                            @endforeach()

                             <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pa11")
                                <th>
                                  IERP                               
                                </th>
                              @endif
                            @endforeach()

                             <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pa12")
                                <th>
                                  Condición
                                </th>
                              @endif
                            @endforeach()
                             <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pa13")
                                <th>
                                  Causa M                           
                                </th>
                              @endif
                            @endforeach()
                             <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pa14")
                                <th>
                                 Obs. Muerte                         
                                </th>
                              @endif
                            @endforeach()
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($reporteReproducion as $item)
                          <tr>
                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pa1")
                              <td>
                                {{ $item->serie}}                                
                              </td>  
                              @endif
                            @endforeach()   

                            @foreach($option as $k)
                              @if($k=="pa2")
                              <td>
                                {{ $item->tipo}}                                
                              </td>
                              @endif
                            @endforeach()     
                            
                            @foreach($option as $k)
                              @if($k=="pa3")
                                <td>
                                  {{ $item->estado}}                                
                                </td>    
                              @endif
                            @endforeach() 
                            
                            @foreach($option as $k)  
                              @if($k=="pa4")   
                                <td>                           
                                  {{ $item->edad }}                                
                                </td>   
                              @endif
                            @endforeach() 

                            @foreach($option as $k)  
                              @if($k=="pa5")
                                <td>
                                  {{ $item->fecup }}                                
                                </td>
                              @endif
                            @endforeach() 
                              
                            @foreach($option as $k)   
                              @if($k=="pa6")
                                <td>
                                  {{ $item->fecpar}}                                
                                </td> 
                              @endif
                            @endforeach() 
                           
                            @foreach($option as $k)   
                              @if($k=="pa8")
                                <td>
                                  {{ $item->becer}} 
                                   
                                  @if(($item->sexo==null) && ($item->sexo==0))
                                  H
                                  @else
                                  M
                                  @endif                               
                                </td> 
                              @endif
                            @endforeach() 
                            @foreach($option as $k)   
                              @if($k=="pa9")
                                <td>
                                  {{ $item->becer1}} 
                                 <strong> ({!!$item->sexo1?"♂":"♀" !!})</strong>
                                  @if($item->sexo1===null)
                                  ( )
                                  @endif
                                 </td> 
                              @endif
                            @endforeach() 
                            @foreach($option as $k)   
                              @if($k=="pa10")
                                <td>
                                  {!!$item->obspar==null?$item->obspar1:$item->obspar !!}                                
                                </td> 
                              @endif
                            @endforeach() 
                            @foreach($option as $k)   
                              @if($k=="pa11")
                                <td>
                                  {{$item->ientpar}}                            
                                </td> 
                              @endif
                            @endforeach()

                            @foreach($option as $k)   
                              @if($k=="pa12")
                                <td>
                                  {!!$item->marcabec1==null?$item->marcabec2:$item->marcabec1!!}                           
                                </td> 
                              @endif
                            @endforeach()  
                            @foreach($option as $k)   
                              @if($k=="pa13")
                                <td>
                                  {!!$item->causanm==null?$item->causanm1:$item->causanm!!}                           
                                </td> 
                              @endif
                            @endforeach()  
                            @foreach($option as $k)   
                              @if($k=="pa14")
                                <td>
                                  {!!$item->obsernm==null?$item->obsernm1:$item->obsernm!!}                           
                                </td> 
                              @endif
                            @endforeach()  
                          </tr>
                        @endforeach()
                      </tbody>
                      @endif
                  </table>
                </div> 
                <div class="row">
                  <div class="resumen-data">
                      <label class="content-resumen-data">Cant. registro: {{$cantregistro}} </label>
                      <br>
                     
                  </div>
                </div>
              @endif 
        </div>
<!--<script type="text/javascript"> 
  window.addEventListener("load", window.print());
</script> -->
    </body>
</html>
