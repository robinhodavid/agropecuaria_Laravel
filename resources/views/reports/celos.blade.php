<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reporte Celos Registrados</title>

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
                text-align: left;
                vertical-align: middle;
               
                border: 1px solid #eaeaea;
               
                color: #333;
                
                padding-left: 26px;
                padding-right: 26px;
                margin-top: 160px;
                font-size: 12px;
            } 
           td
            {
                text-align: left; 
            }   
            .resumen-data 
            {
                margin-top: 40px;
                /*background-color: #eaeaea;*/
                border:1px solid #aeaeae;
                border-radius: 3px; 
                width: 17%;
            }
            .content-resumen-data 
            {
              font-size: 12px;
              line-height: 3;
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
                <label class="title-report-name">Reporte: Celos Registrados</label>
                <label>{{ $fechadereporte }}</label>        
            </div>
            <div>
                <div>
                <table class="table">
                    <thead>  
                       <tr>
                           <th>
                              Serie 
                           </th>
                           <th>
                              Fecha de Registro 
                           </th>
                           <th>
                              Días
                           </th>
                           <th>
                              Responsable 
                           </th>
                           <th>
                              Intervalo Días Abiertos
                           </th>
                           <th>
                              Fecha Estimada Próximo Celo
                           </th>
                       </tr>
                    </thead>
                        <tbody>
                        @foreach($celos as $celo)
                        <tr>
                            <td style="text-align:center;"> 
                                {{$celo->serie}}
                            </td>
                            <td style="text-align:center;">
                                {{$celo->fechr}}
                            </td>
                            <td style="text-align:center;">
                                {{$celo->dias}}
                            </td>
                            <td style="text-align:center;">
                                {{$celo->resp}}
                            </td>
                            <td style="text-align:center;">
                                {{$celo->intdiaabi}}
                            </td>
                            <td style="text-align:center;">
                                {{$celo->fecestprocel}}
                            </td>
                        </tr>  
                      @endforeach()                                        
                    </tbody>
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
