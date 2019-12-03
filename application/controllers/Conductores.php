<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';


class Conductores extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('conductores_model');
		$this->load->library('cloudinary_files');
	}

	//Método que devuelve todos los registros de los conductores, si es que existen
	public function index_get()
	{
		$conductores = $this->conductores_model->get();

		if (!is_null($conductores)) {
			$this->response(array($conductores), 200);
		} else {
			$this->response(array('error' => 'No existen conductores en la base de datos'), 200);
		}
	}

	//Método que devuelve un registro de los conductor, mediante su ID
	public function find_get($id)
	{
		if (!$id) {
			$this->response(array('error' => 'IdConductor vacío.'), 200);
		}

		$conductor = $this->conductores_model->get($id);

		if (!is_null($conductor)) {
			$this->response(array($conductor), 200);
		} else {
			$this->response(array('error' => 'Conductor no encontrado'), 200);
		}
	}

	//Método de inserción de un conductor
	public function index_post()
	{

		$foto = '';
		if (isset($_FILES['file'])) {
			$file = $_FILES['file']['tmp_name'];
			$public_id = $_POST['public_id'];
			try {
				$foto = $this->cloudinary_files->saveFile($file, $public_id);
				$foto = $foto['secure_url'];
			} catch (Exception $e) {
				return $this->response(array(
					'status' => 400,
					'message' => 'Error en ingreso de imagen ' + $e
				), 200);
			}
		}

		$conductor = array();
		$conductor['ID_EMPRESA'] = $_POST['ID_EMPRESA'];
		$conductor['CEDULA_COND'] = $_POST['CEDULA_COND'];
		$conductor['NOMBRE_COND'] = $_POST['NOMBRE_COND'];
		$conductor['APELLIDO_COND'] = $_POST['APELLIDO_COND'];
		$conductor['FOTO_COND'] = $foto;
		$conductor['CORREO_COND'] = $_POST['CORREO_COND'];
		$conductor['DIRECCION_COND'] = $_POST['DIRECCION_COND'];
		$conductor['TELEFONO_COND'] = $_POST['TELEFONO_COND'];
		$conductor['ESTADO_COND'] = $_POST['ESTADO_COND'];
		$isinserted = $this->conductores_model->save($conductor);

		if ($isinserted === false) {
			$this->response(array(
				'status' => 400,
				'message' => 'No se inserto ningun dato, revise los parámetros.',
				'detalles' => 'Los campos de teléfono y correo pueden ser nulos. Los campos de cédula y correo son únicos.'
			), 200);
		} else {
			$this->response(array(
				'status' => 200,
				'message' => 'Ingreso satisfactorio.'
			), 200);
		}
	}

	//Método de actualización de un conductor
	public function update_post()
	{
		$foto = null;
		if (isset($_FILES['file'])) {
			$public_id = $_POST['public_id'];
			$file = $_FILES['file']['tmp_name'];
			try {
				$foto = $this->cloudinary_files->saveFile($file, $public_id);
				$foto = $foto['secure_url'];
			} catch (Exception $e) {
				return $this->response(array(
					'status' => 400,
					'message' => 'Error en ingreso de imagen ' + $e
				), 200);
			}
		}
		$conductor = array();
		$conductor['ID_COND'] = $_POST['ID_COND'];
		$conductor['FOTO_COND'] =  $foto;
		$conductor['CORREO_COND'] = $_POST['CORREO_COND'];
		$conductor['DIRECCION_COND'] = $_POST['DIRECCION_COND'];
		$conductor['TELEFONO_COND'] = $_POST['TELEFONO_COND'];
		$conductor['ESTADO_COND'] = $_POST['ESTADO_COND'];

		$result = $this->conductores_model->actualizarConductor($conductor);
		if ($result) {
			$this->response(array(
				'status' => 200,
				'message' => 'Actualización de chofer correcta.'
			), 200);
		} else {
			$this->response(array(
				'status' => 400,
				'message' => 'El chofer no se actualizó.'
			), 200);
		}
	}

	public function delete_put()
	{
		$id_cond = $this->put('id_cond'); //desde json body
		$user_resp = $this->conductores_model->get($id_cond);
		if ($user_resp == null) {
			return $this->response(array('message' => 'Usuario no encontrado', 'status' => 400), 200);
		}

		$response = $this->conductores_model->deleteDriver($id_cond);
		return $this->response(array(
			$response,
			'usuario' => $id_cond,
			'status' => 200
		), 200);
	}


	public function inactivos_get()
	{
		return $this->response($this->conductores_model->getInactiveDrivers());
	}

	public function update_inactivos_put()
	{
		$id_cond = $this->put('id_cond'); //desde json body
		$user_resp = $this->conductores_model->get($id_cond);
		if ($user_resp == null) {
			return $this->response(array('message' => 'Usuario no encontrado', 'status' => 400), 200);
		}

		$response = $this->conductores_model->updateDriverToActive($id_cond);
		return $this->response([
			$response,
			'usuario' => $id_cond,
			'status' => 200
		], 200);
	}
}//Fin
