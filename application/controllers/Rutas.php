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

	public function findD_post(){
		$ciudad_in = $this->post('CIUDAD_IN');
		if(!$ciudad_in){
			$this->response(array('error' => 'El parámetro es vacío', 'status' => 400), 200);
		}

		$ruta = $this->rutas_model->get($ciudad_in);

		if(!is_null($ruta)){
			$this->response(array('response' => $ruta, 'status' => 200), 200);
		} else {
			$this->response(array('error' => 'Ruta no encontrada', 'status' => 400), 200);
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
			$this->response(array('error' => 'Aún no se han vendido boletos.'), 200);
		}
	}

	//Método de inserción de una ruta
	public function index_post(){
		$Data = array();
		$Data['ID_BUS'] = $this->post('ID_BUS');
		$Data['ID_CIUDAD_INICIO'] = $this->post('ID_CIUDAD_INICIO');
		$Data['ID_CIUDAD_DESTINO'] = $this->post('ID_CIUDAD_DESTINO');
		$Data['ID_IMG'] = $this->rutas_model->getIdImg($Data['ID_CIUDAD_DESTINO']);
		$Data['ID_HORARIO'] = $this->rutas_model->getIdHor($this->post('ID_HORARIO'));
		$Data['COSTO_RUTA'] = $this->post('COSTO_RUTA');
		// $Data['COSTO_RUTA'] = $this->rutas_model->asignarCosto($Data['ID_CIUDAD_INICIO'],$Data['ID_CIUDAD_DESTINO']);
		$insert = $this->rutas_model->save($Data);
		if($insert===false){
			$this->response(array('error','La ruta no se insertó. Revise los parámetros e intente de nuevo.','status' => 400), 200);
		} else {
			$this->response(array('message' => 'Ingreso satisfactorio.','status' => 200), 200);
		}
	}

	//Método de actualización de una ruta
	public function update_post(){
		$Data = array();
		$Data['ID_RUTA'] = $this->post('ID_RUTA');
		$Data['ID_BUS'] = $this->post('ID_BUS');
		$Data['ID_CIUDAD_INICIO'] = $this->post('ID_CIUDAD_INICIO');
		$Data['ID_CIUDAD_DESTINO'] = $this->post('ID_CIUDAD_DESTINO');
		$Data['ID_IMG'] = $this->rutas_model->getIdImg($Data['ID_CIUDAD_DESTINO']);
		$Data['ID_HORARIO'] = $this->rutas_model->getIdHor($this->post('ID_HORARIO'));
		$Data['COSTO_RUTA'] = $this->post('COSTO_RUTA');
		// $Data['COSTO_RUTA'] = $this->rutas_model->asignarCosto($Data['ID_CIUDAD_INICIO'],$Data['ID_CIUDAD_DESTINO']);
		$update = $this->rutas_model->update($Data);
		if($update){
			$this->response(array('message' => 'Actualizacion satisfactoria.','status' => 200), 200);
		}else{
			$this->response(array('error' => 'La ruta no se actualizó. Revise los parámetros e intente de nuevo.','status' => 400), 200);
		}
	}

	//Método que obtiene las ciudades origen de todas las rutas
	public function ciudadesOrigen_get(){
		$ciudades = $this->rutas_model->getCiudadesOrigen();

		if (!is_null($ciudades)) {
			$this->response(array('response' => $ciudades), 200);
		} else {
			$this->response(array('error' => 'No existen ciudades de origen, cree una ruta.'), 200);
		}
	}

}
