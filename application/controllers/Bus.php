<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class Bus extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('bus_model');
    }

    public function all_get()
    {
        return $this->response($this->bus_model->getAllBus());
    }

    public function save_post()
    {
        $id_empresa = $this->post('id_empresa');
        $id_cond = $this->post('id_cond');
        $numero_bus = $this->post('numero_bus');
        $asientos_bus = $this->post('asientos_bus');
        $estado_bus = $this->post('estado_bus');
        $asientos_dis_bus = $this->post('asientos_dis_bus');
        $dos_pisos_bus = $this->post('dos_pisos_bus');

        $bus = array(
            'id_empresa' => $id_empresa,
            'id_cond' => $id_cond,
            'numero_bus' => $numero_bus,
            'asientos_bus' => $asientos_bus,
            'estado_bus' => $estado_bus,
            'asientos_dis_bus' => $asientos_dis_bus,
            'dos_pisos_bus' => $dos_pisos_bus,
        );
        $existe = $this->bus_model->busExists($bus);
        if ($existe)
            return $this->response(['status' => 400, 'msg' => 'No se pudo ingresar. Elemento existente'], 400);
        $response = $this->bus_model->saveBus($bus);
        if (!$response)
            return $this->response(['status' => 400, 'msg' => 'No se pudo ingresar'], 400);

        return $this->response([
            'status' => 200, 'msg' => 'Elemento ingresado correctamente',
            'id_empresa' => $id_empresa,
            'numero_bus' => $numero_bus,
        ], 200);
    }


    public function update_put()
    {

        $id_bus = $this->put('id_bus');
        $id_cond = $this->put('id_cond');
        $numero_bus = $this->put('numero_bus');
        $asientos_bus = $this->put('asientos_bus');
        $dos_pisos_bus = $this->put('dos_pisos_bus');
        $estado_bus = $this->put('estado_bus');

        $bus = array(
            'id_bus' => $id_bus,
            'id_cond' => $id_cond,
            'numero_bus' => $numero_bus,
            'asientos_bus' => $asientos_bus,
            'dos_pisos_bus' => $dos_pisos_bus,
            'estado_bus' => $estado_bus,
        );

        $response = $this->bus_model->updateBus($bus);
        if (!$response)
            return $this->response(['status' => 400, 'msg' => 'No se pudo actualizar'], 400);

        return $this->response([
            'status' => 200, 'msg' => 'Elemento actualizado correctamente',
            'id_cond' => $id_cond,
            'numero_bus' => $numero_bus,
        ], 200);
    }


    public function delete_put()
    {
        $id_bus = $this->put('id_bus'); //desde json body
        $bus_resp = $this->bus_model->getBusById($id_bus,1);
        if ($bus_resp == null) {
            $status = 400;
            return $this->response(['msg' => 'Usuario no encontrado', 'status' => $status], $status);
        }

        $response = $this->bus_model->deleteBus($id_bus);
        return $this->response([
            'response' => $response,
            'bus' => $id_bus,
            'status' => 200
        ], 200);
    }


    public function inactivos_get()
	{
		return $this->response($this->bus_model->getInactiveBuses());
	}

	public function update_inactivos_put()
	{
		$id_bus = $this->put('id_bus'); //desde json body
		$user_resp = $this->bus_model->getBusById($id_bus,0);
		if ($user_resp == null) {
			$status = 400;
			// $status = parent::Htttp;
			return $this->response(['msg' => 'Bus no encontrado', 'status' => $status], $status);
		}

		// print_r($user);
		$response = $this->bus_model->updateBusToActive($id_bus);
		return $this->response([
			'response' => $response,
			'id_bus' => $id_bus,
			'status' => 200
		], 200);
	}


}//end class
