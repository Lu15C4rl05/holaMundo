<?php
class Horario_model extends CI_Model{
	public function __construct(){

	}

	public function get($id=null){
		if(!is_null($id)){
			$query = $this->db->select('*')->from('TBL_HORARIO')->where('ID_HORARIO', $id)->get();
			if($query->num_rows() === 1){
				return $query->row_array();
			}
			return null;
		}

		$query = $this->db->query("select * from TBL_HORARIO");

		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return null;
	}

	public function save($horario){
		$this->db->set($this->setHorario($horario))->insert('TBL_HORARIO');

		if($this->db->affected_rows() === 1){
			return $this->db->insert_id();
		}
		return false;
	}

	public function update($id, $horario){
		$this->db->set($this->setHorario($horario))->where('ID_HORARIO', $id)->update('TBL_HORARIO');

		if($this->db->affected_rows() === 1){
			return true;
		}
		return false;
	}

	public function delete($id){
		$this->db->where('ID_HORARIO', $id)->delete('TBL_HORARIO');

		if($this->db->affected_rows() === 1){
			return true;
		}
		return false;
	}

	private function setHorario($horario){
		return array(
			'ID_HORARIO' => $horario['ID_HORARIO'],
			'HORA_SALIDA' => $horario['HORA_SALIDA'],
			'HORA_LLEGADA' => $horario['HORA_LLEGADA']
		);
	}

}

?>