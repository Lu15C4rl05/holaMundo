<?php
class Buses_model extends CI_Model
{
    public function __construct()
    { }

    public function get($id = null)
    {
        if (!is_null($id)) {
            $query = $this->db->query('select * from view_bus where ID_BUS= "'. $id .'"');
            if ($query->num_rows() === 1) {
                return $query->row_array();
            }
            return null;
        }

        $query = $this->db->query("select * from view_bus where ESTADO_BUS=1");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
        // $this->db->where('ESTADO_BUS', 1);
        // $query = $this->db->get('view_bus');
        // return $query->result();
    }

    public function save($bus = array())
    {
        $this->db->insert('tbl_bus', $bus);
        if ($this->db->affected_rows() == 1)
            return true;
        return false;
    }

    //Determina si el número de un bus, ya fue ingresado anteriormente en la cooperativa.
    public function busExists($bus)
    {
        $this->db->where('ID_EMPRESA', $bus['ID_EMPRESA']);
        $this->db->where('NUMERO_BUS', $bus['NUMERO_BUS']);
        $query = $this->db->get('tbl_bus');
        if ($query->num_rows() == 1)
            return true;
        return false;
    }

    //Actualiza los campos de un bus a partir de su ID
    public function update($bus)
    {
        $query = $this->db->query('update tbl_bus set 
            ID_COND = "'.$bus['ID_COND'].'", NUMERO_BUS = "'.$bus['NUMERO_BUS'].'", ASIENTOS_BUS = "'.$bus['ASIENTOS_BUS'].'", DOS_PISOS_BUS = "'.$bus['DOS_PISOS_BUS'].'"
            where ID_BUS = "'.$bus['ID_BUS'].'"');
        if($this->db->affected_rows() === 1)
            return true;
        return false;
    }

    //Cambia el estado del bus a inactivo
    public function inactivarBus($id_bus)
	{
		$this->db->set('ESTADO_BUS', 0);
		$this->db->where('ID_BUS', $id_bus);
		return $this->db->update('tbl_bus');
    }

    //Cambia el estado del bus a activo
    public function activarBus($id_bus)
    {
        $this->db->set('ESTADO_BUS', 1);
        $this->db->where('ID_BUS', $id_bus);
        return $this->db->update('tbl_bus');
    }

    //Obtiene los buses inactivos
    public function getInactiveBuses()
	{
		$this->db->where('ESTADO_BUS', 0);
		$query = $this->db->get('view_bus');
		return $query->result();
	}

}//end class
