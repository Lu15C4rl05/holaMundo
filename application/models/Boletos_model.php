<?php
class Boletos_model extends CI_Model{
	public function __construct(){

	}

	public function get($id=null){
		if(!is_null($id)){
			$query = $this->db->select("bol.ID_BOLETO, bus.NUMERO_BUS, em.NOMBRE_EMPRESA,
		CONCAT(cii.NOMBRE_CIUDAD,'-',cio.NOMBRE_CIUDAD) AS RUTA,
		CONCAT(usu.APELLIDO_USU,' ',usu.NOMBRE_USU) as USUARIO, bol.NUMPERSONAS_BOLETO AS ASIENTOS")->from(
			'tbl_boleto bol')->join("tbl_bus bus","bol.ID_BUS=bus.ID_BUS")->join("tbl_ruta ru","bol.ID_RUTA=ru.ID_RUTA")->join("tbl_usuario usu","bol.ID_USU=usu.ID_USU")->join("tbl_ciudad cii","ru.ID_CIUDAD_INICIO=cii.ID_CIUDAD")->join("tbl_ciudad cio","ru.ID_CIUDAD_DESTINO=cio.ID_CIUDAD")->join("tbl_empresa em","bus.ID_EMPRESA=em.ID_EMPRESA")->where('bol.ID_BOLETO',$id)->get();

			if($query->num_rows() === 1){
				return $query->row_array();
			}
			return null;
		}

		$query = $this->db->query("SELECT  bol.ID_BOLETO, bus.NUMERO_BUS, CONCAT(cii.NOMBRE_CIUDAD,'-',cio.NOMBRE_CIUDAD) AS RUTA,
		CONCAT(usu.APELLIDO_USU,' ',usu.NOMBRE_USU) as USUARIO, bus.ASIENTOS_DIS_BUS AS ASIENTOS
			FROM tbl_boleto bol
			inner join tbl_bus bus on bol.ID_BUS=bus.ID_BUS
			inner join tbl_ruta ru on bol.ID_RUTA= ru.ID_RUTA
			inner join tbl_usuario usu on bol.ID_USU=usu.ID_USU
			inner join tbl_ciudad cii on ru.ID_CIUDAD_INICIO=cii.ID_CIUDAD
			inner join tbl_ciudad cio on ru.ID_CIUDAD_DESTINO=cio.ID_CIUDAD;");

		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return null;
	}

	public function save($data = array()) {
		
        $insert = $this->db->insert('tbl_boleto', $data);

        if($this->db->affected_rows() === 1){
            return true;
        } else {
        	return false;
        }
    }

    public function obtenerRuta($ruta = array()){
		$query = $this->db->query('select ID_RUTA from tbl_ruta ru
				inner join tbl_ciudad cci on ru.ID_CIUDAD_INICIO=cci.ID_CIUDAD
				inner join tbl_ciudad cco on ru.ID_CIUDAD_DESTINO=cco.ID_CIUDAD
                inner join tbl_horario ho on ru.ID_HORARIO=ho.ID_HORARIO
			where
				concat(cci.NOMBRE_CIUDAD," - ",cco.NOMBRE_CIUDAD)="'.$ruta['NOMBRE_RUTA'].'" and
				date_format(ho.HORA_SALIDA,"%H:%i:%S")="'.$ruta['HORA_RUTA'].'"');

		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return null;
	}

	public function obtenerCompras($idUsu){
		$query = $this->db->query('select emp.NOMBRE_EMPRESA,
				bus.NUMERO_BUS,
			    bo.created_at AS FECHA_COMPRA,
			    CONCAT(cii.NOMBRE_CIUDAD,
			            " - ",
			            cio.NOMBRE_CIUDAD) AS RUTA,
			    DATE_FORMAT(bo.FECHA_VIAJE, "%d/%m/%Y") AS FECHA_SALIDA,
			    DATE_FORMAT(ho.HORA_SALIDA, "%k:%i:%s") AS HORA_SALIDA,
			    usu.CEDULA_USU AS CEDULA,
			    CONCAT(usu.NOMBRE_USU," ", usu.APELLIDO_USU) AS NOMBRES_USUARIO,
			    usu.CORREO_USU AS CORREO,
			    ru.COSTO_RUTA,
			    bo.QR_BOLETO
			FROM
			    tbl_boleto bo
			        INNER JOIN
			    tbl_ruta ru ON bo.ID_RUTA = ru.ID_RUTA
			        INNER JOIN
			    tbl_horario ho ON ru.ID_HORARIO = ho.ID_HORARIO
			        INNER JOIN
			    tbl_bus bus ON ru.ID_BUS=bus.ID_BUS    
					INNER JOIN
				tbl_conductor cond ON bus.ID_COND=cond.ID_COND
			        INNER JOIN
				tbl_empresa emp ON cond.ID_EMPRESA=emp.ID_EMPRESA
			        INNER JOIN
			    tbl_usuario usu ON bo.ID_USU = usu.ID_USU
			        INNER JOIN
			    tbl_ciudad cii ON ru.ID_CIUDAD_INICIO = cii.ID_CIUDAD
			        INNER JOIN
			    tbl_ciudad cio ON ru.ID_CIUDAD_DESTINO = cio.ID_CIUDAD
			WHERE
			    usu.ID_USU = "'.$idUsu.'"
			        AND bo.FECHA_VIAJE > NOW() - INTERVAL 5 HOUR
			ORDER BY bo.created_at DESC');

		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return null;
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
