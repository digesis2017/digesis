<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mdepartamentos extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function distritos_entrys($provid = false) {
		$rows = array();
		$query = $this->db->query("SELECT * FROM distritos");
		if ( is_numeric($provid) )
			$query = $this->db->query("SELECT * FROM distritos WHERE provinciaid = $provid");
		foreach ($query->result() as $key=>$row) {
			$rows[$row->id] = $row->nombre;
		}
		return $rows;
	}

	public function provincias_entrys($dptoid = false) {
		$rows = array();
		$query = $this->db->query("SELECT * FROM provincias");
		if ( is_numeric($dptoid) )
			$query = $this->db->query("SELECT * FROM provincias WHERE dptoid = $dptoid");
		foreach ($query->result() as $key=>$row) {
			$rows[$row->id] = $row->nombre;
		}
		return $rows;
	}

	public function departamentos_entrys() {
		$rows = array();
		$query = $this->db->query("SELECT * FROM departamentos ");
		foreach ($query->result() as $key=>$row) {
			$rows[$row->id] = $row->nombre;
		}
		return $rows;
	}


	public function distrito_getProvincia($id) {
		$query = $this->db->query("SELECT provinciaid FROM distritos WHERE id = $id");
		foreach ( $query->result() as $row ) {
			return $row->provinciaid;
		}
	}

	public function provincia_getDpto($id) {
		$query = $this->db->query("SELECT dptoid FROM provincias WHERE id = $id");
		foreach ( $query->result() as $row ) {
			return $row->dptoid;
		}
	}

	public function distritos_getDistrito($nombre = '', $provincia = '', $dpto = '') {
		if ( empty($nombre) )
			return 1;
		else {
			$query = $this->db->query("SELECT id FROM distritos WHERE nombre = '$nombre';");
			if ( $query->row('id') )
				return $query->row('id');
			else {
				$query = $this->db->query("SELECT id FROM provincias WHERE nombre = '$provincia';");
				if ( $query->row('id') ) {
					$this->db->insert('distritos', array('nombre' => $nombre, 'provinciaid' => $query->row('id')));
					return $this->db->insert_id();
				}
				else {
					$query = $this->db->query("SELECT id FROM departamentos WHERE nombre = '$dpto';");
					if ( $query->row('id') ) {
						$this->db->insert('provincias', array('nombre' => $nombre, 'dptoid' => $query->row('id')));
						$this->db->insert('distritos', array('nombre' => $nombre, 'provinciaid' => $this->db->insert_id()));
						return $this->db->insert_id();
					}
					else {
						$this->db->insert('departamentos', array('nombre' => $dpto));
						$this->db->insert('provincias', array('nombre' => $nombre, 'dptoid' => $this->db->insert_id()));
						$this->db->insert('distritos', array('nombre' => $nombre, 'provinciaid' => $this->db->insert_id()));
						return $this->db->insert_id();
					}
				}
			}
		}
	}

}