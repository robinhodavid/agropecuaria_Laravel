<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reporte Catálogo de Pajuela</title>

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
                <label class="title-report-name">Reporte: Catálogo de Pajuela</label>
                <label>{{ $fechadereporte }}</label>        
            </div>
            <div>
          <div>
        <table class="table table-bordered">
          <thead class="title-table">
            <tr>
              <th style="width: 8%;"></th>
              <th style="width: 12%; text-align: center;"></th>
              <th style="width: 12%;text-align: center;"></th>
              <th style="width: 12%;"></th>
              <th style="width: 12%; text-align: center;"></th>
              <th style="width: 12%; text-align: center;"></th>
              <th colspan="3" style="width: 8%; text-align: center;">DISPONIBILIDAD STOCK</th>
              <th colspan="2" style="width: 8%;text-align: center;"></th>
          
            </tr>
            <tr>
              <th scope="col" style="width: 8%;text-align: center;">Serie</th>
              <th scope="col" style="width: 12%;text-align: center;">Raza</th>
              <th scope="col" style="width: 12%;text-align: center;">Nombre</th>
              <th scope="col" style="width: 12%;text-align: center;">F. Registro</th>
              <th scope="col" style="width: 8%;text-align: center;">F. Naci.</th>
              <th scope="col" style="width: 8%;text-align: center;">Ubicación</th>
              <th scope="col" style="width: 8%;text-align: center;">Cant.</th>
              <th scope="col" style="width: 8%;text-align: center;">C. Mín</th>
              <th scope="col" style="width: 8%;text-align: center;">C. Máx</th>
              <th scope="col">Observación</th>

            </tr>
         </thead>
          <tbody>
         @foreach($pajuela as $item)
            <tr class="text-body-table">
              <td style="width: 8%;text-align: center;">
                {{ $item->serie }}
              </td>
              <td style="width: 12%;text-align: center;">
                {{ $item->nombreraza }}
              </td>
              <td style="width: 12%;text-align: center;">
                {{ $item->nomb }}
              </td>
               <td style="width: 12%;text-align: center;">
                {{ $item->fecr }}
              </td>
              <td style="width: 8%;text-align: center;">
                {{ $item->fnac }}
              </td>
              <td style="width: 8%;text-align: center;">
                {{ $item->ubica}}
              </td>
              <td style="width: 8%;text-align: center;">
               {{ $item->cant}}
              </td>
              <td style="width: 8%;text-align: center;">
                {{ $item->mini }}
              </td>
              <td style="width: 8%;text-align: center;">
                {{ $item->maxi }}
              </td>
              <td style="width: 8%;text-align: center;">
               {{ $item->obser }}
              </td>
            
            </tr>
          </tbody>
        @endforeach()
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
