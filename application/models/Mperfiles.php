<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mperfiles extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function mperfiles_total() {
		$rows = array();
		$query = $this->db->query("SELECT COUNT(id) AS cantidad FROM tecnicos");
		$rows['tecnicos'] = $query->row()->cantidad ? $query->row()->cantidad : 0;
		$query = $this->db->query("SELECT COUNT(id) AS cantidad FROM supervisores");
		$rows['supervisores'] = $query->row()->cantidad ? $query->row()->cantidad : 0;
		$query = $this->db->query("SELECT COUNT(id) AS cantidad FROM jefes");
		$rows['jefes'] = $query->row()->cantidad ? $query->row()->cantidad : 0;
		$rows['total'] = $rows['supervisores'] + $rows['jefes'] + $rows['tecnicos'];
		return $rows;
	}

	public function mperfiles_entrys($bnombres = '') {
		$rows = array();
		$query = $this->db->query("SELECT id, nombres, apellidos, dni, email, publish FROM tecnicos WHERE CONCAT(nombres, ' ', apellidos) LIKE '%$bnombres%'");
		foreach ( $query->result() as $key => $row ) {
			$rows['tecnicos'][] = $row;
		}
		$query = $this->db->query("SELECT id, user, nombres, apellidos, dni, email, publish FROM jefes WHERE CONCAT(nombres, ' ', apellidos) LIKE '%$bnombres%'");
		foreach ( $query->result() as $key => $row ) {
			$rows['jefes'][] = $row;
		}
		$query = $this->db->query("SELECT id, user, nombres, apellidos, dni, email, publish FROM supervisores WHERE CONCAT(nombres, ' ', apellidos) LIKE '%$bnombres%'");
		foreach ( $query->result() as $key => $row ) {
			$rows['supervisores'][] = $row;
		}
		return $rows;
	}

}