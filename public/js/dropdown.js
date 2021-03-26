
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
       var day = 290;
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

       
