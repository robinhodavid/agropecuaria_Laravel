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


