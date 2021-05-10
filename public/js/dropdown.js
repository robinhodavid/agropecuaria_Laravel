
//Permite filtrar y cargar el select Lote de forma dinamica segun el tipo.
$('#tipo_estrategico').change(function(event){
        $.get(`/home/ganaderia/asignar-series/tipo/${event.target.value}`, function(response,tipo){
        console.log(event.target.value);
        $("#nombrelote").empty();
            response.forEach(element => {   
            $("#nombrelote").append(`<option value='${element.nombre_lote}'> ${element.nombre_lote} </option>`);
        });
    });
}); 
$('#tipo_temporada').change(function(event){
        $.get(`/home/ganaderia/asignar-series/tipo/${event.target.value}`, function(response,tipo){
        console.log(response);
        $("#nombrelote").empty();
            response.forEach(element => {   
            $("#nombrelote").append(`<option value='${element.nombre_lote}'> ${element.nombre_lote} </option>`);
        });
    });
}); 
$('#tipo_pastoreo').change(function(event){
        $.get(`/home/ganaderia/asignar-series/tipo/${event.target.value}`, function(response,tipo){
        console.log(response);
        $("#nombrelote").empty();
            response.forEach(element => {   
            $("#nombrelote").append(`<option value='${element.nombre_lote}'> ${element.nombre_lote} </option>`);
        });
    });
}); 

//Permite filtrar y cargar el select Sub-Lote de forma dinamica.
$('#nombrelote').change(function(event){
    $.get(`/home/sisga-admin/finca/${event.target.value}/ganaderia/asignar-series/${event.target.value}`, function(response,nombrelote){
        
        ///home/ganaderia/asignar-series/
        console.log(response);

         if ($.trim(response) != '') {
         $("#sublote").empty();
            response.forEach(element => {   
            $("#sublote").append(`<option value='${element.sub_lote}'> ${element.sub_lote} </option>`);
        });
            } else {
            $("#sublote").empty();  
            $("#sublote").append(`<option value=''> No posee Sub lote </option>`);
         }
    }); 
});


//Permite filtrar y cargar el select tipologia de forma dinamica de forma dinamica.
$('#sexo').change(function(event){
    $.get(`/home/ganaderia/ficha-de-ganado/sexo/${event.target.value}`, function(resp,sexo){
        console.log(resp);

         if ($.trim(resp) != '') {
         $("#tipologia").empty();
            resp.forEach(element => {   
            $("#tipologia").append(`<option value='${element.id_tipologia}'> ${element.nombre_tipologia} </option>`);
        });
            } else {
            $("#tipologia").empty();  
            $("#tipologia").append(`<option value=''> Seleccione una opción </option>`);
         }
    }); 
});

//Permite cargar el select si es de toro o es pajuela.
// Comprobacion usando .prop() (jQuery > 1.6)

// Comprobacion usando .prop() (jQuery > 1.6)

//Con esto llenaremos el campo campos. 
if ($('#espajuela').prop('checked') ) {
    console.log("Checkbox seleccionado");
    $("#seriepadre").hide();
    $("#pajuela").show();
    } else {
    $("#seriepadre").show();
    $("#pajuela").hide();
}


//Con este los llenaremos si se hacen cambios en tiempo real
$('#espajuela').on('change', function() {
    if ($(this).is(':checked') ) {
        //console.log("Checkbox " + $(this).prop("id") +  " (" + $(this).val() + ") => Seleccionado");
          $("#seriepadre").hide();
          $("#pajuela").show(); 
    } else {
        //console.log("Checkbox " + $(this).prop("id") +  " (" + $(this).val() + ") => Deseleccionado");
        $("#seriepadre").show();
        $("#pajuela").hide();
    }
});

/*
*Función que permie calcular en tiempo real la diferencia de dia 
*para el calculo de peso.
*/
$('#fecha').on('change',function(){
       calculodia();
});

