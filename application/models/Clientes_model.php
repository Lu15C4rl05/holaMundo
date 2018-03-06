<?php
class Clientes_model extends CI_Model{
	public function __construct(){

	}

	public function get($id=null){
		if(!is_null($id)){
			$query = $this->db->select('*')->from('tbl_cliente')->where('ID_CLI', $id)->get();
			if($query->num_rows() === 1){
				return $query->row_array();
			}
			return null;
		}

		$query = $this->db->query("select * from tbl_cliente");

		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return null;
	}

	public function save($pasajero){
		$this->db->set($this->setPasajero($pasajero))->insert('tbl_pasajeros');

		if($this->db->affected_rows() === 1){
			return $this->db->insert_id();
		}
		return false;
	}

	public function updat($id, $pasajero){
		$this->db->set($this->setPasajero($pasajero))->where('codigo_pasaj', $id)->update('tbl_pasajeros');

		if($this->db->affected_rows() === 1){
			return true;
		}
		return false;
	}

	public function delete($id){
		$this->db->where('codigo_pasaj', $id)->delete('tbl_pasajeros');

		if($this->db->affected_rows() === 1){
			return true;
		}
		return false;
	}


	private function setPasajero($pasajero){
		return array(
			'codigo_pasaj' => $pasajero['codigo_pasaj'],
			'nombre_pasaj' => $pasajero['nombre_pasaj'],
			'codigoVer_pasaj' => $pasajero['codigoVer_pasaj']
		);
	}

}

?>