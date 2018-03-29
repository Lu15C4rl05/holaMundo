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
		} else {
			$this->response(array('error' => 'No existen rutas en la base de datos'), 404);
		}
	}

	public function find_get($ciudad_in,$ciudad_out){
		if(!$ciudad_in || !$ciudad_out){
			$this->response(array('error' => 'Ruta no encontrada'), 400);
		}

		$ruta = $this->rutas_model->get($ciudad_in,$ciudad_out);

		if(!is_null($ruta)){
			$this->response(array('response' => $ruta), 200);
		} else {
			$this->response(array('error' => 'Ruta no encontrada'), 404);
		}
	}

	public function findimg_get(){
		$ruta = $this->rutas_model->getimg();

		if(!is_null($ruta)){
			$this->response(array('response' => $ruta), 200);
		} else {
			$this->response(array('error' => 'Ruta no encontrado'), 404);
		}
	}

	public function index_post(){
		$Data = array();
		$Data['ID_RUTA'] = $this->post('ID_RUTA');
		$Data['ID_CIUDAD_INICIO'] = $this->post('ID_CIUDAD_INICIO');
		$Data['ID_CIUDAD_DESTINO'] = $this->post('ID_CIUDAD_DESTINO');
		$Data['ID_HORARIO'] = $this->post('ID_HORARIO');
		$Data['COSTO_RUTA'] = $this->post('COSTO_RUTA');
		$insert = $this->rutas_model->save($Data);
		if($insert===false){
				$this->response("Por favor intentelo de nuevo.", REST_Controller::HTTP_BAD_REQUEST);
		} else {
			$this->response([
				'status' => TRUE,
				'message' => 'Ingreso satisfactorio.'
			], REST_Controller::HTTP_OK);
		}
	}

	public function index2_post(){
		$id = $this->post('ID_RUTA');
		$Data = array();
		$Data['ID_CIUDAD_INICIO'] = $this->post('ID_CIUDAD_INICIO');
		$Data['ID_CIUDAD_DESTINO'] = $this->post('ID_CIUDAD_DESTINO');
		$Data['ID_HORARIO'] = $this->post('ID_HORARIO');
		$Data['COSTO_RUTA'] = $this->post('COSTO_RUTA');
		$update = $this->rutas_model->updat($Data);
		if($update){
			$this->response([
				'status' => TRUE,
				'message' => 'Actualizacion satisfactoria.'
			], REST_Controller::HTTP_OK);
		}else{
			$this->response("Por favor intentelo de nuevo.", REST_Controller::HTTP_BAD_REQUEST);
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