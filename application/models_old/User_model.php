<?php

Class User_model extends CI_Model {
    	
    function Get($id = NULL, $search = array()) {
      $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
      $this->db->from('users');
      // Check if we're getting one row or all records
      if($id != NULL){
        // Getting only ONE row
        $this->db->where('id', $id);
        $this->db->limit('1');
        $query = $this->db->get();
        if( $query->num_rows() == 1 ) {
          // One row, match!
          return $query->row();        
        } else {
          // None
          return false;
        }
      } else {
        // Get all
        if(!empty($search)) {
            $defaultSearch = array(
                'username'     =>  '',
                'password' => '',
                'id' => ''
            );
            $search = array_merge($defaultSearch, $search);
            if($search['username'] != '') {
                $this->db->like('username', $search['username']); 
            }
            if($search['id'] != '') {
                $this->db->where('id', $search['id']); 
            }
            if($search['password'] != '') {
                $this->db->where('password', $search['password']); 
            }
            if($search['reset_password_code'] != '') {
                $this->db->where('reset_password_code', $search['reset_password_code']); 
            }
            if(isset($search['order'])) {
                $order = $search['order'];
                if($order[0]['column'] == 1) {
                    $orderby = "username ".strtoupper($order[0]['dir']);
                }
                $this->db->order_by($orderby);
            }
            if(isset($search['start'])) {
                $start = $search['start'];
                $length = $search['length'];
                if($length != -1) {
                    $this->db->limit($length, $start);
                }
            }
        }
        $query = $this->db->get();
        $data["records"] = array();
        if($query->num_rows() > 0) {
          // Got some rows, return as assoc array
            $data["records"] = $query->result();
        }
        $count = $this->db->query('SELECT FOUND_ROWS() AS Count');
        $data["countTotal"] = $this->db->count_all('users');
        $data["countFiltered"] = $count->row()->Count;
        return $data;
      }
    }

    function Add($data) {
        // Run query to insert blank row

        $this->db->insert('users', $data);
        // Get id of inserted record
        $id = $this->db->insert_id();
                
         return $id;
    }
	
	function Editusers($patientid, $data) {
        $this->db->where('patientid', $patientid);
        $result = $this->db->update('users', $data);
      
        // Return
        if($result){
            return $patientid;
        } else {
            return false;
        }
    }
	
	function getworkouts($patient = NULL){
		
		$data = new stdClass;
		
		$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
		$this->db->from('assign_workouts');
		$this->db->order_by("STR_TO_DATE(assessment_date,'%m-%d-%Y') DESC");
		$this->db->where('patient_id', $patient); 
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			$userobj = $query->result();
			$data = $userobj;
			foreach($data as $d){
				$llwork = explode(", ",$d->ll_workouts);
				if(sizeof($llwork) > 0){
					$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
					$this->db->from('workouts');
					$this->db->where_in('id', $llwork );
					
					
					$query2 = $this->db->get();
					if($query2->num_rows() > 0) {
						$d->llvideos = $query2->result();
					}
				}
				
				$sflsblwork = explode(", ",$d->sflsbl_workouts);
				if(sizeof($sflsblwork) > 0){
					$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
					$this->db->from('workouts');
					$this->db->where_in('id', $sflsblwork );
					
					$query2 = $this->db->get();
					if($query2->num_rows() > 0) {
						$d->sflsblvideos = $query2->result();
					}
				}
				
				$sblwork = explode(", ",$d->sbl_workouts);
				if(sizeof($sflsblwork) > 0){
					$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
					$this->db->from('workouts');
					$this->db->where_in('id', $sblwork );
					
					$query2 = $this->db->get();
					if($query2->num_rows() > 0) {
						$d->sflsblvideos = $query2->result();
					}
				}
				
				$splwork = explode(", ",$d->spl_workouts);
				if(sizeof($splwork) > 0){
					$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
					$this->db->from('workouts');
					$this->db->where_in('id', $splwork );
					
					$query2 = $this->db->get();
					if($query2->num_rows() > 0) {
						$d->splvideos = $query2->result();
					}
				}
			}
        }
		
		return $data;
	}
	
	function zone_conversion_date($time, $cur_zone, $req_zone)
	{   
		date_default_timezone_set("GMT");
		$gmt = date("Y-m-d H:i:s");

		date_default_timezone_set($cur_zone);
		$local = date("Y-m-d H:i:s");

		date_default_timezone_set($req_zone);
		$required = date("Y-m-d H:i:s");

		/* return $required; */
		$diff1 = (strtotime($gmt) - strtotime($local));
		$diff2 = (strtotime($required) - strtotime($gmt));

		$date = new DateTime($time);
		$date->modify("+$diff1 seconds");
		$date->modify("+$diff2 seconds");

		return $timestamp = $date->format("Y-m-d H:i:s");
	}
	
	function viewzone_conversion_date($time, $cur_zone, $req_zone)
	{   
		try{
		$date = new DateTime($time, new DateTimeZone($cur_zone));
		$date->setTimezone(new DateTimeZone($req_zone));
		}catch(Exception $e) {
		  echo 'Message: ' .$e->getMessage();
		}
		return $date->format('m/d/Y h:i a');
	}
	
	function fetcholduser(){
		$data = array();
		
		$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
		$this->db->from('users');
		$query = $this->db->get();
		
		
		if($query->num_rows() > 0) {
          // Got some rows, return as assoc array
            $userobj = $query->result();
			foreach($userobj as $user){
				if($user->patientid !="")
					$data[] = $user->patientid;
			}
        }
		
		return $data;
	}
	
	function fetchassignvideos($patientid){
		$data = array();
		
		$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
		$this->db->from('assign_workouts');
		$this->db->where('patient_id', $patientid); 
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
          // Got some rows, return as assoc array
            $userobj = $query->result();
			foreach($userobj as $user){
				if($user->assessment_date !="")
					$data[] = $user->assessment_date;
			}
        }
		return $data;
	}
	
	function fetchvideos($id){
		$data = array();
		
		$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
		$this->db->from('workouts_videos');
		$this->db->where('user_id', $id); 
		$query = $this->db->get();
		
		
		if($query->num_rows() > 0) {
          // Got some rows, return as assoc array
            $userobj = $query->result();
			foreach($userobj as $user){
				$data2 = array();
				$data2['id'] = $user->id;
				$data2['user_id'] = $user->user_id;
				$data2['code'] = $user->code;
				$data[] = $data2;
			}
        }
		
		return $data;
	}
	
	function fetchvideosembed($id){
		$data = array();
		
		$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
		$this->db->from('workouts_videos');
		$this->db->where('id', $id); 
		$query = $this->db->get();
		
		
		if($query->num_rows() > 0) {
          // Got some rows, return as assoc array
            $userobj = $query->result();
			foreach($userobj as $user){
				$data2 = array();
				$data2['id'] = $user->id;
				$data2['user_id'] = $user->user_id;
				$data2['code'] = $user->code;
				$data[] = $data2;
			}
        }
		
		return $data;
	}
	
	function fetchworkoutsembed($id){
		$data = array();
		
		$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
		$this->db->from('workouts');
		$this->db->where('id', $id); 
		$query = $this->db->get();
		
		
		if($query->num_rows() > 0) {
          // Got some rows, return as assoc array
            $userobj = $query->result();
			foreach($userobj as $user){
				$data2 = array();
				$data2['id'] = $user->id;
				$data2['line'] = $user->line;
				$data2['code'] = $user->code;
				$data2['title'] = $user->title;
				$data2['description'] = $user->description;
				$data[] = $data2;
			}
        }
		
		return $data;
	}
	
	function selectworkouts()
	{
		$this->db->select('workouts.*');
		$this->db->from('workouts');
		$this->db->order_by('workouts.id', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	
	function selectvideos()
	{
		$this->db->select('workouts_videos.*,users.first_name,users.last_name');

		$this->db->from('workouts_videos');
		$this->db->join('users', 'users.id = workouts_videos.user_id','left');
		$this->db->order_by('workouts_videos.id', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	
	function usersfetchrules($patientid)
	{
		$this->db->select('workout_rules.*');
		$this->db->from('workout_rules');
		$this->db->join('users', 'users.parentid = workout_rules.user_id','left');
		
		$this->db->where('users.patientid', $patientid);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	
	function insertvideos($data)
	{
		$this->db->insert('workouts_videos', $data);
	}
	
	function insertassignworkouts($data)
	{
		$this->db->insert('assign_workouts', $data);
	}
	
	function updateassignworkouts($patientid, $date, $data)
	{
		$this->db->where('patient_id', $patientid);
		$this->db->where('assessment_date', $date);
        $result = $this->db->update('assign_workouts', $data);
		
		 if($result){
            return $patientid;
        } else {
            return false;
        }
	}
	
	function editworkouts($id, $data) {
        $this->db->where('id', $id);
        $result = $this->db->update('workouts', $data);
      
        // Return
        if($result){
            return $id;
        } else {
            return false;
        }
    }
	
	function insertworkouts($data)
	{
		$this->db->insert('workouts', $data);
	}
	
	function deleteworkouts($id) {
        $this->db->where('id', $id);
        $this->db->delete('workouts'); 
    }
	
	function fetchuser(){
		$data = array();
		
		$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
		$this->db->from('users');
		$query = $this->db->get();
		
		
		if($query->num_rows() > 0) {
          // Got some rows, return as assoc array
            $userobj = $query->result();
			foreach($userobj as $user){
				if($user->patientid !="")
				{	$data2 = array();
					$data2['id'] = $user->id;
					$data2['username'] = $user->first_name." ".$user->last_name;
					$data2['patientid'] = $user->patientid;
					$data[] = $data2;
				}
			}
        }
		
		return $data;
	}
	
	function users_request($data) {
        // Run query to insert blank row

        $this->db->insert('users_request', $data);
        // Get id of inserted record
        $id = $this->db->insert_id();
                
        return $this->db->affected_rows();
    }

    function Edit($id, $data) {
        $this->db->where('id', $id);
        $result = $this->db->update('users', $data);
        
        
        // Return
        if($result){
            return $id;
        } else {
            return false;
        }
    }
	
	function usersEdit($id, $data) {
        $this->db->where('patientid', $id);
        $result = $this->db->update('users', $data);
        
        // Return
        if($result){
            return $id;
        } else {
            return false;
        }
    }
	
    function Delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('users'); 
    }
	
	function deletevideos($id) {
        $this->db->where('id', $id);
        $this->db->delete('workouts_videos'); 
    }
	
    function ValidateLogin($credentials) {
        $this->db->select('*', FALSE);
        $this->db->from('users');
        $this->db->where('username', $this->db->escape_str($credentials['username'])); 
		$this->db->or_where('user_email', $this->db->escape_str($credentials['username'])); 
        $query = $this->db->get();
		$credentials['password'] = $this->db->escape_str($credentials['password']);
        $data["records"] = array();
        if($query->num_rows() == 1) {
            $data["records"] = $query->result();
			$recoverpw = $this->decryptData($data['records'][0]->password, $data['records'][0]->ivv_code);
            if($recoverpw != $credentials['password']) {
                $data["records"] = array();
            }
        }
        return $data;
    }
    function ValidateEmail($credentials) {
        $this->db->select('*', FALSE);
        $this->db->from('users');
        $this->db->where('user_email', $credentials['user_email']); 
        $query = $this->db->get();
        $data["records"] = array();
        if($query->num_rows() == 1) {
            $data["records"] = $query->row();
            
        }
        return $data;
    }
	
	function encryptData($str,$ivv)
	{	
		$salt = PASSWORD_SALT;
		$encrypt_method = "AES-256-CBC";
		$secret_key = $salt;
		$secret_iv = $ivv;
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$output = openssl_encrypt($str, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
		return $output;
	}	

	function decryptData($str,$ivv)
	{
		$salt = PASSWORD_SALT;
		$encrypt_method = "AES-256-CBC";
		$secret_key = $salt;
		$secret_iv = $ivv;
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$output = openssl_decrypt(base64_decode($str), $encrypt_method, $key, 0, $iv);
		return $output;
	}
	
	function fetchuserdetails($patient_id){
		$this->db->select('*', FALSE);
        $this->db->from('users');
        $this->db->where('patientid', $patient_id); 
        $query = $this->db->get();
        $data = array();
        if($query->num_rows() == 1) {
            $data[] = $query->row();
        }
        return $data;
	}
	
	function signupnewuser($patient_id, $username, $email, $profilepic, $fname, $lname){
		$this->load->helper('string');
		$ivv_code = random_string('alnum', 8);
		$rand_password_code = random_string('numeric', 6);
		
		$data = array();
		$data['first_name'] = $fname;
		$data['last_name'] = $lname;
		$data['username'] = $username;
		$data['user_email'] = $email;
		$data['patientid'] = $patient_id;
		$data['ivv_code'] = $ivv_code;
		$data['profile_pic'] = $profilepic;
		$data['password'] = $this->encryptData("Password123!",$ivv_code);
		$data['reset_password_code'] = $rand_password_code;
		
		$usr_id = $this->Add($data);
		$link = base_url() . "login/create_password?user_id=" . $usr_id."&token=". $rand_password_code;
		
		// $to_email = 'phil@foundersapproach.com';
		$to_email = $email;
		$subject = 'Welcome to the Baseline Motion Portal!';
		$message = '<p style="padding:20px; margin-bottom:30px; text-align:center; background:black; "><img style="max-width:300px; width:100%;" src="https://portal.baselinemotion.com/public/images/logo-white.png"></p><p>Hi '.$fname.' '.$lname.',</p><p>Welcome to the Baseline Motion Portal. Here you will be able to see your past assessments, video analysis, overall performance statistics, and corrective workouts to improve your future scores. To access the portal you will need to use your username <b>'.$username.'</b> and a unique password which you can create by clicking the link below.<br/><br/><a href="'.$link.'" target="_blank">'.$link.'</a></p><p>Thanks<br/>The Baseline Motion Team</p>';
		//$headers = 'From: noreply @ company . com';
		$headers = "MIME-Version: 1.0" . "\r\n"; 
		$headers .= 'Cc: derek@baselinemotion.com' . "\r\n";
		$headers .= 'From: Baseline Motion <no-reply@baselinemotion.com>'. "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 

		mail($to_email,$subject,$message,$headers);
		
		//mail('divyesh@foundersapproach.com',$subject,$message,$headers);
		
		return ;
	}
	
	function updateuser($patient_id, $username, $email, $profilepic, $fname, $lname){
		$this->load->helper('string');
		
		$data = array();
		$data['first_name'] = $fname;
		$data['last_name'] = $lname;
		$data['profile_pic'] = $profilepic;
		
		$usr_id = $this->Editusers($patient_id, $data);
		
		return $usr_id;
	}
	
}