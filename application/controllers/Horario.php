<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class Horario extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('horario_model');
	}

	public function index_get(){
		$horario = $this->horario_model->get();

		if (!is_null($horario)) {
			$this->response(array('response' => $horario), 200);
		} else {
			$this->response(array('error' => 'No existen horarios en la base de datos'), 404);
		}
	}

	public function find_get($id){
		if(!$id){
			$this->response(null, 400);
		}

		$horario = $this->horario_model->get($id);

		if(!is_null($horario)){
			$this->response(array('response' => $horario), 200);
		} else {
			$this->response(array('error' => 'Pasajero no encontrado'), 404);
		}
	}

	public function index_post(){
		if ($this->post('horario')) {
			$this->response(null, 400);
		}

		$id = $this->horario_model->save($this->post('horario'));
		if (!is_null($id)) {
			$this->response(array('response' => $id), 200);
		} else {
			$this->response(array('error' => 'Algo ha fallado en el servidor. Acción no procesada'), 400);
		}
	}

	public function index_put(){
		if(!$this->put('horario') || $id){
			$this->response(null, 400);
		}

		$update = $this->horario_model->update($id, $this->put('horario'));

		if(!is_null($update)){
			$this->response(array('response' => 'Horario editado correctamente.'), 200);
		} else {
			$this->response(array('error' => 'Algo ha fallado en el servidor. Acción no procesada'), 400);
		}
	}

	public function index_delete($id){
		if(!$id){
			$this->response(null, 400);
		}
		
		$delete = $this->horario_model->delete($id);

		if(!is_null($delete)){
			$this->response(array('response' => 'Horario eliminado correctamente.'), 200);
		} else {
			$this->response(array('error' => 'Algo ha fallado en el servidor. Acción no procesada'), 400);
		}
	}
}