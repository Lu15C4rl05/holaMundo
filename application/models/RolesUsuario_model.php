<?php
class RolesUsuario_model extends CI_Model
{
	public function __construct()
	{ }

	public function get($id) {
		$query = $this->db->query('select ru.ID_ROL_USUARIO, rol.DESCRIPCION_ROL
		from tbl_rol_usuario ru inner join tbl_rol rol on ru.ID_ROL = rol.ID_ROL
		where ru.ID_USU="'.$id.'"');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return null;
	}

	public function save($rol_usuario = array())
	{
		$query = $this->db->query('select * from tbl_rol_usuario
			where ID_USU = "'.$rol_usuario['ID_USU'].'" and ID_ROL = "'.$rol_usuario['ID_ROL'].'"');
		if($query->num_rows() > 0){
			return false;
		} else {
			$this->db->query('insert into tbl_rol_usuario (ID_USU, ID_ROL) values ("'.$rol_usuario['ID_USU'].'","'.$rol_usuario['ID_ROL'].'")');

			if ($this->db->affected_rows() === 1) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function delete($rol_usuario = array()) {
		$this->db->query('delete from tbl_rol_usuario
			where ID_USU = "'.$rol_usuario['ID_USU'].'" and ID_ROL = "'.$rol_usuario['ID_ROL'].'"');

		if ($this->db->affected_rows() === 1) {
			return true;
		} else {
			return false;
		}
	}

	public function update($rol_usuario = array()) {
		$this->db->query('update tbl_rol_usuario set ID_ROL = "' . $rol_usuario['ID_ROL'] . '"
			where ID_ROL_USUARIO = "' . $rol_usuario['ID_ROL_USUARIO'] . '" AND ID_USU = "'. $rol_usuario['ID_USU'] .'"');

		if ($this->db->affected_rows() === 1) {
			return true;
		} else {
			return false;
		}
	}
}
