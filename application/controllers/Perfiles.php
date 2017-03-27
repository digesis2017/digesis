<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perfiles extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('mperfiles');
		is_logged_in() ? true : redirect('admin');
		securityAccess(array(1, 2));
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'perfiles' ));
	}

	public function index() {
		$data['data'] = $this->mperfiles->mperfiles_entrys();
		$data['cantidades'] = $this->mperfiles->mperfiles_total();
		$this->load->view('admin/perfiles', $data);
	}

	public function lista() {
		$data['bnombres'] = isset($_POST['bnombres']) ? $_POST['bnombres'] : '';
		$data['data'] = $this->mperfiles->mperfiles_entrys($data['bnombres']);
		$data['cantidades'] = $this->mperfiles->mperfiles_total();
		$this->load->view('admin/perfiles', $data);
	}

}

?>