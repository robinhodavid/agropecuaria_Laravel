<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reporte Partos Registrados</title>

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
               font-size: 13px;
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
                <label class="title-report-name">Reporte: Partos Registrados</label>
                <label>{{ $fechadereporte }}</label>        
            </div>
            <div>
                <div>
                <table class="table">
                    <thead>
                    @foreach($partos as $parto)
                       <tr>
                           <th style="background-color: #eaeaea;">
                              Serie Madre: {{$parto->serie}} 
                           </th>
                           <th>
                              Tipología Antes del Parto:  {{$parto->tipoap}} 
                           </th>
                           <th>
                              Raza: {{$parto->nombreraza}} 
                           </th>
                           <th>
                              Edad: {{$parto->edad}}
                           </th>
                       </tr>
                       <tr>
                           <th>
                              N° Partos: {{$parto->nparto}} 
                           </th>
                           <th>
                              Condición Corporal: {{$parto->estado}}
                           </th>
                           <th>
                              N°. Servicios: {{$parto->nservi}}
                           </th>
                       </tr>
                       <tr>
                           <th>
                              Fecha de Parto: {{$parto->fecpar}}
                           </th>
                           <th>
                              Padre: {{$parto->toropaj}} {{$parto->torotemp}}
                           </th>
                           <th>
                              Observación: {{$parto->obspar}}
                           </th>
                       </tr>
                       <tr>
                           <th>
                               
                           </th>
                           <th>
                              Serie 
                           </th>
                           <th>
                              Sexo 
                           </th>
                           <th>
                              Condición Corporal
                           </th>
                           <th>
                              Peso Inicial
                           </th>
                           <th>
                              Raza
                           </th>
                           <th>
                              Color de Pelaje
                           </th>
                           <th>
                              IEP
                           </th>
                       </tr>
                    </thead>
                        <tbody>
                        
                        <tr> <!--Cria 1-->
                            <td style="text-align:center;">
                                <strong>Cría 1</strong>
                            </td>
                            <td style="text-align:center;"> 
                                {{$parto->becer}}
                            </td>
                            <td style="text-align:center;">                                
                                {{$parto->sexo}}
                            </td>
                            <td style="text-align:center;">
                                {{$parto->edobece}}
                            </td>
                            <td style="text-align:center;">
                                {{$parto->pesoib}}
                            </td>
                            <td style="text-align:center;">
                                @if (!($parto->becer==null) or !empty($parto->becer) )
                                    {{$parto->razabe}}
                                @endif

                            </td>
                            <td style="text-align:center;">
                                {{$parto->color_pelaje}}
                            </td>
                            <td style="text-align:center;">
                                {{$parto->ientpar}}
                            </td>
                        </tr>
                        <tr><!--Cria 2-->
                            <td style="text-align:center;"> 
                                <strong>Cría 2</strong>
                            </td>
                            <td style="text-align:center;"> 
                                {{$parto->becer1}}
                            </td>
                            <td style="text-align:center;">
                                {{$parto->sexo1}}
                            </td>
                            <td style="text-align:center;">
                                {{$parto->edobece1}}
                            </td>
                            <td style="text-align:center;">
                                {{$parto->pesoib1}}
                            </td>
                            <td style="text-align:center;">
                                @if (!($parto->becer1==null) or !empty($parto->becer1) )
                                    {{$parto->razabe}}
                                @endif
                            </td>
                            <td style="text-align:center;">
                                {{$parto->color_pelaje1}}
                            </td>
                            <td style="text-align:center;">
                                
                            </td>
                        </tr>  
                      @endforeach()                                        
                    </tbody>
                </table>
            </div>
            <div class="row my-4">
                <table>
                    <thead>
                        @foreach($partosResumen as $pR)
                        <tr>
                            <th>
                               <strong>Total Crías:</strong>{{$pR->totalcria}} 
                            </th>
                            <th>
                               <strong>Partos Promedio por Serie:</strong>{{$pR->partospromanimal}} 
                            </th>
                        </tr>
                        <tr>
                            <th>
                               <strong>Total Hembras:</strong>{{$totalHembra}} | <strong>Total Machos:</strong>{{$totalMacho}}
                            </th>
                            <th>
                               <strong>Promedio de N°. Servicios:</strong>{{$pR->promservicio}} 
                            </th>
                        </tr>
                        <tr>
                            <th>
                               <strong>Promedio IEP:</strong>{{$pR->promientpart}} 
                            </th>
                            <th>
                               <strong>Peso Promedio al Nacimiento:</strong>{{$pR->prompesoalnacer}} 
                            </th>
                        </tr>    
                        @endforeach()
                    </thead>
                   
                </table>
                <div class="resumen-data" style="padding-top: 20px;">
                    <label class="content-resumen-data">Cant. Partos: {{$cantregistro}} </label>
                    <br>
                </div>
            </div>
 
        </div>
<!--<script type="text/javascript"> 
  window.addEventListener("load", window.print());
</script> -->
    </body>
</html>
