<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monedero extends CI_Controller {

	
	 public function __construct()
   {
           parent::__construct();
		   $this->load->library('billetera');		   
		   $this->load->model('mtecnicos');
		   $this->load->model('msupervisores');		   
		   is_logged_in() ? true : redirect('admin');
   }

   public function index()
	 {	 	
	 	securityAccess(array(1));
		date_default_timezone_set('America/Lima');	
		$perfil=null;
		$supervisor=null;
		$fecha=date('Y-m-d');

		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'monedero' ));

		if (isset($_GET['perfil']))
			$perfil=$_GET['perfil'];

		if (isset($_GET['fecha']))
			$fecha=$_GET['fecha'];

		if (isset($_GET['supervisor']))
			$supervisor=$_GET['supervisor'];

		$supervisores = $this->msupervisores->supervisores_combo();


		$r_tecnicos=$this->mtecnicos->tecnicos_byCargoMonedero(($perfil=='all')? null:$perfil,$supervisor);
		
		$result=array();
		if (!empty($r_tecnicos)):
			foreach ($r_tecnicos as $key => $value) {
			$params=array('dni'=>$value->dni,'fecha'=>(!empty($fecha)? $fecha:date('Y-m-d')));
			$resumen=$this->billetera->getresumen($params);
			         
			$result[$key]['nombres']=$value->tnombres;
			$result[$key]['perfil']=($value->cargo==1)? 'Tecnico1':'Tecnico2';
			$result[$key]['comidia']=$resumen['comision_dia'];
			$result[$key]['comimes']=$resumen['comision_mes'];
			$result[$key]['detalle']=array('dni'=>$value->dni,'fecha'=>$fecha);
			}
		endif;	
		$data=array(
			'result'=>$result,
			'fecha'=>$fecha,
			'perfil'=>$perfil,
			'supid'=>$supervisor,
			'supervisores'=>$supervisores
			);		

		$this->load->view('admin/monedero_view', $data);
		
	 }

	 public function detalle()
	 {
	 	date_default_timezone_set('America/Lima');
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'monedero' ));


		$fecha = $this->input->get('fecha');	    
   	  if (isset($_GET['dni']) && ( !empty($_GET['dni']) ) ) {
   	  		$dni=$_GET['dni'];
   	  		$r_tecnicos = $this->mtecnicos->tecnicobyDNI($dni);   	  		
			$params=array('dni'=>$dni,'fecha'=>(!empty($fecha)? $fecha:false));
			$resumen=$this->billetera->getresumen($params);
			$detalle=$this->billetera->getdetalle_comision($params);			

			$data['tecnico'] = $r_tecnicos->nombres.' '.$r_tecnicos->apellidos;						
			$data['perfil']=($r_tecnicos->cargo==1)? 'Tecnico1':'Tecnico2';
			$data['dni'] = $dni;			
			$data['resumen'] = $resumen;
			$data['detalle'] = $detalle;	
		}
	 $data['fecha'] = !empty($fecha)? $fecha:date('Y-m-d');	 
	 $this->load->view('admin/monedero_detalle_view', $data);
	 }

	}