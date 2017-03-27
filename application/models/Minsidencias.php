<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mincidencias extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();

	}
	public function getIncidenciasById($idsot=null){		

		$rows = array();
		$this->db->select('i.*');
		$this->db->from('incidencias i');
		$this->db->where('month(FROM_UNIXTIME(i.fecha_incidencia))=',intval(date('m')));
		$this->db->where('i.sid=',$idsot);
		$query = $this->db->get();  
	     if( $query->num_rows() > 0 ) {
	     	foreach ( $query->result() as $key => $row ) {
				$rows[$row->id] = $row;
			}
		}
		
	}


}