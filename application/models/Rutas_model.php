<?php
class Rutas_model extends CI_Model{
	public function __construct(){

	}

	public function get($ciudad_in=null,$ciudad_out=null,$fecha=null){
		if( (!is_null($ciudad_in)) && (!is_null($ciudad_out)) && (is_null($fecha)) ){
			$query = $this->db->query("CALL proc_verRuta('".$ciudad_in."','".$ciudad_out."')");
			return $query->result_array();
		} else {
			if( (!is_null($ciudad_in)) && (!is_null($ciudad_out)) && (!is_null($fecha)) ){
				$query = $this->db->query("CALL proc_verHorario('".$ciudad_in."','".$ciudad_out."','".$fecha."')");
				return $query->result_array();
			} else {
				if( (!is_null($ciudad_in)) && (is_null($ciudad_out)) && (is_null($fecha)) ){
					$query = $this->db->query("call proc_verDestino('".$ciudad_in."')");
						return $query->result_array();
				} else {
					if( (is_null($ciudad_in)) && (is_null($ciudad_out)) && (is_null($fecha)) ){
						$query = $this->db->query("select * from vista_rutas");
						return $query->result_array();
					}
				}
			}
		}
		if($query->num_rows() > 0){
			 return $query->result_array();
		}
		return null;				
	}
	//Obtiene la ruta "ORIGEN - DESTINO", la imagen de la ciudad destino y el número de boeltos vendido de cada ruta
	public function getimg(){
		$query = $this->db->query("select * from vista_imagenes_ruta");

		if($query->num_rows() > 0){
			foreach ($query->result_array() as $row) {
			 	$row['IMAGEN'] = base64_encode($row['IMAGEN']);
			 	$datos[] = $row;
			 }
			 return $datos;
		}
		return null;
	}
	//Obtiene las ciudades origen de las rutas existentes
	public function getCiudadesOrigen(){
		$query = $this->db->query("select distinct cii.NOMBRE_CIUDAD AS NOMBRE_CIUDAD from tbl_ruta ru
			inner join tbl_ciudad cii on ru.ID_CIUDAD_INICIO= cii.ID_CIUDAD");
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return null;
	}
/*
	public function save($ruta){
		$this->db->set($this->setRuta($ruta))->insert('tbl_ruta');

		if($this->db->affected_rows() === 1){
			return $this->db->insert_id();
		}
		return false;
	}*/
/*
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
	}*/
}

?>