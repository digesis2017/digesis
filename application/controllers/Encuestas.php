<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Encuestas extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('msolicitudes');
		$this->load->model('mencuestas');
		$this->load->library('billetera');
	}

	public function index() {
		if ( isset($_GET['dni']) && ( !empty($_GET['dni']) ) ) {
			$this->load->model('mtecnicos');
			$datat = $this->mtecnicos->tecnicobyDNI($_GET['dni']);

			if ( is_object($datat) ) {
				$tid = $datat->id;
				$data['nuevos'] = $this->msolicitudes->solicitudes_encuestas($tid, 1, true);
				$data['atendidos'] = $this->msolicitudes->solicitudes_encuestas($tid, 2, true);				
				$data['pendientes'] = $this->msolicitudes->solicitudes_encuestas($tid, 3);
				$data['reprogramados'] = $this->msolicitudes->solicitudes_encuestas($tid, 4, true);
				$data['rechazados'] = $this->msolicitudes->solicitudes_encuestas($tid, 5, true);
				$data['sinfotos'] = $this->msolicitudes->solicitudesrf_encuestas($tid);
				$data['estados'] = $this->msolicitudes->estados_entrys();
				//print_r($data['sinfotos']);
				$data['mreprogramados'] = $this->msolicitudes->motivos_entrys(4);
				$data['mpendientes'] = $this->msolicitudes->motivos_entrys(3);
				$data['mrechazados'] = $this->msolicitudes->motivos_entrys(5);

				$data['tecnico'] = $datat->nombres;
				$resumen=$this->billetera_resumen($_GET['dni']);								
				$data['resumen']=$resumen;
				//$data['detalle']=$detalle;				
				$this->load->view('list-solicitudes', $data);
			}
			else
				redirect('welcome');
		}
		else
			redirect('welcome');
	}

	public function billetera_resumen($dni=null){
			$params=array('dni'=>$dni);
			return $this->billetera->getresumen($params);

	}

	public function billetera_detalle($dni=null){
			$params=array('dni'=>$dni);
			return $this->billetera->getdetalle_comision($params);

	}




	public function pendiente() {
		if ( isset($_POST) && count($_POST) ) {
			$form = array('id' => $_POST['sid'], 'motivoid' => $_POST['motivoid'], 'estadoid' => 3);
			$this->msolicitudes->solicitudes_update($form, $_POST['sid']);
			echo json_encode(array('status' => true));
		}
		else
			redirect('welcome');
	}

	public function reprogramar() {
		if ( isset($_POST) && count($_POST) ) {
			if ( strtotime(date('Y-m-d')) < strtotime($_POST['fecha']) ) {
				$form = array('id' => $_POST['sid'], 'horario' => $_POST['tiempo'] , 'fecha_instalacion' => strtotime($_POST['fecha']), 'motivoid' => $_POST['motivoid'], 'estadoid' => 4);
				$this->msolicitudes->solicitudes_update($form, $_POST['sid']);
				$this->msolicitudes->solicitudes_programadas($_POST['sid']);
				echo json_encode(array('status' => true));
			}
			else
				echo json_encode(array('status' => false));
		}
		else
			redirect('welcome');

	}

	public function rechazar() {
		if ( isset($_POST) && count($_POST) ) {
			$form = array('id' => $_POST['sid'], 'motivoid' => $_POST['motivoid'], 'estadoid' => 5);
			$this->msolicitudes->solicitudes_update($form, $_POST['sid']);
			echo json_encode(array('status' => true));
				
		}
		else
			redirect('welcome');
	}

	public function denegar() {
		if ( isset($_POST) && count($_POST) ) {
			$form = array('id' => $_POST['sid'], 'estadoid' => 2);
			$this->msolicitudes->solicitudes_update($form, $_POST['sid']);
			echo json_encode(array('status' => true));	
		}
		else
			redirect('welcome');
	}

	public function preguntas($sid = null) {
		$data = array();
		$preguntas = $this->mencuestas->encuestas_preguntas();
		if ( isset($sid) && !empty($sid) ) {
			if ( isset($_POST['npregunta']) && isset($_POST['respuesta']) ) {
				$form = array(
					'sid' => $sid,
					'preguntaid' => $_POST['npregunta'],
					'respuesta' => $_POST['respuesta']
				);
				$this->mencuestas->encuestas_setresultados($form);
				$npregunta = $_POST['npregunta'] + 1;
				$data['npregunta'] = (object)array('n' => $npregunta, 'pregunta' => $preguntas[$npregunta]);
				if ( $npregunta > count($preguntas) ) {
					$form = array(
						'id' => $sid,
						'estadoid' => 2
					);
					$this->msolicitudes->solicitudes_update($form, $sid);
					redirect('encuestas/gracias/' . $sid . '?dni=' . $_GET['dni']);
				}
			}
			else
				$data['npregunta'] = (object)array('n' => 1, 'pregunta' => $preguntas[1]);

			$this->load->view('preguntas', $data);
		}
		else
			redirect('welcome');
	}

	public function gracias($sid = null) {
		if ( isset($sid) && !empty($sid) )
			$this->load->view('gracias');
		else
			redirect('welcome');
	}

	public function indicaciones($sid = null) {
		if ( isset($sid) && !empty($sid) ) {
			$data['sid'] = $sid;
			$this->load->view('indicaciones', $data);
		}
		else
			redirect('welcome');
	}

	public function detalle() {
		date_default_timezone_set('America/Lima');
		//date_default_timezone_set("GMT");
		//date_default_timezone_set('UTC');
		//setlocale(LC_ALL,"es_ES");
		$lenguage = 'spanish';
		putenv("LANG=$lenguage");
		setlocale(LC_ALL, $lenguage);

		if (isset($_GET['dni']) && (!empty($_GET['dni']))){
			$resumen=$this->billetera_resumen($_GET['dni']);	
			$detalle=$this->billetera_detalle($_GET['dni']);			
			$fecha=get_date_spanish(time(),false,"%A %d de %B del %Y");//strftime("%A %d de %B del %Y");
			$data['resumen'] = $resumen;
			$data['detalle'] = $detalle;
			$data['fecha'] = $fecha;			
			$this->load->view('detalle-billetera', $data);			
		}else
				redirect('welcome');	
	}

