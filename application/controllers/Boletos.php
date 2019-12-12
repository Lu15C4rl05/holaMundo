<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class Boletos extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('boletos_model');
	}

	public function index_get(){
		$boletos = $this->boletos_model->get();

		if (!is_null($boletos)) {
			$this->response(array('response' => $boletos), 200);
		} else {
			$this->response(array('error' => 'No existen boletos en la base de datos', 200));
		}
	}

	public function find_get($id){
		if(!$id){
			$this->response(null, 200);
		}

		$boleto = $this->boletos_model->get($id);

		if(!is_null($boleto)){
			$this->response(array('response' => $boleto), 200);
		} else {
			$this->response(array('error' => 'Boleto no encontrado'), 200);
		}
	}

	public function index_post()
	{
	    $Data = array();
		$Data['ID_RUTA'] = $this->post('ID_RUTA');
		$Data['ID_USU'] = $this->post('ID_USU');
		$Data['QR_BOLETO'] = $this->post('QR_BOLETO');
		$Data['FECHA_VIAJE'] = $this->post('FECHA_VIAJE');
		$insert = $this->boletos_model->save($Data);
		if($insert){
			$this->response(array(
				'message' => 'El boleto se ha guardado correctamente en la BD.',
				'status' => 200
			), 200);
		} else {
			$this->response([
				'message' => 'El boleto no se guardo en la BD.',
				'status' => 400
			], 200);
		}
	}

	public function ruta_post(){
		$ruta = array();
		$ruta['NOMBRE_RUTA'] = $this->post('NOMBRE_RUTA');
		$ruta['HORA_RUTA'] = $this->post('HORA_RUTA');
		$id_ruta = $this->boletos_model->obtenerRuta($ruta);

		if (!is_null($id_ruta)) {
			$this->response(array('response' => $id_ruta), 200);
		} else {
			$this->response(array('error' => 'La ruta especificada no existe.'), 200);
		}
	}

	public function compras_post() {
		$idUsu = $this->post('ID_USU');
		$existeIdUsu = $this->boletos_model->obtenerCompras($idUsu);
		if($existeIdUsu != null){
			$this->response([
				'mensaje' => 'El usuario ingresado registra las siguientes compras.',
				'response' => $existeIdUsu
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'mensaje' => 'El usuario no regitra compras.'
			], REST_Controller::HTTP_OK);
		}
	}

	public function index_delete($id){
		if(!$id){
			$this->response(null, 200);
		}
		
		$delete = $this->boletos_model->delete($id);

		if(!is_null($delete)){
			$this->response(array('response' => 'Boleto eliminado correctamente.'), 200);
		} else {
			$this->response(array('error' => 'Algo ha fallado en el servidor. Acción no procesada'), 200);
		}
	}
}
