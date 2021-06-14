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
                <label class="title-report-name">Reporte Personalizado: Reproducción - Preñeces</label>
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
                              @if($k=="pre1")
                                <th>
                                  Serie
                                </th>                                  
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pre2")
                                <th>
                                  F. Reg                              
                                </th>
                              @endif
                            @endforeach()   
                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pre3")
                                <th>
                                  F. Preñez
                                </th>                                  
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pre4")
                                <th>
                                 F. Servicio                       
                                </th>
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pre5")
                                <th>
                                  Paju                            
                                </th>
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pre6")
                                <th>
                                  Resp                               
                                </th>
                              @endif
                            @endforeach()
                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pre7")
                                <th>
                                  IEDA                               
                                </th>
                              @endif
                            @endforeach()

                             <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pre8")
                                <th>
                                  IEP                               
                                </th>
                              @endif
                            @endforeach()

                             <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pre9")
                                <th>
                                  F. Apróx. Parto                              
                                </th>
                              @endif
                            @endforeach()

                             <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pre10")
                                <th>
                                  Tiempo de Preñez                            
                                </th>
                              @endif
                            @endforeach()

                             <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pre11")
                                <th>
                                  Toro Temp.                               
                                </th>
                              @endif
                            @endforeach()

                             <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="pre12")
                                <th>
                                  Método de Preñez                           
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
                              @if($k=="pre1")
                              <td>
                                {{ $item->serie}}                                
                              </td>  
                              @endif
                            @endforeach()   

                            @foreach($option as $k)
                              @if($k=="pre2")
                              <td>
                                {{ $item->fregp}}                                
                              </td>
                              @endif
                            @endforeach()     
                            
                            @foreach($option as $k)
                              @if($k=="pre3")
                                <td>
                                  {{ $item->fepre}}                                
                                </td>    
                              @endif
                            @endforeach() 
                            
                            @foreach($option as $k)  
                              @if($k=="pre4")   
                                <td>                           
                                  {{ $item->fecser }}                                
                                </td>   
                              @endif
                            @endforeach() 

                            @foreach($option as $k)  
                              @if($k=="pre5")
                                <td>
                                  {{ $item->toropaj }}                                
                                </td>
                              @endif
                            @endforeach() 
                              
                            @foreach($option as $k)   
                              @if($k=="pre6")
                                <td>
                                  {{ $item->nomi}}                                
                                </td> 
                              @endif
                            @endforeach() 
                            @foreach($option as $k)   
                              @if($k=="pre7")
                                <td>
                                  {{ $item->intdiaabi}}                                
                                </td> 
                              @endif
                            @endforeach() 
                            @foreach($option as $k)   
                              @if($k=="pre8")
                                <td>
                                  {{ $item->intestpar}}                                
                                </td> 
                              @endif
                            @endforeach() 
                            @foreach($option as $k)   
                              @if($k=="pre9")
                                <td>
                                  {{ $item->fecap}}                                
                                </td> 
                              @endif
                            @endforeach() 
                            @foreach($option as $k)   
                              @if($k=="pre10")
                                <td>
                                  {!!$item->dias_prenez==null? $item->mesespre." M" : $item->dias_prenez." D"!!}                                
                                </td> 
                              @endif
                            @endforeach() 
                            @foreach($option as $k)   
                              @if($k=="pre11")
                                <td>
                                  {{$item->torotemp}}                            
                                </td> 
                              @endif
                            @endforeach()

                            @foreach($option as $k)   
                              @if($k=="pre12")
                                <td>
                                  {{$item->metodo}}                            
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
