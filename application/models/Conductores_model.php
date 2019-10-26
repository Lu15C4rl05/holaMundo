<?php
class Conductores_model extends CI_Model
{
	public function __construct()
	{ }

	public function get($id = null)
	{
		if (!is_null($id)) {
			$query = $this->db->select('*')->from('tbl_conductor')->where('ID_COND', $id)->get();
			if ($query->num_rows() === 1) {
				return $query->row_array();
			}
			return null;
		}

		$query = $this->db->query("select * from tbl_conductor where ESTADO_COND=1");

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
		$query = $this->db->query('update tbl_conductor set
			FOTO_COND = "' . $conductor['FOTO_COND'] . '", CORREO_COND = "' . $conductor['CORREO_COND'] . '", DIRECCION_COND = "' . $conductor['DIRECCION_COND'] . '", TELEFONO_COND = "' . $conductor['TELEFONO_COND'] . '", ESTADO_COND = "' . $conductor['ESTADO_COND'] . '"
			where ID_COND = "' . $conductor['ID_COND'] . '"');

		$query = $this->db->update('tbl_conductor');
		if ($this->db->affected_rows() === 1) {
			return true;
		} else {
			return false;
		}
	}
}
