<?php
class Conductores_model extends CI_Model
{
	public function __construct()
	{ }

	public function get($id = null)
	{
		if (!is_null($id)) {
			$query = $this->db->query("select c.ID_COND, c.ID_EMPRESA, c.CEDULA_COND, c.NOMBRE_COND, c.APELLIDO_COND, c.CORREO_COND, c.DIRECCION_COND, c.TELEFONO_COND,	c.ESTADO_COND, i.URL_IMAGEN as FOTO_COND from tbl_conductor c inner join tbl_img i on c.ID_IMG=i.ID_IMG
				where ID_COND=".$id."");
			if ($query->num_rows() === 1) {
				return $query->row_array();
			}
			return null;
		}

		$query = $this->db->query("select c.ID_COND, c.ID_EMPRESA, c.CEDULA_COND, c.NOMBRE_COND, c.APELLIDO_COND, c.CORREO_COND, c.DIRECCION_COND, c.TELEFONO_COND,	c.ESTADO_COND, i.URL_IMAGEN as FOTO_COND from tbl_conductor c inner join tbl_img i on c.ID_IMG=i.ID_IMG
			where ESTADO_COND=1");

		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return null;
	}

	public function save($conductor = array())
	{
		$this->db->insert('tbl_conductor', $conductor);

		if ($this->db->affected_rows() === 1) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteDriver($id_cond)
	{
		$this->db->set('ESTADO_COND', 0);
		$this->db->where('ID_COND', $id_cond);
		return $this->db->update('tbl_conductor');
	}

	public function actualizarConductor($conductor = array())
	{
		if ($conductor['FOTO_COND'] != null)
			$this->db->set('FOTO_COND', $conductor['FOTO_COND']); //cambia la foto si ésta no es null
		$this->db->set('CORREO_COND', $conductor['CORREO_COND']);
		$this->db->set('DIRECCION_COND', $conductor['DIRECCION_COND']);
		$this->db->set('TELEFONO_COND', $conductor['TELEFONO_COND']);
		$this->db->set('ESTADO_COND', $conductor['ESTADO_COND']);
		$this->db->where('ID_COND', $conductor['ID_COND']);
		$this->db->update('tbl_conductor');

		if ($this->db->affected_rows() === 1) {
			return true;
		} else {
			return false;
		}
	}

	public function getInactiveDrivers()
	{
		$this->db->where('ESTADO_COND', 0);
		$query = $this->db->get('tbl_conductor');
		return $query->result();
	}


	public function updateDriverToActive($id_cond)
	{
		$this->db->set('ESTADO_COND', 1);
		$this->db->where('ID_COND', $id_cond);
		return $this->db->update('tbl_conductor');
	}
}//end class
