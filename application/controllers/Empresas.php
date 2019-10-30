<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class Empresas extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('empresas_model');
    }

    public function index_get()
    {
        $empresas = $this->empresas_model->get();

		if (!is_null($empresas)) {
			$this->response(array('response' => $empresas), 200);
		} else {
			$this->response(array('error' => 'No existen cooperativas de transporte registradas en la base de datos'), 200);
		}
    }

	public function find_get($id){
		if(!$id){
			$this->response(null, 200);
		}

		$empresa = $this->empresas_model->get($id);

		if(!is_null($empresa)){
			$this->response(array('response' => $empresa), 200);
		} else {
			$this->response(array('error' => 'Coop. de transporte no encontrada'), 200);
		}
	}

	public function index_post(){
		$empresa = array();
		$empresa['NOMBRE_EMPRESA'] = $this->post('NOMBRE_EMPRESA');
		$isinserted = $this->empresas_model->save($empresa);
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
		$empresa = array();
		$empresa['ID_EMPRESA'] = $this->post('ID_EMPRESA');
		$empresa['NOMBRE_EMPRESA'] = $this->post('NOMBRE_EMPRESA');
		$result = $this->empresas_model->update($empresa);
        if($result){
            $this->response([
					'mensaje' => 'Actualización de empresa correcta.'
				], REST_Controller::HTTP_OK);
        }
        else {
            $this->response([
					'mensaje' => 'La empresa no se actualizó.'
				], REST_Controller::HTTP_OK);
        }
	}

}//end class
