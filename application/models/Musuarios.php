<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Musuarios extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	//obtenemos las entradas de todos o un usuario, dependiendo
	// si le pasamos le id como argument o no
	public function usuarios_entrys($id = false, $publish = false, $rolid = 0, $bnombres = '') {
		//$rows = array();
		if ( $id === false ) {
			$this->db->select('c.*, r.nombre');
			$this->db->from('usuarios c');
			$this->db->join('roles r', 'r.id = c.rolid', 'left');
			if ( $rolid )
				$this->db->where('c.rolid', $rolid);
			if ( !empty($bnombres) )
				$this->db->where('CONCAT(c.nombres, " ", c.apellidos) LIKE "%' . $bnombres . '%"', NULL, FALSE);
			$this->db->order_by("c.publish, c.id", "desc");
		}
		else {
			$this->db->select('c.*');
			$this->db->from('usuarios c');
			$this->db->where('c.id', $id);
		}
		$query = $this->db->get();
		if ( $query->num_rows() > 0 )
			return $query->result();
	}
	
	public function usuarios_create($data) {
		$this->db->insert('usuarios', $data);
	}
   
	public function usuarios_delete($id) {
		$this->db->where('id', $id);
		$this->db->update('usuarios', array('publish' => 0));
	}

	public function usuarios_update($data) {
		$this->db->where('id', $data['id']);
		$this->db->update('usuarios', $data);
	}

	public function usuarios_cantidades() {
		$rows = array();
		$total = 0;
		$query = $this->db->query("SELECT rolid, COUNT(id) AS cantidad FROM usuarios GROUP BY rolid");
		foreach ( $query->result() as $key => $row ) {
			$total += $row->cantidad;
			$rows[$row->rolid] = $row->cantidad;
		}
		$rows[0] = $total;
		return $rows;
	}

}