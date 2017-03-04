<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {

	public function __construct() {
		parent::__construct();
		securityAccess(array(1));
		$this->load->model('mreportes');
		$this->load->model('mtecnicos');
		$this->load->model('msupervisores');
		$this->load->model('mjefes');
		$this->load->model('mbases');
	}

	public function index() {
		redirect('reportes/encuestas');
	}

	public function eficiencia() {
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'eficiencia'));

		$data['desde'] = isset($_POST['desde']) ? $_POST['desde'] : date('Y-m-01');
		$data['hasta'] = isset($_POST['hasta']) ? $_POST['hasta'] : date('Y-m-d');
		if ( @$_GET['test'] == TRUE ) {
			echo '<pre>' . 'Desde: ' . $data['desde'] . '</pre>';
			echo '<pre>' . 'Hasta: ' . $data['hasta'] . '</pre>';
			echo date_default_timezone_get();
		}
		$data['jefeid'] = isset($_POST['jefeid']) ? $_POST['jefeid'] : null;
		$data['supervisorid'] = isset($_POST['supervisorid']) ? $_POST['supervisorid'] : null;
		$data['baseid'] = isset($_POST['baseid']) ? $_POST['baseid'] : null;

		$data['jefes'] = $this->mjefes->jefes_combo();
		$data['supervisores'] = $this->msupervisores->supervisores_combo();
		if ( $data['jefeid'] )
			$data['supervisores'] = $this->msupervisores->supervisores_combo($data['jefeid']);
		$data['bases'] = $this->mbases->bases_combo();

		$params = array('desde' => $data['desde'], 'hasta' => $data['hasta'], 'jefeid' => $data['jefeid'], 'supervisorid' => $data['supervisorid'], 'baseid' => $data['baseid']);
		$data['data'] = $this->mreportes->jefes_getEficiencia($data['jefes'], $params);
		$this->load->view('admin/reportes/eficiencia', $data);
	}

	public function produccion() {
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'produccion'));

		$data['desde'] = isset($_POST['desde']) ? $_POST['desde'] : date('Y-m-01');
		$data['hasta'] = isset($_POST['hasta']) ? $_POST['hasta'] : date('Y-m-d');
		$data['jefeid'] = isset($_POST['jefeid']) ? $_POST['jefeid'] : null;
		$data['supervisorid'] = isset($_POST['supervisorid']) ? $_POST['supervisorid'] : null;
		$data['baseid'] = isset($_POST['baseid']) ? $_POST['baseid'] : null;

		$data['jefes'] = $this->mjefes->jefes_combo();
		$data['supervisores'] = $this->msupervisores->supervisores_combo();
		if ( $data['jefeid'] )
			$data['supervisores'] = $this->msupervisores->supervisores_combo($data['jefeid']);
		$data['bases'] = $this->mbases->bases_combo();

		$params = array('desde' => $data['desde'], 'hasta' => $data['hasta'], 'jefeid' => $data['jefeid'], 'supervisorid' => $data['supervisorid'], 'baseid' => $data['baseid']);
		$data['data'] = $this->mreportes->jefes_getProduccion($data['jefes'], $params);
		$this->load->view('admin/reportes/produccion', $data);
	}

	public function rfotografico() {
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'rfotografico'));

		$data['desde'] = isset($_POST['desde']) ? $_POST['desde'] : date('Y-m-01');
		$data['hasta'] = isset($_POST['hasta']) ? $_POST['hasta'] : date('Y-m-d');
		$data['jefeid'] = isset($_POST['jefeid']) ? $_POST['jefeid'] : null;
		$data['supervisorid'] = isset($_POST['supervisorid']) ? $_POST['supervisorid'] : null;
		$data['baseid'] = isset($_POST['baseid']) ? $_POST['baseid'] : null;

		$data['jefes'] = $this->mjefes->jefes_combo();
		$data['supervisores'] = $this->msupervisores->supervisores_combo();
		if ( $data['jefeid'] )
			$data['supervisores'] = $this->msupervisores->supervisores_combo($data['jefeid']);
		$data['bases'] = $this->mbases->bases_combo();

		$params = array('desde' => $data['desde'], 'hasta' => $data['hasta'], 'jefeid' => $data['jefeid'], 'supervisorid' => $data['supervisorid'], 'baseid' => $data['baseid']);
		$data['data'] = $this->mreportes->jefes_getRFotografico($data['jefes'], $params);
		$this->load->view('admin/reportes/rfotografico', $data);
	}

	public function encuestas() {
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'encuestas' ));

		$data['desde'] = isset($_POST['desde']) ? $_POST['desde'] : date('Y-m-01');
		$data['hasta'] = isset($_POST['hasta']) ? $_POST['hasta'] : date('Y-m-d');
		$data['jefeid'] = isset($_POST['jefeid']) ? $_POST['jefeid'] : null;
		$data['supervisorid'] = isset($_POST['supervisorid']) ? $_POST['supervisorid'] : null;
		$data['tecnicoid'] = isset($_POST['tecnicoid']) ? $_POST['tecnicoid'] : null;

		$data['jefes'] = $this->mjefes->jefes_combo();
		$data['supervisores'] = $this->msupervisores->supervisores_combo();
		if ( $data['jefeid'] )
			$data['supervisores'] = $this->msupervisores->supervisores_combo($data['jefeid']);
		if ( $data['supervisorid'] )
			$data['tecnicos'] = $this->mtecnicos->tecnicos_bySupervisor($data['supervisorid']);

		$params = array('desde' => $data['desde'], 'hasta' => $data['hasta'], 'jefeid' => $data['jefeid'], 'supervisorid' => $data['supervisorid'], 'tecnicoid' => $data['tecnicoid']);
		$data['data'] = $this->mreportes->jefes_getEncuestas($data['jefes'], $params);

		//var_dump($data['data']);

		$this->load->view('admin/reportes/encuestas',$data);
	}

	public function tecnico_encuestas($tid = null, $fecha_ini = null, $fecha_fin = null) {
		if ( is_numeric($tid) && ( $tid != 0 ) ) {
			$fechas = array('desde' => strtotime($fecha_ini), 'hasta' => strtotime($fecha_fin));
			$data['header'] = $this->load->view('admin/menu/header', array('active' => 'encuestas' ));
			$data['data'] = $this->mreportes->tecnico_getEncuestas($tid, $fechas);
			$data['tecnicos'] = $this->mtecnicos->tecnicos_combo();
			$data['tid'] = $tid;
			$this->load->view('admin/reportes/tecnico_encuestas', $data);
		}
		else
			redirect('reportes');
	}

	public function supervisor_encuestas($supid = null, $fecha_ini = null, $fecha_fin = null) {
		if ( is_numeric($supid) && ( $supid != 0 ) ) {
			$fechas = array('desde' => strtotime($fecha_ini), 'hasta' => strtotime($fecha_fin));
			$data['header'] = $this->load->view('admin/menu/header', array('active' => 'encuestas' ));
			$data['supervisores'] = $this->msupervisores->supervisores_combo();
		$data['tecnicos'] = $this->mtecnicos->tecnicos_combo();
		$data['supid'] = $supid;
		$tecnicos = $this->mtecnicos->tecnicos_bySupervisor($supid);


			$data['data'] = $this->mreportes->supervisor_getEncuestas($tecnicos, array('supid' => $supid, 'nombres' => ''));

			
$suma=array();
$promedio=array();
$contador=array();
foreach ($data['data']['tecnicos'] as $key_tecnico => $value_tecnico) {
	
	$r=$this->mreportes->tecnico_getEncuestas($key_tecnico, $fechas);	
	if (!empty($r['solicitudes'])){
	foreach ($r['solicitudes'] as $key_soli => $solicitud) {	
		foreach ($solicitud->encuestas as $key => $value) {
		@$suma[$value_tecnico['id']][$value_tecnico['nombres']][$key]=@$suma[$value_tecnico['id']][$value_tecnico['nombres']][$key]+$value;

@$contador[$value_tecnico['id']][$key]=@$contador[$value_tecnico['id']][$key]+1;

$promedio[$value_tecnico['id']]['promedio'][$key]=round((@$suma[$value_tecnico['id']][$value_tecnico['nombres']][$key])/@$contador[$value_tecnico['id']][$key],2);

		}

	}	
}

}
	$data['promedio']=$promedio;	
	$this->load->view('admin/reportes/supervisor_encuestas', $data);
		}
		else
			redirect('reportes');	
	}

	public function jefe_encuestas($jefeid = null, $fecha_ini = null, $fecha_fin = null) {
		if ( is_numeric($jefeid) && ( $jefeid != 0 ) ) {
			$fechas = array('desde' => strtotime($fecha_ini), 'hasta' => strtotime($fecha_fin));
			$data['header'] = $this->load->view('admin/menu/header', array('active' => 'encuestas' ));
			$data['jefes'] = $this->mjefes->jefes_combo();
			$data['supervisores'] = $this->msupervisores->supervisores_combo();
			$supervisores = $this->msupervisores->supervisores_combo($jefeid);
			$data['data'] = $this->mreportes->jefe_getEncuestas($supervisores, $jefeid);



$suma=array();
$promedio=array();
$contador=array();

	if ( @isset($data['data']['supervisores']) ) { 
		foreach ($data['data']['supervisores'] as $key_sup => $value_sup) {


		foreach ($value_sup['tecnicos'] as $key_tecnico => $value_tecnico) {
			
			$r=$this->mreportes->tecnico_getEncuestas($key_tecnico, $fechas);	
			if (!empty($r['solicitudes'])){

			foreach ($r['solicitudes'] as $key_soli => $solicitud) {	
				foreach ($solicitud->encuestas as $key => $value) {
				@$suma[$key_sup][$key]=@$suma[$key_sup][$key]+$value;

		@$contador[$key_sup][$key]=@$contador[$key_sup][$key]+1;

		$promedio[$key_sup]['promedio'][$key]=round((@$suma[$key_sup][$key])/@$contador[$key_sup][$key],2);

					}

					}	
				}

			}
		}
	}
		/*echo '<pre>';
		print_r($promedio);
		echo '</pre>';
		exit;*/
			$data['promedio']=$promedio;	

			$data['jefeid'] = $jefeid;
			$this->load->view('admin/reportes/jefe_encuestas', $data);
		}
		else
			redirect('reportes');	
	}

}