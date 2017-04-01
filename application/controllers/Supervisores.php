<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supervisores extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->database('default');
		$this->load->model('msupervisores');
		$this->load->model('mperfiles');
		is_logged_in() ? true : redirect('admin');
		securityAccess(array(1, 2));
	}

	public function index() {
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'perfiles' ));
		$data['data'] = $this->msupervisores->supervisores_entrys();
		$data['cantidades'] = $this->mperfiles->mperfiles_total();
		$this->load->view('admin/supervisores', $data);
	}

	public function lista() {
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'perfiles' ));
		$data['bnombres'] = isset($_POST['bnombres']) ? $_POST['bnombres'] : '';
		$data['data'] = $this->msupervisores->supervisores_entrys(false, false, $data['bnombres']);
		$data['cantidades'] = $this->mperfiles->mperfiles_total();
		$this->load->view('admin/supervisores', $data);
	}

	public function form($id = false) {
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'supervisores' ));
		$this->load->model('mbases');
		$this->load->model('mjefes');
		$data['data'] = $this->msupervisores->supervisores_entrys($id);
		$data['jefes'] = $this->mjefes->jefes_entrys(FALSE, 1);
		$data['bases'] = $this->mbases->bases_entrys();
		if ( !$id )
			unset($data['data']);
		$this->load->view('admin/supervisoresedit', $data);
	}

	public function edit($id) {
		$formdata = array (
			'id' => $id,
			'nombres' => $this->input->post('nombres'),
			'apellidos' => $this->input->post('apellidos'),
			'dni' => $this->input->post('dni'),
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password'),
			'jefeid' => $this->input->post('jefeid'),
			'baseid' => $this->input->post('baseid'),
			'publish' => $this->input->post('publish'),
			'fecha_cese' => $this->input->post('publish') ? 0 : strtotime($this->input->post('fecha_cese')),
			'motivo_cese' => $this->input->post('publish') ? '' : $this->input->post('motivo_cese')
		);
		$this->msupervisores->supervisores_update($formdata);
		redirect('supervisores');
	}

	public function add() {
		$formdata = array (
			'nombres' => $this->input->post('nombres'),
			'apellidos' => $this->input->post('apellidos'),
			'dni' => $this->input->post('dni'),
			'email' => $this->input->post('email'),
			'user' => $this->input->post('user'),
			'password' => $this->input->post('password'),
			'jefeid' => $this->input->post('jefeid'),
			'baseid' => $this->input->post('baseid')
		);
		$this->msupervisores->supervisores_create($formdata);
		redirect('supervisores');
	}

	public function delete($id) {
		$this->msupervisores->supervisores_delete($id);
		redirect('supervisores');
	}
}

?>