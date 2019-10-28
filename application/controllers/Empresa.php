<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class Empresa extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('empresa_model');
    }

    
    public function all_get()
    {
        return $this->response($this->empresa_model->getAllEmpresa());
    }




}//end class
