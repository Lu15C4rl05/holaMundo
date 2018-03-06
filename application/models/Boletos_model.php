<?php
class Boletos_model extends CI_Model{
	public function __construct(){

	}

	public function get($id=null){
		if(!is_null($id)){
			$query = $this->db->select('*')->from('tbl_boleto')->where('ID_BOLETO', $id)->get();
			if($query->num_rows() === 1){
				return $query->row_array();
			}
			return null;
		}

		$query = $this->db->query("
			SELECT  bol.ID_BOLETO, bus.NUMERO_BUS, CONCAT(cii.NOMBRE_CIUDAD,'-',cio.NOMBRE_CIUDAD) AS RUTA,
		CONCAT(cli.APELLIDO_CLI,' ',cli.NOMBRE_CLI) as CLIENTE
			FROM tbl_boleto bol
			inner join tbl_bus bus on bol.ID_BUS=bus.ID_BUS
			inner join tbl_ruta ru on bol.ID_RUTA= ru.ID_RUTA
			inner join tbl_cliente cli on bol.ID_CLI=cli.ID_CLI
			inner join tbl_ciudad cii on ru.ID_CIUDAD_INICIO=cii.ID_CIUDAD
			inner join tbl_ciudad cio on ru.ID_CIUDAD_DESTINO=cio.ID_CIUDAD;");

		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return null;
	}

	public function save($pasajero){
		$this->db->set($this->setPasajero($pasajero))->insert('tbl_pasajeros');

		if($this->db->affected_rows() === 1){
			return $this->db->insert_id();
		}
		return false;
	}

	public function update($id, $pasajero){
		$this->db->set($this->setPasajero($pasajero))->where('codigo_pasaj', $id)->update('tbl_pasajeros');

		if($this->db->affected_rows() === 1){
			return true;
		}
		return false;
	}

	public function delete($id){
		$this->db->where('codigo_pasaj', $id)->delete('tbl_pasajeros');

		if($this->db->affected_rows() === 1){
			return true;
		}
		return false;
	}


	private function setPasajero($pasajero){
		return array(
			'codigo_pasaj' => $pasajero['codigo_pasaj'],
			'nombre_pasaj' => $pasajero['nombre_pasaj'],
			'codigoVer_pasaj' => $pasajero['codigoVer_pasaj']
		);
	}

}

?>