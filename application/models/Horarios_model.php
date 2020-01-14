<?php
class Horarios_model extends CI_model
{
    public function __construct()
    {
    }


    public function get()
    {
        $query = $this->db->query('select h.*,DATE_FORMAT(h.HORA_SALIDA,"%H:%i") HORA from tbl_horario h');
        return $query->result();
    }
}//end class
