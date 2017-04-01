<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mservicios extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mdepartamentos');
	}


	public function delete(){		
		$this->db->query("delete from servicios");
	}

	public function delete_row($id=null){

	  $this->db->where('id', $id);
      return $this->db->delete('servicios'); 	 	  
	}
	public function insert($data=array()){
			
		$this->db->insert('servicios', $data);
	}

	public function get($id=null)
	{

	$this->db->select('s.*');
	$this->db->from('servicios s');	

	if (!empty($id))
		$this->db->where('categoria', $id);

	$query = $this->db->get();
	if ( $query->num_rows() > 0 )
		return $query->result();

	}

	public function getById($id=null)
	{

	$this->db->select('s.*');
	$this->db->from('servicios s');		
	$this->db->where('id', $id);
	$query = $this->db->get();
	//echo $this->db->last_query();
	if ( $query->num_rows() > 0 )
		return $query->result();
	}

	public function getByCategoria($categoria=null)
	{

	$this->db->select('s.*');
	$this->db->from('servicios s');	
	$this->db->where('categoria',$categoria);
	$query = $this->db->get();
	//echo $this->db->last_query();
	$rows=array();
	if( $query->num_rows() > 0 ) {
		foreach ($query->result() as $key => $row ) {
					  $rows[] = $row;
				}			
			}
		return $rows;
	}

	public function update($data=array(),$id=null){

	   $this->db->where('id',$id);
       $r=$this->db->update('servicios',$data);
	   return $r;	   
	}

	public function get_tipo_servicios()
	{

		$this->db->select('ts.*');
		$this->db->from('tiposervicios ts');
		$query = $this->db->get();
		foreach ($query->result() as $key =>$row)
		 {
		 		 $row->nombre=rtrim($row->nombre,' ');
				 $rows[] = $row;
		 }	
		return $rows;
	}

}
