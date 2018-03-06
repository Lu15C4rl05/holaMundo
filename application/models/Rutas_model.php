<?php
class Rutas_model extends CI_Model{
	public function __construct(){

	}

	public function get($id=null){
		if(!is_null($id)){
			$query = $this->db->select('*')->from('tbl_ruta')->where('ID_RUTA', $id)->get();
			if($query->num_rows() === 1){
				return $query->row_array();
			}
			return null;
		}

		$query = $this->db->query("select 	ru.ID_RUTA, CONCAT(cii.NOMBRE_CIUDAD,'-',cio.NOMBRE_CIUDAD) AS RUTA,CONCAT(convert(char(8),ho.HORA_SALIDA,108),' - ',
			convert(char(8),ho.HORA_LLEGADA,108)) AS HORARIO
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

	public function update($id, $ruta){
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


	private function setRuta($ruta){
		return array(
			'ID_RUTA' => $pasajero['ID_RUTA'],
			'ID_CIUDAD_INICIO' => $pasajero['ID_CIUDAD_INICIO'],
			'ID_CIUDAD_DESTINO' => $pasajero['ID_CIUDAD_DESTINO'],
			'ID_HORARIO' => $pasajero['ID_HORARIO'],
			'COSTO_RUTA' => $pasajero['COSTO_RUTA']
		);
	}

}

?>