function calculodia()
{
    
    var fecr = new Date(document.getElementById('fecr').value);    
    var fulpes = new Date(document.getElementById('fulpes').value);
    var fecha = new Date(document.getElementById('fecha').value);

    if  ( isNaN(fulpes) ) {
        if (fulpes > fecha) {
        alert('Error: Fecha de último Pesaje no puede ser mayor a la Fecha de Pesaje');
        } else {
            var difdia =fecha.getTime() - fecr.getTime();
            var contdia = Math.round(difdia/(1000*60*60*24));
            $("#difdia").val(contdia);
        }
        
        } else {
        if (fulpes > fecha) {
                alert('Error: Fecha de último Pesaje no puede ser mayor a la Fecha de Pesaje');
            } else {
                var difdia =fecha.getTime() - fulpes.getTime();
                var contdia = Math.round(difdia/(1000*60*60*24));
                $("#difdia").val(contdia);
            }      
        }      
} 
/*
*Función que permie calcular en tiempo real GDP 
*y peso ganado.
*/
$('#peso').on('change',function(){
       console.log ('hoka');
       calculogdp();
});

function calculogdp(){
    var peso = document.getElementById('peso').value;
    var pesoactual = document.getElementById('pesoactual').value;
    var dias = document.getElementById('dias').value;
    var gdp = (peso - pesoactual)/dias;
    var pesoganado = gdp * dias;
    
    if (pesoactual > peso) {
        alert('Info: Se sugiere revisar el valor de Peso, la serie presenta perdida de peso');
        var gdp = (peso - pesoactual)/dias;    
        $("#gdp").val(gdp);
        $("#pgan").val(pesoganado);
    } else {
        var gdp = (peso - pesoactual)/dias;
        $("#gdp").val(gdp);
        $("#pgan").val(pesoganado);    
    }

}

/*
* Con esto se permite que una serie pueda ser activada a través de un
* motivo de entrada, con su respectiva fecha de entrada. 
*/

if ($('#status').prop('checked') ) {
    console.log("Checkbox seleccionado");
    $("#motivo_e").hide();
    $("#label_motivo_e").hide();
    } else {
    $("#motivo_e").hide();
    $("#label_motivo_e").hide();
}
/*
* Con este Colocaremos que el campo motivo de entrada  
* si se hacen cambios en tiempo real
*/
$('#status').on('change', function() {
    if ($(this).is(':checked') ) {
          $("#motivo_e").show(); 
          $("#label_motivo_e").show();
    } else {
        $("#motivo_e").hide();
        $("#label_motivo_e").hide();
    }
});

/*
*Función que permie calcular la fecha final basado en 9 meses  
*/

$('#fecini').on('change',function(){
       console.log('Hola Fecha');
       var day = 365; //Días que duraría la temporada reproductiva
       calculosumadias(day);
});

function calculosumadias(day)
{
    //var fecini = new Date(document.getElementById('fecini').value);
    var fecini = new Date($('#fecini').val());
    //console.log(fecini);    
    var dias = day; //Equivale a 9 meses de toda la temporada de reproducción 11 meses
    fecini.setDate(fecini.getDate() + dias);
    console.log(fecini); 
    fecfin = fecini.toJSON().slice(0,10); // Se transforma para que lo tome. 
    $("#fecfin").val(fecfin);
} 

/*
*Función que permie calcular la fecha final basado en 3 meses  
*/
$('#fechainicialciclo').on('change',function(){
    //   console.log('Hola Fecha');
       var day = 90;
       caldate(90);
       duracion();
});

$('#fechafinalciclo').on('change',function(){
    //   console.log('Hola Fecha');
       duracion();
});

function caldate(day)
{
    
    var fecini = new Date($('#fechainicialciclo').val());
    //var fecfin = new Date(document.getElementById('fechafinalciclo').value);
    //console.log(fecini);    
    var dias = day; //Equivale a 9 meses de toda la temporada de reproducción 11 meses
    
    fecini.setDate(fecini.getDate() + dias);
    //console.log(fecini); 
    fecfin = fecini.toJSON().slice(0,10); // Se transforma para que lo tome. 
    $("#fechafinalciclo").val(fecfin);    
   
} 

