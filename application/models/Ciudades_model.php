<?php
class Ciudades_model extends CI_Model{
	public function __construct(){
	}

	public function get(){
		$query = $this->db->query("select NOMBRE_CIUDAD from tbl_ciudad");
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return null;
	}
}

?>