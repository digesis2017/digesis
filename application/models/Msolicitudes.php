<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Msolicitudes extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mdepartamentos');
	}

	public function solicitudes_entrys($estadoid = false, $distritoid = false, $solicitudid = '') {
		$this->db->select('s.*, ts.nombre AS tsnombre, dist.nombre AS distrito, dpto.nombre AS dpto, e.nombre AS enombre');
		$this->db->from('solicitudes s');
		$this->db->join('tiposervicios ts', 'ts.id = s.tiposervicioid', 'left');
		$this->db->join('estados e', 'e.id = s.estadoid', 'left');
		$this->db->join('distritos dist', 'dist.id = s.distritoid', 'left');
		$this->db->join('provincias prov', 'prov.id = dist.provinciaid', 'left');
		$this->db->join('departamentos dpto', 'dpto.id = prov.dptoid', 'left');
		if ( is_numeric($estadoid) && ( $estadoid != 0 ) )
			$this->db->where('s.estadoid', $estadoid);
		if ( is_numeric($distritoid) && ( $distritoid != 0 ) )
			$this->db->where('s.distritoid', $distritoid);
		if ( !empty($solicitudid) )
			$this->db->where('s.id LIKE "%' . $solicitudid . '%"', NULL, FALSE);

		$this->db->order_by("s.fecha_instalacion, s.horario");

		$query = $this->db->get();
		if ( $query->num_rows() > 0 ) {
			return $query->result();
		}
	}

	public function solicitudes_encuestas($tid = false, $estado = false, $today = false, $date=false) {
		$rows = array();
		$this->db->select('s.*, ts.nombre AS tsnombre, e.nombre AS enombre, m.motivo');
		$this->db->from('solicitudes s');
		$this->db->join('tiposervicios ts', 'ts.id = s.tiposervicioid', 'left');
		$this->db->join('solicitudestecnicos st', 'st.sid = s.id', 'left');
		$this->db->join('estados e', 'e.id = s.estadoid', 'left');
		$this->db->join('motivos m', 'm.id = s.motivoid', 'left');

		date_default_timezone_set('America/Lima');
		//date_default_timezone_set('UTC');
		//date_default_timezone_set("GMT");
		if ( $today ) {			
			$this->db->where('s.fecha_instalacion >=', strtotime(date('Y-m-d 00:00:00')));
			$this->db->where('s.fecha_instalacion <=', strtotime(date('Y-m-d 23:59:59')));
		}

		if ($date) {			
			$this->db->where('s.fecha_instalacion >=', strtotime(date($date.' 00:00:00')));
			$this->db->where('s.fecha_instalacion <=', strtotime(date($date.' 23:59:59')));
		}
		
		if ( is_numeric($estado) && ( $estado != 0 ) )
			$this->db->where('s.estadoid', $estado);
		if ( is_numeric($tid) && ( $tid != 0 ) ) {
			$where = "(st.t1id = $tid OR st.t2id = $tid)";
			$this->db->where($where);
		}

		$this->db->order_by("s.fecha_instalacion, s.horario");

		$query = $this->db->get();

		/*if ($date) {			
		echo $this->db->last_query();
		exit;
		}*/

		if ( $query->num_rows() > 0 ) {
			foreach ( $query->result() as $key => $row ) {
				$rows[$row->id] = $row;
			}
		}
		return $rows;
	}

	public function solicitudes_encuestas_all($tid = false, $estado = false) {
		$rows = array();
		$this->db->select('s.*, ts.nombre AS tsnombre, e.nombre AS enombre, m.motivo');
		$this->db->from('solicitudes s');
		$this->db->join('tiposervicios ts', 'ts.id = s.tiposervicioid', 'left');
		$this->db->join('solicitudestecnicos st', 'st.sid = s.id', 'left');
		$this->db->join('estados e', 'e.id = s.estadoid', 'left');
		$this->db->join('motivos m', 'm.id = s.motivoid', 'left');

		date_default_timezone_set('America/Lima');  		
		$this->db->where('month(FROM_UNIXTIME(s.fecha_instalacion))=',intval(date("m")));			
		
		
		if ( is_numeric($estado) && ( $estado != 0 ) )
			$this->db->where('s.estadoid', $estado);
		if ( is_numeric($tid) && ( $tid != 0 ) ) {
			$where = "(st.t1id = $tid OR st.t2id = $tid)";
			$this->db->where($where);
		}

		//$this->db->order_by("s.fecha_instalacion, s.id");
		
		$query = $this->db->get();
		if ( $query->num_rows() > 0 ) {
			foreach ( $query->result() as $key => $row ) {
				$rows[$row->id] = $row;
			}
		}
		return $rows;
	}

	public function solicitudes_cantidades() {
		$rows = array();
		$total = 0;
		$query = $this->db->query("SELECT estadoid, COUNT(id) AS cantidad FROM solicitudes GROUP BY estadoid");
		foreach ( $query->result() as $key => $row ) {
			$total += $row->cantidad;
			$rows[$row->estadoid] = $row->cantidad;
		}
		$rows[0] = $total;
		return $rows;
	}

	public function solicitudesrf_cantidades() {
		$rows = array();
		$total = 0;
		$query = $this->db->query("SELECT rf, COUNT(id) AS cantidad FROM solicitudes WHERE estadoid IN (2, 3) GROUP BY rf");
		foreach ( $query->result() as $key => $row ) {
			$total += $row->cantidad;
			$rows[$row->rf] = $row->cantidad;
		}
		$rows[0] = $total;
		return $rows;
	}

	public function solicitudestecnicos_entrys($distritoid = false, $solicitudid = '') {
		$this->db->select('s.*, st.t1id, st.t2id, ts.nombre AS tsnombre, dist.nombre AS distrito, dpto.nombre AS dpto, e.nombre AS enombre');
		$this->db->from('solicitudes s');
		$this->db->join('tiposervicios ts', 'ts.id = s.tiposervicioid', 'left');
		$this->db->join('solicitudestecnicos st', 'st.sid = s.id', 'left');
		$this->db->join('estados e', 'e.id = s.estadoid', 'left');
		$this->db->join('distritos dist', 'dist.id = s.distritoid', 'left');
		$this->db->join('provincias prov', 'prov.id = dist.provinciaid', 'left');
		$this->db->join('departamentos dpto', 'dpto.id = prov.dptoid', 'left');
		$this->db->where('s.estadoid !=', 2);
		$this->db->where('s.estadoid !=', 3);
		$this->db->where('s.estadoid !=', 5);
		$this->db->where('st.t1id', 0);
		$this->db->where('st.t2id', 0);
		/*$where = "(st.t1id = 0 OR st.t2id = 0)";
		$this->db->where($where);*/

		if ( is_numeric($distritoid) && ( $distritoid != 0 ) )
			$this->db->where('s.distritoid', $distritoid);
		if ( !empty($solicitudid) )
			$this->db->where('s.id LIKE "%' . $solicitudid . '%"', NULL, FALSE);
		$query = $this->db->get();
		if ( $query->num_rows() > 0 ) {
			return $query->result();
		}
	}


	public function solicitudesvalidadas_entrys($distritoid = false, $solicitudid = '', $today = false) {
		$rows = array();
		$this->db->select('s.*, ts.nombre AS tsnombre, dist.nombre AS distrito, dpto.nombre AS dpto');
		$this->db->from('solicitudes s');
		$this->db->join('tiposervicios ts', 'ts.id = s.tiposervicioid', 'left');
		$this->db->join('distritos dist', 'dist.id = s.distritoid', 'left');
		$this->db->join('provincias prov', 'prov.id = dist.provinciaid', 'left');
		$this->db->join('departamentos dpto', 'dpto.id = prov.dptoid', 'left');
		if ( !$today ) {
			if ( is_numeric($distritoid) && ( $distritoid != 0 ) )
				$this->db->where('s.distritoid', $distritoid);
			if ( !empty($solicitudid) )
				$this->db->where('s.id LIKE "%' . $solicitudid . '%"', NULL, FALSE);
		}
		else {
			$this->db->join('incidencias i', 'i.sid = s.id', 'inner');
			$this->db->where('i.fecha_incidencia', strtotime(date('d-m-Y')));
		}
		$this->db->where('s.estadoid', 2);
		$query = $this->db->get();
		if ( $query->num_rows() > 0 ) {

			foreach ( $query->result() as $key => $row ) {
				$row->incidencias = $this->msolicitudes->solicitudes_incidencias($row->id, TRUE);
				$rows[] = $row;
			}

		}
		return $rows;
	}

	public function solicitudesseguimiento_entrys($t1id = false, $t2id = false, $analistaid = false, $solicitudid = '') {
		$this->db->select('s.id, s.estadoid, s.cliente, dist.nombre AS distrito, dpto.nombre AS dpto, ts.nombre AS tsnombre, e.nombre AS enombre');
		$this->db->from('solicitudes s');
		$this->db->join('tiposervicios ts', 'ts.id = s.tiposervicioid', 'left');
		$this->db->join('solicitudestecnicos st', 'st.sid = s.id', 'left');
		$this->db->join('estados e', 'e.id = s.estadoid', 'left');
		$this->db->join('distritos dist', 'dist.id = s.distritoid', 'left');
		$this->db->join('provincias prov', 'prov.id = dist.provinciaid', 'left');
		$this->db->join('departamentos dpto', 'dpto.id = prov.dptoid', 'left');
		$this->db->where('st.t1id', $t1id);
		$this->db->where('st.t2id', $t2id);
		if ( is_numeric($analistaid) && ( $analistaid != 0 ) )
			$this->db->where('st.aid', $analistaid);

		if ( !empty($solicitudid) )
			$this->db->where('s.id LIKE "%' . $solicitudid . '%"', NULL, FALSE);
		$query = $this->db->get();
		if ( $query->num_rows() > 0 ) {
			return $query->result();
		}
		else
			return array();
	}

	public function solicitudesgroupbytecnicos($solicitudid = '', $tecnicoid = false, $analistaid = false) {
		$rows = array();
		$this->db->select('t1id, t2id');
		$this->db->from('solicitudestecnicos s');
		$this->db->where('t1id !=', 0);
		//$this->db->where('t2id !=', 0);

		if ( is_numeric($tecnicoid) && ( $tecnicoid != 0 ) )
			$this->db->where('t1id', $tecnicoid);

		$this->db->group_by(array("t1id", "t2id"));

		$query = $this->db->get();
		if ( $query->num_rows() > 0 ) {
			foreach ( $query->result() as $key => $row ) {
				$row->solicitudes = $this->msolicitudes->solicitudesseguimiento_entrys($row->t1id, $row->t2id, $analistaid, $solicitudid);
				$rows[] = $row;
			}
		}
		//var_dump($rows); die();
		return $rows;
	}

	public function solicitudes_carga($id = '') {
		$this->db->select('s.*, ts.nombre AS tsnombre, dist.nombre AS distrito, dpto.nombre AS dpto');
		$this->db->from('solicitudes s');
		$this->db->join('tiposervicios ts', 'ts.id = s.tiposervicioid', 'left');
		$this->db->join('distritos dist', 'dist.id = s.distritoid', 'left');
		$this->db->join('provincias prov', 'prov.id = dist.provinciaid', 'left');
		$this->db->join('departamentos dpto', 'dpto.id = prov.dptoid', 'left');
		$this->db->where('s.fecha_instalacion', strtotime(date('d-m-Y')));
		$this->db->where('s.upload', 1);
		if ( !empty($id) )
			$this->db->where('s.id LIKE "%' . $id . '%"', NULL, FALSE);
		$query = $this->db->get();
		if ( $query->num_rows() > 0 ) {
			return $query->result();
		}
	}

	public function solicitudesrf_entrys($estadorfid = false, $distritoid = false, $solicitudid = '', $supervisorid = false) {
		$this->db->select('s.*, CONCAT(t.nombres, " ", t.apellidos) AS tnombres, ts.nombre AS tsnombre, dist.nombre AS distrito, dpto.nombre AS dpto, rf.nombre AS rfnombre');
		$this->db->from('solicitudes s');
		$this->db->join('solicitudestecnicos st', 'st.sid = s.id', 'left');
		$this->db->join('tecnicos t', 't.id = st.t1id', 'left');
		$this->db->join('tiposervicios ts', 'ts.id = s.tiposervicioid', 'left');
		$this->db->join('estadosrf rf', 'rf.id = s.rf', 'left');
		$this->db->join('distritos dist', 'dist.id = s.distritoid', 'left');
		$this->db->join('provincias prov', 'prov.id = dist.provinciaid', 'left');
		$this->db->join('departamentos dpto', 'dpto.id = prov.dptoid', 'left');
		$this->db->where_in('s.estadoid', array(2, 3));

		if ( is_numeric($estadorfid) && ( $estadorfid != 0 ) )
			$this->db->where('s.rf', $estadorfid);
		if ( is_numeric($distritoid) && ( $distritoid != 0 ) )
			$this->db->where('s.distritoid', $distritoid);
		if ( strlen($solicitudid) )
			$this->db->where('s.id LIKE "%' . $solicitudid . '%"', NULL, FALSE);
		if ( is_numeric($supervisorid) && ( $supervisorid != 0 ) )
			$this->db->where('t.supervisorid', $supervisorid);
		$query = $this->db->get();
		if ( $query->num_rows() > 0 ) {
			return $query->result();
		}
	}

	public function solicitudesrf_encuestas($tid = false) {
		$this->db->select('s.*, ts.nombre AS tsnombre, rf.nombre AS rfnombre');
		$this->db->from('solicitudes s');
		$this->db->join('tiposervicios ts', 'ts.id = s.tiposervicioid', 'left');
		$this->db->join('solicitudestecnicos st', 'st.sid = s.id', 'left');
		$this->db->join('estadosrf rf', 'rf.id = s.rf', 'left');
		$this->db->where('s.estadoid', 2);
		$this->db->where_in('s.rf', array(1, 2));
		if ( is_numeric($tid) && ( $tid != 0 ) ) {
			$where = "(st.t1id = $tid OR st.t2id = $tid)";
			$this->db->where($where);
		}
		$this->db->order_by("s.fecha_instalacion");
		$query = $this->db->get();
		if ( $query->num_rows() > 0 ) {
			return $query->result();
		}
	}

	public function solicitudes_byID($id) {
		$rows = array();
		$query = $this->db->query("SELECT s.*, st.* FROM solicitudes s LEFT JOIN solicitudestecnicos st ON st.sid = s.id WHERE id = '$id'");
		foreach ($query->result() as $key=>$row) {
			$row->provinciaid = $this->mdepartamentos->distrito_getProvincia($row->distritoid);
			$row->departamentoid = $this->mdepartamentos->provincia_getDpto($row->provinciaid);
			$rows[$key] = $row;
		}
		$rows = $rows[0];
		return $rows;
	}

	public function solicitudes_incidencias($sid, $count = false) {
		$rows = array();
		$query = $this->db->query("SELECT id, fecha_incidencia FROM incidencias WHERE sid = '$sid'");
		foreach ($query->result() as $key=>$row) {
			$rows[$key + 1] = $row->fecha_incidencia;
		}
		if ( $count )
			return count($rows);
		else
			return $rows;
	}

	public function tipostrabajo_entrys() {
		$rows = array();
		$query = $this->db->query("SELECT * FROM tipotrabajos");
		foreach ($query->result() as $key=>$row) {
			$rows[$row->id] = $row->nombre;
		}
		return $rows;
	}

	public function estados_entrys() {
		$rows = array();
		$query = $this->db->query("SELECT * FROM estados");
		foreach ($query->result() as $key=>$row) {
			$rows[$row->id] = $row->nombre;
		}
		return $rows;
	}

	public function motivos_entrys($estadoid = 4) {
		$rows = array();
		$query = $this->db->query("SELECT * FROM motivos WHERE estadoid = $estadoid");
		foreach ( $query->result() as $key => $row ) {
			$rows[$row->id] = $row->motivo;
		}
		return $rows;
	}

	public function estadosrf_entrys() {
		$rows = array();
		$query = $this->db->query("SELECT * FROM estadosrf");
		foreach ($query->result() as $key=>$row) {
			$rows[$row->id] = $row->nombre;
		}
		return $rows;
	}

	public function regiones_entrys() {
		$rows = array();
		$query = $this->db->query("SELECT * FROM regiones");
		foreach ($query->result() as $key=>$row) {
			$rows[$row->id] = $row->nombre;
		}
		return $rows;
	}

	public function horarios_entrys() {
		$rows = array();
		$query = $this->db->query("SELECT * FROM horarios");
		foreach ($query->result() as $key=>$row) {
			$rows[$row->id] = $row->nombreh;
		}
		return $rows;
	}

	public function tiposservicio_entrys() {
		$rows = array();
		$query = $this->db->query("SELECT * FROM tiposervicios");
		foreach ($query->result() as $key=>$row) {
			$rows[$row->id] = $row->nombre;
		}
		return $rows;
	}

	public function solicitudess_get_ndestacadas($provid) {
		$query = $this->db->query("SELECT ndestacadas FROM solicitudes WHERE id = $provid");
		foreach ($query->result() as $row) {
			return $row->ndestacadas;
		}
	}

	public function solicitudess_promo($id) {
		$rows = array();
		$this->db->select('pp.provid, p.nombre');
		$this->db->from('promociones_solicitudess pp');
		$this->db->join('solicitudes p', 'pp.provid = p.id', 'left');
		$this->db->where('pp.promoid', $id);
		$query = $this->db->get();
		if ( $query->num_rows() > 0 ) {
			foreach ( $query->result() as $row ) {
				 $rows[$row->provid] = $row->nombre;
			 }
		}
		return $rows;
	}

	public function solicitudes_update($data, $id) {
		$this->db->where('id', $id);
		$this->db->update('solicitudes', $data);
	}

	public function solicitudes_programadas($id) {
		$this->db->replace('solicitudesprogramadas', array('sid' => $id, 'fecha' => strtotime("now")));
	}

	public function solicitudes_getID($sid) {
		$query = $this->db->query("SELECT id FROM solicitudes WHERE id = '$sid'");
		return $query->num_rows();
	}

	public function solicitudes_create($data) {
		$this->db->insert('solicitudes', $data);
	}

	public function solicitudes_addIncidencia($data) {
		$this->db->insert('incidencias', $data);
	}

	public function solicitudes_addtecnicos($data) {
		$this->db->replace('solicitudestecnicos', $data);
	}

	public function solicitudes_getTipoTrabajo($nombre = '') {
		if ( empty($nombre) )
			return 1;
		else {
			$query = $this->db->query("SELECT id FROM tipotrabajos WHERE nombre = '$nombre';");
			if ( $query->row('id') )
				return $query->row('id');
			else
				return 1;
		}
	}

	public function solicitudes_getTipoServicio($nombre = '') {
		if ( empty($nombre) )
			return 1;
		else {
			$query = $this->db->query("SELECT id FROM tiposervicios WHERE nombre = '$nombre';");
			if ( $query->row('id') )
				return $query->row('id');
			else
				return 1;
		}
	}

	public function solicitudes_replace($data) {
		$this->db->replace('solicitudes', $data);
		return $this->db->affected_rows();
	}

	public function solicitudes_cargalog($data) {
		$this->db->insert('logsolicitudes', $data);
	}

	public function solicitudes_rflog($data) {
		$this->db->insert('logsolicitudesrf', $data);
	}

	public function solicitudes_delete($id) {
		$this->db->where('id', $id);
		$this->db->update('solicitudes', array('publish' => 0));
	}

	public function solicitudes_motivos($estadoid = false) {
		$rows = array();
		$query = $this->db->query("SELECT * FROM motivos");
		if ( is_numeric($estadoid) )
			$query = $this->db->query("SELECT * FROM motivos WHERE estadoid = $estadoid");
		foreach ($query->result() as $key=>$row) {
			$rows[$row->id] = $row->motivo;
		}
		return $rows;
	}

	public function solicitudes_validate($sid = null) {
		return $this->db->get_where('solicitudes', array('id' => $sid))->row();
	}

	/*JC*/
	public function solicitudesByIdAndDate($sid,$flag=false){		
		$this->db->select('s.id,s.rf');
		$this->db->from('solicitudes s');
		if ($flag==false):
			$this->db->where('s.fecha_instalacion >=', strtotime(date('Y-m-d')));
			$this->db->where('s.fecha_instalacion <=', strtotime(date('Y-m-d 23:59:59')));
		endif;	
		$this->db->where('s.id LIKE "%' . $sid . '%"', NULL, FALSE);
		$this->db->where('s.rf', 2); // estado observado
		$query = $this->db->get();				
		if ( $query->num_rows() > 0 ) {			
			return 1;
		}
		else
			return 0;		
	}


