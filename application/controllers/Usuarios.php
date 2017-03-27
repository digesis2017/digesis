<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->database('default');
		$this->load->model('mroles');
		$this->load->model('musuarios');
		is_logged_in() ? true : redirect('admin');
	}

	public function index() {
		securityAccess(array(1, 2));
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'usuarios' ));
		$data['roles'] = $this->mroles->roles_entrys();
		$data['data'] = $this->musuarios->usuarios_entrys();
		$data['cantidades'] = $this->musuarios->usuarios_cantidades();
		$this->load->view('admin/usuarios', $data);
	}

	public function lista($rolid = 0) {
		securityAccess(array(1, 2));
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'usuarios' ));
		$data['rolid'] = $rolid ? $rolid : 0;
		$data['bnombres'] = isset($_POST['bnombres']) ? $_POST['bnombres'] : '';
		$data['roles'] = $this->mroles->roles_entrys();
		$data['data'] = $this->musuarios->usuarios_entrys(false, false, $data['rolid'], $data['bnombres']);
		$data['cantidades'] = $this->musuarios->usuarios_cantidades();
		$this->load->view('admin/usuarios', $data);
	}

	public function form($id = false) {
		securityAccess(array(1, 2));
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'usuariosadd' ));
		$data['data'] = $this->musuarios->usuarios_entrys($id);
		$data['roles'] = $this->mroles->roles_entrys();
		if ( !$id )
			unset($data['data']);
		$session = get_session();
		if ( in_array($session->rolid, array(1 , 2)) && ($session->id == $id) )
			$data['disabled'] = true;
		$this->load->view('admin/usuariosedit', $data);
	}

	public function tuusuario($id, $post = false) {
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'usuarioactivo' ));
		$data['data'] = $this->musuarios->usuarios_entrys($id);
		$data['roles'] = $this->mroles->roles_entrys();
		$session = get_session();
		if ( $session->id == $id )
			$data['disabled'] = true;
		$this->load->view('admin/usuariosedit', $data);
	}	

	public function edit($id, $self = false) {
		$formdata = array (
			'id' => $id,
			'password' => $this->input->post('password'),
			'nombres' => $this->input->post('nombres'),
			'apellidos' => $this->input->post('apellidos'),
			'dni' => $this->input->post('dni'),
			'email' => $this->input->post('email'),
			'rolid' => $this->input->post('rolid'),
			'publish' => $this->input->post('publish'),
			'fecha_cese' => $this->input->post('publish') ? 0 : strtotime($this->input->post('fecha_cese')),
			'motivo_cese' => $this->input->post('publish') ? '' : $this->input->post('motivo_cese')
		);
		$this->musuarios->usuarios_update($formdata);
		if ( $self )
			redirectUser();
		else
			redirect('usuarios');
	}

	public function add() {
		$formdata = array (
			'user' => $this->input->post('user'),
			'password' => $this->input->post('password'),
			'nombres' => $this->input->post('nombres'),
			'apellidos' => $this->input->post('apellidos'),
			'dni' => $this->input->post('dni'),
			'email' => $this->input->post('email'),
			'rolid' => $this->input->post('rolid')
		);
		$this->musuarios->usuarios_create($formdata);
		redirect('usuarios');
	}

	public function delete($id) {
		$this->musuarios->usuarios_delete($id);
		redirect('usuarios');
	}
}

?>