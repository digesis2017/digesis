function changeTecnico() {
	var url = $("#urlt").val() ? $("#urlt").val() : '';

	$.ajax({
		data: { t1id : $("#tecnico1id").val(), t2id : $("#tecnico2id").val() },
		url:   url + '/tecnico_telefono',
		type:  'POST',
		dataType: 'json',
		success:  function (r) {
			if ( r.success ) {
				if ( r.t1cell )
					$("#tec1cell").html("RPC: " + r.t1cell);
				if ( r.t2cell )
					$("#tec2cell").html("RPC: " + r.t2cell);
			}
		}
	});
}

$(document).ready(function() {

	changeTecnico();

	$("#supervisorid").change(function() {
		$("#tec1cell").html("");
		$("#tec2cell").html("");
	});

	$("#tecnico1id").change(function() {
		changeTecnico();
	});

	$("#tecnico2id").change(function() {
		changeTecnico();
	});

});