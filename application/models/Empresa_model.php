<?php
class Empresa_model extends CI_Model
{
    public function __construct()
    { }

    public function getAllEmpresa(){
        return ($this->db->get('tbl_empresa'))->result();
    }
}//end class
