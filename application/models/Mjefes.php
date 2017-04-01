<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mjefes extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function jefes_entrys($id = false, $publish = false, $bnombres = '') {
		if ( $id === false ) {
			$this->db->select('c.*, r.nombre AS znombre');
			$this->db->from('jefes c');
			$this->db->join('regiones r', 'r.id = c.regionid', 'left');
			if ( !empty($bnombres) )
				$this->db->where('CONCAT(c.nombres, " ", c.apellidos) LIKE "%' . $bnombres . '%"', NULL, FALSE);
			if ( $publish )
				$this->db->where('c.publish', $publish);
			$this->db->order_by("c.publish, c.id", "desc");
		}
		else {
			$this->db->select('c.*');
			$this->db->from('jefes c');
			$this->db->where('c.id', $id);
		}
		$query = $this->db->get();
		if ( $query->num_rows() > 0 )
			return $query->result();
	}

public function jefes_ByDni($dni=null)
	{

		$this->db->select('c.*');
		$this->db->from('jefes c');
		$this->db->where('dni',$dni);
		$query = $this->db->get();
		if ( $query->num_rows() > 0 )
			return $query->result();
	}

	public function jefes_create($data) {
		$this->db->insert('jefes', $data);
	}
   
	public function jefes_delete($id) {
		$this->db->where('id', $id);
		$this->db->update('jefes', array('publish' => 0));
	}

	public function jefes_update($data) {
		$this->db->where('id', $data['id']);
		$this->db->update('jefes', $data);
	}

	public function jefes_combo() {
		$rows = array();
		$query = $this->db->query("SELECT id, CONCAT(nombres, ' ', apellidos) AS tnombres FROM jefes WHERE publish = 1");
		foreach ( $query->result() as $key=>$row ) {
			$rows[$row->id] = $row->tnombres;
		}
		return $rows;
	}

}