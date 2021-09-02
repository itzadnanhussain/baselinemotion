<?php

Class Kinetisense_model extends CI_Model {
	
	function getscores($patient = NULL){
		
		$data = array();
		
		$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
		$this->db->from('users_kams_score');
		$this->db->where('patient_id', $patient); 
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			$userobj = $query->result();
			foreach($userobj as $user){
				$data[] = $user;
			}
        }
		
		return $data;
	}
	
	function addimage($data) {
        // Run query to insert blank row

        $this->db->insert('kinetisense_image', $data);
        // Get id of inserted record
        $id = $this->db->insert_id();
                
         return $id;
    }
	
	function fetchimage(){
		$data = array();
		
		$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
		$this->db->from('kinetisense_image');
		$query = $this->db->get();
		
		
		if($query->num_rows() > 0) {
          // Got some rows, return as assoc array
            $userobj = $query->result();
			foreach($userobj as $user){
				$data[] = $user->kinetisenseImageId;
			}
        }
		
		return $data;
	}
}

?>