public function supervisor($dni=null,$fecha=null) {

	if ( isset($_GET['dni']) && ( !empty($_GET['dni'])) ) {
		date_default_timezone_set('America/Lima');
		$this->load->model('mtecnicos');
		$this->load->model('msupervisores');
		$fecha=$this->input->get('fecha');

		if (empty($fecha))
			$fecha=date('Y-m-d');

		$r_supervisor=$this->msupervisores->supervisores_ByDni($_GET['dni']);
		$data = array();
		$acumulador=array('nuevos'=>0,'atendidos'=>0,'pendientes'=>0,'reprogramados'=>0,'rechazados'=>0);

		$data['fecha']=$fecha;
		foreach ( $r_supervisor as $key => $value_sup ) {
			$data['nom_supervisor']=$value_sup->nombres.' '.$value_sup->apellidos;
			$r_tecnicos=$this->mtecnicos->tecnicos_bySupervisor2($value_sup->id);
			$acumulador['nuevos']=0;		
			foreach ( $r_tecnicos as $key => $value ) {
				$datat = $this->mtecnicos->tecnicobyDNI($value->dni);
				if ( is_object($datat) ) {
					$tid = $datat->id;
					$data['supervisor'][$key]['id'] = $datat->id;
					$data['supervisor'][$key]['tecnico'] = $datat->nombres;
					$data['supervisor'][$key]['nuevos'] = $this->msolicitudes->solicitudes_encuestas($tid, 1, false,$fecha);
					$acumulador['nuevos']=intval($acumulador['nuevos'])+count($data['supervisor'][$key]['nuevos']);
					$data['supervisor'][$key]['atendidos']=$this->msolicitudes->solicitudes_encuestas($tid, 2, false,$fecha);
					$acumulador['atendidos']=intval($acumulador['atendidos']) + count($data['supervisor'][$key]['atendidos']);
					$data['supervisor'][$key]['pendientes']= $this->msolicitudes->solicitudes_encuestas($tid, 3);
					$acumulador['pendientes']=intval($acumulador['pendientes']) +count($data['supervisor'][$key]['pendientes']);
					$data['supervisor'][$key]['reprogramados']= $this->msolicitudes->solicitudes_encuestas($tid, 4, false,$fecha);
					$acumulador['reprogramados']=intval($acumulador['reprogramados']) + count($data['supervisor'][$key]['reprogramados']);
					$data['supervisor'][$key]['rechazados']=$this->msolicitudes->solicitudes_encuestas($tid, 5, false,$fecha);	
					$acumulador['rechazados']=intval($acumulador['rechazados']) + count($data['supervisor'][$key]['rechazados']);
					$data['supervisor'][$key]['sinfotos']=$this->msolicitudes->solicitudesrf_encuestas($tid);
					$data['supervisor'][$key]['estados']= $this->msolicitudes->estados_entrys();
				}
			}
		}
		$data['acumulador']=$acumulador;
		$this->load->view('list-solicitudes-supervisor', $data);
	}
	else
		redirect('welcome');
}

