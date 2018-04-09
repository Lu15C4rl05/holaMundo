<?php
class Ciudades_model extends CI_Model{
	public function __construct(){
	}

	public function get(){
		$query = $this->db->query("select distinct
	cii.NOMBRE_CIUDAD AS NOMBRE_CIUDAD
from tbl_ruta ru
	inner join tbl_ciudad cii on ru.ID_CIUDAD_INICIO= cii.ID_CIUDAD");
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return null;
	}
}

?>