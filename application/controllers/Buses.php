<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class Buses extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('buses_model');
    }

    //Método que devuelve todos los registros de los buses, si es que existen
    public function index_get()
    {
        $buses = $this->buses_model->get();
        if (!is_null($buses)) {
            $this->response($buses, 200);
        } else {
            $this->response(array('error' => 'No existen buses en la base de datos'), 200);
        }
    }

    //Método que devuelve un registro de los buses, mediante su ID
    public function find_get($id)
    {
        if (!$id) {
            $this->response(array('error' => 'Parámetro IdBus vacío.'), 200);
        }

        $bus = $this->buses_model->get($id);

        if (!is_null($bus)) {
            $this->response(array($bus), 200);
        } else {
            $this->response(array('error' => 'Bus no encontrado'), 200);
        }
    }

    //Método de inserción de un bus
    public function index_post()
    {
        $bus = array();
        $bus['ID_COND'] = $_POST['ID_COND'];
        $bus['NUMERO_BUS'] = $_POST['NUMERO_BUS'];
        $bus['ASIENTOS_BUS'] = $_POST['ASIENTOS_BUS'];
        $bus['DOS_PISOS_BUS'] = $_POST['DOS_PISOS_BUS'];
        $bus['ID_EMPRESA'] = $this->buses_model->getCoopFromCond($bus['ID_COND']);
        $existe = $this->buses_model->busExists($bus);
        if ($existe)
            return $this->response(array(
                'message' => 'No se pudo insertar. El número de bus ingresado para la cooperativa actual ya ha sido ingresado.',
                'status' => 400
            ), 200);
        $response = $this->buses_model->save($bus);
        if (!$response)
            return $this->response(array(
                'message' => 'No se pudo insertar. Revise los parámetros ingresados.',
                'status' => 400
            ), 200);

        return $this->response(array(
            'message' => 'Elemento insertado correctamente.',
            'status' => 200
        ), 200);
    }

    //Método de actualización de un bus
    public function update_post()
    {
        $bus = array();
        $bus['ID_BUS'] = $_POST['ID_BUS'];
        $bus['ID_COND'] = $_POST['ID_COND'];
        $bus['NUMERO_BUS'] = $_POST['NUMERO_BUS'];
        $bus['ASIENTOS_BUS'] = $_POST['ASIENTOS_BUS'];
        $bus['DOS_PISOS_BUS'] = $_POST['DOS_PISOS_BUS'];
        $response = $this->buses_model->update($bus);
        if (!$response)
            return $this->response(array('status' => 400, 'message' => 'No se pudo actualizar'), 200);
        return $this->response(array('message' => 'Bus actualizado correctamente','status' => 200), 200);
    }

    //Itera el estado del bus entre activo e inactivo
    public function setEstado_post()
    {
        $id_bus = $this->post('ID_BUS');
        $estado_bus = $this->post('ESTADO_BUS');
        $bus = $this->buses_model->get($id_bus);
        if ($bus == null) {
            return $this->response(array(
                'message' => 'Bus no encontrado',
                'status' => 400
            ), 200);
        } else {
            if($estado_bus==0){
            $response = $this->buses_model->inactivarBus($id_bus);
            return $this->response(array('message' => 'Bus ha cambiado a inactivo.','status' => 200), 200);
            } else {
                $response = $this->buses_model->activarBus($id_bus);
                return $this->response(array('message' => 'Bus ha cambiado a activo.','status' => 200), 200);
            }
        }
    }

    public function inactivos_get()
	{
		return $this->response($this->buses_model->getInactiveBuses());
	}

}//end class
