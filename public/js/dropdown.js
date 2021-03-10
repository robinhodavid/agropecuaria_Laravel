//Permite filtrar y cargar el select Sub-Lote de forma dinamica.
$('#nombrelote').change(function(event){
    $.get(`/home/ganaderia/asignar-series/${event.target.value}`, function(response,nombrelote){
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

//Permite filtrar y cargar el select Lote de forma dinamica segun el tipo.
$('#tipo_estrategico').change(function(event){
        $.get(`/home/ganaderia/asignar-series/tipo/${event.target.value}`, function(response,tipo){
        console.log(response);
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