function duracion(){
    //Fecha Inicial de Ciclo
    var fechaini = new Date(document.getElementById('fechainicialciclo').value);
    var fechafini = new Date(document.getElementById('fechafinalciclo').value);
    var year1 = fechaini.getFullYear();
    var year2 = fechafini.getFullYear();
    var month1 = fechaini.getMonth()+1; 
    var month2 = fechafini.getMonth();
    
    numberOfMonths=(year2-year1)*12+(month2-month1);

     if  ( isNaN(fechafini) ) {

         alert('Error en Fecha: Fecha Final no posee valor - Seleccione una Fecha');

     }

    if (fechaini > fechafini) {
        alert('Error en Rango de Fecha: Fecha Inicial no puede ser mayor a la Fecha Final');
        } else {
            if (numberOfMonths==0) {
               var difdia =fechafini.getTime() - fechaini.getTime();
               var contdia = Math.round(difdia/(1000*60*60*24));
               diadura = contdia;
            } else {
                var difdia =fechafini.getTime() - fechafini.getTime();
                var contdia = Math.floor(difdia/(1000*60*60*24));
                var daymes = fechafini.getDate();
                diadura = daymes;
            }    
        }
    if (diadura <0) {
        diadura = diadura*(-1);
    }

    dura = numberOfMonths +"-"+ diadura;

    $("#duracion").val(dura);  
}

/*
* Aqui el procedimiento o function que permite calcular los Intervalos entre Registro de Celos
*/
/*
*Función que permie calcular en tiempo real la diferencia de dia 
*para el calculo de peso.
*/


$('#fregistro').on('change',function(){
    
    var dec = document.getElementById('dec').value;
    calproxcelo(dec);    
    calculoier();
    calintdiaabi();
    
});


function calculoier()
{
    
    var fregistro = new Date(document.getElementById('fregistro').value);    
    var fecu = new Date(document.getElementById('fecu').value);
 

    if  ( isNaN(fecu) ) {
        if (fecu > fregistro) {
        alert('Error en Rango de Fecha: Fecha de Último Celo o Servicio no puede ser mayor a la Fecha de Registro Actual');
        } else {
            var difdia = fregistro.getTime() - fregistro.getTime();
            var contdia = Math.round(difdia/(1000*60*60*24));
           
            $("#ier").val(contdia);
        }
        
        } else {
        if (fecu > fregistro) {
         alert('Error en Rango de Fecha: Fecha de Último Celo o Servicio no puede ser mayor a la Fecha de Registro Actual');
            } else {
                var difdia =fregistro.getTime() - fecu.getTime();
                var contdia = Math.round(difdia/(1000*60*60*24));
                
                $("#ier").val(contdia);
            }      
        }        
}

  function calproxcelo(day)
{
    
    //var fechaini = new Date($('#fregistro').val());
    var fechaini = new Date(document.getElementById('fregistro').value);   
    var dias = parseInt(day);
    //console.log(dias);     //Equivale a 9 meses de toda la temporada de reproducción 11 meses
    fechaini.setDate(fechaini.getDate() + dias);
    //console.log(fecini); 
    fecfin = fechaini.toJSON().slice(0,10); // Se transforma para que lo tome. 
    $("#fproxcelo").val(fecfin);    
   
} 

function calintdiaabi()
{
    
    var fregistro = new Date(document.getElementById('fregistro').value);    
    var fecup = new Date(document.getElementById('fecup').value);
    
    if  ( isNaN(fecup) ) {
    
        if (fecup > fregistro) {
            alert('Error en Rango de Fecha: Fecha de Último Parto no puede ser mayor a la Fecha de Registro Actual');
        } else {
            var difdia = fregistro.getTime() - fregistro.getTime();
            var contdia = Math.round(difdia/(1000*60*60*24));
            $("#ida").val(contdia);
        }
        
        } else {
        if (fecup > fregistro) {
         alert('Error en Rango de Fecha: Fecha de Último Parto no puede ser mayor a la Fecha de Registro Actual');
            } else {
                var difdia = fregistro.getTime() - fecup.getTime();
                 var contdia = Math.round(difdia/(1000*60*60*24));
                $("#ida").val(contdia);
            }      
        }        
}

