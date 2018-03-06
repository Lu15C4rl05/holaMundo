<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class Rutas extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('rutas_model');
	}

	public function index_get(){
		$rutas = $this->rutas_model->get();

		if (!is_null($rutas)) {
			$this->response(array('response' => $rutas), 200);
			$this->load->view('insertar');
		} else {
			$this->response(array('error' => 'No existen rutas en la base de datos'), 404);
		}
		//$this->load->view('insertar');
	}

	public function find_get($id){
		if(!$id){
			$this->response(null, 400);
		}

		$ruta = $this->rutas_model->get($id);

		if(!is_null($ruta)){
			$this->response(array('response' => $ruta), 200);
		} else {
			$this->response(array('error' => 'Ruta no encontrado'), 404);
		}
	}

	public function index_post(){
		if (!$this->post('ruta')) {
			$this->response(null, 400);
		}

		$id = $this->rutas_model->save($this->post('ruta'));
		if (!is_null($id)) {
			$this->response(array('response' => $id), 200);
		} else {
			$this->response(array('error' => 'Algo ha fallado en el servidor. Acción no procesada'), 400);
		}
	}

	public function index_put(){
		if(!$this->put('ruta') || $id){
			$this->response(null, 400);
		}

		$update = $this->rutas_model->update($id, $this->put('ruta'));

		if(!is_null($update)){
			$this->response(array('response' => 'Ruta editada correctamente.'), 200);
		} else {
			$this->response(array('error' => 'Algo ha fallado en el servidor. Acción no procesada'), 400);
		}
	}

	public function index_delete($id){
		if(!$id){
			$this->response(null, 400);
		}
		
		$delete = $this->rutas_model->delete($id);

		if(!is_null($delete)){
			$this->response(array('response' => 'Ruta eliminada correctamente.'), 200);
		} else {
			$this->response(array('error' => 'Algo ha fallado en el servidor. Acción no procesada'), 400);
		}
	}
}