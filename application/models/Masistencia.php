<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Masistencia extends CI_Model
{
	public function __construct()
	{
		parent::__construct();		
	}
	public function getAsistenciaByIdAndMonth($id=null,$date=false,$month=false){		
        $month=($month==false)?  intval(date('m')): date('m',strtotime($month));
		$rows = array();
		$this->db->select('a.*');
		$this->db->from('asistencia a');
        if ($date==false)
		  $this->db->where('month(FROM_UNIXTIME(a.fecha))=',$month);
        else
          $this->db->where('a.fecha=',strtotime($date));

		$this->db->where('a.idtecnico=',$id);
		$this->db->order_by("a.fecha");
		$query = $this->db->get();  
		//echo $this->db->last_query();
		//exit;
	     if( $query->num_rows() > 0 ) {
	     	foreach ( $query->result() as $key => $row ) {
				$rows[$row->id] = $row;
			}
		}
		return $rows;
	}

function get_records_by_tecnico($dni=null,$fecha=null)
    {

            date_default_timezone_set('America/Lima');
            $data=array();
            $this->db->select('*');
            $this->db->from('asistencia');
            $this->db->join('tecnicos', 'tecnicos.id = asistencia.idtecnico');
$this->db->where('month(FROM_UNIXTIME(fecha))=',date('m',strtotime($fecha)));
            $this->db->where('dni',$dni);     
            $this->db->order_by('fecha');            
            $query = $this->db->get();            
            if ( $query->num_rows() > 0 ) {
                 $data = $query->result();
            }            
            
            return $data;
    }

	function get_records($fecha = null)
      	{
            date_default_timezone_set('America/Lima');
            $this->db->select('*');
            $this->db->from('asistencia');
            $this->db->join('tecnicos', 'tecnicos.id = asistencia.idtecnico');
        	$this->db->where('fecha', strtotime($fecha));
            $query = $this->db->get();
            //echo $this->db->last_query();
            //exit();
            //$data = $query->result();
            //
            if ( $query->num_rows() > 0 ) {
            	 $data = $query->result();
            } else{
              $query = $this->db->get('tecnicos');
              $data = $query->result();
            }

            //echo $this->db->last_query();            
            if(!empty($data)){
              return $data;
            }
            return false;
        }

        function set_records($output = array())
        {        			
            date_default_timezone_set('America/Lima');
            $this->db->select('*');
            $this->db->from('asistencia');
            $this->db->where('fecha',strtotime($output['date']));
            $query = $this->db->get();
            $dataa = $query->result();

            if(!empty($dataa)){
              $this->db->delete('asistencia', array('fecha' =>strtotime($output['date'])));
            }
            for ($i=1; $i <= $output['cantidad']; $i++) {

                $idtecnico  = $output['id-' . $i];
                $fecha      = (isset($output['date']) && $output['date'] != '') ? $output['date'] : date('Y-m-d');
                $asistio    = (isset($output['asistencia-' . $i])) ? $output['asistencia-' . $i] : '0';
                $falto      = (isset($output['descanso-' . $i])) ? $output['descanso-' . $i] : '0';
                $motivo     = (isset($output['motivo-' . $i]) && trim($output['motivo-' . $i]) != '') ? $output['motivo-' . $i] : '';

              //  echo '<pre>';
              //  var_dump($motivo);
              //  echo '</pre>';
              //  die();

                $data = array(
                    'idTecnico' => $idtecnico,
                    'fecha'     =>strtotime($fecha),
                    'asistencia'   => $asistio,
                    'descanso'     => $falto,
                    'motivo'    => $motivo
                );
                

                $result = $this->db->insert('asistencia', $data);

            }

            if($result){
              return $result;
            }
            return false;
        }

        function set_records2($output = array())
        {                   
            date_default_timezone_set('America/Lima');
            
            for ($i=1; $i <= $output['cantidad']; $i++) {

                $idtecnico  = $output['id-' . $i];

$fecha = !empty($output['fecha-' . $i])? $output['fecha-' . $i] : date('Y-m-d');

                $asistio    = (isset($output['asistencia-' . $i])) ? $output['asistencia-' . $i] : '0';
                $falto      = (isset($output['descanso-' . $i])) ? $output['descanso-' . $i] : '0';
                $motivo     = (isset($output['motivo-' . $i]) && trim($output['motivo-' . $i]) != '') ? $output['motivo-' . $i] : '';

                $data = array(
                    'idTecnico' => $idtecnico,
                    'fecha'     =>$fecha,
                    'asistencia'   => $asistio,
                    'descanso'     => $falto,
                    'motivo'    => $motivo
                );
                
                                                            
        $this->db->where('idTecnico', $idtecnico);
        $this->db->where('fecha', $fecha);
    $result = $this->db->update('asistencia', $data); 
    //$result = $this->db->update('asistencia', $data);
                //$result = $this->db->insert('asistencia', $data);

            }

            if($result){
              return $result;
            }
            return false;
        }


}	
