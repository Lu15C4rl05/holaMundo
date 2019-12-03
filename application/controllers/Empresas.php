<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class Empresas extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('empresas_model');
	}

	public function index_get()
	{
		$empresas = $this->empresas_model->get();

		if (!is_null($empresas)) {
			$this->response(array($empresas,'status' => 200),200);
		} else {
			$this->response(array('error' => 'No existen cooperativas de transporte registradas en la base de datos','status' => 400), 200);
		}
	}

	public function find_get($id)
	{
		if (!$id) {
			$this->response(null, 200);
		}

		$empresa = $this->empresas_model->get($id);

		if (!is_null($empresa)) {
			$this->response(array('response' => $empresa, 'status' => 200), 200);
		} else {
			$this->response(array('error' => 'Coop. de transporte no encontrada', 'status' => 400), 200);
		}
	}

	public function index_post()
	{
		$empresa = array();
		$empresa['NOMBRE_EMPRESA'] = $this->post('NOMBRE_EMPRESA');
		$isinserted = $this->empresas_model->save($empresa);
		if ($isinserted === false) {
			$this->response(array('error' => 'Por favor intentelo de nuevo.','status' => 400), 200);
		} else {
			$this->response([
				'status' => 200,
				'message' => 'Ingreso satisfactorio.'
			], REST_Controller::HTTP_OK);
		}
	}

	public function update_post()
	{
		$empresa = array();
		$empresa['ID_EMPRESA'] = $this->post('ID_EMPRESA');
		$empresa['NOMBRE_EMPRESA'] = $this->post('NOMBRE_EMPRESA');
		$result = $this->empresas_model->update($empresa);
		if ($result) {
			$this->response(array('message' => 'Actualización de empresa correcta.','status' => 200), 200);
		} else {
			$this->response(array('error' => 'La empresa no se actualizó.', 'status' => 400), 200);
		}
	}
}//end class
