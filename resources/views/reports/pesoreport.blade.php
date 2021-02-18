<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reporte de Peso Específico</title>

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
               font-size: 10px;
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
            }
            .content-resumen-data 
            {
                font-size: 10px; 
            }
            
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                    <label class="title-membrete">{{$finca->nombre}}</label>  
                    <label>SISGA</label>
            </div>
            <div class="row">
                <label class="title-report-name">Reporte: Registro de Peso Específico</label>
                <label>{{ $fechadereporte }}</label>        
            </div>
            <div class="row">
                <label class="title-report-name">Serie: {{ $serie->serie }}</label>
                <div class="card-especie">
                <table class="table table-bordered">
                  <thead>                  
                    <tr class="title-header-table">
                      <th>Fecha</th>
                      <th>Peso</th>
                      <th>GDP</th>
                      <th>Días</th>
                      <th>Peso Ganado</th>
                      <th>Dif Día</th>
                      <th>¿Es peso de Destete?</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($pesoreport as $item)
                    <tr>
                        <td>
                            {{ $item->fecha }}
                        </td>
                        <td>
                          {{ $item->peso }}
                        </td>
                        <td>
                          {{ $item->gdp }}
                        </td>
                        <td>
                          {{ $item->dias }}
                        </td>
                         <td>
                          {{ $item->pgan }}
                        </td>
                         <td>
                           {{ $item->difdia }}
                        </td>
                        <td style="text-align: center;">
                            <input style="text-align: center;" type="checkbox" name="destetado" disabled="true"
                            {{$item->destetado?"checked":""}}
                            >
                        </td>
                    </tr>
                    @endforeach()
                  </tbody>
                </table>
            </div> 
            <div class="row">
                <div class="resumen-data">
                    <label class="content-resumen-data">Cant. Pesaje: {{$cantregistro}} </label>
                    <br>
                    <label class="content-resumen-data">Promedio de Peso: {{ $prompeso }}</label>
                </div>
            </div>

        </div>
<!--<script type="text/javascript"> 
  window.addEventListener("load", window.print());
</script> -->
    </body>
</html>
