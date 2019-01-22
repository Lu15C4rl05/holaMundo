<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class Usuarios extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('usuarios_model');
	}

	public function index_get(){
		$usuarios = $this->usuarios_model->get();

		if (!is_null($usuarios)) {
			$this->response(array('response' => $usuarios), 200);
		} else {
			$this->response(array('error' => 'No existen usuarios en la base de datos'), 200);
		}
	}

	public function find_get($id){
		if(!$id){
			$this->response(null, 200);
		}

		$usuario = $this->usuarios_model->get($id);

		if(!is_null($usuario)){
			$this->response(array('response' => $usuario), 200);
		} else {
			$this->response(array('error' => 'Usuario no encontrado'), 200);
		}
	}

	public function index_post(){
		$usuario = array();
		$usuario['ID_USU'] = $this->post('ID_USU');
		$usuario['CEDULA_USU'] = $this->post('CEDULA_USU');
		$usuario['ID_CIUDAD'] = $this->post('ID_CIUDAD');
		$usuario['NOMBRE_USU'] = $this->post('NOMBRE_USU');
		$usuario['APELLIDO_USU'] = $this->post('APELLIDO_USU');
		$usuario['CORREO_USU'] = $this->post('CORREO_USU');
		$usuario['PASSWORD'] = $this->post('PASSWORD');
		$usuario['FECHA_CREACION_USU'] = $this->post('FECHA_CREACION_USU');
		$isinserted = $this->usuarios_model->save($usuario);
		if($isinserted===false){
				$this->response("Por favor intentelo de nuevo.", REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => TRUE,
				'message' => 'Ingreso satisfactorio.'
			], REST_Controller::HTTP_OK);
		}
	}

	public function existe_post(){
		$usuario = array();
		$usuario['CORREO_USU'] = $this->post('CORREO_USU');
		$usuario['PASSWORD'] = $this->post('PASSWORD');
		if ($usuario['PASSWORD'] != null){
			$existeUsuario = $this->usuarios_model->existeUsuario($usuario);
			if($existeUsuario){
				$this->response([
					'mensaje' => 'Usuario y contraseña válidos.',
					'response' => $existeUsuario
				], REST_Controller::HTTP_OK);
			} else {
				$this->response([
					'mensaje' => 'Usuario o contraseña incorrectos.'
				], REST_Controller::HTTP_OK);
			}
		} else {
			$existeUsuario = $this->usuarios_model->existeUsuario($usuario);
			if($existeUsuario){
				$this->response([
					'mensaje' => 'El correo ingresado ya está registrado.',
					'codver' => array($existeUsuario)
				], REST_Controller::HTTP_OK);
			} else {
				$CODVER_USU=null;
				for ($i=0; $i < 4; $i++) { 
					$CODVER_USU .= rand(0,9);
				}
				$this->response([
					'mensaje' => 'El correo ingresado no está registrado.',
					'codver' => $CODVER_USU
				], REST_Controller::HTTP_OK);
			}
		}
	}

	public function update_post(){
		$usuario = array();
		$usuario['ID_USU'] = $this->post('ID_USU');
		$usuario['CORREO_USU'] = $this->post('CORREO_USU');
		$usuario['CEDULA_USU'] = $this->post('CEDULA_USU');
		$usuario['NOMBRE_USU'] = $this->post('NOMBRE_USU');
		$usuario['APELLIDO_USU'] = $this->post('APELLIDO_USU');
		$usuario['PASSWORD'] = $this->post('PASSWORD');
		$result = $this->usuarios_model->actualizarUsuario($usuario);
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
