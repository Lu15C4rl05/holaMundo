<?php
class Boletos_model extends CI_Model{
	public function __construct(){

	}

	public function get($idBoleto=null){
		if(is_null($idBoleto)){
			$query = $this->db->query("call proc_verBoletos");
			return $query->result_array();
		} else {
			$query = $this->db->query('select bo.ID_BOLETO,
				e.ID_EMPRESA,
				e.NOMBRE_EMPRESA,
				bu.NUMERO_BUS,
				CONCAT(cii.NOMBRE_CIUDAD,"-",cio.NOMBRE_CIUDAD) AS RUTA,
		    	CONCAT(usu.NOMBRE_USU," ",usu.APELLIDO_USU) as USUARIO,
			    bo.FECHA_BOLETO as FECHA_COMPRA,
			    bo.FECHA_VIAJE,
			    bo.QR_BOLETO
			from tbl_boleto bo inner join tbl_ruta r on bo.ID_RUTA=r.ID_RUTA
				inner join tbl_usuario usu on bo.ID_USU=usu.ID_USU
				inner join tbl_bus bu on r.ID_BUS=bu.ID_BUS
			    inner join tbl_conductor co on bu.ID_COND=co.ID_COND
			    inner join tbl_empresa e on co.ID_EMPRESA=e.ID_EMPRESA
			    inner join tbl_ciudad cii on r.ID_CIUDAD_INICIO=cii.ID_CIUDAD
			    inner join tbl_ciudad cio on r.ID_CIUDAD_DESTINO=cio.ID_CIUDAD
			where ID_BOLETO ='.$idBoleto);
		}
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return null;
	}

	public function getBoletosPorEmpresa($idEmpresa){
		$query = $this->db->query('select bo.ID_BOLETO,
			e.ID_EMPRESA,
			e.NOMBRE_EMPRESA,
			bu.NUMERO_BUS,
			CONCAT(cii.NOMBRE_CIUDAD,"-",cio.NOMBRE_CIUDAD) AS RUTA,
	    	CONCAT(usu.NOMBRE_USU," ",usu.APELLIDO_USU) as USUARIO,
		    bo.FECHA_BOLETO as FECHA_COMPRA,
		    bo.FECHA_VIAJE,
		    bo.QR_BOLETO
		from tbl_boleto bo inner join tbl_ruta r on bo.ID_RUTA=r.ID_RUTA
			inner join tbl_usuario usu on bo.ID_USU=usu.ID_USU
			inner join tbl_bus bu on r.ID_BUS=bu.ID_BUS
		    inner join tbl_conductor co on bu.ID_COND=co.ID_COND
		    inner join tbl_empresa e on co.ID_EMPRESA=e.ID_EMPRESA
		    inner join tbl_ciudad cii on r.ID_CIUDAD_INICIO=cii.ID_CIUDAD
		    inner join tbl_ciudad cio on r.ID_CIUDAD_DESTINO=cio.ID_CIUDAD
		where e.ID_EMPRESA ='.$idEmpresa);
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return null;
	}

	public function getAsientosOcupados($idRuta,$fecha){
		$query = $this->db->query('call proc_verAsientosOcupados('.$idRuta.',"'.$fecha.'");');
		return $query->result_array();

		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return null;
	}

	public function save($data = array()) {
		
        $insert = $this->db->insert('tbl_boleto', $data);

        if($this->db->affected_rows() === 1){
            return true;
        }
        return false;
    }

 //    public function obtenerRuta($ruta = array()){
	// 	$query = $this->db->query('select ID_RUTA from tbl_ruta ru
	// 			inner join tbl_ciudad cci on ru.ID_CIUDAD_INICIO=cci.ID_CIUDAD
	// 			inner join tbl_ciudad cco on ru.ID_CIUDAD_DESTINO=cco.ID_CIUDAD
 //                inner join tbl_horario ho on ru.ID_HORARIO=ho.ID_HORARIO
	// 		where
	// 			concat(cci.NOMBRE_CIUDAD," - ",cco.NOMBRE_CIUDAD)="'.$ruta['NOMBRE_RUTA'].'" and
	// 			date_format(ho.HORA_SALIDA,"%H:%i:%S")="'.$ruta['HORA_RUTA'].'"');

	// 	if($query->num_rows() > 0){
	// 		return $query->result_array();
	// 	}
	// 	return null;
	// }

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
