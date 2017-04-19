<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mtecnicos extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function tecnicos_entrys($id = false, $publish = 1, $bnombres = '') {
		if ( $id === false ) {
			$this->db->select('t.*, CONCAT(s.nombres, " ", s.apellidos) AS snombre, b.nombre AS bnombre');
			$this->db->from('tecnicos t');
			$this->db->join('supervisores s', 's.id = t.supervisorid', 'left');
			$this->db->join('bases b', 'b.id = t.baseid', 'left');
			if ( !empty($bnombres) )
				$this->db->where('CONCAT(t.nombres, " ", t.apellidos) LIKE "%' . $bnombres . '%"', NULL, FALSE);
			$this->db->where('t.publish', $publish);
			$this->db->order_by("t.id", "desc");
		}
		else {
			$this->db->select('c.*');
			$this->db->from('tecnicos c');
			$this->db->where('c.id', $id);
		}
		$query = $this->db->get();
		if ( $query->num_rows() > 0 )
			return $query->result();
	}

	public function tecnicobyDNI($dni) {
		$query = $this->db->query("SELECT id, nombres,apellidos,cargo,dni FROM tecnicos WHERE dni = '$dni' AND publish = 1");
		if ( $query->row()->id )
			return $query->row();
		return null;
	}

	public function tecnicos_byCargo($cargo = 1) {
		$rows = array();
		$this->db->select('id, CONCAT(nombres, " ", apellidos) AS tnombres');
		$this->db->from('tecnicos');
		$this->db->where('cargo', $cargo);
		$this->db->where('publish', 1);

		$query = $this->db->get();
		foreach ( $query->result() as $key => $row ) {
			$rows[$row->id] = $row->tnombres;
		}
		return $rows;
	}

	public function tecnicos_byCargoMonedero($cargo = null,$sup=null) {
		$rows = array();
		$this->db->select('id, CONCAT(nombres, " ", apellidos) AS tnombres,dni,cargo');
		$this->db->from('tecnicos');
		if (!empty($cargo))
			$this->db->where('cargo', $cargo);
		if (!empty($sup))
			$this->db->where('supervisorid', $sup);

		$this->db->where('publish', 1);

		$query = $this->db->get();
		foreach ( $query->result() as $key => $row ) {
			$rows[$row->id] = $row;
		}
		return $rows;
	}

	public function tecnicos_combo() {
		$rows = array();
		$query = $this->db->query("SELECT id, CONCAT(nombres, ' ', apellidos) AS tnombres FROM tecnicos WHERE publish = 1");
		foreach ( $query->result() as $key=>$row ) {
			$rows[$row->id] = $row->tnombres;
		}
		return $rows;
	}

	public function tecnicos_combo2() {
		$rows = array();
		$query = $this->db->query("SELECT id, CONCAT(nombres, ' ', apellidos) AS tnombres,dni FROM tecnicos WHERE publish = 1");
		foreach ( $query->result() as $key=>$row ) {
			$rows[$row->dni] = $row->tnombres;
		}
		return $rows;
	}

	public function tecnicos_bySupervisor($supervisorid = 0, $cargo = 0) {
		$rows = array();
		if ( is_numeric($cargo) && ( $cargo != 0 ) )
			$query = $this->db->query("SELECT id, CONCAT(nombres, ' ', apellidos) AS tnombres FROM tecnicos WHERE cargo = $cargo AND publish = 1 AND supervisorid = $supervisorid");
		else
			$query = $this->db->query("SELECT id, CONCAT(nombres, ' ', apellidos) AS tnombres,dni,cargo FROM tecnicos WHERE publish = 1 AND supervisorid = $supervisorid");
		foreach ($query->result() as $key=>$row) {
			$rows[$row->id] = $row->tnombres;
		}
		return $rows;
	}

	public function tecnicos_bySupervisor2($supervisorid = 0) {
		$rows = array();
			$query = $this->db->query("SELECT id, CONCAT(nombres, ' ', apellidos) AS tnombres,dni,cargo FROM tecnicos WHERE cargo = 2 AND publish = 1 AND supervisorid = $supervisorid");

		foreach ($query->result() as $key=>$row) {
			$rows[$row->id] = $row;
		}

		return $rows;
	}

	public function tecnicos_total() {
		$query = $this->db->query("SELECT COUNT(id) AS cantidad FROM tecnicos");
		return $query->row(0);
	}
	
	public function tecnicos_create($data) {
		$this->db->insert('tecnicos', $data);
	}
   
	public function tecnicos_delete($id) {
		$this->db->where('id', $id);
		$this->db->update('tecnicos', array('publish' => 0));
	}

	public function tecnicos_update($data) {
		$this->db->where('id', $data['id']);
		$this->db->update('tecnicos', $data);
	}

	public function tecnicos_get_telefono($id) {
		$query = $this->db->query("SELECT rpc FROM tecnicos WHERE id = $id");
		$rst = $query->row('rpc');
		return ($rst ? $rst : '-');
	}

}