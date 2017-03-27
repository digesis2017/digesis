<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mroles extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function roles_entrys() {
		$this->db->select('r.*');
		$this->db->from('roles r');
		$query = $this->db->get();
		if ( $query->num_rows() > 0 )
			return $query->result();
	}

}