<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter REST Class
 *
 * Make REST requests to RESTful services with simple syntax.
 *
 * @package         CodeIgniter
 * @subpackage      Libraries
 * @category        Libraries
 * @author          Philip Sturgeon
 * @author          Chris Kacerguis
 * @created         04/06/2009
 * @license         http://philsturgeon.co.uk/code/dbad-license
 * @link            http://getsparks.org/packages/restclient/show
 */
class Billetera
{

    protected $_ci;
    Const id_tipo=1;
    Const CODIGO_RF='PEN03';
    Const CODIGO_IN='PEN04';
    Const CODIGO_ASISTENCIA1='PEN05';
    Const CODIGO_ASISTENCIA2='PEN06';
    private $atendidos =null;
    private $atendidosm=null;
    private $reprogramados=null;
    private $rechazados =null;
    private $pendientes=null;
    private $incidencias=null;
    private $tid=null;
    private $monto_sot=null;
    private $dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');

            
    function __construct($config = array())
    {
        $this->_ci =& get_instance();            
        $this->_ci->load->model('minsi');
        $this->_ci->load->model('mcostosot');        
        $this->_ci->load->model('meficiencia');
        $this->_ci->load->model('msolicitudes');
        $this->_ci->load->model('mencuestas');
        $this->_ci->load->model('mtecnicos');        
        $this->_ci->load->model('mpenalidades');
        $this->_ci->load->model('masistencia');                        
    }        
    /**
     * get
     *
     * @access  public
     * @author  Phil Sturgeon
     * @version 1.0
     */
    public function getresumen($params = array())
    {
        $data=array();
        $monto=0;
        if ($params)
        {
            $datat = $this->_ci->mtecnicos->tecnicobyDNI($params['dni']);
            if ( is_object($datat) ) 
            {

        $tid = $datat->id;                                                                    
        /* calculo de la eficiencia mes*/
        $this->atendidosm =$this->_ci->msolicitudes->solicitudes_encuestas_all($tid, 2);            
        $this->reprogramados= $this->_ci->msolicitudes->solicitudes_encuestas_all($tid, 4);
        $this->rechazados = $this->_ci->msolicitudes->solicitudes_encuestas_all($tid, 5);
        $this->pendientes = $this->_ci->msolicitudes->solicitudes_encuestas_all($tid, 3);              
        
        $fecha=!empty($params['fecha'])? $params['fecha']:false;
        $data['comision_dia']=$this->getComisionDia($tid,$fecha);
        $data['comision_mes']=$this->getComisionMes($tid,$fecha);                                            
        return $data;
    }
    
    }
}
/* calculo de la comision por dia*/
private function getComisionDia($tid=null,$fecha=false){
date_default_timezone_set('America/Lima');
/* pago por Sot validadas*/
$this->atendidos =$this->_ci->msolicitudes->solicitudes_encuestas($tid, 2, false,$fecha);
$rcosto=$this->_ci->mcostosot->getSotByType(self::id_tipo,count($this->atendidos));
if (!empty($rcosto)){
    $this->monto_sot=$rcosto[0]->monto;
    $pago_sot_validado=$rcosto[0]->monto;
}
else
    $pago_sot_validado=0;

/* descuento de inasistencias*/
    $date=($fecha==false)? date('Y-m-d'):$fecha;
    $desc_inasistencia=0;
    $monto_desc_asistencia=0;
    $r_asistencia=$this->_ci->masistencia->getAsistenciaByIdAndMonth($tid,$date);

    if(!empty($r_asistencia)){
        foreach ($r_asistencia as $key => $value) {
        if ($value->descanso==1){
            $dia_semana = $this->dias[date('N', strtotime($date))-1];
            $monto_desc_asistencia = $monto_desc_asistencia+$this->_ci->mpenalidades->getPenalidadesById(($dia_semana=='Domingo')? self::CODIGO_ASISTENCIA2 : self::CODIGO_ASISTENCIA1);   
            }
                    
            }
        }
    $desc_inasistencia=$monto_desc_asistencia;
    

/* descuento por RF no validada*/
   $c=0;
   $monto_desc_rf = $this->_ci->mpenalidades->getPenalidadesById(self::CODIGO_RF);   
    foreach ($this->atendidos as $key => $value) {
        $rf=$this->_ci->msolicitudes->solicitudesByIdAndDate($key);
        if ($rf==1)
         $c++;
      }      
  $desc_rf_no_validada=$monto_desc_rf*$c;

  return $pago_sot_validado - $desc_inasistencia - $desc_rf_no_validada;
}

private function getComisionMes($tid=null,$fecha=false){

$comision_mes_sot=0;
$comision_mes_eficiencia=0;
$desc_mes_inasistencia=0;
$desc_mes_rf_no_validada=0;
$desc_mes_insidencia=0;

/* comision por sot mes */
$r_sot_validadas=$this->_ci->msolicitudes->solicitudesByMonthCount($tid,$fecha);

if (!empty($r_sot_validadas))
{
    foreach ($r_sot_validadas as $key => $value) {
        $rcosto=$this->_ci->mcostosot->getSotByType(self::id_tipo,$value['cantidad']);        
        if(!empty($rcosto))
            $comision_mes_sot=$comision_mes_sot + intval($rcosto[0]->monto); 
    }
}


/*comision por eficiencia*/
set_error_handler(function () {
    throw new Exception('Ach!');
});
try{
$p=(100* count($this->atendidosm))/(count($this->pendientes)+count($this->reprogramados)+count($this->rechazados)+count($this->atendidosm));
$p=round($p, 0);
}
catch(Exception $e){
    $p=0;
}
restore_error_handler();

$eficiencia=$this->_ci->meficiencia->geteficiencia($p);

if (!empty($eficiencia))
    $comision_mes_eficiencia = intval($eficiencia);


/* descuento de inasistencias*/

$r_asistencia=$this->_ci->masistencia->getAsistenciaByIdAndMonth($tid,false,$fecha);

$monto_desc_asistencia=0;
if (!empty($r_asistencia)):
                              
  foreach ($r_asistencia as $key => $value) {  
    $fecha1= gmdate("Y-m-d", $value->fecha);
    if ($value->asistencia==0)
        if ($value->descanso==0){
        $dia_semana = $this->dias[date('N', strtotime($fecha1))-1];        
        $monto_desc_asistencia = $monto_desc_asistencia+$this->_ci->mpenalidades->getPenalidadesById(($dia_semana=='Domingo')? self::CODIGO_ASISTENCIA2 : self::CODIGO_ASISTENCIA1);   
        }
}
endif;
    $desc_mes_inasistencia=$monto_desc_asistencia;

/* descuento por RF no validada*/
    $c=0;    
    $sot_atendidos=$this->_ci->msolicitudes->solicitudesByMonth($tid,$fecha);    
    $monto_desc_rf = $this->_ci->mpenalidades->getPenalidadesById(self::CODIGO_RF);
    foreach ($sot_atendidos as $key => $value) {
      $rf=$this->_ci->msolicitudes->solicitudesByIdAndDate($value['id'],true);
        if ($rf==1)
           $c++;
    }      
    $desc_mes_rf_no_validada=$monto_desc_rf*$c;

/* descuento por insidencias*/
    $desc_insidencia = $this->_ci->mpenalidades->getPenalidadesById(self::CODIGO_IN);    
    $c_i=0;
    foreach ($sot_atendidos as $key => $value) {
    $r_insidencias=$this->_ci->minsi->getIncidenciasById($value['id']);        
    $c_i=$c_i+count($r_insidencias);
    }

set_error_handler(function () {
    throw new Exception('Ach!');
    });
    try{
        $porcentaje=((100*$c_i)/count($sot_atendidos));    
    }
    catch(Exception $e){
        $porcentaje=0;
    }
restore_error_handler();

    if (round($porcentaje,0)>=5)
        $desc_mes_insidencia=$desc_insidencia * $c_i;

    $r_data['porcentaje']=$p;
    $r_data['comision_mes_sot']=$comision_mes_sot;
    $r_data['comision_mes_eficiencia']=$comision_mes_eficiencia;
    $r_data['desc_mes_insidencia']=$desc_mes_insidencia;
    

    $r_data['monto']=($comision_mes_sot + $comision_mes_eficiencia - ($desc_mes_inasistencia + $desc_mes_rf_no_validada +$desc_mes_insidencia));

    
    return $r_data;

    return ($comision_mes_sot + $comision_mes_eficiencia - ($desc_mes_inasistencia + $desc_mes_rf_no_validada +$desc_mes_insidencia));

}

