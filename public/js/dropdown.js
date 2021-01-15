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
$('#tipo_temporal').change(function(event){
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





