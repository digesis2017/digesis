<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tecnicos extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('mtecnicos');
		$this->load->model('mperfiles');
		is_logged_in() ? true : redirect('admin');
		securityAccess(array(1, 2));
	}

	public function index() {
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'perfiles' ));
		$data['data'] = $this->mtecnicos->tecnicos_entrys();
		$data['bpublish'] = 1;
		$data['cantidades'] = $this->mperfiles->mperfiles_total();
		$this->load->view('admin/tecnicos', $data);
	}

	public function lista() {
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'perfiles' ));
		$data['bnombres'] = isset($_POST['bnombres']) ? $_POST['bnombres'] : '';
		$data['bpublish'] = isset($_POST['bpublish']) ? $_POST['bpublish'] : 1;
		$data['data'] = $this->mtecnicos->tecnicos_entrys(false, $data['bpublish'], $data['bnombres']);
		$data['cantidades'] = $this->mperfiles->mperfiles_total();
		$this->load->view('admin/tecnicos', $data);
	}

	public function form($id = false) {
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'tecnicos' ));
		$this->load->model('mbases');
		$this->load->model('msupervisores');
		$data['data'] = $this->mtecnicos->tecnicos_entrys($id);
		$data['supervisores'] = $this->msupervisores->supervisores_entrys(FALSE, 1);
		$data['bases'] = $this->mbases->bases_entrys(FALSE, 1);
		if ( !$id )
			unset($data['data']);
		$this->load->view('admin/tecnicosedit', $data);
	}

	public function edit($id) {
		$formdata = array (
			'id' => $id,
			'nombres' => $this->input->post('nombres'),
			'apellidos' => $this->input->post('apellidos'),
			'dni' => $this->input->post('dni'),
			'cargo' => $this->input->post('cargo'),
			'rpc' => $this->input->post('rpc'),
			'email' => $this->input->post('email'),
			'fechaingreso' => strtotime($this->input->post('fechaingreso')),
			'renta' => $this->input->post('renta'),
			'supervisorid' => $this->input->post('supervisorid'),
			'baseid' => $this->input->post('baseid'),
			'publish' => $this->input->post('publish'),
			'fecha_cese' => $this->input->post('publish') ? 0 : strtotime($this->input->post('fecha_cese')),
			'motivo_cese' => $this->input->post('publish') ? '' : $this->input->post('motivo_cese')
		);
		$this->mtecnicos->tecnicos_update($formdata);
		redirect('tecnicos');
	}

	public function add() {
		$formdata = array (
			'nombres' => $this->input->post('nombres'),
			'apellidos' => $this->input->post('apellidos'),
			'dni' => $this->input->post('dni'),
			'cargo' => $this->input->post('cargo'),
			'rpc' => $this->input->post('rpc'),
			'email' => $this->input->post('email'),
			'fechaingreso' => strtotime($this->input->post('fechaingreso')),
			'renta' => $this->input->post('renta'),
			'supervisorid' => $this->input->post('supervisorid'),
			'baseid' => $this->input->post('baseid'),
		);
		$this->mtecnicos->tecnicos_create($formdata);
		redirect('tecnicos');
	}

	public function delete($id) {
		$this->mtecnicos->tecnicos_delete($id);
		redirect('tecnicos');
	}

	public function tecnico_telefono() {
		$array = array('success' => FALSE);
		if ( $_POST ) {

			if ( !empty($_POST['t1id']) ) {
				$array['success'] = TRUE;
				$array['t1cell'] = $this->mtecnicos->tecnicos_get_telefono($_POST['t1id']);
			}
			if ( !empty($_POST['t2id']) ) {
				$array['success'] = TRUE;
				$array['t2cell'] = $this->mtecnicos->tecnicos_get_telefono($_POST['t2id']);
			}
			echo json_encode($array);
		}
		else
			echo json_encode($array);

	}
}

?>