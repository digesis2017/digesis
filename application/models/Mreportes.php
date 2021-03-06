<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mreportes extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('msupervisores');
		$this->load->model('mtecnicos');
	}

	public function tecnico_getEncuestas($tid = null, $fechas = null) {
		$rows = array();
		$this->db->select('s.id, s.fecha_instalacion');
		$this->db->from('solicitudes s');
		$this->db->join('solicitudestecnicos st', 'st.sid = s.id', 'left');
		$this->db->where('s.estadoid', 2);
		$where = "(st.t1id = $tid OR st.t2id = $tid)";
		$this->db->where($where);

		if ( is_array($fechas) && count($fechas) ) {
			$this->db->where('s.fecha_instalacion >=', $fechas['desde']);
			$this->db->where('s.fecha_instalacion <=', $fechas['hasta']);
		}

		$query = $this->db->get();
		$rows['promedio'] = 0;
		if ( $query->num_rows() > 0 ) {
			foreach ( $query->result() as $key => $row ) {
				$row->encuestas = $this->mreportes->preguntas_bySid($row->id);
				$row->fecha_instalacion = date('d/m/Y', $row->fecha_instalacion);
				$this->db->select_avg('respuesta');
				$this->db->where('sid', $row->id);
				$row->promedio = $this->db->get('encuestas')->row()->respuesta;
				if ( $row->promedio ) {
					$row->promedio = number_format($row->promedio, 2);
					$rows['promedio'] += $row->promedio;
					$rows['solicitudes'][] = $row;
				}
			}
			$rows['promedio'] = number_format($rows['promedio'] / (count($rows['solicitudes'])), 2);
			$rows['id'] = $tid;
		}
		return $rows;
	}

	public function preguntas_bySid($sid) {
		$rows = array();
		$query = $this->db->query("SELECT preguntaid, respuesta FROM encuestas WHERE sid = '$sid'");
		foreach ( $query->result() as $key=>$row ) {
			$rows[$row->preguntaid] = $row->respuesta;
		}
		return $rows;
	}

	public function supervisor_getEncuestas($tecnicos, $supervisor, $params = null) {
		$rows = array();
		$rows['promedio'] = 0;
		if ( is_array($tecnicos) && count($tecnicos) ) {
			foreach ( $tecnicos as $tid => $tecnico ) {
				$this->db->select_avg('respuesta');
				$this->db->from('encuestas e');
				$this->db->join('solicitudestecnicos st', 'st.sid = e.sid', 'left');
				$this->db->join('solicitudes s', 's.id = e.sid', 'left');
				$this->db->where('s.estadoid', 2);
				if ( $params['desde'] && $params['hasta'] ) {
					$this->db->where('s.fecha_instalacion >=', strtotime($params['desde']));
					$this->db->where('s.fecha_instalacion <=', strtotime($params['hasta']));
				}
				$where = "(st.t1id = $tid OR st.t2id = $tid)";
				$this->db->where($where);
				$promedio = $this->db->get()->row()->respuesta;
				if ( @$promedio ) {
					$promedio = number_format($promedio, 2);
					$rows['promedio'] += $promedio;
					$rows['tecnicos'][$tid] = array('id' => $tid, 'nombres' => $tecnico, 'promedio' => $promedio);
				}
			}
			if ( isset($rows['tecnicos']) && count($rows['tecnicos']) ) {
				$rows['promedio'] = number_format($rows['promedio'] / (count($rows['tecnicos'])), 2);
				$rows['nombres'] = $supervisor['nombres'];
				$rows['id'] = $supervisor['supid'];
			}
		}
		return $rows;
	}

	public function jefe_getEncuestas($supervisores, $jefeid, $params = null) {
		$rows = array();
		$rows['promedio'] = 0;
		if ( is_array($supervisores) && count($supervisores) ) {
			foreach ( $supervisores as $id => $supervisor ) {
				$tecnicos = $this->mtecnicos->tecnicos_bySupervisor($id);
				if ( count($tecnicos) ) {

					if ( $params['tecnicoid'] )
						$tecnicos2[$params['tecnicoid']] = $tecnicos[$params['tecnicoid']];
					else
						$tecnicos2 = $tecnicos;

					$data_sup = $this->mreportes->supervisor_getEncuestas($tecnicos2, array('supid' => $id, 'nombres' => $supervisor), $params);
					if ( isset($data_sup['tecnicos']) && count($data_sup['tecnicos']) ) {
						$rows['promedio'] += $data_sup['promedio'];
						$rows['supervisores'][$id] = $data_sup;
					}
				}
			}
			if ( isset($rows['supervisores']) && count($rows['supervisores']) ) {
				$rows['promedio'] = number_format($rows['promedio'] / (count($rows['supervisores'])), 2);
				$rows['id'] = $jefeid;
			}
		}
		return $rows;
	}

	public function jefes_getEncuestas($jefes, $params = null) {
		$rows = array();
		if ( is_array($jefes) && count($jefes) ) {

			if ($params['jefeid'])
				$jefes2[$params['jefeid']] = $jefes[$params['jefeid']];
			else
				$jefes2 = $jefes;

			foreach ( $jefes2 as $id => $jefe ) {
				$supervisores = $this->msupervisores->supervisores_combo($id);
				if ( count($supervisores) ) {

					if ( $params['supervisorid'] )
						$supervisores2[$params['supervisorid']] = $supervisores[$params['supervisorid']];
					else
						$supervisores2 = $supervisores;

					$rows[$id] = $this->mreportes->jefe_getEncuestas($supervisores2, $id, $params);
				}
			}
		}
		return $rows;
	}


	public function jefes_getReporteProduccion($supervisores, $params = null) {
		$rows = array();
		$rows['totalcuadrillas'] = $rows['totalvalidados'] = 0;
		foreach ( $supervisores as $rkey => $sup ) {
			$this->db->select('COUNT(st.supid)');
			$this->db->from('solicitudestecnicos st');
			$this->db->join('solicitudes s', 'st.sid = s.id', 'left');
			$this->db->where('st.supid', $sup->id);
			if ( $params['desde'] && $params['hasta'] ) {
				$this->db->where('s.fecha_instalacion >=', strtotime($params['desde']));
				$this->db->where('s.fecha_instalacion <=', strtotime($params['hasta']));
			}
			$this->db->group_by(array("st.supid", "st.t1id", "st.t2id"));
			$query = $this->db->get();
			if ( $query->num_rows() > 0 ) {
				$rows['bases'][$sup->baseid][$sup->id]['totalcuadrillas'] = $query->num_rows();
				$rows['totalcuadrillas'] += $query->num_rows();
			}

			$this->db->select('COUNT(st.sid) AS cantidad');
			$this->db->from('solicitudestecnicos st');
			$this->db->join('solicitudes s', 'st.sid = s.id', 'left');
			$this->db->where('st.supid', $sup->id);
			if ( $params['desde'] && $params['hasta'] ) {
				$this->db->where('s.fecha_instalacion >=', strtotime($params['desde']));
				$this->db->where('s.fecha_instalacion <=', strtotime($params['hasta']));
			}
			$this->db->where('s.estadoid', 2);
			$this->db->group_by("s.estadoid");
			$query = $this->db->get();
			if ( $query->num_rows() > 0 ) {
				$rows['bases'][$sup->baseid][$sup->id]['totalvalidados'] = 0;
				foreach ( $query->result() as $key => $row ) {
					$rows['bases'][$sup->baseid][$sup->id]['totalvalidados'] = $row->cantidad;
					$rows['totalvalidados'] += $row->cantidad;
				}
			}
		}
		return $rows;
	}

	public function jefes_getTotalSolicitudes($supervisores, $params = null) {
		$rows = array();
		$rows['totalprogramadas'] = $rows['totaladicionales'] = $rows['totalsolicitudes'] = 0;
		$rows['totalsinestado'] = $rows['totalreprogramados'] = $rows['totalrechazados'] = $rows['totalvalidados'] = $rows['totalpendientes'] = $rows['porcentaje'] = 0;
		foreach ( $supervisores as $rkey => $sup ) {
			$this->db->select('COUNT(st.sid) AS cantidad, s.upload');
			$this->db->from('solicitudestecnicos st');
			$this->db->join('solicitudes s', 'st.sid = s.id', 'left');
			$this->db->where('st.supid', $sup->id);
			if ( $params['desde'] && $params['hasta'] ) {
				$this->db->where('s.fecha_instalacion >=', strtotime($params['desde']));
				$this->db->where('s.fecha_instalacion <=', strtotime($params['hasta']));
			}
			$this->db->group_by("s.upload");
			$query = $this->db->get();
			if ( $query->num_rows() > 0 ) {
				$rows['bases'][$sup->baseid][$sup->id]['adicionales'] = $rows['bases'][$sup->baseid][$sup->id]['programadas'] = $rows['bases'][$sup->baseid][$sup->id]['totalsolicitudes'] = 0;
				foreach ( $query->result() as $key => $row ) {
					if ( $row->upload == 1 ) {
						$rows['bases'][$sup->baseid][$sup->id]['programadas'] = $row->cantidad;
						$rows['totalprogramadas'] += $row->cantidad;
					}
					else if ( $row->upload == 0 ) {
						$rows['bases'][$sup->baseid][$sup->id]['adicionales'] = $row->cantidad;
						$rows['totaladicionales'] += $row->cantidad;
					}
					$rows['bases'][$sup->baseid][$sup->id]['totalsolicitudes'] = $rows['bases'][$sup->baseid][$sup->id]['adicionales'] + $rows['bases'][$sup->baseid][$sup->id]['programadas'];
					$rows['totalsolicitudes'] += $row->cantidad;
				}
				$rows['bases'][$sup->baseid][$sup->id]['nombre'] = $sup->nombres . ' ' . $sup->apellidos;
			}

			$this->db->select('COUNT(st.sid) AS cantidad, s.estadoid, s.fecha_instalacion');
			$this->db->from('solicitudestecnicos st');
			$this->db->join('solicitudes s', 'st.sid = s.id', 'left');
			$this->db->where('st.supid', $sup->id);
			if ( $params['desde'] && $params['hasta'] ) {
				$this->db->where('s.fecha_instalacion >=', strtotime($params['desde']));
				$this->db->where('s.fecha_instalacion <=', strtotime($params['hasta']));
				if ( @$_GET['test'] == TRUE ) {
					echo '<pre>' . 'Desde Timestamp: ' . strtotime($params['desde']) . '</pre>';
					echo '<pre>' . 'Hasta Timestamp: ' . strtotime($params['hasta']) . '</pre>';
				}
			}
			$this->db->group_by("s.estadoid");
			$query = $this->db->get();
			if ( $query->num_rows() > 0 ) {
				$rows['bases'][$sup->baseid][$sup->id]['sinestado'] = $rows['bases'][$sup->baseid][$sup->id]['validados'] = $rows['bases'][$sup->baseid][$sup->id]['pendientes'] = $rows['bases'][$sup->baseid][$sup->id]['reprogramados'] = $rows['bases'][$sup->baseid][$sup->id]['rechazados'] = $rows['bases'][$sup->baseid][$sup->id]['porcentaje'] = 0;
				foreach ( $query->result() as $key => $row ) {
					if ( $row->estadoid == 1 ) {
						$rows['bases'][$sup->baseid][$sup->id]['sinestado'] = $row->cantidad;
						$rows['totalsinestado'] += $row->cantidad;
					}
					else if ( $row->estadoid == 2 ) {
						$rows['bases'][$sup->baseid][$sup->id]['validados'] = $row->cantidad;
						$rows['totalvalidados'] += $row->cantidad;
					}
					else if ( $row->estadoid == 3 ) {
						$rows['bases'][$sup->baseid][$sup->id]['pendientes'] = $row->cantidad;
						$rows['totalpendientes'] += $row->cantidad;
					}
					else if ( $row->estadoid == 4 ) {
						$rows['bases'][$sup->baseid][$sup->id]['reprogramados'] = $row->cantidad;
						$rows['totalreprogramados'] += $row->cantidad;
					}
					else if ( $row->estadoid == 5 ) {
						$rows['bases'][$sup->baseid][$sup->id]['rechazados'] = $row->cantidad;
						$rows['totalrechazados'] += $row->cantidad;
					}
					$rows['bases'][$sup->baseid][$sup->id]['porcentaje'] = number_format(($rows['bases'][$sup->baseid][$sup->id]['validados'] / $rows['bases'][$sup->baseid][$sup->id]['totalsolicitudes']) * 100, 0);
				}
			}
			if ( $rows['totalsolicitudes'] )
				$rows['porcentaje'] = number_format(($rows['totalvalidados'] / $rows['totalsolicitudes'] * 100), 0);
		}
		return $rows;
	}

	public function jefes_getTotalSolicitudesRF($supervisores, $params = null) {
		$rows = array();
		$rows['totalvalidados'] = $rows['totalpendientes'] = $rows['totalsolicitudes'] = 0;
		$rows['totalobservados'] = $rows['totalsinrf'] = $rows['totalconforme'] = $rows['porcentaje'] = 0;
		foreach ( $supervisores as $rkey => $sup ) {
			$this->db->select('COUNT(st.sid) AS cantidad, s.estadoid');
			$this->db->from('solicitudestecnicos st');
			$this->db->join('solicitudes s', 'st.sid = s.id', 'left');
			$this->db->where('st.supid', $sup->id);
			if ( $params['desde'] && $params['hasta'] ) {
				$this->db->where('s.fecha_instalacion >=', strtotime($params['desde']));
				$this->db->where('s.fecha_instalacion <=', strtotime($params['hasta']));
			}
			$where = "(s.estadoid = 2 OR s.estadoid = 3)";
			$this->db->where($where);
			$this->db->group_by("s.estadoid");
			$query = $this->db->get();
			if ( $query->num_rows() > 0 ) {
				$rows['bases'][$sup->baseid][$sup->id]['validados'] = $rows['bases'][$sup->baseid][$sup->id]['pendientes'] = $rows['bases'][$sup->baseid][$sup->id]['totalsolicitudes'] = 0;
				foreach ( $query->result() as $key => $row ) {
					if ( $row->estadoid == 2 ) {
						$rows['bases'][$sup->baseid][$sup->id]['validados'] = $row->cantidad;
						$rows['totalvalidados'] += $row->cantidad;
					}
					else if ( $row->estadoid == 3 ) {
						$rows['bases'][$sup->baseid][$sup->id]['pendientes'] = $row->cantidad;
						$rows['totalpendientes'] += $row->cantidad;
					}
					$rows['bases'][$sup->baseid][$sup->id]['totalsolicitudes'] = $rows['bases'][$sup->baseid][$sup->id]['validados'] + $rows['bases'][$sup->baseid][$sup->id]['pendientes'];
					$rows['totalsolicitudes'] += $row->cantidad;
				}
				$rows['bases'][$sup->baseid][$sup->id]['nombre'] = $sup->nombres . ' ' . $sup->apellidos;
			}

			$this->db->select('COUNT(st.sid) AS cantidad, s.rf');
			$this->db->from('solicitudestecnicos st');
			$this->db->join('solicitudes s', 'st.sid = s.id', 'left');
			$this->db->where('st.supid', $sup->id);
			if ( $params['desde'] && $params['hasta'] ) {
				$this->db->where('s.fecha_instalacion >=', strtotime($params['desde']));
				$this->db->where('s.fecha_instalacion <=', strtotime($params['hasta']));
			}
			$where = "(s.estadoid = 2 OR s.estadoid = 3)";
			$this->db->where($where);
			$this->db->group_by("s.rf");
			$query = $this->db->get();
			if ( $query->num_rows() > 0 ) {
				$rows['bases'][$sup->baseid][$sup->id]['sinrf'] = $rows['bases'][$sup->baseid][$sup->id]['observados'] = $rows['bases'][$sup->baseid][$sup->id]['conforme'] = $rows['bases'][$sup->baseid][$sup->id]['porcentaje'] = 0;
				foreach ( $query->result() as $key => $row ) {
					if ( $row->rf == 1 ) {
						$rows['bases'][$sup->baseid][$sup->id]['sinrf'] = $row->cantidad;
						$rows['totalsinrf'] += $row->cantidad;
					}
					else if ( $row->rf == 2 ) {
						$rows['bases'][$sup->baseid][$sup->id]['observados'] = $row->cantidad;
						$rows['totalobservados'] += $row->cantidad;
					}
					else if ( $row->rf == 3 ) {
						$rows['bases'][$sup->baseid][$sup->id]['conforme'] = $row->cantidad;
						$rows['totalconforme'] += $row->cantidad;
					}
					$rows['bases'][$sup->baseid][$sup->id]['porcentaje'] = number_format(($rows['bases'][$sup->baseid][$sup->id]['conforme'] / $rows['bases'][$sup->baseid][$sup->id]['totalsolicitudes']) * 100, 0);
				}
			}
			if ( $rows['totalsolicitudes'] )
				$rows['porcentaje'] = number_format(($rows['totalconforme'] / $rows['totalsolicitudes'] * 100), 0);
		}
		return $rows;
	}

	public function jefes_getSolicitudes($supervisores, $params = null) {
		$rows = array();
		foreach ( $supervisores as $rkey => $sup ) {
			$this->db->select('s.fecha_instalacion, s.id, ts.nombre AS "tiposervicio", s.tipotrabajo, s.cliente, s.direccion, s.plano, e.nombre AS "nestado", u.nombres AS "anombres", rf.nombre AS "rfnombre", u2.nombres AS "lrfnombres", t1.nombres AS "t1nombres", t2.nombres AS "t2nombres", sup.nombres AS "supnombres", j.nombres AS "jnombres"');
			$this->db->from('solicitudestecnicos st');
			$this->db->join('solicitudes s', 'st.sid = s.id', 'left');
			$this->db->join('tiposervicios ts', 'ts.id = s.tiposervicioid', 'left');
			$this->db->join('estados e', 'e.id = s.estadoid', 'left');
			$this->db->join('estadosrf rf', 'rf.id = s.rf', 'left');
			$this->db->join('tecnicos t1', 't1.id = st.t1id', 'left');
			$this->db->join('tecnicos t2', 't2.id = st.t1id', 'left');
			$this->db->join('supervisores sup', 'sup.id = st.supid', 'left');
			$this->db->join('jefes j', 'j.id = sup.jefeid', 'left');
			$this->db->join('usuarios u', 'u.id = st.aid', 'left');
			$this->db->join('logsolicitudesrf lrf', 'lrf.sid = s.id', 'left');
			$this->db->join('usuarios u2', 'u2.id = lrf.usuarioid', 'left');
			$this->db->where('st.supid', $sup->id);
			if ( $params['desde'] && $params['hasta'] ) {
				$this->db->where('s.fecha_instalacion >=', strtotime($params['desde']));
				$this->db->where('s.fecha_instalacion <=', strtotime($params['hasta']));
			}
			$this->db->order_by("s.id");
			$query = $this->db->get();
			if ( $query->num_rows() > 0 ) {
				foreach ( $query->result() as $key => $row ) {
					$rows[$row->id] = $row;
				}
			}
		}
		return $rows;
	}

	public function reportes_getSolicitudes($jefes, $params) {
		$rows = array();
		if ( is_array($jefes) && count($jefes) ) {
			if ( $params['jefeid'] )
				$jefes2[$params['jefeid']] = $jefes[$params['jefeid']];
			else
				$jefes2 = $jefes;

			foreach ( $jefes2 as $id => $jefe ) {
				$array = array('jefeid' => $id, 'publish' => 1);
				$supervisores = $this->msupervisores->supervisores_byJefe($id, $array);
				if ( count($supervisores) )
					$rows[$id] = $this->mreportes->jefes_getSolicitudes($supervisores, $params);
			}
		}
		return $rows;
	}

	public function jefes_getEficiencia($jefes, $params) {
		$rows = array();
		if ( is_array($jefes) && count($jefes) ) {

			if ( $params['jefeid'] )
				$jefes2[$params['jefeid']] = $jefes[$params['jefeid']];
			else
				$jefes2 = $jefes;

			foreach ( $jefes2 as $id => $jefe ) {
				$array = array('jefeid' => $id, 'publish' => 1);
				if ( $params['baseid'] )
					$array['baseid'] = $params['baseid'];
				if ( $params['supervisorid'] )
					$array['id'] = $params['supervisorid'];
				$supervisores = $this->msupervisores->supervisores_byJefe($id, $array);
				if ( count($supervisores) )
					$rows[$id] = $this->mreportes->jefes_getTotalSolicitudes($supervisores, $params);
			}
		}
		return $rows;
	}

	public function jefes_getRFotografico($jefes, $params) {
		$rows = array();
		if ( is_array($jefes) && count($jefes) ) {

			if ( $params['jefeid'] )
				$jefes2[$params['jefeid']] = $jefes[$params['jefeid']];
			else
				$jefes2 = $jefes;

			foreach ( $jefes2 as $id => $jefe ) {
				$array = array('jefeid' => $id, 'publish' => 1);
				if ( $params['baseid'] )
					$array['baseid'] = $params['baseid'];
				if ( $params['supervisorid'] )
					$array['id'] = $params['supervisorid'];
				$supervisores = $this->msupervisores->supervisores_byJefe($id, $array);
				if ( count($supervisores) )
					$rows[$id] = $this->mreportes->jefes_getTotalSolicitudesRF($supervisores, $params);
			}
		}
		return $rows;
	}

	public function jefes_getProduccion($jefes, $params) {
		$rows = array();
		if ( is_array($jefes) && count($jefes) ) {

			if ( $params['jefeid'] )
				$jefes2[$params['jefeid']] = $jefes[$params['jefeid']];
			else
				$jefes2 = $jefes;

			foreach ( $jefes2 as $id => $jefe ) {
				$array = array('jefeid' => $id, 'publish' => 1);
				if ( $params['baseid'] )
					$array['baseid'] = $params['baseid'];
				if ( $params['supervisorid'] )
					$array['id'] = $params['supervisorid'];
				$supervisores = $this->msupervisores->supervisores_byJefe($id, $array);
				if ( count($supervisores) )
					$rows[$id] = $this->mreportes->jefes_getReporteProduccion($supervisores, $params);
			}
		}
		return $rows;
	}

}