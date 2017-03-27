<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicios extends CI_Controller {

	const SERVICIO_MANTENIMIENTO=1;
	const SERVICIO_INSTALACIONES=2;
	const SERVICIO_POST_VENTA=3;

	const SERVICIO_MANTENIMIENTO_NAME="mantenimiento";
	const SERVICIO_INSTALACIONES_NAME="instalacion";
	const SERVICIO_POST_VENTA_NAME="post venta";

	
	 public function __construct()
   {
 	   parent::__construct();
		$this->load->model('mservicios');
		$this->load->library('excel');
		is_logged_in() ? true : redirect('admin');
	}
			  
	 public function index()
	 {	 	
	 	$this->load->library('excel');

	 	$session = get_session();
		securityAccess(array(1, 3));

	 	$data['header'] = $this->load->view('admin/menu/header', array('active' => 'serviciosload' ));

	 	
		
		if ($this->input->server('REQUEST_METHOD') == 'GET'){

			$categoria=null;
			$cat=$this->input->get('cat');
			$data['cat']=$cat;
			if (!empty($cat)){

		
	if ($cat==self::SERVICIO_INSTALACIONES)
		$categoria="instalacion";

	if ($cat==self::SERVICIO_MANTENIMIENTO)
		$categoria='mantenimiento';

	if ($cat==self::SERVICIO_POST_VENTA)
		$categoria='post instalacion';

			}

			$r_categoria=$this->mservicios->get_tipo_servicios();
			$data['categorias']=$r_categoria;			
			$r_servicios=$this->mservicios->get($categoria);
			$data['servicios']=$r_servicios;
	 		$this->load->view('admin/carga-servicios',$data);
		}else if ($this->input->server('REQUEST_METHOD') == 'POST'){
			$this->mservicios->delete();	
			$file = $_FILES['file']['tmp_name'];
			$type = $_FILES['file']['type'];
			
			if (!empty($file)) {
		 		$obj_excel = PHPExcel_IOFactory::load($file);    
		       	$sheetData = $obj_excel->getActiveSheet()->toArray(null,true,true,true);
		       	$arr_datos = array();
		       	foreach ($sheetData as $index => $value) {  
					if (!in_array($index,array(1))){
			            $arr_datos = array(
			                    'descripcion'  => $value['B'], 
			                    'categoria' =>  $value['C'],
			                    'motivos'  =>  $value['D'],            
			                    'fotos'  =>  $value['E']
			            ); 
			
				foreach ($arr_datos as $llave => $valor) {
					$arr_datos[$llave] = $valor;
				}

				$this->mservicios->insert($arr_datos);	
            } 	
}
}
   		redirect('servicios');
   		}
   		
	 }

public function delete(){
	$id=$this->input->post('id');		
	if (!empty($id)){
		$r=$this->mservicios->delete_row($id);	
		if ($r)
			echo json_encode(array('code'=>200));
		else
			echo json_encode(array('code'=>$r));
		exit();
	}
}
public function add(){
	$request=$this->input->post();		
	if (!empty($request)) {				

		$categoria=null;
	if ($request['categoria']==self::SERVICIO_INSTALACIONES)
		$categoria="instalacion";

	if ($request['categoria']==self::SERVICIO_MANTENIMIENTO)
		$categoria='mantenimiento';

	if ($request['categoria']==self::SERVICIO_POST_VENTA)
		$categoria='post instalacion';


		$arr_datos = array(
			'descripcion'  =>$request['servicio'],
			'categoria' => $categoria,
			'motivos'  =>$request['motivos'],
			'fotos'  =>$request['fotos']
		); 						
		$this->mservicios->insert($arr_datos);	
		echo json_encode(array('msg'=>'ok','code'=>200));
	}else
		echo json_encode(array('msg'=>'faild','code'=>-1));
exit;		
}

public function update($id){

		$request=$this->input->post();
		$data=array();
		$categoria=null;		
	if ($request['categoria']==self::SERVICIO_INSTALACIONES)
		$categoria="Instalacion";

	if ($request['categoria']==self::SERVICIO_MANTENIMIENTO)
		$categoria='Mantenimiento';

	if ($request['categoria']==self::SERVICIO_POST_VENTA)
		$categoria='Post instalacion';

	   
	   $data=array(
		'descripcion'=>$request['descripcion'],
		'categoria'=>$categoria,
		'motivos'=>$request['motivos'],
		'fotos'=>$request['fotos']
	   	);

	 if (isset($request['id'])){  
		$r=$this->mservicios->update($data,$request['id']);
		if ($r)
			redirect('servicios');
	}else
		echo 'Error, ';	

}

public function edit($id){

$session = get_session();
securityAccess(array(1, 3));

$data['header'] = $this->load->view('admin/menu/header', array('active' => 'serviciosload' ));

$r_categoria=$this->mservicios->get_tipo_servicios();
$data['categorias']=$r_categoria;
$cat=null;

if (!empty($id))
	{
	$r_servicios=$this->mservicios->getById($id);	
   
if(strtolower($r_servicios[0]->categoria)==self::SERVICIO_MANTENIMIENTO_NAME)
	$cat=self::SERVICIO_MANTENIMIENTO;

if(strtolower($r_servicios[0]->categoria)==self::SERVICIO_INSTALACIONES_NAME)
	$cat=self::SERVICIO_INSTALACIONES;

if(strtolower($r_servicios[0]->categoria)==self::SERVICIO_POST_VENTA_NAME)
	$cat=self::SERVICIO_POST_VENTA;

	
	$data['cat']=$cat;
	$data['servicios']=$r_servicios;
	$this->load->view('admin/servicios_editar', $data);
	}

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
}