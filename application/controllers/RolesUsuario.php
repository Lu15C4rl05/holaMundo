<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class RolesUsuario extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('rolesusuario_model');
	}

	//Método que devuelve que roles tiene un usuario en específico, mediante su ID
	public function find_get($id){
		$roles = $this->rolesusuario_model->get($id);

		if(!is_null($roles)){
			$this->response(array('response' => $roles), 200);
		} else {
			$this->response(array('response' => 'El usuario no tiene asignado ningun rol'), 200);
		}
	}

	//Método para agregar un rol al usuario
	public function index_post(){
		$rol_usuario = array();
		$rol_usuario['ID_USU'] = $this->post('ID_USU');
		$rol_usuario['ID_ROL'] = $this->post('ID_ROL');
		$isinserted = $this->rolesusuario_model->save($rol_usuario);
		if($isinserted===false){
			$this->response([
				'status' => FALSE,
				'mensaje' => 'No se vinculo ningun rol al usuario.'
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => TRUE,
				'mensaje' => 'Ingreso satisfactorio.'
			], REST_Controller::HTTP_OK);
		}
	}

	//Método para eliminar el rol de un usuario
	public function delete_post(){
		$rol_usuario = array();
		$rol_usuario['ID_USU'] = $this->post('ID_USU');
		$rol_usuario['ID_ROL'] = $this->post('ID_ROL');
		$isdeleted = $this->rolesusuario_model->delete($rol_usuario);
		if($isdeleted===false){
			$this->response([
				'status' => FALSE,
				'mensaje' => 'No se eliminó ningun rol al usuario.'
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => TRUE,
				'mensaje' => 'Se eliminó el rol del usuario.'
			], REST_Controller::HTTP_OK);
		}
	}

	//Método de actualización de un rol de usuario
	public function update_post(){
		$rol_usuario = array();
		$rol_usuario['ID_ROL_USUARIO'] = $this->post('ID_ROL_USUARIO');
		$rol_usuario['ID_USU'] = $this->post('ID_USU');
		$rol_usuario['ID_ROL'] = $this->post('ID_ROL');
		$result = $this->rolesusuario_model->update($rol_usuario);
        if($result){
            $this->response([
            	'status' => TRUE,
				'mensaje' => 'Actualización de rol correcta.'
			], REST_Controller::HTTP_OK);
        }
        else {
            $this->response([
            	'status' => FALSE,
				'mensaje' => 'El rol no se actualizó.'
			], REST_Controller::HTTP_OK);
        }
	}

}
