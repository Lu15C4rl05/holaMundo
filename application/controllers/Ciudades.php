<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class Ciudades extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('ciudades_model');
	}

	public function index_get(){
		$ciudades = $this->ciudades_model->get();

		if (!is_null($ciudades)) {
			$this->response(array('response' => $ciudades), 200);
		} else {
			$this->response(array('error' => 'No existen ciudades en la base de datos'), 404);
		}
	}
}