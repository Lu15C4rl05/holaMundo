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
			$this->response(array('error' => 'No existen rutas en la base de datos'), 200);
		}
	}

	public function find_get($ciudad_in,$ciudad_out){
		if(!$ciudad_in || !$ciudad_out){
			$this->response(array('error' => 'Ruta no encontrada'), 200);
		}

		$ruta = $this->rutas_model->get($ciudad_in,$ciudad_out);

		if(!is_null($ruta)){
			$this->response(array('response' => $ruta), 200);
		} else {
			$this->response(array('error' => 'Ruta no encontrada'), 200);
		}
	}

	public function findD_get($ciudad_in){
		if(!$ciudad_in){
			$this->response(array('error' => 'No existen destinos'), 200);
		}

		$ruta = $this->rutas_model->get($ciudad_in);

		if(!is_null($ruta)){
			$this->response(array('response' => $ruta), 200);
		} else {
			$this->response(array('error' => 'Ruta no encontrada'), 200);
		}
	}

	public function findh_get($ciudad_in,$ciudad_out,$fecha){
		if(!$ciudad_in || !$ciudad_out || !$fecha){
			$this->response(array('error' => 'Horario no encontrado'), 200);
		}

		$ruta = $this->rutas_model->get($ciudad_in,$ciudad_out,$fecha);

		if(!is_null($ruta)){
			$this->response(array('response' => $ruta), 200);
		} else {
			$this->response(array('error' => 'Ruta no encontrada'), 200);
		}
	}

	public function findimg_get(){
		$ruta = $this->rutas_model->getimg();

		if(!is_null($ruta)){
			$this->response(array('response' => $ruta), 200);
		} else {
			$this->response(array('error' => 'Ruta no encontrado'), 200);
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
				$this->response("Por favor intentelo de nuevo.", REST_Controller::HTTP_OK);
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
			$this->response("Por favor intentelo de nuevo.", REST_Controller::HTTP_OK);
		}
	}

	public function index_delete($id){
		if(!$id){
			$this->response(null, 200);
		}
		
		$delete = $this->rutas_model->delete($id);

		if(!is_null($delete)){
			$this->response(array('response' => 'Ruta eliminada correctamente.'), 200);
		} else {
			$this->response(array('error' => 'Algo ha fallado en el servidor. Acción no procesada'), 200);
		}
	}
}
