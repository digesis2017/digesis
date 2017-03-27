<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mcostosot extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

	}

	public function getSotByType($id_tipo=null,$num=null){		

		 $rows = array();
	     $query = $this->db->get_where('monto_sot', array('tipo_id' => $id_tipo,'nsot'=>$num));
	     if( $query->num_rows() > 0 ) {
		     foreach ($query->result() as $key => $row ) {
					  $rows[] = $row;
				}
			}
		return $rows;
	}


}