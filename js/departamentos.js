$(document).ready(function() {

	$('.solo-numero').keyup(function (){
		this.value = (this.value + '').replace(/[^0-9]/g, '');
	});

	var publish = $("#publish").val();
	if ( publish == 0 )
		$(".inactivo").show('slow');
	$("#publish").change(function() {
		if ( $("#publish").val() == 0 )
			$(".inactivo").show('slow');
		else
			$(".inactivo").hide('slow');
	});

	$( "#form" ).submit(function( event ) {
		if ( $("#dptoid").val() != 0 ) {
			if ( $("#provinciaid").val() != 0 ) {
				if ( $("#distritoid").val() != 0 )
					return;
				else
					alert('Seleccione Distrito');
			}
			else
				alert('Seleccione Provincia');
			event.preventDefault();
		}
		else
			return;
	});

	$( "#tusuarioform" ).submit(function( event ) {
		alert('Datos Guardados');
	});


	if ( !$("#distritoid").val() ) {
		$("#distritoid").prop('disabled', true);
		$("#provinciaid").prop('disabled', true);
	}

	var url = $("#url").val() ? $("#url").val() : '';

	$("#estadoid").change(function() {
		var motivos = $("#motivoid");
		var estados = $(this)
		if($(this).val() != '' && $(this).val() != 0) {
			$.ajax({
				data: { id : estados.val() },
				url:   url + '/ajaxMotivos',
				type:  'POST',
				dataType: 'json',
				beforeSend: function () {
					estados.prop('disabled', true);
				},
				success:  function (r) {
					estados.prop('disabled', false);
					motivos.find('option').remove();
					$(r).each(function(i, v) {
						motivos.append('<option value="' + v.id + '">' + v.nombre + '</option>');
					})
					motivos.prop('disabled', false);
				}
			});
		}
		else {
			motivos.find('option').remove();
			motivos.prop('disabled', true);
		}
	});

	$("#supervisorid").change(function() {
		var tecnicos1 = $("#tecnico1id");
		var tecnicos2 = $("#tecnico2id");
		var supervisores = $(this)
		if($(this).val() != '' && $(this).val() != 0) {
			$.ajax({
				data: { id : supervisores.val() },
				url:   url + '/ajaxTecnicos/1',
				type:  'POST',
				dataType: 'json',
				beforeSend: function () {
					supervisores.prop('disabled', true);
				},
				success:  function (r) {
					supervisores.prop('disabled', false);
					tecnicos1.find('option').remove();
					$(r).each(function(i, v) {
						tecnicos1.append('<option value="' + v.id + '">' + v.nombre + '</option>');
					})
					tecnicos1.prop('disabled', false);
				}
			});

			$.ajax({
				data: { id : supervisores.val() },
				url:   url + '/ajaxTecnicos/2',
				type:  'POST',
				dataType: 'json',
				beforeSend: function () {
					supervisores.prop('disabled', true);
				},
				success:  function (r) {
					supervisores.prop('disabled', false);
					tecnicos2.find('option').remove();
					$(r).each(function(i, v) {
						tecnicos2.append('<option value="' + v.id + '">' + v.nombre + '</option>');
					})
					tecnicos2.prop('disabled', false);
				}
			});

		}
		else {
			tecnicos1.find('option').remove();
			tecnicos1.prop('disabled', true);
			tecnicos2.find('option').remove();
			tecnicos2.prop('disabled', true);
		}
	});

	$("#dptoid").change(function() {
		var distritos = $("#distritoid");
		distritos.find('option').remove();
		distritos.append('<option value="0">-Seleccione-</option>')
		var provincias = $("#provinciaid");
		var departamentos = $(this)
		if($(this).val() != '' && $(this).val() != 0) {
			$.ajax({
				data: { id : departamentos.val() },
				url:   url + '/ajaxProvincias',
				type:  'POST',
				dataType: 'json',
				beforeSend: function () {
					departamentos.prop('disabled', true);
				},
				success:  function (r) {
					departamentos.prop('disabled', false);
					provincias.find('option').remove();
					$(r).each(function(i, v) {
						provincias.append('<option value="' + v.id + '">' + v.nombre + '</option>');
					})
					provincias.prop('disabled', false);
				}
			});
		}
		else {
			provincias.find('option').remove();
			provincias.prop('disabled', true);
		}
	});

	$("#provinciaid").change(function() {
		var distritos = $("#distritoid");
		var provincias = $(this)
		if($(this).val() != '' && $(this).val() != 0) {
			$.ajax({
				data: { id : provincias.val() },
				url:   url + '/ajaxDistritos',
				type:  'POST',
				dataType: 'json',
				beforeSend: function () {
					provincias.prop('disabled', true);
				},
				success:  function (r) {
					provincias.prop('disabled', false);
					distritos.find('option').remove();
					$(r).each(function(i, v) {
						distritos.append('<option value="' + v.id + '">' + v.nombre + '</option>');
					})
					distritos.prop('disabled', false);
				}
			});
		}
		else {
			distritos.find('option').remove();
			distritos.prop('disabled', true);
		}
	});


$("#select_all").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});



$("#tiposervicioid").change(function() {		

		var servicio= $('#tiposervicioid').val();
		var trabajo = $('#tipotrabajoid');			
			$.ajax({
				data: { id : servicio },
				url:   '/digesis/index.php/solicitudes/get_tipo_trabajo',
				type:  'GET',
				dataType: 'json',
				beforeSend: function () {					
				},
				success:  function (r) {					
					trabajo.find('option').remove();					
					$(r).each(function(i, v) {								
						trabajo.append('<option value="' + v.id + '">' + v.descripcion + '</option>');
					})					
				}
			});

 });

})