$('#fecharegistro').on('change',function(){
    /*
    * Esto es por cada cambio en el campo Fecha de Registro limpie los campos.
    */
    $("#festipre").val("");
    $("#faprosecado").val(""); 
    $("#faproparto").val("");  
    diaprenez(); 
    var tsecado = document.getElementById('tsecado').value;
    fechaaproxsecado(tsecado);

    var tgesta = document.getElementById('tgesta').value; 
    fechaaproxparto(tgesta); 

    intdiaabi();

    calculoierparto();


});
$('#mesesprenez').on('change',function(){
    /*
    * Esto es por cada cambio en el campo Fecha de Registro limpie los campos.
    */
    $("#festipre").val("");
    $("#faprosecado").val(""); 
    $("#faproparto").val(""); 
    diaprenez(); 
    var tsecado = document.getElementById('tsecado').value;
    fechaaproxsecado(tsecado);

    var tgesta = document.getElementById('tgesta').value; 
    fechaaproxparto(tgesta); 

    intdiaabi();

    calculoierparto();

});

function diaprenez()
{
    
    var fregistro = new Date(document.getElementById('fecharegistro').value);    
    var fecus = new Date(document.getElementById('fecus').value);
    

    if ($('#nral').prop('checked') ) {
        if  ( isNaN(fecus) ) {
            if (fecus > fregistro) {
            alert('Error en Rango de Fecha: Fecha de Servicio Anterior no puede ser mayor a la Fecha de Registro Actual');
            } else {
                var difdia = fregistro.getTime() - fregistro.getTime();
                //var contdia = Math.round(difdia/(1000*60*60*24));
                //$("#diaprenez").val(contdia);
                var mpz = document.getElementById('mesesprenez').value;
                var contdia = (parseInt(mpz))*30; 
                //Con esto calculamos en este mismo procedimiento la fecha aproximada de preñez
                fregistro.setDate(fregistro.getDate() - contdia);
                var fecprenez = fregistro.toJSON().slice(0,10);  
                $("#festipre").val(fecprenez);
            }
        } else {
        if (fecus > fregistro) {
         alert('Error en Rango de Fecha: Fecha de Servicio Anterior no puede ser mayor a la Fecha de Registro Actual');
            } else {
                var difdia =fregistro.getTime() - fecus.getTime();
                //var contdia = Math.round(difdia/(1000*60*60*24));
                //$("#diaprenez").val(contdia);
                var mpz = document.getElementById('mesesprenez').value;
                var contdia = (parseInt(mpz))*30; 
                //Con esto calculamos en este mismo procedimiento la fecha aproximada de preñez
                fregistro.setDate(fregistro.getDate() - contdia);
                var fecprenez = fregistro.toJSON().slice(0,10);
                $("#festipre").val(fecprenez);
            }      
        }
   
    }else{
    
        if  ( isNaN(fecus) ) {
        if (fecus > fregistro) {
        alert('Error en Rango de Fecha: Fecha de Servicio Anterior no puede ser mayor a la Fecha de Registro Actual');
        } else {
            var difdia = fregistro.getTime() - fregistro.getTime();
            var contdia = Math.round(difdia/(1000*60*60*24));
            $("#diaprenez").val(contdia);

            //Con esto calculamos en este mismo procedimiento la fecha aproximada de preñez
            fregistro.setDate(fregistro.getDate() - contdia);
            var fecprenez = fregistro.toJSON().slice(0,10);
            $("#festipre").val(fecprenez);
        }
        
        } else {
        if (fecus > fregistro) {
         alert('Error en Rango de Fecha: Fecha de Servicio Anterior no puede ser mayor a la Fecha de Registro Actual');
            } else {
                var difdia =fregistro.getTime() - fecus.getTime();
                var contdia = Math.round(difdia/(1000*60*60*24));
                $("#diaprenez").val(contdia);
                
                //Con esto calculamos en este mismo procedimiento la fecha aproximada de preñez
                fregistro.setDate(fregistro.getDate() - contdia);
                var fecprenez = fregistro.toJSON().slice(0,10);
                $("#festipre").val(fecprenez);
            }      
        }
    }          
}  

