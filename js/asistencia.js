$(function() {

  $( "#fecha" ).datepicker();
  $( "#fecha" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

  // $( "#frmasistencia" ).on( "change", "#fecha", function() {
  //   $( "#date" ).val($( "#fecha" ).val());
  // });

$( "#frmmonedero" ).on( "click", "#btnbuscar", function() {        
      var fecha = $('#frmmonedero #fecha').val();          
      var perfil = $("#tecnico1id").val();
      var supervisor = $("#supervisorid").val();
      
      window.location.href = '/digesis/index.php/monedero?perfil='+perfil+'&fecha='+fecha+'&supervisor='+supervisor;
});
/*
$( "#frmmonedero" ).on( "click", "#btnbuscar", function() {      
      var fecha = $('#frmmonedero #fecha').val();          
      var dni = $("#tecnico1id").val();
      window.location.href = '/digesis/index.php/monedero?dni='+dni+'&fecha='+fecha;      
});
*/

  $( "#frmasistencia" ).on( "click", "#btnbuscar", function() {
      var fecha = $('#frmasistencia #fecha').val();
      var dni = $('#frmasistencia #dni').val();
      console.log(dni);
      var url =  '/digesis/index.php/asistencia/buscar/' + fecha+'&dni='+dni;
      window.location.href = '/digesis/index.php/asistencia?fecha='+fecha+'&dni='+dni;
    /*
      $.ajax({
        url : url,
        data : {fecha : fecha},
        type : 'GET',
        dataType : 'json',
        success : function(json) {
            // window.location.href = url;
            // history.pushState(null, "", url);
            //alert('okk');
            window.location.href = '/digesis/index.php/asistencia?fecha='+fecha;
            //$('#resultadoasistencia').html(json.result);
        },
        error : function(xhr, status) {
             alert('Disculpe, existió un problema');
        },
        complete : function(xhr, status) {
            // alert('Petición realizada');
        }
      });*/

    $( "#date" ).val($( "#fecha" ).val());

  });

  $( "#grabar" ).on( "click", function() {
      var fecha = $('#fecha').val();
      var dni = $('#dni').val();
      var result = $('#result').val();

      if (result=='result2')
        var url = '/digesis/index.php/asistencia/grabar';
      else
        var url= '/digesis/index.php/asistencia/grabar';

      var data = $('#frmasistencia').serialize();    
      $.ajax({
        url : url,
        data : {data : data},
        type : 'POST',
        dataType : 'json',
        success : function(json) {
              alert('Asistencia guardada correctamente');
              window.location.href = '/digesis/index.php/asistencia?fecha='+fecha+'&dni='+dni;
            // history.pushState(null, "", url);
            // $('#frmasistencia #resultadoasistencia').html(json.result);
        },
        error : function(xhr, status) {
             alert('Disculpe, existió un problema');
        },
        complete : function(xhr, status) {
            // alert('Petición realizada');
        }
      });
  });


$("#tbmonedero  a.supervisor_detalle" ).on( "click", function() {
    var id=$(this).attr('data-id');
  
  if($(".detalle_jefe-"+id).hasClass('hidden')){
      
      $(".detalle_jefe-"+id).fadeIn();
      $(".detalle_jefe-"+id).removeClass('hidden');

  }else{

      $(".detalle_jefe-"+id).fadeOut();
      $(".detalle_jefe-"+id).addClass('hidden');      
    }

});

$("#mult-asignacion" ).on( "click", function() {

    var checked = []
    var i=1;
    $("input[name='sot[]']:checked").each(function ()
      {
        checked.push("sot"+i+"="+$(this).val());
        i++;
      });
      checked = checked.join('&');
      console.log(checked);
      window.location.href = '/digesis/index.php/solicitudes/form_multiple?'+checked;
  });

});