 public function getdetalle_comision($params=array()){
    date_default_timezone_set('America/Lima');
    $r_detalle=array();    
    if ($params)
        {
            $datat = $this->_ci->mtecnicos->tecnicobyDNI($params['dni']);
            if ( is_object($datat) ) 
            {
                $tid = $datat->id; 
                $r_asistencia=$this->_ci->masistencia->getAsistenciaByIdAndMonth($tid);
                
             /*   echo '<pre>';
                    print_r($r_asistencia);
                echo '</pre>';*/
                
                if (!empty($r_asistencia)):
                      $cc=1;
                      foreach ($r_asistencia as $key => $value) {
                        $monto_desc_asistencia=0;                        
                        //$fecha= date('Y-m-d',$value->fecha);                        
                        $fecha= gmdate("Y-m-d", $value->fecha);

                if ($value->asistencia==0)
                        if ($value->descanso==0){
                            $dia_semana = $this->dias[date('N', strtotime($fecha))-1];                                                
                            $monto_desc_asistencia = $this->_ci->mpenalidades->getPenalidadesById(($dia_semana=='Domingo')? self::CODIGO_ASISTENCIA2 : self::CODIGO_ASISTENCIA1);   
                        }


                        $this->atendidos =$this->_ci->msolicitudes->solicitudes_encuestas($tid, 2, false,$fecha);       
                        /*
                        echo '<pre>';
                            print_r($this->atendidos);
                        echo '</pre>';
                        */
                        $c=0;                        
                         $monto_desc_rf = $this->_ci->mpenalidades->getPenalidadesById(self::CODIGO_RF);   
                            foreach ($this->atendidos as $key => $value) {
                        $rf=$this->_ci->msolicitudes->solicitudesByIdAndDate($key,true);
                                if ($rf==1)
                                    $c++;
                              }      
                          $desc_rf_no_validada=$monto_desc_rf*$c;

                        $rcosto=$this->_ci->mcostosot->getSotByType(self::id_tipo,count($this->atendidos));
                        
                        /*echo '<pre>---costo';
                            print_r($rcosto);
                        echo '</pre>';*/
                        
                            $r_detalle[$cc]['fecha']=$fecha;
                            $r_detalle[$cc]['sot']=count($this->atendidos);
                            $r_detalle[$cc]['monto']=!empty($rcosto)? $rcosto[0]->monto:0;
                            $r_detalle[$cc]['desc_asistencia']=$monto_desc_asistencia;
                            $r_detalle[$cc]['desc_rf']=$desc_rf_no_validada;
                            $r_detalle[$cc]['total']=($r_detalle[$cc]['monto']) - ($monto_desc_asistencia+$desc_rf_no_validada);                            
                            $cc++;
                                           
                  }
                endif;    
            }    
 }
 return $r_detalle;

}
}

