<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asistencia extends CI_Controller {

	
	 public function __construct()
   {

    parent::__construct();
	$this->load->model('masistencia');
	is_logged_in() ? true : redirect('admin');
	}
			  
	 public function index()
	 {	 	
	 	securityAccess(array(1,2));
	 	date_default_timezone_set('America/Lima');
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'asistencia' ));

$fecha = $this->input->get('fecha');
$dni = $this->input->get('dni');
$fecha=(!empty($fecha))? $fecha:date('Y-m-d');
$data['dni']= $dni;
$data['fecha']= $fecha;
 if(!empty($dni))
 	$data['result1']= $this->masistencia->get_records_by_tecnico($dni,$fecha);
 else
 	$data['result2']= $this->masistencia->get_records($fecha);

$this->load->view('admin/asistencia_view', $data);
	 }

	 public function grabar()
	 {
		 $data = $this->input->post('data');		 
		 parse_str($data, $output);

		 //print_r($output);
		 //exit();
		 if (!empty($output['dni']))
		 		$datar['result'] = $this->masistencia->set_records2($output);
		 else
		 	$datar['result'] = $this->masistencia->set_records($output);


		 echo json_encode($datar);
   }

	 public function buscar($fecha = null,$dni=null)
	 {
		 if($fecha == null){
			 $fecha = date('Y-m-d');
		 }
		 if($dni == null){
			 $dni = $dni;
		 }
		
		$data['result'] 	= $this->masistencia->get_records($fecha);
		$data['date'] 		= $fecha;		
		$data['dni'] 		= $dni;		
		
		$output['result'] = $this->load->view('admin/lista_view', $data, TRUE);
		echo json_encode($output);
  }
}
