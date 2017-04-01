<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mencuestas extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function encuestas_preguntas() {
		$rows = array();
		$query = $this->db->query("SELECT * FROM preguntas");
		foreach ( $query->result() as $row ) {
			$rows[$row->id] = $row->pregunta;
		}
		return $rows;
	}

	public function encuestas_setresultados($data) {
		$this->db->replace('encuestas', $data);
	}

}