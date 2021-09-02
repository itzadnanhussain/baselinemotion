<?php
class Csv_import_model extends CI_Model
{
	function select()
	{
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('users_kams_score');
		return $query;
	}

	function insert($data)
	{
		$this->db->insert_batch('users_kams_score', $data);
	}
 
	function olddatafetch(){
		$data = array();
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('users_kams_score');
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$data[] = $row->patient_id ."---". $row->date;
			}
		}
		return $data;
	}
 
}