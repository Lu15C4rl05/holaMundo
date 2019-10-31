<?php
class Bus_model extends CI_Model
{
    public function __construct()
    { }

    public function getAllBus()
    {
        $this->db->where('ESTADO_BUS', 1);
        $query = $this->db->get('view_bus');
        return $query->result();
    }


    public function getBusById($id_bus,$estado_bus)
    {
        $this->db->where('ESTADO_BUS', $estado_bus);
        $this->db->where('ID_BUS', $id_bus);
        $query = $this->db->get('view_bus');
        return $query->result();
    }

    public function saveBus($bus)
    {
        $this->db->insert('tbl_bus', $bus);
        if ($this->db->affected_rows() == 1)
            return true;
        return false;
    }
    //bus ya existe de acuerdo al numeroe de bus de una cooperativa dada
    public function busExists($bus)
    {
        $this->db->where('ID_EMPRESA', $bus['id_empresa']);
        $this->db->where('NUMERO_BUS', $bus['numero_bus']);
        $query = $this->db->get('tbl_bus');
        if ($query->num_rows() == 1)
            return true;
        return false;
    }


    public function updateBus($bus)
    {
        $this->db->set('ID_COND', $bus['id_cond']);
        $this->db->set('NUMERO_BUS', $bus['numero_bus']);
        $this->db->set('ASIENTOS_BUS', $bus['asientos_bus']);
        $this->db->set('DOS_PISOS_BUS', $bus['dos_pisos_bus']);
        $this->db->where('ID_BUS', $bus['id_bus']);
        return $this->db->update('tbl_bus');
    }



    public function deleteBus($id_bus)
	{
		$this->db->set('ESTADO_BUS', 0);
		$this->db->where('ID_BUS', $id_bus);
		return $this->db->update('tbl_bus');
    }
    

    public function getInactiveBuses()
	{
		$this->db->where('ESTADO_BUS', 0);
		$query = $this->db->get('view_bus');
		return $query->result();
	}


	public function updateBusToActive($id_bus)
	{
		$this->db->set('ESTADO_BUS', 1);
		$this->db->where('ID_BUS', $id_bus);
		return $this->db->update('tbl_bus');
	}


}//end class
