<?php
class Empresas_model extends CI_Model
{
    public function __construct(){

    }

    public function get($id = null){
    	if(!is_null($id)){
			$query = $this->db->select('*')->from('tbl_empresa')->where('ID_EMPRESA', $id)->get();
			if($query->num_rows() === 1){
				return $query->row_array();
			}
			return null;
		}

		$query = $this->db->query("select * from tbl_empresa");

		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return null;
    }

    public function save($empresa = array()){
		$this->db->insert('tbl_empresa', $empresa);

		if($this->db->affected_rows() === 1){
			return true;
		} else {
			return false;
		}
	}

	public function update($empresa = array()){
		$query = $this->db->query('update tbl_empresa set NOMBRE_EMPRESA = "'.$empresa['NOMBRE_EMPRESA'].'" where ID_EMPRESA = "'.$empresa['ID_EMPRESA'].'"');
		if($this->db->affected_rows() === 1){
			return true;
		} else {
			return false;
		}
	}


}//end class