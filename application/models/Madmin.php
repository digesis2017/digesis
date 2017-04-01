<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Madmin extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function admin_login($formdata) {
		$user = $formdata->user;
		$pass = $formdata->pass;
		$data = array();
		$query = $this->db->query("SELECT id, rolid FROM usuarios WHERE user = '$user' AND password = '$pass' AND publish = 1;");
		if ( $query->result() ) {
			foreach ( $query->result() as $row ) {
				$data['id'] = $row->id;
				$data['rolid'] = $row->rolid;
			}
			return (object)$data;
		}
		else
			return false;
	}

	public function tecnicos_login($dni = null) {
		return $this->db->get_where('tecnicos', array('dni' => $dni, 'publish' => 1))->row();
	}

public function supervisores_login($dni = null) {
		return $this->db->get_where('supervisores', array('dni' => $dni, 'publish' => 1))->row();
	}


public function jefes_login($dni = null) {
		return $this->db->get_where('jefes', array('dni' => $dni, 'publish' => 1))->row();
	}



	public function admin_inactivo($user = null) {
		return $this->db->get_where('usuarios', array('user' => $user, 'publish' => 0))->row();
	}

	public function admin_email($email = null) {
		return $this->db->get_where('usuarios', array('email' => $email, 'publish' => 1))->row();
	}

	public function user_bytoken($token = null) {
		return $this->db->get_where('tblreseteopass', array('token' => $token, 'active' => 1))->row();
	}

	public function usuarios_update($id) {
		$this->db->where('userid', $id);
		$this->db->update('tblreseteopass', array('active' => 0));
	}

	public function generarLink($data) {
		$this->db->insert('tblreseteopass', $data);
	}

}