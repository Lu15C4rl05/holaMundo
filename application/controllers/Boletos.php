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
			$this->load->view('insertar');
		} else {
			$this->response(array('error' => 'No existen boletos en la base de datos'), 404);
		}
		//$this->load->view('insertar');
	}

	public function find_get($id){
		if(!$id){
			$this->response(null, 400);
		}

		$boleto = $this->boletos_model->get($id);

		if(!is_null($boleto)){
			$this->response(array('response' => $boleto), 200);
		} else {
			$this->response(array('error' => 'Boleto no encontrado'), 404);
		}
	}

	public function index_post()
	{
	    $Data = array();
		$Data['ID_BOLETO'] = $this->post('ID_BOLETO');
		$Data['ID_BUS'] = $this->post('ID_BUS');
		$Data['ID_RUTA'] = $this->post('ID_RUTA');
		$Data['ID_CLI'] = $this->post('ID_CLI');
		$Data['NUMPERSONAS_BOLETO'] = $this->post('NUMPERSONAS_BOLETO');
		$insert = $this->boletos_model->save($Data);
		if($insert===false){
				$this->response("Por favor intentelo de nuevo.", REST_Controller::HTTP_BAD_REQUEST);
			}else{
			
				$this->response([
					'status' => TRUE,
					'message' => 'Ingreso satisfactorio.'
				], REST_Controller::HTTP_OK);
			}
       
	}

	/*public function index_put(){
		if(!$this->put('boleto') || $id){
			$this->response(null, 400);
		}

		$update = $this->boletos_model->update($id, $this->put('boleto'));

		if(!is_null($update)){
			$this->response(array('response' => 'Boleto editado correctamente.'), 200);
		} else {
			$this->response(array('error' => 'Algo ha fallado en el servidor. Acción no procesada'), 400);
		}
	}*/

	public function index2_post() {
		$id = $this->post('ID_BOLETO');
		$Data = array();
		$Data['ID_BUS'] = $this->post('ID_BUS');
		$Data['ID_RUTA'] = $this->post('ID_RUTA');
		$Data['ID_CLI'] = $this->post('ID_CLI');
		$Data['NUMPERSONAS_BOLETO'] = $this->post('NUMPERSONAS_BOLETO');
		$update = $this->boletos_model->updat($id, $Data);
		if($update){
			$this->response([
				'status' => TRUE,
				'message' => 'Actualizacion satisfactoria.'
			], REST_Controller::HTTP_OK);
		}else{
			$this->response("Por favor intentelo de nuevo.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_delete($id){
		if(!$id){
			$this->response(null, 400);
		}
		
		$delete = $this->boletos_model->delete($id);

		if(!is_null($delete)){
			$this->response(array('response' => 'Boleto eliminado correctamente.'), 200);
		} else {
			$this->response(array('error' => 'Algo ha fallado en el servidor. Acción no procesada'), 400);
		}
	}
}