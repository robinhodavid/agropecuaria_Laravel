<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reporte Manejo de Vientre</title>

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
                <label class="title-report-name">Reporte: Manejo de Vientre</label>
                <label>{{ $fechadereporte }}</label>        
            </div>
            <div>
                <div>
                <table class="table">
                    <thead>  
                        @foreach($mvmadres as $vientre)                    
                            <tr>
                                <th colspan="2" style="background-color:#eaeaea; font-size: 18px;">VIENTRE: {{$vientre->serie}} </th>
                                
                                <th colspan="2" style="background-color:#eaeaea; font-size: 18px;">N° CRÍAS: {{$vientre->sgmv1s_count}} </th>
                                
                            </tr>
                             <tr class="title-header-table">
                              <th>Tipología: {{$vientre->tipo}}</th>
                              <th>Parto. Reg: {{$vientre->nparto}}</th>
                              <th>N°. Aborto: {{$vientre->nabortoreport}}</th>
                              <th>Lote: {{$vientre->nombrelote}}</th>
                            </tr>
                            <tr>
                              <th>Fec. N.: {{$vientre->fnac}}</th>
                              <th>F. Apróx Parto: {{$vientre->fecaproxparto}}</th>
                              <th>N°. Parto NC: {{$vientre->npartonc}}</th>
                              <th>Intervalo Días Abiertos (IDA): {{$vientre->ida}}</th>              
                            </tr>                    
                            <tr>
                              <th>Edad (A-M): 
                                @if($vientre->edad==null)
                                {{$vientre->anho}} - {{$vientre->mes}}
                                @else
                                 {{$vientre->edad}}
                                @endif
                                </th>
                              <th>Meses de Preñez: {{$vientre->mesesprenada}}</th>
                              <th>N°. Servicios: {{$vientre->nservi}}</th>
                              <th>Observación: {{$vientre->observa}}</th> 

                            </tr>
                            <tr>
                                <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                            </tr>
                            <tr>
                              <th></th>
                              <th>Caso</th>
                              <th>Serie</th>
                              <th>Tipologia</th>
                              <th>Peso Destete</th>
                              <th>Padre</th>
                              <th>Fecha Parto / Aborto</th>
                              <th>IEE</th>
                              <th>IEP</th>
                            </tr>    
                    </thead>
                        <tbody>
                        @foreach($vientre->sgmv1s as $cria)          
                        <tr>
                            <td style="text-align:left; text-transform: uppercase;"> 
                            </td>
                            <td style="text-align:left; text-transform: uppercase;">

                                {!!$cria->caso=="PREÑ"?"":$cria->caso!!}
                            </td>
                            <td style="text-align:center;">
                                {{$cria->serie_hijo}}                                                 
                            </td>
                            <td style="text-align:center;">
                                {{$cria->tipologia}}
                            </td>
                            <td style="text-align:center;">
                                {{$cria->pesodestete}}
                            </td>
                            <td style="text-align:center;">
                                {{$cria->codpadre}}
                                {{$cria->pajuela}}
                            </td>
                            <td style="text-align:center;">
                                {{$cria->fecha}}
                            </td>
                            <td style="text-align:center;">
                                
                            </td>
                            <td style="text-align:center;">
                                
                            </td>
                            
                        </tr>
                        @endforeach()
                                
                    </tbody>
                @endforeach() 
                </table>
            </div> 
        
        </div>
<!--<script type="text/javascript"> 
  window.addEventListener("load", window.print());
</script> -->
    </body>
</html>
