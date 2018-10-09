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
			$query = $this->db->query("select ID_CLI, CEDULA_CLI, NOMBRE_CLI, APELLIDO_CLI from tbl_cliente
			 WHERE CORREO_CLI = '".$correo."'");
			if($query->num_rows() > 0){
				$num= array();
				$num['CODVER_CLI']=null;
				$num['ID_CLI'] =null;
				for ($i=0; $i < 4; $i++) { 
					$num['CODVER_CLI'] .= rand(0,9);
				}
				$result = $query->row();
				$num['NOMBRE_CLI'] = $result->NOMBRE_CLI;
				$num['APELLIDO_CLI'] = $result->APELLIDO_CLI;
				$num['CEDULA_CLI'] = $result->CEDULA_CLI;
				$num['ID_CLI'] = $result->ID_CLI;
				return $num;
			} else {
				return false;
			}
		}
	}

	public function actualizarUsuario($usuario = array()){
		$query = $this->db->query('update tbl_cliente set
			CORREO_USU = "'.$usuario['CORREO_CLI'].'", CEDULA_CLI = "'.$usuario['CEDULA_CLI'].'", NOMBRE_CLI = "'.$usuario['NOMBRE_CLI'].'", APELLIDO_CLI = "'.$usuario['APELLIDO_CLI'].'", PASSWORD = "'.$usuario['PASSWORD'].'"
			where ID_CLI = "'.$usuario['ID_CLI'].'"');
		if($this->db->affected_rows() === 1){
			return true;
		} else {
			return false;
		}
	}
	
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
