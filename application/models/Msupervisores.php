<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Msupervisores extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	//obtenemos las entradas de todos o un usuario, dependiendo
	// si le pasamos le id como argument o no
	public function supervisores_entrys($id = false, $publish = false, $bnombres = '') {
		//$rows = array();
		if ( $id === false ) {
			$this->db->select('s.*, CONCAT(j.nombres, " ", j.apellidos) AS jnombre, b.nombre AS bnombre');
			$this->db->from('supervisores s');
			$this->db->join('jefes j', 'j.id = s.jefeid', 'left');
			$this->db->join('bases b', 'b.id = s.baseid', 'left');
			if ( !empty($bnombres) )
				$this->db->where('CONCAT(s.nombres, " ", s.apellidos) LIKE "%' . $bnombres . '%"', NULL, FALSE);
			if ( $publish )
				$this->db->where('s.publish', $publish);
			$this->db->order_by("s.publish, s.id", "desc");
		}
		else {
			$this->db->select('c.*');
			$this->db->from('supervisores c');
			$this->db->where('c.id', $id);
		}
		$query = $this->db->get();
		if ( $query->num_rows() > 0 )
			return $query->result();
	}
	
	public function supervisores_create($data) {
		$this->db->insert('supervisores', $data);
	}
   
	public function supervisores_delete($id) {
		$this->db->where('id', $id);
		$this->db->update('supervisores', array('publish' => 0));
	}

	//actualizamos los datos del usuario con id = 3
	public function supervisores_update($data) {
		$this->db->where('id', $data['id']);
		$this->db->update('supervisores', $data);
	}

	public function supervisores_combo($jefeid = null) {
		$rows = array();
		if ( is_numeric($jefeid) && ($jefeid != 0) )
			$query = $this->db->query("SELECT id, CONCAT(nombres, ' ', apellidos) AS tnombres FROM supervisores WHERE jefeid = $jefeid AND publish = 1");
		else
			$query = $this->db->query("SELECT id, CONCAT(nombres, ' ', apellidos) AS tnombres FROM supervisores WHERE publish = 1");
		foreach ( $query->result() as $key=>$row ) {
			$rows[$row->id] = $row->tnombres;
		}
		return $rows;
	}

	public function supervisores_byJefe($jefeid = null) {
		return $this->db->get_where('supervisores', array('jefeid' => $jefeid, 'publish' => 1))->result();
	}

	public function supervisores_ByDni($dni = null) {
		return $this->db->get_where('supervisores', array('dni' => $dni, 'publish' => 1))->result();
		}

}