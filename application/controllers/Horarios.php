<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class Horarios extends REST_Controller
{

    public function __construct()
	{
		parent::__construct();
		$this->load->model('horarios_model');
    }
    
    public function index_get()
	{
		$rutas = $this->horarios_model->get();

		if (!is_null($rutas)) {
			$this->response($rutas, 200);
		} else {
			$this->response(array('error' => 'No existen horarios en la base de datos'), 200);
		}
	}

}//end class