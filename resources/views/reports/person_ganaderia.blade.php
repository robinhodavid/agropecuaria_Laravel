<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reporte Personalizado Catálogo de Ganado</title>

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
                <label class="title-report-name">Reporte Personalizado: Catálogo de Ganado</label>
                <label>{{ $fechadereporte }}</label>        
            </div>
            <div>
              @if($indicador==0)
                <h5 style="text-align: center;"> No se seleccionó ningún campo para este reporte</h5>             
              @else
                <div>
                  <table class="table table-bordered">
                      @if( ($option->count()>0) )
                      <thead>                  
                        <tr class="title-header-table">  
                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                              <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="option1")
                                <th>
                                  Serie
                                </th>                                  
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="option2")
                                <th>
                                  Raza                                
                                </th>
                              @endif
                            @endforeach()   
                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="option3")
                                <th>
                                  F. Nac
                                </th>                                  
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="option4")
                                <th>
                                  Sexo                              
                                </th>
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="option5")
                                <th>
                                  Tipología                                
                                </th>
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="option6")
                                <th>
                                  Cod. Madre                                
                                </th>
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="option7")
                                <th>
                                  Cod. Padre                                
                                </th>
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="option8")
                                <th>
                                  F. Registro                                
                                </th>  
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="option9")
                                <th>
                                  P. Nac                                
                                </th>
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="option10")
                                <th>
                                  Ult. Pesaje                                
                                </th>
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="option11")
                                <th>
                                  F. Destete                                
                                </th>
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="option12")
                                <th>
                                  P. Destete                                
                                </th>
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="option13")
                                <th>
                                  Lote                                
                                </th>
                              @endif
                            @endforeach()

                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="option14")
                                <th>
                                  P. Actual                                
                                </th>
                              @endif
                            @endforeach()
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($reportGanaderia as $item)
                          <tr>
                            <!--Recorremos el array -->   
                            @foreach($option as $k)
                            <!--Comparamos si una de las opciones de igual a la primera para mostrar-->
                              @if($k=="option1")
                              <td>
                                {{ $item->serie}}                                
                              </td>  
                              @endif
                            @endforeach()   

                            @foreach($option as $k)
                              @if($k=="option2")
                              <td>
                                {{ $item->nombreraza}}                                
                              </td>
                              @endif
                            @endforeach()     
                            
                            @foreach($option as $k)
                              @if($k=="option3")
                                <td>
                                  {{ $item->fnac}}                                
                                </td>    
                              @endif
                            @endforeach() 
                            
                            @foreach($option as $k)  
                              @if($k=="option4")   
                                <td>                           
                                  {!!$item->sexo?"M":"H"!!}                                
                                </td>   
                              @endif
                            @endforeach() 

                            @foreach($option as $k)  
                              @if($k=="option5")
                                <td>
                                  {{ $item->nomenclatura }}                                
                                </td>
                              @endif
                            @endforeach() 
                              
                            @foreach($option as $k)   
                              @if($k=="option6")
                                <td>
                                  {{ $item->codmadre }}                                
                                </td> 
                              @endif
                            @endforeach() 
                              
                            @foreach($option as $k)  
                              @if($k=="option7")
                                <td>
                                  {{ $item->codpadre}}                                
                                </td> 
                              @endif
                            @endforeach() 
                              
                              @foreach($option as $k)  
                                @if($k=="option8")
                                  <td>
                                    {{ $item->fecr}}
                                  </td>                                   
                                @endif
                              @endforeach() 
                              
                              @foreach($option as $k)  
                                @if($k=="option9")
                                  <td>
                                    {{ $item->pesoi}}                                
                                  </td> 
                                @endif
                              @endforeach() 
                              
                              @foreach($option as $k)  
                                @if($k=="option10")
                                  <td>
                                    {{ $item->fulpes}}                                
                                  </td> 
                                @endif
                              @endforeach() 
                              
                              @foreach($option as $k)  
                                @if($k=="option11")
                                  <td>
                                    {{ $item->fecdes}}                                
                                  </td> 
                                @endif
                              @endforeach() 
                              
                              @foreach($option as $k)  
                                @if($k=="option12")
                                  <td>
                                    {{ $item->pesodestete}}                                
                                  </td> 
                                @endif
                              @endforeach() 
                              
                              @foreach($option as $k)  
                                @if($k=="option13")
                                  <td>
                                    {{ $item->nombrelote}}                                
                                  </td> 
                                @endif
                              @endforeach() 
                          
                              @foreach($option as $k)  
                                @if($k=="option14")
                                  <td>
                                    {{ $item->pesoactual}}                                
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
