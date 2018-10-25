<?php
class Usuarios_model extends CI_Model{
	public function __construct(){

	}

	public function get($id=null){
		if(!is_null($id)){
			$query = $this->db->select('*')->from('tbl_usuario')->where('ID_USU', $id)->get();
			if($query->num_rows() === 1){
				return $query->row_array();
			}
			return null;
		}

		$query = $this->db->query("select * from tbl_usuario");

		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return null;
	}

	public function save($usuario = array()){
		$this->db->insert('tbl_usuario', $usuario);

		if($this->db->affected_rows() === 1){
			return true;
		} else {
			return false;
		}
		
	}

	public function existeUsuario($usuario = array()){
		$correo = $usuario['CORREO_USU'];
		$password = $usuario['PASSWORD'];
		if($usuario['PASSWORD'] != null){
			$query = $this->db->query("select ID_USU, CEDULA_USU, NOMBRE_USU, APELLIDO_USU from tbl_usuario
			 WHERE CORREO_USU = '".$correo."' and PASSWORD = '".$password."'");
			if($query->num_rows() > 0){
				return $query->result_array();
			} else {
				return false;
			}
		} else {
			$query = $this->db->query("select ID_USU, CEDULA_USU, NOMBRE_USU, APELLIDO_USU from tbl_usuario
			 WHERE CORREO_USU = '".$correo."'");
			if($query->num_rows() > 0){
				$num= array();
				$num['CODVER_USU']=null;
				$num['ID_USU'] =null;
				for ($i=0; $i < 4; $i++) { 
					$num['CODVER_USU'] .= rand(0,9);
				}
				$result = $query->row();
				$num['NOMBRE_USU'] = $result->NOMBRE_USU;
				$num['APELLIDO_USU'] = $result->APELLIDO_USU;
				$num['CEDULA_USU'] = $result->CEDULA_USU;
				$num['ID_USU'] = $result->ID_USU;
				return $num;
			} else {
				return false;
			}
		}
	}

	public function actualizarUsuario($usuario = array()){
		$query = $this->db->query('update tbl_usuario set
			CORREO_USU = "'.$usuario['CORREO_USU'].'", CEDULA_USU = "'.$usuario['CEDULA_USU'].'", NOMBRE_USU = "'.$usuario['NOMBRE_USU'].'", APELLIDO_USU = "'.$usuario['APELLIDO_USU'].'", PASSWORD = "'.$usuario['PASSWORD'].'"
			where ID_USU = "'.$usuario['ID_USU'].'"');
		if($this->db->affected_rows() === 1){
			return true;
		} else {
			return false;
		}
	}

	private function setUsuario($usuario){
		return array(
			'ID_USU' => $usuario['ID_USU'],
			'CEDULA_USU' => $usuario['CEDULA_USU'],
			'ID_CIUDAD' => $usuario['ID_CIUDAD'],
			'NOMBRE_USU' => $usuario['NOMBRE_USU'],
			'APELLIDO_USU' => $usuario['APELLIDO_USU'],
			'CORREO_USU' => $usuario['CORREO_USU'],
			'PASSWORD_USU' => $usuario['PASSWORD_USU']
		);
	}

}

?>
