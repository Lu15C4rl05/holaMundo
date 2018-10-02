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

	public function save($cliente = array()){
		$this->db->insert('tbl_cliente', $cliente);

		if($this->db->affected_rows() === 1){
			return true;
		} else {
			return false;
		}
		
	}
	
	public function existeUsuario($usuario = array()){
		$correo = $usuario['CORREO_CLI'];
		$password = $usuario['PASSWORD'];
		if($usuario['PASSWORD'] != null){
			$query = $this->db->query("select ID_CLI, CEDULA_CLI, NOMBRE_CLI, APELLIDO_CLI from tbl_cliente
			 WHERE CORREO_CLI = '".$correo."' and PASSWORD = '".$password."'");
			if($query->num_rows() > 0){
				return $query->result_array();
			} else {
				return false;
			}
		} else {
			$query = $this->db->query("select * from tbl_cliente
			 WHERE CORREO_CLI = '".$correo."'");
			if($query->num_rows() > 0){
				return true;
			} else {
				return false;
			}
		}
	}
	
/*
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
*/

	private function setCliente($cliente){
		return array(
			'ID_CLI' => $cliente['ID_CLI'],
			'CEDULA_CLI' => $cliente['CEDULA_CLI'],
			'ID_CIUDAD' => $cliente['ID_CIUDAD'],
			'NOMBRE_CLI' => $cliente['NOMBRE_CLI'],
			'APELLIDO_CLI' => $cliente['APELLIDO_CLI'],
			'CORREO_CLI' => $cliente['CORREO_CLI'],
			'PASSWORD_CLI' => $cliente['PASSWORD_CLI']
		);
	}

}

?>
