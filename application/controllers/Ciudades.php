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
			$this->response(array($ciudades, 'status' => 200), 200);
		} else {
			$this->response(array('error' => 'No existen ciudades en la base de datos', 'status' => 400), 200);
		}
	}

	//Método que devuelve un registro de las ciudades, mediante su ID
	public function find_get($id){
		if(!$id){
			$this->response(array('error' => 'null', 400), 200);
		}

		$ciudad = $this->ciudades_model->get($id);

		if(!is_null($ciudad)){
			$this->response(array($ciudad, 'status' => 200), 200);
		} else {
			$this->response(array('error' => 'Ciudad no encontrada', 'status' => 400), 200);
		}
	}

	//Método de inserción de una ciudad
	public function index_post(){
		$ciudad = array();
		$ciudad['NOMBRE_CIUDAD'] = $this->post('NOMBRE_CIUDAD');
		$isinserted = $this->ciudades_model->save($ciudad);
		if($isinserted===false){
			$this->response(array(
				'status' => 400,
				'message' => 'No se inserto ningun dato, revise los parámetros.', 'status' => 400
			), 200);
		} else {
			$this->response(array(
				'status' => 200,
				'message' => 'Ingreso satisfactorio.'
			), 200);
		}
	}

	//Método de actualización de un conductor
	public function update_post(){
		$ciudad = array();
		$ciudad['ID_CIUDAD'] = $this->post('ID_CIUDAD');
		$ciudad['NOMBRE_CIUDAD'] = $this->post('NOMBRE_CIUDAD');
		$result = $this->ciudades_model->actualizarCiudad($ciudad);
        if($result){
            $this->response(array(
            	'status' => 200,
				'message' => 'Actualización de ciudad correcta.'
			), 200);
        }
        else {
            $this->response(array(
            	'status' => 400,
				'message' => 'La ciudad no se actualizó.'
			), 200);
        }
	}

}
