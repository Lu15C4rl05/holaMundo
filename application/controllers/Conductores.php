<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class Conductores extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('conductores_model');
	}

	//Método que devuelve todos los registros de los conductores, si es que existen
	public function index_get(){
		$conductores = $this->conductores_model->get();

		if (!is_null($usuarios)) {
			$this->response(array('response' => $usuarios), 200);
		} else {
			$this->response(array('error' => 'No existen conductores en la base de datos'), 200);
		}
	}

	//Método que devuelve un registro de los conductor, mediante su ID
	public function find_get($id){
		if(!$id){
			$this->response(null, 200);
		}

		$conductor = $this->conductores_model->get($id);

		if(!is_null($conductor)){
			$this->response(array('response' => $conductor), 200);
		} else {
			$this->response(array('error' => 'Conductor no encontrado'), 200);
		}
	}

	//Método de inserción de un conductor
	public function index_post(){
		$conductor = array();
		$conductor['ID_COND'] = $this->post('ID_COND');
		$conductor['ID_EMPRESA'] = $this->post('ID_EMPRESA');
		$conductor['CEDULA_COND'] = $this->post('CEDULA_COND');
		$conductor['NOMBRE_COND'] = $this->post('NOMBRE_COND');
		$conductor['APELLIDO_COND'] = $this->post('APELLIDO_COND');
		$conductor['FOTO_COND'] = $this->post('FOTO_COND');
		$conductor['CORREO_COND'] = $this->post('CORREO_COND');
		$conductor['DIRECCION_COND'] = $this->post('DIRECCION_COND');
		$conductor['TELEFONO_COND'] = $this->post('TELEFONO_COND');
		$conductor['ESTADO_COND'] = $this->post('ESTADO_COND');
		$isinserted = $this->conductores_model->save($conductor);
		if($isinserted===false){
				$this->response("Por favor intentelo de nuevo.", REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => TRUE,
				'message' => 'Ingreso satisfactorio.'
			], REST_Controller::HTTP_OK);
		}
	}

	public function update_post(){
		$conductor = array();
		$conductor['FOTO_COND'] = $this->post('FOTO_COND');
		$conductor['CORREO_COND'] = $this->post('CORREO_COND');
		$conductor['DIRECCION_COND'] = $this->post('DIRECCION_COND');
		$conductor['TELEFONO_COND'] = $this->post('TELEFONO_COND');
		$conductor['ESTADO_COND'] = $this->post('ESTADO_COND');
		$result = $this->conductores_model->actualizarConductor($conductor);
        if($result){
            $this->response([
					'mensaje' => 'Actualización de usuario correcta.'
				], REST_Controller::HTTP_OK);
        }
        else {
            $this->response([
					'mensaje' => 'El usuario no se actualizó.'
				], REST_Controller::HTTP_OK);
        }
	}

}
