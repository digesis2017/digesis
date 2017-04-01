$(document).ready(function() {

	$( "#form" ).submit(function( event ) {
		var desde = $("#desde").val();
		var hasta = $("#hasta").val();

		if ( new Date(desde).getTime() > new Date(hasta).getTime() ) {
			alert('Coloque Fechas Correctas');
			event.preventDefault();
		}
		else
			return;
	});


	var url = $("#url").val() ? $("#url").val() : '';

	$("#rjefeid").change(function() {
		var tecnicos = $("#rtecnicoid");
		tecnicos.find('option').remove();
		tecnicos.append('<option value="0">-Seleccione-</option>')
		var supervisores = $("#rsupervisorid");
		var jefes = $(this)
		if($(this).val() != '' && $(this).val() != 0) {
			$.ajax({
				data: { id : jefes.val() },
				url:   url + '/ajaxSupervisores',
				type:  'POST',
				dataType: 'json',
				beforeSend: function () {
					jefes.prop('disabled', true);
				},
				success:  function (r) {
					jefes.prop('disabled', false);
					supervisores.find('option').remove();
					$(r).each(function(i, v) {
						supervisores.append('<option value="' + v.id + '">' + v.nombre + '</option>');
					})
					supervisores.prop('disabled', false);
				}
			});
		}
		else {
			supervisores.find('option').remove();
			supervisores.prop('disabled', true);
		}
	});

	$("#rsupervisorid").change(function() {
		var tecnicos = $("#rtecnicoid");
		var supervisores = $(this)
		if($(this).val() != '' && $(this).val() != 0) {
			$.ajax({
				data: { id : supervisores.val() },
				url:   url + '/ajaxTecnicos',
				type:  'POST',
				dataType: 'json',
				beforeSend: function () {
					supervisores.prop('disabled', true);
				},
				success:  function (r) {
					supervisores.prop('disabled', false);
					tecnicos.find('option').remove();
					$(r).each(function(i, v) {
						tecnicos.append('<option value="' + v.id + '">' + v.nombre + '</option>');
					})
					tecnicos.prop('disabled', false);
				}
			});
		}
		else {
			tecnicos.find('option').remove();
			tecnicos.prop('disabled', true);
		}
	});

});