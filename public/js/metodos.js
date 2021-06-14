/*
$('#additem').on('click', function() {
    var idt = document.getElementById("idtitulo").value;
	var idtitulo = parseInt(idt);
	//ahora se lo pasamos al modal
	$("#iddelanota").val(idtitulo);     
});
*/

//Con esta funcion obtenemos la informacion y la pasamos al modal
obtenerItem = function(id, contenido){
	$("#iditemnota").val(id);
	$("#itemcontent").val(contenido);
};

//Con esto mostramos los campos de reporte de celos 
if ($('#celos').prop('checked') ) {
    $(".celos").show();
    $(".servicios").hide();
    $(".palpaciones").hide();
    $(".prenez").hide();
    $(".parto").hide();
    $(".aborto").hide();
    $(".pnc").hide();
    } else {
    $(".celos").hide();
    $(".servicios").show();
    $(".palpaciones").show();
    $(".prenez").show(); 
    $(".parto").show();
    $(".aborto").show();
    $(".pnc").show();
}

//Con este los llenaremos si se hacen cambios en tiempo real
$('#celos').on('change', function() {
    if ($(this).is(':checked') ) {        
        $(".celos").show(); 
        $(".servicios").hide();
        $(".palpaciones").hide();
        $(".prenez").hide();
        $(".parto").hide();
        $(".aborto").hide();
        $(".pnc").hide();
    } else {
        $(".celos").hide();
        $(".servicios").show();
        $(".palpaciones").show(); 
        $(".prenez").show();
        $(".parto").show();
        $(".aborto").show();
        $(".pnc").show(); 
    }
});

$('#servicios').on('change', function() {
    if ($(this).is(':checked') ) {        
        $(".servicios").show(); 
        $(".celos").hide();
        $(".palpaciones").hide();
        $(".prenez").hide();
        $(".parto").hide();
        $(".aborto").hide();
        $(".pnc").hide();
    } else {
        $(".servicios").hide();
        $(".celos").show();
        $(".palpaciones").show();
        $(".prenez").show();
        $(".parto").show();
        $(".aborto").show();
        $(".pnc").show();
    }
});

$('#palpaciones').on('change', function() {
    if ($(this).is(':checked') ) {        
        $(".servicios").hide(); 
        $(".celos").hide();
        $(".palpaciones").show();
        $(".prenez").hide();
        $(".parto").hide();
        $(".aborto").hide();
        $(".pnc").hide();
    } else {
        $(".servicios").show();
        $(".celos").show();
        $(".palpaciones").hide();
        $(".parto").show();
        $(".aborto").show();
        $(".pnc").show();
    }
});

$('#prenez').on('change', function() {
    if ($(this).is(':checked') ) {        
        $(".servicios").hide(); 
        $(".celos").hide();
        $(".palpaciones").hide();
        $(".prenez").show();
        $(".parto").hide();
        $(".aborto").hide();
        $(".pnc").hide();
    } else {
        $(".servicios").show();
        $(".celos").show();
        $(".palpaciones").show();
        $(".prenez").hide();
        $(".parto").show();
        $(".aborto").show();
        $(".pnc").show();
    }
});

$('#partos').on('change', function() {
    if ($(this).is(':checked') ) {        
        $(".servicios").hide(); 
        $(".celos").hide();
        $(".palpaciones").hide();
        $(".prenez").hide();
        $(".parto").show();
        $(".aborto").hide();
        $(".pnc").hide();
    } else {
        $(".servicios").show();
        $(".celos").show();
        $(".palpaciones").show();
        $(".prenez").show();
        $(".parto").hide();
        $(".aborto").show();
        $(".pnc").show();
    }
});

$('#abortos').on('change', function() {
    if ($(this).is(':checked') ) {        
        $(".servicios").hide(); 
        $(".celos").hide();
        $(".palpaciones").hide();
        $(".prenez").hide();
        $(".parto").hide();
         $(".aborto").show();
         $(".pnc").hide();
    } else {
        $(".servicios").show();
        $(".celos").show();
        $(".palpaciones").show();
        $(".prenez").show();
        $(".parto").show();
        $(".aborto").hide();
        $(".pnc").show();

    }
});

$('#partopnc').on('change', function() {
    if ($(this).is(':checked') ) {        
        $(".servicios").hide(); 
        $(".celos").hide();
        $(".palpaciones").hide();
        $(".prenez").hide();
        $(".parto").hide();
         $(".aborto").hide();
         $(".pnc").show();
    } else {
        $(".servicios").show();
        $(".celos").show();
        $(".palpaciones").show();
        $(".prenez").show();
        $(".parto").show();
        $(".aborto").show();
        $(".pnc").hide();

    }
});