function fechaaproxsecado(dias)
{
   //var fechaaproxparto = new Date(document.getElementById('faproparto').value);    

    var fprenez = new Date(document.getElementById('festipre').value);    
    var days = parseInt(dias);

    fprenez.setDate(fprenez.getDate() + days);
    var fechasecado = fprenez.toJSON().slice(0,10);
            $("#faprosecado").val(fechasecado);
           
}

function fechaaproxparto(dias)
{
    var fprenez = new Date(document.getElementById('festipre').value);    
    
    var days = parseInt(dias);

    fprenez.setDate(fprenez.getDate() + days);
    var fechaaproxparto = fprenez.toJSON().slice(0,10);
            $("#faproparto").val(fechaaproxparto);
           
}

function intdiaabi()
{
    
    var fregistro = new Date(document.getElementById('fecharegistro').value);    
    var fecup = new Date(document.getElementById('fecup').value);
    
    if  ( isNaN(fecup) ) {
        if (fecup > fregistro) {
        alert('Error en Rango de Fecha: Fecha de Último Parto no puede ser mayor a la Fecha de Registro Actual');
        } else {
            var difdia = fregistro.getTime() - fregistro.getTime();
            var contdia = Math.round(difdia/(1000*60*60*24));
            $("#ida").val(contdia);
        }
        
        } else {
        if (fecup > fregistro) {
         alert('Error en Rango de Fecha: Fecha de Último Parto no puede ser mayor a la Fecha de Registro Actual');
            } else {
                var difdia =fregistro.getTime() - fecup.getTime();
                var contdia = Math.round(difdia/(1000*60*60*24));
                $("#ida").val(contdia);
            }      
        }        
}

function calculoierparto()
{
    
    var fecup = new Date(document.getElementById('fecup').value);    
    var faproxparto = new Date(document.getElementById('faproparto').value);
 

    if  ( isNaN(fecup) ) {
        if (fecup > faproxparto) {
        alert('Error en Rango de Fecha: Fecha de Último Parto no puede ser mayor a la Fecha Aproximada Parto');
        } else {
            var difdia = faproxparto.getTime() - faproxparto.getTime();
            var contdia = Math.round(difdia/(1000*60*60*24));
            $("#ier").val(contdia);
        }
        
        } else {
        if (fecup > faproxparto) {
         alert('Error en Rango de Fecha: Fecha de Último Parto no puede ser mayor a la Fecha Aproximada Parto');
            } else {
                var difdia =faproxparto.getTime() - fecup.getTime();
                var contdia = Math.round(difdia/(1000*60*60*24));
                $("#ier").val(contdia);
            }      
        }        
}

/*
*--> Aquí ocultamos los campos si es pajuela o Toro
*/
//Con esto llenaremos el campo campos. 
if ($('#serie_paju').prop('checked') ) {
    console.log("Checkbox seleccionado");
        $(".col-toro").hide();
        $(".col-paju").show();
        //$("#cantpaju").show();
        //$("#resp").show();
    } else {
        $(".col-toro").show();
        $(".col-paju").hide();
        //$("#cantpaju").hide();
        //$("#resp").hide();
}

//Con este los llenaremos si se hacen cambios en tiempo real
$('#serie_toro').on('change', function() {
    if ($(this).is(':checked') ) {
        //console.log("Checkbox " + $(this).prop("id") +  " (" + $(this).val() + ") => Seleccionado");
          $(".col-paju").hide();
          $(".col-toro").show(); 
    } else {
        //console.log("Checkbox " + $(this).prop("id") +  " (" + $(this).val() + ") => Deseleccionado");
        $(".col-paju").show();
        $(".col-toro").hide();
    }
});
//Con este los llenaremos si se hacen cambios en tiempo real
$('#serie_paju').on('change', function() {
    if ($(this).is(':checked') ) {
        //console.log("Checkbox " + $(this).prop("id") +  " (" + $(this).val() + ") => Seleccionado");
          $(".col-paju").show();
          $(".col-toro").hide(); 
    } else {
        //console.log("Checkbox " + $(this).prop("id") +  " (" + $(this).val() + ") => Deseleccionado");
        $(".col-paju").hide();
        $(".col-toro").show();
    }
});

