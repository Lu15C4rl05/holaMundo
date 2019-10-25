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
			$this->response(array('error' => 'No existen ciudades en la base de datos'), 200);
		}
	}

	//Método que devuelve un registro de las ciudades, mediante su ID
	public function find_get($id){
		if(!$id){
			$this->response(null, 200);
		}

		$ciudad = $this->ciudades_model->get($id);

		if(!is_null($ciudad)){
			$this->response(array('response' => $ciudad), 200);
		} else {
			$this->response(array('error' => 'Ciudad no encontrada'), 200);
		}
	}

	//Método de inserción de una ciudad
	public function index_post(){
		$ciudad = array();
		$ciudad['NOMBRE_CIUDAD'] = $this->post('NOMBRE_CIUDAD');
		$isinserted = $this->ciudades_model->save($ciudad);
		if($isinserted===false){
			$this->response([
				'status' => FALSE,
				'mensaje' => 'No se inserto ningun dato, revise los parámetros.'
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => TRUE,
				'mensaje' => 'Ingreso satisfactorio.'
			], REST_Controller::HTTP_OK);
		}
	}

	//Método de actualización de un conductor
	public function update_post(){
		$ciudad = array();
		$ciudad['ID_CIUDAD'] = $this->post('ID_CIUDAD');
		$ciudad['NOMBRE_CIUDAD'] = $this->post('NOMBRE_CIUDAD');
		$result = $this->ciudades_model->actualizarCiudad($ciudad);
        if($result){
            $this->response([
            	'status' => TRUE,
				'mensaje' => 'Actualización de ciudad correcta.'
			], REST_Controller::HTTP_OK);
        }
        else {
            $this->response([
            	'status' => FALSE,
				'mensaje' => 'La ciudad no se actualizó.'
			], REST_Controller::HTTP_OK);
        }
	}

}
