<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Billeteradigital extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database('default');
        $this->load->model('mcostosot');        
        $this->load->model('meficiencia');
        $this->load->model('msolicitudes');
		$this->load->model('mencuestas');
        is_logged_in() ? true : redirect('admin');
        //securityAccess(array(1, 2));
    }

	public function index() {

		if ( isset($_GET['dni']) && ( !empty($_GET['dni']) ) ) {
			$this->load->model('mtecnicos');
			$datat = $this->mtecnicos->tecnicobyDNI($_GET['dni']);
			if ( is_object($datat) ) {
				$tid = $datat->id;
				$data['nuevos'] = $this->msolicitudes->solicitudes_encuestas($tid, 1, true);
				$data['atendidos'] = $this->msolicitudes->solicitudes_encuestas($tid, 2, true);

		$data['resumen'] = $this->load->view('billtera/resumen', array('active' => 'perfiles' ));				
	}

	public function () {
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'perfiles' ));
		$data['bnombres'] = isset($_POST['bnombres']) ? $_POST['bnombres'] : '';
		$data['data'] = $this->mjefes->jefes_entrys(false, false, $data['bnombres']);
		$data['cantidades'] = $this->mperfiles->mperfiles_total();
		$this->load->view('admin/jefes', $data);
	}

	public function form($id = false) {
		$this->load->model('msolicitudes');
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'jefes' ));
        $data['regiones'] = $this->msolicitudes->regiones_entrys();
        if ( $id )
			$data['data'] = $this->mjefes->jefes_entrys($id);
        $this->load->view('admin/jefesedit', $data);
	}

	public function edit($id) {
		$formdata = array (
			'id' => $id,
			'nombres' => $this->input->post('nombres'),
			'apellidos' => $this->input->post('apellidos'),
			'dni' => $this->input->post('dni'),
			'email' => $this->input->post('email'),
			'regionid' => $this->input->post('regionid'),
			'password' => $this->input->post('password'),
			'publish' => $this->input->post('publish'),
			'fecha_cese' => $this->input->post('publish') ? 0 : strtotime($this->input->post('fecha_cese')),
			'motivo_cese' => $this->input->post('publish') ? '' : $this->input->post('motivo_cese')
		);
		$this->mjefes->jefes_update($formdata);
		redirect('jefes');
	}

	public function add() {
		$formdata = array (
			'nombres' => $this->input->post('nombres'),
			'apellidos' => $this->input->post('apellidos'),
			'dni' => $this->input->post('dni'),
			'email' => $this->input->post('email'),
			'user' => $this->input->post('user'),
			'password' => $this->input->post('password'),
			'regionid' => $this->input->post('regionid')
		);
		$this->mjefes->jefes_create($formdata);
		redirect('jefes');
	}

	public function delete($id) {
		$this->mjefes->jefes_delete($id);
		redirect('jefes');
	}
}

?>