//Nos permitirá mostrar el campo Días de preñez si es de tipo inseminación. 
if ($('#mia').prop('checked') ) {
    console.log("Checkbox seleccionado");
    $("#mesesprenez").hide();
    $("#labelmeses").hide();
    $("#diaprenez").show();
    $("#labeldias").show();
        } else {
    $("#mesesprenez").show();
    $("#labelmeses").show();
    $("#diaprenez").hide();
    $("#labeldias").hide();
}

//Si hay cambios en el input nos mostrará ya sea el campo díasde preñez o meses de preñez.
$('#mia').on('change', function() {
    if ($(this).is(':checked') ) {
        //console.log("Checkbox " + $(this).prop("id") +  " (" + $(this).val() + ") => Seleccionado");
          $("#mesesprenez").hide();
          $("#labelmeses").hide();
          $("#diaprenez").show(); 
          $("#labeldias").show();
    } else {
        //console.log("Checkbox " + $(this).prop("id") +  " (" + $(this).val() + ") => Deseleccionado");
        $("#mesesprenez").show();
        $("#labelmeses").show();
        $("#diaprenez").hide();
        $("#labeldias").hide();

    }
});

//Si hay cambios en el input nos mostrará ya sea el campo díasde preñez o meses de preñez.
$('#monta_mixta').on('change', function() {
    if ($(this).is(':checked') ) {
        
        $("#mesesprenez").show();
        $("#labelmeses").show();
        $("#diaprenez").hide();
        $("#labeldias").hide();  
    } else {        
        $("#mesesprenez").hide();
        $("#labelmeses").hide();
        $("#diaprenez").show(); 
        $("#labeldias").show();
    }
});

//Si hay cambios en el input nos mostrará ya sea el campo díasde preñez o meses de preñez.
$('#nral').on('change', function() {
    if ($(this).is(':checked') ) {
        
        $("#mesesprenez").show();
        $("#labelmeses").show();
        $("#diaprenez").hide();
        $("#labeldias").hide();  
    } else {        
        $("#mesesprenez").hide();
        $("#labelmeses").hide();
        $("#diaprenez").show(); 
        $("#labeldias").show();
    }
});

if ($('#customCheckbox1').prop('checked') ) {
        $( '.tab-cri a[data-toggle=tab]' ).removeClass( 'disabled' );
    } else {
        $( '.tab-cri a[data-toggle=tab]' ).addClass( 'disabled' ); 
}

//Con este los llenaremos si se hacen cambios en tiempo real
$('#customCheckbox1').on('change', function() {
    if ($(this).is(':checked') ) {
        //quitamos la clase disable
        $( '.tab-cri a[data-toggle=tab]' ).removeClass( 'disabled' );
    } else {
        $( '.tab-cri a[data-toggle=tab]' ).addClass( 'disabled' ); 
    }
});
/*
* Esto es para ocultar o mostrar el form de nacimiento muerto
*/

$('#cria1').on('click', function() {

    if ($('#vivo').prop('checked') ) {
        $(".becerrovivo").show();
        $(".becerromuerto").hide();
        } else {
        $(".becerrovivo").hide();
        $(".becerromuerto").show();
    }    
});

$('#cria2').on('click', function() {
    
    if ($('#vivo2').prop('checked') ) {
        $(".becerrovivo").show();
        $(".becerromuerto").hide();
        } else {
        $(".becerrovivo").hide();
        $(".becerromuerto").show();
    }    
}); 

if ($('#vivo').prop('checked') ) {
    $(".becerrovivo").show();
    $(".becerromuerto").hide();
    } else {
    $(".becerrovivo").hide();
    $(".becerromuerto").show();
}

