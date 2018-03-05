<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class Ciudad extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('ciudad_model');
	}

	public function index_get(){
		$ciudad = $this->ciudad_model->get();

		if (!is_null($ciudad)) {
			$this->response(array('response' => $ciudad), 200);
		} else {
			$this->response(array('error' => 'No existen pasajeros en la base de datos'), 404);
		}
	}



	public function find_get($id){
		if(!$id){
			$this->response(null, 400);
		}

		$pasajero = $this->pasajeros_model->get($id);

		if(!is_null($pasajero)){
			$this->response(array('response' => $pasajero), 200);
		} else {
			$this->response(array('error' => 'Pasajero no encontrado'), 404);
		}
	}

	public function index_post(){
		if ($this->post('pasajero')) {
			$this->response(null, 400);
		}

		$id = $this->pasajeros_model->save($this->post('pasajero'));
		if (!is_null($id)) {
			$this->response(array('response' => $id), 200);
		} else {
			$this->response(array('error' => 'Algo ha fallado en el servidor. Acción no procesada'), 400);
		}
	}

	public function index_put(){
		if(!$this->put('pasajero') || $id){
			$this->response(null, 400);
		}

		$update = $this->pasajeros_model->update($id, $this->put('pasajero'));

		if(!is_null($update)){
			$this->response(array('response' => 'Pasajero editado correctamente.'), 200);
		} else {
			$this->response(array('error' => 'Algo ha fallado en el servidor. Acción no procesada'), 400);
		}
	}

	public function index_delete($id){
		if(!$id){
			$this->response(null, 400);
		}
		
		$delete = $this->pasajeros_model->delete($id);

		if(!is_null($delete)){
			$this->response(array('response' => 'Pasajero eliminado correctamente.'), 200);
		} else {
			$this->response(array('error' => 'Algo ha fallado en el servidor. Acción no procesada'), 400);
		}
	}
}
