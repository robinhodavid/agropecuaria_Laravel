<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reporte Peso Ajustado</title>

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
                <label class="title-report-name">Reporte: Peso Ajustado</label>
                <label>{{ $fechadereporte }}</label>        
            </div>
            <div>
                <div>
                <table class="table table-bordered">
                  <thead>                  
                     <tr class="title-header-table">
                      <th>Serie</th>
                      <th>Sexo</th>
                      <th>C. Mad</th>
                      <th>Días al D</th>
                      <th>Peso D</th>
                      <th>Pa. 205 (kg)</th>
                      <th>i (%)</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($ajust as $item)
                    <tr>
                        <td>
                           {{ $item->serie }}
                        </td>
                        <td>
                           {!! $item->sexo?"M":"H" !!}
                        </td>
                        <td>
                           {{ $item->codmadre }}
                        </td>
                        <td>
                          {{ $item->difdia }}
                        </td>
                        <td>
                          {{ $item->pesdes }}
                        </td>
                         <td>
                          {{ $item->pa1 }}
                        </td>
                        <td>
                           {{ $item->c1 }}
                        </td>
                    </tr>
                    @endforeach()
                  </tbody>
                  <thead>                  
                     <tr class="title-header-table">
                      <th colspan="4"> Valores Promedios</th>
                      <th>{{$promPesoDestete}}</th>
                      <th>{{$promPa1}}</th>
                      <th></th>
                    </tr>
                  </thead>
                </table>
            </div> 
            <div class="row">
                <div class="resumen-data">
                    <label class="content-resumen-data">Cant. registro: {{$cantregistro}} </label>
                    <br>
                   
                </div>
            </div>

        </div>
<!--<script type="text/javascript"> 
  window.addEventListener("load", window.print());
</script> -->
    </body>
</html>