//Con este los llenaremos si se hacen cambios en tiempo real
$('#vivo').on('change', function() {
    if ($(this).is(':checked') ) {
        $(".becerrovivo").show();
        $(".becerromuerto").hide(); 
    } else {
        $(".becerrovivo").hide();
        $(".becerromuerto").show();
    }
});

if ($('#muerto').prop('checked') ) {
    $(".becerrovivo").hide();
    $(".becerromuerto").show();
    } else {
    $(".becerrovivo").show();
    $(".becerromuerto").hide();
}

$('#muerto').on('change', function() {
    if ($(this).is(':checked') ) {
        $(".becerrovivo").hide();
        $(".becerromuerto").show(); 
    } else {
        $(".becerrovivo").show();
        $(".becerromuerto").hide();
    }
}); 

if ($('#vivo2').prop('checked') ) {
    $(".becerrovivo").show();
    $(".becerromuerto").hide();
    } else {
    $(".becerrovivo").hide();
    $(".becerromuerto").show();
}

//Con este los llenaremos si se hacen cambios en tiempo real
$('#vivo2').on('change', function() {
    if ($(this).is(':checked') ) {
        $(".becerrovivo").show();
        $(".becerromuerto").hide(); 
    } else {
        $(".becerrovivo").hide();
        $(".becerromuerto").show();
    }
}); 

if ($('#muerto2').prop('checked') ) {
    $(".becerrovivo").hide();
    $(".becerromuerto").show();
    } else {
    $(".becerrovivo").show();
    $(".becerromuerto").hide();
}

$('#muerto2').on('change', function() {
    if ($(this).is(':checked') ) {
        $(".becerrovivo").hide();
        $(".becerromuerto").show(); 
    } else {
        $(".becerrovivo").show();
        $(".becerromuerto").hide();
    }
});     

/*
*-->>>>>>>>
*/        

if ($('#peso').prop('checked') ) {
 
    $("#porpeso").removeAttr("readonly");
    $("#poredad").attr("readonly","readonly");
    //$("#pajuela").show();
    } else {
    $("#porpeso").attr("readonly","readonly");
    $("#poredad").removeAttr("readonly");
}


//Con este los llenaremos si se hacen cambios en tiempo real
$('#peso').on('click', function() {
    if ($(this).is(':checked') ) {
        $("#porpeso").removeAttr("readonly");
        $("#poredad").attr("readonly","readonly");
    } else {
        $("#porpeso").attr("readonly","readonly");
        $("#poredad").removeAttr("readonly");
    }
});


//Con este los llenaremos si se hacen cambios en tiempo real
$('#edad').on('change', function() {
    if ($(this).is(':checked') ) {
        $("#poredad").removeAttr("readonly");
        $("#porpeso").attr("readonly","readonly");
    } else {
        $("#poredad").attr("readonly","readonly");
        $("#porpeso").removeAttr("readonly");
    }
});

//Con este los llenaremos si se hacen cambios en tiempo real
$('#edad_peso').on('click', function() {
    if ($(this).is(':checked') ) {
       $("#porpeso").removeAttr("readonly");
       $("#poredad").removeAttr("readonly");
    } else {
        $("#porpeso").attr("readonly","readonly");
        $("#poredad").attr("readonly","readonly");
    }
});

// Se harcode por efecto de rapidez
$('#ta').on('change', function() {
    var tipoactual = document.getElementById('ta').value;
    
    if (tipoactual=="MAUTE") {
        var tipopropuesta = "TORETE"
        $("#tipopropuesta").val(tipopropuesta);     
    } else if (tipoactual=="TORETE") {
        var tipopropuesta = "TORO PADROTE"
        $("#tipopropuesta").val(tipopropuesta);
    } else if (tipoactual=="MAUTA") {
        var tipopropuesta = "NOVILLA"
        $("#tipopropuesta").val(tipopropuesta);
    } else {
        var tipopropuesta = ""
        $("#tipopropuesta").val(tipopropuesta);
    }   
});