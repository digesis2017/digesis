
$(document).ready(function() {
  $("#exportar").on( "click", function() {
    //ExportToExcel();    
  var a = document.createElement('a');    
  var data_type = 'data:application/vnd.ms-excel';
  var table_div = document.getElementById('tbl_exportar');
  var table_html = table_div.outerHTML.replace(/ /g, '%20');
    a.href = data_type + ', ' + table_html;    
    a.download = 'reporte.xls';    
    a.click();    
    e.preventDefault();
});
});

function ExportToExcel(){
   var htmltable= document.getElementById('tbl_exportar');
   var html = htmltable.outerHTML;
   window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
    }

