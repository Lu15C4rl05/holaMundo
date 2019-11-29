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

    public function save($bus)
    {
        $this->db->query('insert into tbl_bus (ID_COND,NUMERO_BUS,ASIENTOS_BUS,DOS_PISOS_BUS) values ('.$bus['ID_COND'].','.$bus['NUMERO_BUS'].','.$bus['ASIENTOS_BUS'].','.$bus['DOS_PISOS_BUS'].')');
        if ($this->db->affected_rows() == 1)
            return true;
        return false;
    }

    //Determina si el número de un bus, ya fue ingresado anteriormente en la cooperativa.
    public function busExists($bus)
    {
        $query = $this->db->query('select * from tbl_bus b inner join tbl_conductor c on b.ID_COND=c.ID_COND 
            where b.NUMERO_BUS='.$bus['NUMERO_BUS'].' and c.ID_EMPRESA='.$bus['ID_EMPRESA']);
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

    //Obtiene la cooperativa de transporte a la que pertenece un conductor
    public function getCoopFromCond($id_cond){
        $query = $this->db->query('select ID_EMPRESA from tbl_conductor where ID_COND='.$id_cond);
        $row = $query->row_array();
        return $row['ID_EMPRESA'];
    }

}//end class
