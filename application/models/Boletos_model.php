<?php
class Boletos_model extends CI_Model{
	public function __construct(){

	}

	public function get($id=null){
		if(!is_null($id)){
			$query = $this->db->select("bol.ID_BOLETO, bus.NUMERO_BUS, em.NOMBRE_EMPRESA,
		CONCAT(cii.NOMBRE_CIUDAD,'-',cio.NOMBRE_CIUDAD) AS RUTA,
		CONCAT(cli.APELLIDO_CLI,' ',cli.NOMBRE_CLI) as CLIENTE")->from(
			'tbl_boleto bol')->join("tbl_bus bus","bol.ID_BUS=bus.ID_BUS")->join("tbl_ruta ru","bol.ID_RUTA=ru.ID_RUTA")->join("tbl_cliente cli","bol.ID_CLI=cli.ID_CLI")->join("tbl_ciudad cii","ru.ID_CIUDAD_INICIO=cii.ID_CIUDAD")->join("tbl_ciudad cio","ru.ID_CIUDAD_DESTINO=cio.ID_CIUDAD")->join("tbl_empresa em","bus.ID_EMPRESA=em.ID_EMPRESA")->where('bol.ID_BOLETO',$id)->get();

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

	public function save($data = array()) {
		
        $insert = $this->db->insert('tbl_boleto', $data);

         if($insert===null){
            return false;
        }else{
            return true;
        }
    }

	public function updat($id, $boleto){
		//$this->db->set($this->setPasajero($pasajero))->where('codigo_pasaj', $id)->update('tbl_pasajeros');
		$this->db->where('ID_BOLETO', $id)->update('tbl_boleto', $boleto);
		if($this->db->affected_rows() === 1){
			return true;
		}
		return false;
	}

	public function delete($id){
		$this->db->where('ID_BOLETO', $id)->delete('tbl_boleto');

		if($this->db->affected_rows() === 1){
			return true;
		}
		return false;
	}

}

?>