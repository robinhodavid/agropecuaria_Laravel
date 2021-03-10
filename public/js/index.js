$(document).ready(function (){
	$("#tabla-data").on('submit','.form-eliminar',function(){
		event.preventDefault();
		const form = $(this);
		swal({
			title: '¿Está seguro que desea eliminar el registro?',
			text: "Ésta acción no se puede revertir!",
			icon: 'warning', 
			buttons: {
				cancel: "Cancelar",
				confirm:"Aceptar"
			}, 
		}).then((value)=>{
			if (value){
				ajaxRequest(form);
			}
		});
	});

	function ajaxRequest(form){
		$.ajax({
			url: form.attr('action'),
			type: 'POST',
			data: form.seralize(),
			success: function (respuesta){
				if (respuesta.mensaje="ok"){
					form.parents('tr').remove();
					notificaciones('El registro fue eliminado correctamente', 'SISGA', 'success');
				}else {
					notificaciones('El registro puede ser eliminado, hay recursos usandolos', 'SISGA', 'success');
				}
			}
		})
	}
})