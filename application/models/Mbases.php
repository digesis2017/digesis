<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mbases extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function bases_entrys() {
		$this->db->select('r.*');
		$this->db->from('bases r');
		$query = $this->db->get();
		if ( $query->num_rows() > 0 )
			return $query->result();
	}

	public function bases_combo() {
		$rows = array();
		$query = $this->db->query("SELECT * FROM bases");
		foreach ( $query->result() as $key=>$row ) {
			$rows[$row->id] = $row->nombre;
		}
		return $rows;
	}

}