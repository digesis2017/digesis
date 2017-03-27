function $_GET(param) {
	var vars = {};
	window.location.href.replace( location.hash, '' ).replace( 
		/[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
		function( m, key, value ) { // callback
			vars[key] = value !== undefined ? value : '';
		}
	);

	if ( param ) {
		return vars[param] ? vars[param] : null;	
	}
	return vars;
}


"use strict";

$.datepicker.regional['es'] = {
	closeText: 'Cerrar',
	prevText: '<Ant',
	nextText: 'Sig>',
	currentText: 'Hoy',
	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
	dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
	weekHeader: 'Sm',
	dateFormat: 'dd-mm-yy',
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: '',
	defaultDate: +1
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);


$( document ).ready(function() {
   
   
     var ID = function () {
	  var postfix="sid";
      return Math.random().toString(36).substr(2, 9)+'-'+postfix ;
    };  
   
     /*$( ".container-list .cont-solicitud" ).each(function( index ) {
		 var nkey=ID();
		 var n_item=$(this);
		 n_item.attr("id", nkey);
     });  */
   
$( "#datepicker1" ).datepicker({
	onSelect: function(dateText, inst) {
		//$(".schedule .calendar").hide();
		//$(".schedule .datetime").show();
		//$("#datepicker").trigger( "focus" );
		//$(".test").hide();
		//$(".client").hide();
		
    }
});

$( "#datepicker2" ).datepicker({
	onSelect: function(dateText, inst) {
		//$(".schedule .calendar").hide();
		//$(".schedule .datetime").show();
		//$("#datepicker").trigger( "focus" );
		//$(".test").hide();
		//$(".client").hide();
		
    }
});

//$( "#ui-datepicker-div" ).insertBefore(".schedule .ui-popup-options-contenido");
/*    $("#datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
			onSelect: function(dateText, inst) {
				$(".schedule .calendar").hide();
				$(".schedule .datetime").show();
				$(".test").hide();
				$(".client").hide();
				
			}
    })
    .hide()
    .click(function() {
      $(this).hide();
    });

    $("#datepickerImage").click(function() {
       $("#datepicker").show(); 
    });*/

$( ".cont_billetera" ).on( "click", function() {
    event.preventDefault();
    	$(".ui-popup-options").show();
		$( ".client-box" ).addClass('display-none');
		$(".ui-popup-options-list li a").removeClass("active");
		$(".billetera").show();
		$("body").addClass("no-scroll");
		$(".client").hide();
		$(".schedule").hide();
		$(".reject").hide();
		$(".test").hide();
		$(".schedule .datetime").show();
		$(".schedule .calendar").show();
		//$(".test").find("#test-sid").val(sid);
		$("#evento").val('detalle');
    
});


$(".cont-solicitud .combo-ui" ).each(function() {	
	var t=$( this );
	var sid=t.parent().attr("data-codigo");
	var sel=t.find("select");
	sel.change(function() {
		var opt=sel.find("option:selected");
		var choice=opt.text();		
		var rule=(choice==="Rechazado");
		var rule2=(choice==="Validado");
		var rule3=(choice==="Reprogramado");
		var rule4=(choice==="Pendiente de Validar");
		$(".ui-popup-options-wrapper").find("input[type='hidden'][name*='-sid']").attr("value",sid);
	 	if ( rule ) {
		$(".ui-popup-options").show();
		$( ".client-box" ).addClass('display-none');
		$(".ui-popup-options-list li a").removeClass("active");
		$(".test").hide();
		$(".client").hide();
		$(".schedule").hide();
		$(".reject").show();
		$("body").addClass("no-scroll");
		$(".schedule .datetime").show();
		$(".schedule .calendar").show();
		$(".reject").find("#reject-sid").val(sid);
		$(".billetera").hide();		
		$("#evento").val('rechazar');
	  }else if(rule2){
		$(".ui-popup-options").show();
		$( ".client-box" ).addClass('display-none');
		$(".ui-popup-options-list li a").removeClass("active");
		$(".test").show();
		$("body").addClass("no-scroll");
		$(".client").hide();
		$(".schedule").hide();
		$(".reject").hide();
		$(".schedule .datetime").show();
		$(".schedule .calendar").show();
		$(".test").find("#test-sid").val(sid);
		$(".billetera").hide();
		$("#evento").val('validar');
	  }else if(rule3){
		$(".ui-popup-options").show();
		$( ".client-box" ).addClass('display-none');
		$(".ui-popup-options-list li a").removeClass("active");
		$(".test").hide();
		$(".client").hide();
		$(".schedule").show();
		$("body").addClass("no-scroll");
		$(".reject").hide();
		$(".schedule .datetime").show();
		$(".schedule .calendar").show();	
		$(".billetera").hide();
		$("#datepicker").trigger( "focus" );
		$(".schedule").find("#schedule-sid").val(sid);
		$("#evento").val('reprogramar');
	  }else if(rule4){
		$(".ui-popup-options").show();
		$( ".client-box" ).addClass('display-none');
		$(".ui-popup-options-list li a").removeClass("active");
		$(".test").hide();
		$(".client").show();
		$("body").addClass("no-scroll");
		$(".schedule").hide();
		$(".reject").hide();
		$(".billetera").hide();
		$(".schedule .datetime").show();
		$(".schedule .calendar").show();
		$(".client").find("#client-sid").val(sid);
		$( "#datepicker" ).datepicker('setDate', null);
		$("#evento").val('pendiente');
		  
	  }else{
		$(".ui-popup-options").hide();
		$( ".client-box" ).addClass('display-none');
		$(".ui-popup-options-list li a").removeClass("active");
		$(".test").hide();
		$(".client").hide();
		$(".schedule").hide();
		$(".reject").hide();
		$(".billetera").hide();
		$(".schedule .datetime").show();
		$(".schedule .calendar").show();
		$("body").removeClass("no-scroll");
	  }
	  
	  
	});  


});

if($(".cont-login").length!==0){
	//console.log("login-frm detected");
	$(".input_f").focusin(function() {
		var current=$(this).attr("value");
		if((current==="") || (current==="DNI")){
			$(this).attr("value","");
		}
		
		
	}); 	
	$(".input_f").blur(function() {
		
		$(this).attr("value","DNI");
		
	});
	
		$(window).keyup(function (e) {
			var code = (e.keyCode ? e.keyCode : e.which);
			
			if (code == 9 && $('.input_f:focus').length) {
				
				$(this).attr("value","");
			}
		});
	
		
}


if($(".cont-login.thanks").length!==0){
	//console.log("login-thanks detected");
	$("form input").click(function(event) {
		event.preventDefault();
		var sendme='login.html';
		$(location).attr('href',sendme);
	}); 	

}



//


//TABS
	if($("#tab-ui").length!==0){


		var ui_tabs=function(){
								var wrapW=$(".wrapper").width();
								//console.log(wrapW);
								var slides=$(".ui-tab-item").length;
								//console.log("slides:"+slides);
								var fwrap=wrapW*slides;
								$(".ui-container-tab").width(fwrap);
								var wrapH=$(".ui-tab-item").height();
								$(".ui-container-tab").height(wrapH);
								$(".wrap-ui-container-tab").height(wrapH);
								$(".wrap-ui-container-tab").width(wrapW);
								$(".ui-tab-item").width(wrapW);
								$(".ui-container-tab").attr("style","position:absolute");
								
								$(".ui-tabs-links li a").click(function (event) {
										event.preventDefault();

										$(".ui-tabs-links li").removeClass("active");
										$(this).parent().addClass("active");
										



										var i = $(this).parent().index();
										$(".ui-tab-item").removeClass("active");
										$(".ui-tab-item").eq(i).addClass("active");
										var nH = $(".ui-tab-item.active").height();
										$(".ui-container-tab").height(nH);
										$(".wrap-ui-container-tab").height(nH);	
																			//console.log("i:"+i);
										//var cpos=$(".ui-container-tab").css("left").replace("px","");
										//console.log("cpos:"+cpos);
										
										var npos=-(wrapW*i);

										//console.log("npos:"+npos);
										$(".ui-container-tab").attr("style","width:"+fwrap+"px; height:"+nH+"px;position:absolute;left:"+npos+"px;");
								});

		}
		
		

		ui_tabs();

		window.addEventListener("resize", function() {
		   ui_tabs();
		   $(".ui-tabs-links li.active").find("a").trigger("click");
		}, false);

		window.addEventListener("orientationchange", function() {
		   ui_tabs();
		   $(".ui-tabs-links li.active").find("a").trigger("click");

		}, false);

		
	}
	//POPUP
	function hidepop(){
		$(".ui-popup-options").fadeOut("fast");
		$("body").removeClass("no-scroll");
		//RESET LI FORM  RADIO BUTTONS
		//$(".ui-popup-options-list li a").removeClass("active");
	}

	//CANCEL
	if($(".cancel").length!==0){
			$(".cancel").click(function(event) {
				location.reload();
				/*event.preventDefault();
				setTimeout(hidepop, 500);
				var v=$(".ui-popup-options-wrapper").find("input[type='hidden'][name*='-sid']").attr("value");
				var sol=$("[data-codigo='"+v+"']");
				sol.find(".combo-ui select").val('SIN ESTADO').trigger('change');*/
			});
	}

	if($(".submit").length!==0){
			$(".submit").click(function(event) {
				var value = '';
				var evento = $("#evento").val();
				if ( evento == 'rechazar') {
					value = $("#rechazar .active").attr('value');
					if ( value ) {
						$.post( "../index.php/encuestas/rechazar",
							{
								motivoid : value,
								sid : $("#reject-sid").val()
							},
							function( data ) {
	  							if ( data.status )
	  								location.reload();
	  							else
	  								alert('Error, comuniquese con su administrador');
						}, 'json');
					}
					else
						alert('Seleccione un Motivo');
				}
				else if ( evento == 'pendiente' ) {
					value = $("#pendientes .active").attr('value');
					if ( value ) {
						$.post( "../index.php/encuestas/pendiente",
							{
								motivoid : value,
								sid : $("#client-sid").val()
							},
							function( data ) {
	  							if ( data.status )
	  								location.reload();
	  							else
	  								alert('Error, comuniquese con su administrador');
						}, 'json');
					}
					else
						alert('Seleccione un Motivo');
				}
				else if ( evento == 'validar' ) {
					value = $("#encuestar .active").attr('value');
					if ( value == 'iniciar' )
						location.href = "/digesis/index.php/encuestas/indicaciones/" + $("#test-sid").val() + '?dni=' + $_GET('dni');
					else if ( value == 'denegar' ) {
						$.post( "../index.php/encuestas/denegar",
							{
								sid : $("#test-sid").val()
							},
							function( data ) {
	  							if ( data.status )
	  								location.reload();
	  							else
	  								alert('Error, comuniquese con su administrador');
						}, 'json');
					}
					else
						alert("Seleccione una opción");
				}
				else if ( evento == 'reprogramar' ) {
					date = $( "#datepicker1" ).datepicker().val();
					vtiempo = $("#reprogramar .active").attr('value');
					vmotivo = $(".reason .active").attr('value');
					if ( date && vtiempo && vmotivo ) {
						$.post( "../index.php/encuestas/reprogramar",
							{
								motivoid : vmotivo,
								tiempo : vtiempo,
								fecha : date,
								sid : $("#schedule-sid").val()
							},
							function( data ) {
	  							if ( data.status )
	  								location.reload();
	  							else
	  								alert('Debe seleccionar una fecha a futuro');
						}, 'json');
					}
					else
						alert('Todos los formularios deben ser seleccionados');
				}
				else if ( evento == 'detalle' ) {					
					location.href = "/digesis/index.php/encuestas/detalle/" +'?dni=' + $_GET('dni');
				}


			});
	}

	if($(".ui-popup-options").length!==0){	
		$(".ui-popup-options-contenido .icon-cerrar").click(function(event) {
			//$(this).parent().parent().parent().parent().hide();
			event.preventDefault();
			//setTimeout(hidepop, 500);
			$( "#datepicker" ).datepicker('setDate', null);
		});	
		$(".ui-popup-options-contenido .icon-client").click(function(event) {
			$( ".client-box" ).removeClass('display-none');
		});

	$(".ui-popup-options-list" ).each(function() {

			var t=$(this);
			t.find("li a").click(function(event) {
				event.preventDefault();

				t.find("li a").removeClass("active");
				var s=$(this);

				var ctrl=t.attr("binding");
				ctrl="#"+ctrl;
				//console.log(ctrl);

				var fill=s.text();
				$(ctrl).attr("value",fill);
				//console.log("fill:"+fill);

				if (s.hasClass('icon-encuestar')) {
					//linking poll
					/*$.ajax({
					   type: 'POST',
					   url: "methodPHP.php",
					   data: data2serialize,
					   success: function(data){
					     console.log("data sended!");
					   },
					   complete:function(){
					     console.log("finished!");
					 	 setTimeout(hidepop, 500);
					     location.href="preguntas-final.html";  
					   }
					});*/
				}
				s.addClass("active");
			});
	});	



	$(".ui-popup-close").click(function(event) {
		location.reload();
		/*event.preventDefault();
		setTimeout(hidepop, 500);
		var v=$(".ui-popup-options-wrapper").find("input[type='hidden'][name*='-sid']").attr("value");
		console.log("cod:"+v);
		var sol=$("[data-codigo='"+v+"']");
		//console.log(sol);
		sol.find(".combo-ui select").val('Seleccionar').trigger('change');*/
	});	

		//console.log("..popup");
		
	}
	if($(".indications").length!==0){
		$(".indications ul li a").click(function(event) {
			event.preventDefault();
			$(".indications ul li a").removeClass("active");
			$(this).addClass("active");
		});
	}	
	
});