public function popupSup() {
	if ( $_POST ) {
		if ( $_POST['estado'] == 'nuevos' )
			$data = $this->msolicitudes->solicitudes_encuestas($_POST['tecnicoid'], 1, false, $_POST['fecha']);
		else if ( $_POST['estado'] == 'sinfotos' )
			$data = $this->msolicitudes->solicitudesrf_encuestas($_POST['tecnicoid']);
		else
			$data = array();

		$html = '<table id="tbmonedero" class="detalle-billetera">';
		$html .= '<thead>
						<tr>		
							<th>ID</th>
							<th>Fecha Instalación</th>
						</tr>
				</thead>
				<tbody>';
		foreach ( $data as $key => $value ) {
			$html .= '<tr><td>' . $value->id . '</td><td>' . date('d-m-Y', $value->fecha_instalacion) . '</td>';
		}
		$html .= '</tbody></table>';
		echo $html;
	}
	else
		redirect('welcome');
}

public function popupJefe() {
	if ( $_POST ) {
		$tecnicos = $this->mtecnicos->tecnicos_bySupervisor($_POST['supid']);
		$fecha = $_POST['fecha'];
		$sid = array();
		if ( $_POST['estado'] == 'nuevos' ) {
			$html = '<table id="tbmonedero" class="detalle-billetera">';
			$html .= '<thead>
							<tr>		
								<th>ID</th>
								<th>Fecha Instalación</th>
							</tr>
					</thead>
					<tbody>';
			foreach ( $tecnicos as $key => $value ) {
				$data = $this->msolicitudes->solicitudes_encuestas($key, 1, false, $fecha);
				foreach ( $data as $key => $value ) {
					if ( !isset($sids[$value->id]) ) {
						$html .= '<tr><td>' . $value->id . '</td><td>' . date('d-m-Y', $value->fecha_instalacion) . '</td>';
						$sids[$value->id] = TRUE;
					}
				}
			}
			$html .= '</tbody></table>';
		}
		echo $html;
	}
	else
		redirect('welcome');
}

