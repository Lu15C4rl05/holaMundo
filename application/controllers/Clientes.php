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
		$cliente = array();
		$cliente['ID_CLI'] = $this->post('ID_CLI');
		$cliente['CEDULA_CLI'] = $this->post('CEDULA_CLI');
		$cliente['ID_CIUDAD'] = $this->post('ID_CIUDAD');
		$cliente['NOMBRE_CLI'] = $this->post('NOMBRE_CLI');
		$cliente['APELLIDO_CLI'] = $this->post('APELLIDO_CLI');
		$cliente['CORREO_CLI'] = $this->post('CORREO_CLI');
		$cliente['PASSWORD'] = $this->post('PASSWORD');
		$isinserted = $this->clientes_model->save($cliente);
		if($isinserted===false){
				$this->response("Por favor intentelo de nuevo.", REST_Controller::HTTP_BAD_REQUEST);
		} else {
			$this->response([
				'status' => TRUE,
				'message' => 'Ingreso satisfactorio.'
			], REST_Controller::HTTP_OK);
		}
	}
	
	public function existe_post(){
		$usuario = array();
		$usuario['CORREO_CLI'] = $this->post('CORREO_CLI');
		$usuario['PASSWORD'] = $this->post('PASSWORD');
		if ($usuario['PASSWORD'] != null){
			$existeUsuario = $this->clientes_model->existeUsuario($usuario);
			if($existeUsuario){
				$this->response([
					'mensaje' => 'Usuario y contraseña válidos.',
					'response' => $existeUsuario
				], REST_Controller::HTTP_OK);
			} else {
				$this->response([
					'mensaje' => 'Usuario o contraseña incorrectos.'
				], REST_Controller::HTTP_BAD_REQUEST);
			}
		} else {
			$existeUsuario = $this->clientes_model->existeUsuario($usuario);
			if($existeUsuario){
				$this->response([
					'mensaje' => 'El correo ingresado ya está registrado.',
					'codver' => array($existeUsuario)
				], REST_Controller::HTTP_OK);
			} else {
				$this->response([
					'mensaje' => 'El correo ingresado no está registrado.'
				], REST_Controller::HTTP_BAD_REQUEST);
			}
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
