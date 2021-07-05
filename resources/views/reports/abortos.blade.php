<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reporte Abortos Registrados</title>

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
                <label class="title-report-name">Reporte: Abortos Registrados</label>
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
                              Fecha de Aborto 
                           </th>
                           <th>
                              Causa
                           </th>
                           <th>
                              Días de Preñez
                           </th>
                           <th>
                              Observación
                           </th>
                       </tr>
                    </thead>
                        <tbody>
                        @foreach($abortos as $aborto)
                        <tr>
                            <td style="text-align:center;"> 
                                {{$aborto->serie}}
                            </td>
                            <td style="text-align:center;">
                                {{$aborto->fecr}}
                            </td>
                            <td style="text-align:center;">
                                {{$aborto->causa}}
                            </td>
                            <td style="text-align:center;">
                                {{$aborto->diap}}
                            </td>
                            <td style="text-align:center;">
                                {{$aborto->obser}}
                            </td>
                        </tr>  
                      @endforeach()                                        
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="resumen-data">
                    <label class="content-resumen-data">Cant. de Animales: {{$cantregistro}} </label>
                    <br>
                </div>
            </div>
 
        </div>
<!--<script type="text/javascript"> 
  window.addEventListener("load", window.print());
</script> -->
    </body>
</html>
