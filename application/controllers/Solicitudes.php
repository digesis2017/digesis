<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitudes extends CI_Controller {

	const SERVICIO_MANTENIMIENTO=1;
	const SERVICIO_INSTALACIONES=2;
	const SERVICIO_POST_VENTA=3;

	public function __construct()
	 {
		parent::__construct();
		$this->load->database('default');
		$this->load->model('msolicitudes');
		$this->load->model('mtecnicos');
		$this->load->model('mdepartamentos');
		$this->load->model('musuarios');
		$this->load->model('msupervisores');
		$this->load->model('mservicios');
		is_logged_in() ? true : redirect('admin');
	}

	public function index() {
		securityAccess(array(1));
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'solicitudes' ));
		$data['estados'] = $this->msolicitudes->estados_entrys();
		$data['departamentos'] = $this->mdepartamentos->departamentos_entrys();
		$data['data'] = $this->msolicitudes->solicitudes_entrys();
		$data['cantidades'] = $this->msolicitudes->solicitudes_cantidades();
		$this->load->view('admin/solicitudes', $data);

	}

	public function lista($estadoid = 0) {
		securityAccess(array(1));
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'solicitudes' ));
		$data['estadoid'] = $estadoid ? $estadoid : 0;
		$data['distritoid'] = isset($_POST['distritoid']) ? $_POST['distritoid'] : 0;
		$data['solicitudid'] = isset($_POST['solicitudid']) ? $_POST['solicitudid'] : '';
		if ( $data['distritoid'] ) {
			$data['provinciaid'] = $this->mdepartamentos->distrito_getProvincia($data['distritoid']);
			$data['departamentoid'] = $this->mdepartamentos->provincia_getDpto($data['provinciaid']);
		}
		$data['estados'] = $this->msolicitudes->estados_entrys();
		$data['data'] = $this->msolicitudes->solicitudes_entrys($data['estadoid'], $data['distritoid'], $data['solicitudid']);
		$data['distritos'] = $this->mdepartamentos->distritos_entrys(@$data['provinciaid']);
		$data['provincias'] = $this->mdepartamentos->provincias_entrys(@$data['departamentoid']);
		$data['departamentos'] = $this->mdepartamentos->departamentos_entrys();
		$data['cantidades'] = $this->msolicitudes->solicitudes_cantidades();
		$this->load->view('admin/solicitudes', $data);
	}


	public function form($id = false) {
		securityAccess(array(1, 4));
		$session = get_session();
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'solicitudesadd' ));
		$data['supervisores'] = $this->msupervisores->supervisores_combo();
		$data['analistas'] = $this->musuarios->usuarios_entrys(false, false, 4);

		//$data['tipotrabajos'] = $this->msolicitudes->tipostrabajo_entrys();
		$data['tipotrabajos'] =array();			
		$data['tiposervicios'] = $this->msolicitudes->tiposservicio_entrys();
		$data['distritos'] = $this->mdepartamentos->distritos_entrys();
		$data['provincias'] = $this->mdepartamentos->provincias_entrys();
		$data['departamentos'] = $this->mdepartamentos->departamentos_entrys();
		$data['regiones'] = $this->msolicitudes->regiones_entrys();
		$data['horarios'] = $this->msolicitudes->horarios_entrys();
		$data['admin'] = ($session->rolid==1) ? TRUE : FALSE;
		if ( isset($id) && is_numeric($id) && ( $id != "0" ) ) {
			securityAccess(array(1));
			if ( $this->msolicitudes->solicitudes_validate($id) ) {
				$data['data'] = $this->msolicitudes->solicitudes_byID($id);
				
		$categoria=null;
	if ($data['data']->tiposervicioid==self::SERVICIO_INSTALACIONES)
		$categoria="instalacion";

	if ($data['data']->tiposervicioid==self::SERVICIO_MANTENIMIENTO)
		$categoria='mantenimiento';

	if ($data['data']->tiposervicioid==self::SERVICIO_POST_VENTA)
		$categoria='post instalacion';

				$data['tipotrabajos']=$this->mservicios->getByCategoria($categoria);

				$data['distritos'] = $this->mdepartamentos->distritos_entrys($data['data']->provinciaid);
				$data['provincias'] = $this->mdepartamentos->provincias_entrys($data['data']->departamentoid);
				$data['estados'] = $this->msolicitudes->estados_entrys();
				$data['motivos'] = $this->msolicitudes->solicitudes_motivos($data['data']->estadoid);
				if (@$data['data']->supid){
					$data['tecnicos1'] = $this->mtecnicos->tecnicos_bySupervisor($data['data']->supid, 1);
					$data['tecnicos2'] = $this->mtecnicos->tecnicos_bySupervisor($data['data']->supid, 2);
					}
			}
			else
				redirect('solicitudes');
		}
		$this->load->view('admin/solicitudesedit', $data);
	}


	public function form_multiple() {
		securityAccess(array(1, 4));		
		$session = get_session();
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'asignartecnicos' ));
		$data['supervisores'] = $this->msupervisores->supervisores_combo();
		$data['analistas'] = $this->musuarios->usuarios_entrys(false, false, 4);
		$sot=$this->input->get();
		$sots=array();
		for ( $i=0; $i<=count($sot); $i++) {
			if (isset($sot['sot'.$i]))
				$sots[]=$sot['sot'.$i];
		}
					
		$data['admin'] = ($session->rolid==1) ? TRUE : FALSE;
		if ( !empty($sots) ) {
			securityAccess(array(1,4));

			$sol_mult = $this->msolicitudes->solicitudes_asignar_multiple($sots);
			$r_sol_tec = [];
			foreach ( $sol_mult as $key => $value ) {
				$r_sol_tec[$value->id]['id']=$value->id;		
				$r_sol_tec[$value->id]['tecnico1']=(($value->tecnico1!="")?$value->tecnico1:"sin asignar");
				$r_sol_tec[$value->id]['tecnico2']=(($value->tecnico2!="")?$value->tecnico2:"sin asignar");
				$categoria=null;
				if ($value->tiposervicioid==self::SERVICIO_INSTALACIONES)
					$categoria="instalacion";

				if ($value->tiposervicioid==self::SERVICIO_MANTENIMIENTO)
					$categoria='mantenimiento';

				if ($value->tiposervicioid==self::SERVICIO_POST_VENTA)
					$categoria='post instalacion';
		
				$r_sol_tec[$value->id]['tipotrabajos']=$this->mservicios->getByCategoria($categoria);
				$r_sol_tec[$value->id]['fecha']=($value->fecha_instalacion==0)? 'Sin asignar': date('Y-m-d',$value->fecha_instalacion);
				$r_sol_tec[$value->id]['hora']=(($value->hora!="")? $value->hora:"12:00");
			}

			$data['r_sol_tec']=$r_sol_tec;				
		}
		else
			redirect('solicitudes');
		
		$this->load->view('admin/solicitudes_asignar', $data);
	}


	public function asignar() {
		$session = get_session();
		$request=$this->input->post();    
		$data=json_decode($request['data']);	 
		foreach ( $data as $key => $value ) {
          	
		$formdata = array(
			'sid' => $value->id,
			'supid' =>$request['supervisorid'], 
			't1id' => $request['tecnico1id'], 
			't2id' => $request['tecnico2id'], 
			'aid' => $session->id
		);
	
		$this->msolicitudes->solicitudes_addtecnicos($formdata);
		$formdata = array(
			'id' =>$value->id,
			'fecha_instalacion' => $value->fecha? strtotime($value->fecha) : strtotime('now'),
			'hora' => $value->hora,
			'modtime' => strtotime("now"),
			'tipotrabajoid'=>$value->tipotrabajoid
		);		

		$this->msolicitudes->solicitudes_update($formdata, $value->id);
				
     }
     return json_encode(array('msg'=>'ok'));

	}

	public function listarf($estadorf = 0) {
		securityAccess(array(1, 6));
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'listarf' ));
		$data['solicitudid'] = isset($_POST['solicitudid']) ? $_POST['solicitudid'] : '';
		$data['supervisorid'] = isset($_POST['supervisorid']) ? $_POST['supervisorid'] : 0;
		$data['distritoid'] = isset($_POST['distritoid']) ? $_POST['distritoid'] : 0;
		if ( $data['distritoid'] ) {
			$data['provinciaid'] = $this->mdepartamentos->distrito_getProvincia($data['distritoid']);
			$data['departamentoid'] = $this->mdepartamentos->provincia_getDpto($data['provinciaid']);
		}
		$data['estadorf'] = $estadorf ? $estadorf : 0;
		$data['data'] = $this->msolicitudes->solicitudesrf_entrys($data['estadorf'], $data['distritoid'], $data['solicitudid'], $data['supervisorid']);
		$data['estados'] = $this->msolicitudes->estadosrf_entrys();
		$data['distritos'] = $this->mdepartamentos->distritos_entrys(@$data['provinciaid']);
		$data['provincias'] = $this->mdepartamentos->provincias_entrys(@$data['departamentoid']);
		$data['departamentos'] = $this->mdepartamentos->departamentos_entrys();
		$data['cantidades'] = $this->msolicitudes->solicitudesrf_cantidades();
		$data['supervisores'] = $this->msupervisores->supervisores_combo();
		$this->load->view('admin/solicitudesrf', $data);
	}

	public function listatecnicos() {
		securityAccess(array(1, 4));
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'asignartecnicos' ));
		$data['solicitudid'] = isset($_POST['solicitudid']) ? $_POST['solicitudid'] : '';
		$data['distritoid'] = isset($_POST['distritoid']) ? $_POST['distritoid'] : 0;
		if ( $data['distritoid'] ) {
			$data['provinciaid'] = $this->mdepartamentos->distrito_getProvincia($data['distritoid']);
			$data['departamentoid'] = $this->mdepartamentos->provincia_getDpto($data['provinciaid']);
		}
		$data['distritos'] = $this->mdepartamentos->distritos_entrys(@$data['provinciaid']);
		$data['provincias'] = $this->mdepartamentos->provincias_entrys(@$data['departamentoid']);
		$data['departamentos'] = $this->mdepartamentos->departamentos_entrys();
		$data['data']['pendientes'] = $this->msolicitudes->solicitudestecnicos_entrys($data['distritoid'], $data['solicitudid']);
		$data['data']['programadas'] = $this->msolicitudes->solicitudes_entrys(4);
		$data['tecnicos1'] = $this->mtecnicos->tecnicos_byCargo(1);
		$data['tecnicos2'] = $this->mtecnicos->tecnicos_byCargo(2);
		$this->load->view('admin/solicitudestecnicos', $data);
	}

	public function formtecnicos($id) {
		securityAccess(array(1, 4));
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'asignartecnicos' ));
		$data['supervisores'] = $this->msupervisores->supervisores_combo();
		$data['horarios'] = $this->msolicitudes->horarios_entrys();



		$data['data'] = $this->msolicitudes->solicitudes_byID($id);				

		$data['tiposervicios'] = $this->msolicitudes->tiposservicio_entrys();

		$categoria=null;
	if ($data['data']->tiposervicioid==self::SERVICIO_INSTALACIONES)
		$categoria="instalacion";

	if ($data['data']->tiposervicioid==self::SERVICIO_MANTENIMIENTO)
		$categoria='mantenimiento';

	if ($data['data']->tiposervicioid==self::SERVICIO_POST_VENTA)
		$categoria='post instalacion';

		$data['tipotrabajos']=$this->mservicios->getByCategoria($categoria);

		if ( @$data['data']->supid ) {
			$data['tecnicos1'] = $this->mtecnicos->tecnicos_bySupervisor($data['data']->supid, 1);
			$data['tecnicos2'] = $this->mtecnicos->tecnicos_bySupervisor($data['data']->supid, 2);
		}
		$this->load->view('admin/solicitudestecnicosedit', $data);
	}

	public function seguimiento() {
		securityAccess(array(1, 4));
		$session = get_session();
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'asignartecnicos' ));
		$data['solicitudid'] = isset($_POST['solicitudid']) ? $_POST['solicitudid'] : '';
		$data['tecnicoid'] = isset($_POST['tecnicoid']) ? $_POST['tecnicoid'] : 0;
		$id = ( $session->rolid==1 ) ? false : $session->id;
		$data['data'] = $this->msolicitudes->solicitudesgroupbytecnicos($data['solicitudid'], $data['tecnicoid'], $id);
		$data['tecnicos1'] = $this->mtecnicos->tecnicos_byCargo(1);
		$data['tecnicos2'] = $this->mtecnicos->tecnicos_byCargo(2);
		$this->load->view('admin/listaseguimiento', $data);
	}

	public function listavalidados() {
		securityAccess(array(1, 4));
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'asignartecnicos' ));
		$data['solicitudid'] = isset($_POST['solicitudid']) ? $_POST['solicitudid'] : '';
		$data['distritoid'] = isset($_POST['distritoid']) ? $_POST['distritoid'] : 0;
		if ( $data['distritoid'] ) {
			$data['provinciaid'] = $this->mdepartamentos->distrito_getProvincia($data['distritoid']);
			$data['departamentoid'] = $this->mdepartamentos->provincia_getDpto($data['provinciaid']);
		}
		$data['distritos'] = $this->mdepartamentos->distritos_entrys(@$data['provinciaid']);
		$data['provincias'] = $this->mdepartamentos->provincias_entrys(@$data['departamentoid']);
		$data['departamentos'] = $this->mdepartamentos->departamentos_entrys();
		$today = count($_POST) ? FALSE : TRUE;
		$data['data'] = $this->msolicitudes->solicitudesvalidadas_entrys($data['distritoid'], $data['solicitudid'], $today);
		$data['tecnicos1'] = $this->mtecnicos->tecnicos_byCargo(1);
		$data['tecnicos2'] = $this->mtecnicos->tecnicos_byCargo(2);
		$this->load->view('admin/listavalidados', $data);
	}

	public function formincidencia($sid) {
		securityAccess(array(1, 4));
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'asignartecnicos' ));
		$data['data'] = $this->msolicitudes->solicitudes_byID($sid);
		$data['incidencias'] = $this->msolicitudes->solicitudes_incidencias($sid);
		$this->load->view('admin/solicitudesincidencia', $data);
	}

	public function ajaxDistritos() {
		if ( $_POST ) {
			$array[] = array('id' => '', 'nombre' => '-Seleccione-');
			$data = $this->mdepartamentos->distritos_entrys($_POST['id']);
			foreach ($data as $key => $value) {
				$array[] = array('id' => $key, 'nombre' => $value);
			}
			echo json_encode($array);
		}

	}

	public function ajaxProvincias() {
		if ( $_POST ) {
			$array[] = array('id' => '', 'nombre' => '-Seleccione-');
			$data = $this->mdepartamentos->provincias_entrys($_POST['id']);
			foreach ($data as $key => $value) {
				$array[] = array('id' => $key, 'nombre' => $value);
			}
			echo json_encode($array);
		}
	}

	public function ajaxMotivos() {
		if ( $_POST ) {
			$array[] = array('id' => 0, 'nombre' => '-Seleccione-');
			$data = $this->msolicitudes->solicitudes_motivos($_POST['id']);
			foreach ($data as $key => $value) {
				$array[] = array('id' => $key, 'nombre' => $value);
			}
			echo json_encode($array);
		}
	}

	public function ajaxSupervisores() {
		if ( $_POST ) {
			$array[] = array('id' => 0, 'nombre' => '-Seleccione-');
			$data = $this->msupervisores->supervisores_combo($_POST['id']);
			foreach ($data as $key => $value) {
				$array[] = array('id' => $key, 'nombre' => $value);
			}
			echo json_encode($array);
		}
	}

	public function ajaxTecnicos($cargo = null) {
		if ( $_POST ) {
			$array[] = array('id' => 0, 'nombre' => '-Seleccione-');
			$data = $this->mtecnicos->tecnicos_bySupervisor($_POST['id'], $cargo);
			foreach ($data as $key => $value) {
				$array[] = array('id' => $key, 'nombre' => $value);
			}
			echo json_encode($array);
		}
	}

	public function formrf($id = false) {
		securityAccess(array(1, 6));
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'listarf' ));
		$data['tecnicos1'] = $this->mtecnicos->tecnicos_byCargo(1);
		$data['tecnicos2'] = $this->mtecnicos->tecnicos_byCargo(2);
		$data['tipotrabajos'] = $this->msolicitudes->tipostrabajo_entrys();
		$data['tiposervicios'] = $this->msolicitudes->tiposservicio_entrys();
		$data['distritos'] = $this->mdepartamentos->distritos_entrys();
		$data['estadosrf'] = $this->msolicitudes->estadosrf_entrys();
		$data['departamentos'] = $this->mdepartamentos->departamentos_entrys();
		$data['provincias'] = $this->mdepartamentos->provincias_entrys();
		$data['regiones'] = $this->msolicitudes->regiones_entrys();
		if ( $id )
			$data['data'] = $this->msolicitudes->solicitudes_byID($id);
		
		$this->load->view('admin/solicitudesrfedit', $data);
	}

	public function edit($id) {
		date_default_timezone_set('America/Lima');
		//date_default_timezone_set("GMT");
		//date_default_timezone_set('UTC');
		if ( $_POST ) {			
			$fecha=$this->input->post('fecha_instalacion');			
			securityAccess(array(1));
			$session = get_session();
			$formdata = array (
				'id' => $this->input->post('solicitudid'),
				'tipotrabajoid' => $this->input->post('tipotrabajoid'),
				'tiposervicioid' => $this->input->post('tiposervicioid'),
				'plano' => $this->input->post('plano'),
				'cliente' => $this->input->post('cliente'),
				'direccion' => $this->input->post('direccion'),
				'regionid' => $this->input->post('regionid'),
				'distritoid' => $this->input->post('distritoid'),
				'usuarioid' => $session->id,
				'estadoid' => $this->input->post('estadoid'),
				'motivoid' => $this->input->post('motivoid'),
				'fecha_instalacion' => $this->input->post('fecha_instalacion') ? strtotime($fecha) : strtotime('now'),
				'horario' => $this->input->post('horarioid'),
				'modtime' => strtotime("now")
			);
			$this->msolicitudes->solicitudes_update($formdata, $id);
			$formdata = array(
				'sid' => $this->input->post('solicitudid'),
				'supid' => $this->input->post('supid'),
				't1id' => $this->input->post('tecnico1id'),
				't2id' => $this->input->post('tecnico2id'),
				'aid' => $this->input->post('analistaid')
			);
			$this->msolicitudes->solicitudes_addtecnicos($formdata);
			redirect('solicitudes');
		}
		redirectUser();
	}

	public function add() {
		date_default_timezone_set('America/Lima');
		//date_default_timezone_set("GMT");
		if ( $_POST ) {
			$session = get_session();
			$fecha=$this->input->post('fecha_instalacion');			
			$formdata = array (
				'id' => $this->input->post('solicitudid'),
				'tipotrabajoid' => $this->input->post('tipotrabajoid'),
				'tiposervicioid' => $this->input->post('tiposervicioid'),
				'plano' => $this->input->post('plano'),
				'cliente' => $this->input->post('cliente'),
				'direccion' => $this->input->post('direccion'),
				'regionid' => $this->input->post('regionid'),
				'distritoid' => $this->input->post('distritoid'),
				'usuarioid' => $session->id,
				'upload' => 0,
				'fecha_instalacion' => $this->input->post('fecha_instalacion') ? strtotime($fecha) : strtotime('now'),
				'horario' => $this->input->post('horarioid'),
				'modtime' => strtotime("now")
			);
			$this->msolicitudes->solicitudes_create($formdata);
			$formdata = array(
				'sid' => $this->input->post('solicitudid'),
				'supid' => $this->input->post('supid') ? $this->input->post('supid') : 0,
				't1id' => $this->input->post('tecnico1id') ? $this->input->post('tecnico1id') : 0,
				't2id' => $this->input->post('tecnico2id') ? $this->input->post('tecnico2id') : 0,
				'aid' => $this->input->post('analistaid') ? $this->input->post('analistaid') : 0
			);
			$this->msolicitudes->solicitudes_addtecnicos($formdata);
		}

		redirectUser();
	}

	public function editrf($id) {
		$session = get_session();
		$formdata = array (
			'rf' => $this->input->post('estadosrfid'),
			'motivorf' => $this->input->post('motivo')
		);
		$this->msolicitudes->solicitudes_update($formdata, $id);
		$this->msolicitudes->solicitudes_rflog(array(
			'moddate' => strtotime("now"),
			'usuarioid' => $session->id,
			'sid' => $id,
			'estadorf' => $this->input->post('estadosrfid')
		));
		redirect('solicitudes/listarf');
	}

	public function addIncidencia($sid) {
		if ( isset($_POST) && is_array($_POST['incidencias']) ) {
			foreach ( $_POST['incidencias'] as $key => $date ) {
				$this->msolicitudes->solicitudes_addIncidencia(array('sid' => $sid, 'fecha_incidencia' => strtotime($date)));
			}
		}
		redirect('solicitudes/listavalidados');
	}

	public function edittecnicos($id) {
		$session = get_session();
		$formdata = array(
			'sid' => $id,
			'supid' => $this->input->post('supid'), 
			't1id' => $this->input->post('tecnico1id'),
			't2id' => $this->input->post('tecnico2id'),
			'aid' => $session->id
		);
		$this->msolicitudes->solicitudes_addtecnicos($formdata);
		$formdata = array(
			'id' => $id,
			'fecha_instalacion' => $this->input->post('fecha_instalacion') ? strtotime($this->input->post('fecha_instalacion')) : strtotime('now'),
			'hora' => $this->input->post('hora'),
			'tipotrabajoid'=>$this->input->post('tipotrabajoid'),
			'modtime' => strtotime("now")
		);
		$this->msolicitudes->solicitudes_update($formdata, $id);
		if ( $_GET['flag'] == 'seguimiento')
			redirect('solicitudes/seguimiento');
		else
			redirect('solicitudes/listatecnicos');
	}

	public function delete($id) {
		$this->msolicitudes->solicitudes_delete($id);
		redirect('solicitudes');
	}

	public function validateSid() {
		if ( $_POST ) {
			if ( !empty($_POST['sid']) ) {

				if ( $_POST['evento'] == 'add' ) {
					if ( $this->msolicitudes->solicitudes_validate($_POST['sid']) )
						echo 'error';
					else
						echo 'OK';
				}
				else {
					if ( (int)$_POST['asid'] == (int)$_POST['sid'] )
						echo 'OK';
					else if ( $this->msolicitudes->solicitudes_validate($_POST['sid']) )
						echo 'error';
					else
						echo 'OK';
				}

			}
			else
				echo 'error';

		}
		else
			echo 'error';
	}

	public function carga() {
		date_default_timezone_set('America/Lima');
		$session = get_session();
		securityAccess(array(1, 3));
		$data['header'] = $this->load->view('admin/menu/header', array('active' => 'solicitudesload' ));
		$data['bnombres'] = isset($_POST['bnombres']) ? $_POST['bnombres'] : '';
		if ( @$_POST['carga'] ) {
			$file = $_FILES['file']['tmp_name'];
			$type = $_FILES['file']['type'];
			if ( !empty($file) && ( $type == 'application/vnd.ms-excel' ) ) {
				$handle = fopen($file, "r");
				$fila = 1;
				$datos = array();
				$i = $inserts = $updates = 0;
				while ( ($datos = fgetcsv($handle)) !== false ) {
					if ( count($datos) > 8 ) {
						$i++;
						if ( $i == 1 )
							continue;
						if ( !empty($datos[0]) ) {
							$fecha = str_replace('/', '-', $datos[8]);
							$formdata = array(
								'id' => $datos[0],
								'tiposervicioid' => $this->msolicitudes->solicitudes_getTipoServicio($datos[1]),
								'plano' => $datos[7],
								'cliente' => $datos[2],
								'direccion' => $datos[3],
								'distritoid' => $this->mdepartamentos->distritos_getDistrito($datos[4], $datos[5], $datos[6]),
								'usuarioid' => $session->id,
								'fecha_instalacion' => empty($datos[8]) ? strtotime(date('d-m-Y')) : strtotime($fecha),
								'upload' => 1,
								'horario' => 1,
								'modtime' => strtotime("now")
							);
							if ( $this->msolicitudes->solicitudes_getID($datos[0]) ) {
								$updates++;
								$this->msolicitudes->solicitudes_update($formdata, $datos[0]);
							}
							else {
								$inserts++;
								$this->msolicitudes->solicitudes_create($formdata);
								$this->msolicitudes->solicitudes_addtecnicos(array('sid' => $datos[0], 't1id' => 0, 't2id' => 0, 'aid' => 0));
							}
						}
					}
					else {
						$data['error'] = '<p style="color: red;"><b>Error en el Archivo, El archivo CSV debe tener 9 Columnas</b></p>';
						break;
					}
				}
				$data['info'] = (object)array('filas' => $i-1, 'add' => $inserts, 'update' => $updates);
				$this->msolicitudes->solicitudes_cargalog(array(
					'fecha_upload' => strtotime("now"),
					'usuarioid' => $session->id,
					'agregados' => $inserts,
					'archivo' => $_FILES['file']['name']
				));
			}
			else
				$data['error'] = '<p style="color: red;"><b>Error de Archivo, Elija un Archivo .csv</b></p>';
		}
		else
			$data['bnombres'] = isset($_POST['bnombres']) ? $_POST['bnombres'] : '';

		$data['data'] = $this->msolicitudes->solicitudes_carga($data['bnombres']);
		$this->load->view('admin/carga-solicitudes', $data);
	}


public function get_tipo_trabajo($id=null)
{
	$id=$this->input->get('id');

	if ($id==self::SERVICIO_INSTALACIONES)
		$categoria="instalacion";

	if ($id==self::SERVICIO_MANTENIMIENTO)
		$categoria='mantenimiento';

	if ($id==self::SERVICIO_POST_VENTA)
		$categoria='post instalacion';

	$r=$this->mservicios->getByCategoria($categoria);
	echo json_encode($r);
	exit();
}	
}