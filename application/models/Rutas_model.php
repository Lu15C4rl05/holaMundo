<?php
class Rutas_model extends CI_Model{
	public function __construct(){

	}

	public function get($id=null){
		if(!is_null($id)){
			$query = $this->db->select('ID_RUTA,
	CONCAT(cii.NOMBRE_CIUDAD,"-",cio.NOMBRE_CIUDAD) AS RUTA,
    CONCAT(date_format(ho.HORA_SALIDA,"%H:%I")," - ",date_format(ho.HORA_LLEGADA,"%H:%I")) AS HORARIO, RU.COSTO_RUTA')->from('tbl_ruta ru')->join('tbl_ciudad cii','ru.ID_CIUDAD_INICIO= cii.ID_CIUDAD')->join('tbl_ciudad cio','ID_CIUDAD_DESTINO=cio.ID_CIUDAD')->join('tbl_horario ho','ru.ID_HORARIO=ho.ID_HORARIO')->where('ru.ID_RUTA', $id)->get();
			if($query->num_rows() === 1){
				return $query->row_array();
			}
			return null;
		}

		$query = $this->db->query("select ru.ID_RUTA,
	CONCAT(cii.NOMBRE_CIUDAD,'-',cio.NOMBRE_CIUDAD) AS RUTA,
    CONCAT(date_format(ho.HORA_SALIDA,'%H:%I'),' - ',date_format(ho.HORA_LLEGADA,'%H:%I')) AS HORARIO, ru.COSTO_RUTA
from tbl_ruta ru
	inner join tbl_ciudad cii on ru.ID_CIUDAD_INICIO= cii.ID_CIUDAD
	inner join tbl_ciudad cio on ru.ID_CIUDAD_DESTINO=cio.ID_CIUDAD
	inner join tbl_horario ho on ru.ID_HORARIO=ho.ID_HORARIO;");

		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return null;
	}

	public function save($ruta){
		$this->db->set($this->setRuta($ruta))->insert('tbl_ruta');

		if($this->db->affected_rows() === 1){
			return $this->db->insert_id();
		}
		return false;
	}

	public function updat($id, $ruta){
		$this->db->set($this->setRuta($ruta))->where('ID_RUTA', $id)->update('tbl_ruta');

		if($this->db->affected_rows() === 1){
			return true;
		}
		return false;
	}

	public function delete($id){
		$this->db->where('ID_RUTA', $id)->delete('tbl_ruta');

		if($this->db->affected_rows() === 1){
			return true;
		}
		return false;
	}
}

?>