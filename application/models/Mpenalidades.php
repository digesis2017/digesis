<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mpenalidades extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

	}

	public function getPenalidadesById($codigo=null){		

		 $rows = array();
	     $query = $this->db->get_where('penalidades', array('codigo' => $codigo));
	     if( $query->num_rows() > 0 ) {
	     	$r=$query->result();
	     	return $r[0]->monto;		     
			}
		
	}


}