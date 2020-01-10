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
			$this->response($conductores, 200);
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

		$conductor = array();
		$conductor['ID_EMPRESA'] = $_POST['ID_EMPRESA'];
		$conductor['CEDULA_COND'] = $_POST['CEDULA_COND'];
		$conductor['NOMBRE_COND'] = $_POST['NOMBRE_COND'];
		$conductor['APELLIDO_COND'] = $_POST['APELLIDO_COND'];
		$conductor['CORREO_COND'] = $_POST['CORREO_COND'];
		$conductor['DIRECCION_COND'] = $_POST['DIRECCION_COND'];
		$conductor['TELEFONO_COND'] = $_POST['TELEFONO_COND'];
		$conductor['ESTADO_COND'] = $_POST['ESTADO_COND'];
		$conductor['ID_IMG'] = $this->conductores_model->nullDriverId();
		$response_driver = $this->conductores_model->save($conductor);

		if (!$response_driver['IS_INSERTED']) {
			$this->response(array(
				'status' => 400,
				'message' => 'No se inserto ningun dato, revise los parámetros.',
				'detalles' => 'Los campos de teléfono y correo pueden ser nulos. Los campos de cédula y correo son únicos.'
			), 200);
		} else {
			if (isset($_FILES['FILE'])) {
				$imagen = array();
				$file = $_FILES['FILE']['tmp_name'];
				$public_id = 'driver/' . $_POST['CEDULA_COND'];
				try {
					$foto = $this->cloudinary_files->saveFile($file, $public_id);
					$id_driver = $response_driver['ID_DRIVER'];
					$imagen['ID_TIPO_IMG'] = $this->conductores_model->tipoImgDriverId();
					$imagen['NOMBRE_IMG'] = $_POST['CEDULA_COND'];
					$imagen['URL_IMAGEN'] = $foto['secure_url'];
					$id_img = $this->conductores_model->saveImgDriver($imagen);
					$this->conductores_model->update_id_img($id_driver, $id_img);
				} catch (Exception $e) {
					return $this->response(array(
						'status' => 400,
						'message' => 'No se pudo guardar la imagen ' + $e
					), 200);
				}
			}
			$this->response(array(
				'status' => 200,
				'message' => 'Ingreso satisfactorio.'
			), 200);
		}
	}

	//Método de actualización de un conductor
	public function update_post()
	{


		$conductor = array();
		$conductor['ID_COND'] = $_POST['ID_COND'];
		$conductor['CORREO_COND'] = $_POST['CORREO_COND'];
		$conductor['DIRECCION_COND'] = $_POST['DIRECCION_COND'];
		$conductor['TELEFONO_COND'] = $_POST['TELEFONO_COND'];
		$conductor['ESTADO_COND'] = $_POST['ESTADO_COND'];
		// $conductor['ID_IMG'] = $_POST['ID_IMG'];

		$result = $this->conductores_model->actualizarConductor($conductor);
		if ($result) {
			if (isset($_FILES['FILE'])) {
				$imagen = array();
				$file = $_FILES['FILE']['tmp_name'];
				$response = $this->conductores_model->get($_POST['ID_COND']);
				// var_dump($response['CEDULA_COND']);
				$public_id = 'driver/' . $response['CEDULA_COND'];
				try {
					$foto = $this->cloudinary_files->saveFile($file, $public_id);
					$imagen['ID_TIPO_IMG'] = $this->conductores_model->tipoImgDriverId();
					$imagen['NOMBRE_IMG'] =   $response['CEDULA_COND'];
					$imagen['URL_IMAGEN'] = $foto['secure_url'];
					$id_img = $this->conductores_model->saveImgDriver($imagen);
					$this->conductores_model->update_id_img($_POST['ID_COND'], $id_img);
				} catch (Exception $e) {
					return $this->response(array(
						'status' => 400,
						'message' => 'No se pudo guardar la imagen ' + $e
					), 200);
				}
			}
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

	public function nulldriver_get()
	{
		return $this->response(array('nulldriverid' => $this->conductores_model->nullDriverId()));
	}
}//Fin
