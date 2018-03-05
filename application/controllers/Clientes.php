<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class Clientes extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('clientes_model');
	}

	public function index_get(){
		$clientes = $this->clientes_model->get();

		if (!is_null($clientes)) {
			$this->response(array('response' => $clientes), 200);
		} else {
			$this->response(array('error' => 'No existen clientes en la base de datos'), 404);
		}
		//$this->load->view('insertar');
	}

	public function find_get($id){
		if(!$id){
			$this->response(null, 400);
		}

		$cliente = $this->clientes_model->get($id);

		if(!is_null($cliente)){
			$this->response(array('response' => $cliente), 200);
		} else {
			$this->response(array('error' => 'Cliente no encontrado'), 404);
		}
	}

	public function index_post(){
		if (!$this->post('cliente')) {
			$this->response(null, 400);
		}

		$id = $this->clientes_model->save($this->post('cliente'));
		if (!is_null($id)) {
			$this->response(array('response' => $id), 200);
		} else {
			$this->response(array('error' => 'Algo ha fallado en el servidor. Acción no procesada'), 400);
		}
	}

	public function index_put(){
		if(!$this->put('cliente') || $id){
			$this->response(null, 400);
		}

		$update = $this->clientes_model->update($id, $this->put('cliente'));

		if(!is_null($update)){
			$this->response(array('response' => 'Cliente editado correctamente.'), 200);
		} else {
			$this->response(array('error' => 'Algo ha fallado en el servidor. Acción no procesada'), 400);
		}
	}

	public function index_delete($id){
		if(!$id){
			$this->response(null, 400);
		}
		
		$delete = $this->clientes_model->delete($id);

		if(!is_null($delete)){
			$this->response(array('response' => 'Cliente eliminado correctamente.'), 200);
		} else {
			$this->response(array('error' => 'Algo ha fallado en el servidor. Acción no procesada'), 400);
		}
	}
}