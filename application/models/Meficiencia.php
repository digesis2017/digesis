<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Meficiencia extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

	}

	public function geteficiencia($p=null){			     
	     $rows = array();

	     $query = $this->db->get('eficiencia');
	     if( $query->num_rows() > 0 ) {
	     	$x=0;
		    foreach ($query->result() as $key => $row ) {
					  $rows[$row->monto] = range($x,$row->porcentaje);
					  $x=$row->porcentaje+1;
			}
			$y=0;
			$flag=0;
            foreach ($rows as $key => $value){
            	   if (in_array($p,$value)){
            	   	   $y=$key;					            	   	
            	   	   $flag=1;
            	   }
			}          
			if ($flag==0)
				$y=$key;					            	   	
		}
		return $y;
	}

	
}