public function jefe($dni=null,$fecha=null) {

	if ( isset($_GET['dni']) && ( !empty($_GET['dni']))){
		date_default_timezone_set('America/Lima');
		$this->load->model('mtecnicos');
		$this->load->model('msupervisores');
		$this->load->model('mjefes');

		$fecha=$this->input->get('fecha');

		if (empty($fecha))
			$fecha=date('Y-m-d');

$r_jefes=$this->mjefes->jefes_ByDni($_GET['dni']);
$sum_sup=array();
$acumulador=array();
$data=array();
$data['fecha']=$fecha;
if (!empty($r_jefes)){
foreach ($r_jefes as $key => $value_jefes) {

	$r_supervisor=$this->msupervisores->supervisores_byJefe($value_jefes->id);

	$data['jefe']['nom_jefe']=$value_jefes->nombres.' '.$value_jefes->apellidos;

	$acumulador=array('nuevos'=>0,'atendidos'=>0,'pendientes'=>0,'reprogramados'=>0,'rechazados'=>0);

	foreach ($r_supervisor as $key_sup => $value_sup) {
		
	$key_sup=$value_sup->id;
	$data['jefe']['supervisor'][$key_sup]['id']= $value_sup->id;
	$data['jefe']['supervisor'][$key_sup]['nom_supervisor']=$value_sup->nombres.' '.$value_sup->apellidos;


	$r_tecnicos=$this->mtecnicos->tecnicos_bySupervisor2($value_sup->id);

	$sum_sup[$key_sup]['nuevos']=0;
	$sum_sup[$key_sup]['atendidos']=0;
	$sum_sup[$key_sup]['pendientes']=0;
	$sum_sup[$key_sup]['reprogramados']=0;
	$sum_sup[$key_sup]['rechazados']=0;
	$sum_sup[$key_sup]['sinfotos']=0;

	foreach ($r_tecnicos as $key_tecnico => $value)	{
		$datat = $this->mtecnicos->tecnicobyDNI($value->dni);

		if ( is_object($datat) )
		{
		$tid = $datat->id;		
$data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['tecnico']=$datat->nombres;

$data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['nuevos']=$this->msolicitudes->solicitudes_encuestas($tid, 1, false,$fecha);


$acumulador['nuevos']=intval($acumulador['nuevos'])+count($data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['nuevos']);

$sum_sup[$key_sup]['nuevos']=intval($sum_sup[$key_sup]['nuevos'])+count($data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['nuevos']);


$data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['atendidos']=$this->msolicitudes->solicitudes_encuestas($tid, 2, false,$fecha);

	$acumulador['atendidos']=intval($acumulador['atendidos']) + count($data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['atendidos']);

	$sum_sup[$key_sup]['atendidos']=intval($sum_sup[$key_sup]['atendidos'])+count($data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['atendidos']);

	$data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['pendientes']= $this->msolicitudes->solicitudes_encuestas($tid, 3);

	$acumulador['pendientes']=intval($acumulador['pendientes']) +count($data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['pendientes']);

	$sum_sup[$key_sup]['pendientes']=intval($sum_sup[$key_sup]['pendientes']) +count($data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['pendientes']);

	$data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['reprogramados']= $this->msolicitudes->solicitudes_encuestas($tid, 4, false,$fecha);

			$acumulador['reprogramados']=intval($acumulador['reprogramados']) + count($data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['reprogramados']);

	$sum_sup[$key_sup]['reprogramados']=intval($sum_sup[$key_sup]['reprogramados'])+ count($data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['reprogramados']);

			$data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['rechazados']=$this->msolicitudes->solicitudes_encuestas($tid, 5, false,$fecha);	

	$acumulador['rechazados']=intval($acumulador['rechazados']) + count($data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['rechazados']);

	$sum_sup[$key_sup]['rechazados']=intval($sum_sup[$key_sup]['rechazados'])+ count($data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['rechazados']);

			$data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['sinfotos']=$this->msolicitudes->solicitudesrf_encuestas($tid);


	$sum_sup[$key_sup]['sinfotos']=intval($sum_sup[$key_sup]['sinfotos'])+ count($data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['sinfotos']);



			$data['jefe']['supervisor'][$key_sup]['tec'][$key_tecnico]['estados']= $this->msolicitudes->estados_entrys();

		}
	}

}
}
}				
		$data['sum_sup']=$sum_sup;
		$data['acumulador']=$acumulador;					
		$this->load->view('list-solicitudes-jefe', $data);
	}
			else
				redirect('welcome');
	
	}		

}