public function solicitudesByMonthCount($tid=null,$fecha=false){
	$date=($fecha==false)? date('m'): date('m',strtotime($fecha)) ;
	$sql="SELECT
	DATE_FORMAT(FROM_UNIXTIME(solicitudes.fecha_instalacion), '%Y-%m-%d') as fecha,
	count(solicitudes.id) as cantidad
	FROM
	solicitudes
	LEFT JOIN tiposervicios ON solicitudes.tiposervicioid = tiposervicios.id
	LEFT JOIN solicitudestecnicos ON solicitudestecnicos.sid = solicitudes.id
	LEFT JOIN estados ON estados.id = solicitudes.estadoid
	LEFT JOIN motivos ON motivos.id = solicitudes.motivoid
	where solicitudes.estadoid=2 and (solicitudestecnicos.t1id=$tid or solicitudestecnicos.t2id=$tid) AND
	month(FROM_UNIXTIME(solicitudes.fecha_instalacion))=$date
	group by solicitudes.fecha_instalacion";
	$query= $this->db->query($sql);
	//echo $this->db->last_query();
	//exit;
	return $query->result_array();

}

public function solicitudesByMonth($tid=null,$fecha=null){
	$date=($fecha==false)? date('m'): date('m',strtotime($fecha)) ;
	$sql="SELECT
		solicitudes.id,
		DATE_FORMAT(FROM_UNIXTIME(solicitudes.fecha_instalacion), '%Y-%m-%d') as fecha
		FROM
		solicitudes
		LEFT JOIN tiposervicios ON solicitudes.tiposervicioid = tiposervicios.id
		LEFT JOIN solicitudestecnicos ON solicitudestecnicos.sid = solicitudes.id
		LEFT JOIN estados ON estados.id = solicitudes.estadoid
		LEFT JOIN motivos ON motivos.id = solicitudes.motivoid
		where solicitudes.estadoid=2 and (solicitudestecnicos.t1id=$tid or solicitudestecnicos.t2id=$tid) AND
		month(FROM_UNIXTIME(solicitudes.fecha_instalacion))=$date";
		$query= $this->db->query($sql);
		return $query->result_array();

}



public function solicitudes_asignar_multiple($sot)
{

		$this->db->select('s.*, CONCAT(t1.nombres, " ", t1.apellidos) AS tecnico1,CONCAT(t2.nombres, " ", t2.apellidos) AS tecnico2');
		$this->db->from('solicitudes s');
		$this->db->join('solicitudestecnicos st', 'st.sid = s.id', 'left');
		$this->db->join('tecnicos t1', 't1.id = st.t1id', 'left');
		$this->db->join('tecnicos t2', 't2.id = st.t2id', 'left');

		$this->db->where_in('s.id',$sot); 
		$query = $this->db->get();	
		
		if ( $query->num_rows() > 0 ) {			
			return $query->result();
		}

}

}