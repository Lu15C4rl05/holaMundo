<?php
class Rutas_model extends CI_Model{
	public function __construct(){

	}

	public function get($id=null){
		if(!is_null($id)){
			$query = $this->db->query("CALL proc_verRuta('".$id."')");
			return $query->result_array();
		}

		$query = $this->db->query("select * from vista_rutas");

		if($query->num_rows() > 0){
			foreach ($query->result_array() as $row) {
			 	$row['IMAGEN'] = base64_encode($row['IMAGEN']);
			 	$datos[] = $row;
			 }
			 return $datos;
		}
		return null;
	}

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