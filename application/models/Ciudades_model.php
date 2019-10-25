<?php
class Ciudades_model extends CI_Model{
	public function __construct(){
	}

	public function get($id=null){
		if(!is_null($id)){
			$query = $this->db->select('*')->from('tbl_ciudad')->where('ID_CIUDAD', $id)->get();
			if($query->num_rows() === 1){
				return $query->row_array();
			}
			return null;
		}

		$query = $this->db->query("select * from tbl_ciudad");

		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return null;
	}

	public function save($ciudad = array()){
		$this->db->insert('tbl_ciudad', $ciudad);

		if($this->db->affected_rows() === 1){
			return true;
		} else {
			return false;
		}
		
	}

	public function actualizarCiudad($ciudad = array()){
		$query = $this->db->query('update tbl_ciudad set 
			NOMBRE_CIUDAD = "'.$ciudad['NOMBRE_CIUDAD'].'"
			where ID_CIUDAD = "'.$ciudad['ID_CIUDAD'].'"');
		if($this->db->affected_rows() === 1){
			return true;
		} else {
			return false;
		}
	}
}

?>