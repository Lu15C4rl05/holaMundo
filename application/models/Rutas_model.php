<?php
class Rutas_model extends CI_Model{
	public function __construct(){

	}

	//La función devuelve segun los parámetros recibidos:
		//*Sin parámetros: Todas las rutas
		//*Un parámetro ($ciudad_in): Las ciudades destino que tiene la ciudad origen.
		//*Dos parámetros ($ciudad_in,$ciudad_out): Las horas de salida de la ruta entre las dos ciudades.
		//*Tres parámetros ($ciudad_in,$ciudad_out,$fecha): Las horas de salida de la ruta entre las dos ciudades y en la fecha especificada.
	public function get($ciudad_in=null,$ciudad_out=null,$fecha=null){
		if( (!is_null($ciudad_in)) && (!is_null($ciudad_out)) && (is_null($fecha)) ){
			$query = $this->db->query("CALL proc_verRuta('".$ciudad_in."','".$ciudad_out."')");
			return $query->result_array();
		} else {
			if( (!is_null($ciudad_in)) && (!is_null($ciudad_out)) && (!is_null($fecha)) ){
				$query = $this->db->query("CALL proc_verHorario('".$ciudad_in."','".$ciudad_out."','".$fecha."')");
				return $query->result_array();
			} else {
				if( (!is_null($ciudad_in)) && (is_null($ciudad_out)) && (is_null($fecha)) ){
					$query = $this->db->query("call proc_verDestino('".$ciudad_in."')");
						return $query->result_array();
				} else {
					if( (is_null($ciudad_in)) && (is_null($ciudad_out)) && (is_null($fecha)) ){
						$query = $this->db->query("select * from vista_rutas");
						return $query->result_array();
					}
				}
			}
		}
		if($query->num_rows() > 0){
			 return $query->result_array();
		}
		return null;				
	}

	//Obtiene la ruta "ORIGEN - DESTINO", la imagen de la ciudad destino y el número de boletos vendido de cada ruta. Esta función se utiliza para el apartado de "RUTAS MÁS VENDIDAS" en la app.
	public function getimg(){
		$query = $this->db->query("select * from vista_imagenes_ruta");

		if($query->num_rows() > 0){
			foreach ($query->result_array() as $row) {
			 	$row['IMAGEN'] = base64_encode($row['IMAGEN']);
			 	$datos[] = $row;
			 }
			 return $datos;
		}
		return null;
	}

	//Obtiene las ciudades origen de las rutas existentes
	public function getCiudadesOrigen(){
		$query = $this->db->query("select distinct cii.ID_CIUDAD, cii.NOMBRE_CIUDAD from tbl_ruta ru
			inner join tbl_ciudad cii on ru.ID_CIUDAD_INICIO= cii.ID_CIUDAD");
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return null;
	}

	//Obtiene el Id de un horario a partir de su HORA_SALIDA
	public function getIdHor($hora_salida){
		$query = $this->db->query('select ID_HORARIO from tbl_horario where HORA_SALIDA = "2019-08-28 '.$hora_salida.'"');
		$row = $query->row_array();
		return $row['ID_HORARIO'];
	}

	//Calcula el costo de la ruta según normativa de la ANT
	public function asignarCosto($ciudad_in,$ciudad_out){
		//Se implementará cuando se estructure en la BD los costos de todo el Ecuador..
	}

	//Obtiene el ID de la imagen de la ciudad correspondiente
	public function getIdImg($id_ciudad){
		switch ($id_ciudad) {
			case 1: return 5; break;
			case 2: return 4; break;
			case 3:	return 6; break;
			case 4:	return 6; break;
			case 5:	return 1; break;
			case 6:	return 3; break;
			case 7:	return 2; break;
			case 8:	return 7; break;
			case 9:	return 8; break;
			default: break;
		}
	}

	//Método de inserción de una ruta
	public function save($ruta){
		$this->db->insert('tbl_ruta',$ruta);
		if($this->db->affected_rows() == 1)
			return true;
		return false;
	}

	//Método de actualización de una ruta
	public function update($ruta){
		$query = $this->db->query('update tbl_ruta set 
            ID_BUS = "'.$ruta['ID_BUS'].'", ID_CIUDAD_INICIO = "'.$ruta['ID_CIUDAD_INICIO'].'", ID_CIUDAD_DESTINO = "'.$ruta['ID_CIUDAD_DESTINO'].'", ID_IMG = "'.$ruta['ID_IMG'].'", ID_HORARIO = "'.$ruta['ID_HORARIO'].'", COSTO_RUTA = "'.$ruta['COSTO_RUTA'].'"
            where ID_RUTA = "'.$ruta['ID_RUTA'].'"');
        if($this->db->affected_rows() === 1)
            return true;
        return false;
	}

	// public function delete($id){
	// 	$this->db->where('ID_RUTA', $id)->delete('tbl_ruta');

	// 	if($this->db->affected_rows() === 1){
	// 		return true;
	// 	}
	// 	return false;
	// }
}

?>