<?php 
class Category_model extends CI_Model  {   
        
    public function get_category($id = NULL, $search='',$limit='',$start='',$sort_col=0,$sort='asc'){

    	$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
    	$this->db->from('category');
	 	$this->db->where('category.isDelete', 0);
    	if ($id != NULL) {
            // Getting only ONE row
            $this->db->where('category.id', $id);
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                // One row, match!
                return $query->row();
            } else {
                return false;
            }
        } else {
        	$this->db->limit($limit, $start);
        	if(!empty($search)){
        		$this->db->like('categoryName', $search);
        	}
            $this->db->order_by($sort_col." ".$sort);
        	$query = $this->db->get();
            $data["data"] = array();
            if ($query->num_rows() > 0) { 
                $data["data"] = $query->result();
            }
            $count = $this->db->query('SELECT FOUND_ROWS() AS Count');
            $data["recordsTotal"] = $this->db->count_all('category');
            $data["recordsFiltered"] = $count->row()->Count;
            return $data;
        }
    }
    function Add($data) {
        $this->db->insert('category', $data);
        // echo $this->db->last_query();die;

         // Get id of inserted record
        $id = $this->db->insert_id();
        return $id;
    }
    function Edit($id, $data) {
        $this->db->where('id', $id);
        $result = $this->db->update('category', $data);
         // echo $this->db->last_query();die;
         // Return
         if($result){
            return $id;
         } else {
            return false;
         }
    }

}