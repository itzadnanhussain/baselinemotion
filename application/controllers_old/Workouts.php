<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Workouts extends CI_Controller {
 
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index()
	{
		$this->load->model('user_model');
		$data = array();
		$data["userlist"] = $this->user_model->fetchuser();
		
		if( isset($_REQUEST['id']) && $_REQUEST['id']!="" ) {
			$data["videosembed"] = $this->user_model->fetchworkoutsembed($_REQUEST['id']);
		}
		
		$this->load->view('template/header');
		$this->load->view('workouts/workouts', $data);
		$this->load->view('template/footer');
	}

	public function load_data()
	{
		$this->load->model('user_model');
		$result = $this->user_model->selectworkouts();
		$output = '<h3 align="center">Workouts Videos</h3>
				<div class="table-responsive">
					<table id="orig_videos_data" class="table table-bordered table-striped">
						<thead><tr>
						   <th>Sr. No</th>
						   <th>Workout Title</th>
						   <th>Workout Description</th>
						   <th>Select Line</th>
						   <th>Embeded Code</th>
						   <th>Created Date</th>
						   <th>Actions</th>
						</tr></thead><tbody>';
		$count = 0;
		if($result->num_rows() > 0)
		{
			foreach($result->result() as $row)
			{
				
				$date = DateTime::createFromFormat('Y-m-d H:i:s', $row->created_date);
				$createdate = $date->format('m-d-Y h:i a');
				
				$count = $count + 1;
				$line = 'Superficial Frontline (SFL)/ Superficial Backline (SBL)';
				if($row->line == 'LL'){
					$line = 'Lateral Line (LL)';
				}else if($row->line == 'SPL'){
					$line = 'Spiral Line (SPL)';
				}else if($row->line == 'SFL'){
					$line = 'Superficial Frontline (SFL)';
				}else if($row->line == 'SBL'){
					$line = 'Superficial Backline (SBL)';
				}
				
				$date45 = DateTime::createFromFormat('Y-m-d H:i:s', $row->created_date);
				$rr888 = $date45->format('D, d M Y H:i:s');
				
				$output .= '
					<tr>
						<td>'.$count.'</td>
						<td>'.$row->title.'</td>
						<td>'.$row->description.'</td>
						<td>'.$line.'</td>
						<td>'.$row->code.'</td>
						<td><span id="timeupd'.$count.'" class="date"></span></td>
						<td><a href="'.base_url().'workouts?id='.$row->id.'">Edit</a> <a href="javascript:deleteDataWorkout(\''.$row->id.'\');">Delete</a></td>
					</tr>';
				$output .= '<script>var strDateTime'.$count.' = "'.$rr888.' GMT"; var myDate'.$count.' = new Date(strDateTime'.$count.'); var str11'.$count.' = myDate'.$count.'.toLocaleString(); var str_array'.$count.' = str11'.$count.'.split(\', \'); jQuery(document).ready(function(){ var t'.$count.' = str_array'.$count.'[1]; var end'.$count.' = t'.$count.'.indexOf(" "); var st11'.$count.' = t'.$count.'.lastIndexOf(":"); var res125'.$count.' = t'.$count.'.substring(st11'.$count.', end'.$count.'); var res11'.$count.' = t'.$count.'.replace(res125'.$count.', ""); var r1'.$count.' = str11'.$count.'.replace(",", ""); jQuery("#timeupd'.$count.'").html(r1'.$count.'); }); </script>';
			}
		}
		/*else
		{
			$output .= '
					<tr>
						<td colspan="4" align="center">Data not Available</td>
					</tr>
				';
		}*/
	  $output .= '</tbody></table></div>';
	  echo $output;
	}
	
	public function addworkouts()
	{
		$this->load->model('user_model');
		//print_r($_REQUEST);
		if(isset($_REQUEST['line']) && $_REQUEST['line']!=""){
			$convert_date = date("Y-m-d H:i:s");
			$tz1 = $_REQUEST['userTimeZone'];
			$updateddate = $this->user_model->zone_conversion_date($convert_date,$tz1,'GMT');
			
			if(isset($_REQUEST['id']) && $_REQUEST['id']!=""){
				$data = array(
					'id' => $_REQUEST['id'],
					'title' => $_REQUEST['title'],
					'description' => $_REQUEST['description'],
					'line' => $_REQUEST['line'],
					'code'  => $_REQUEST['code'],
					'modified_date'  => $updateddate,
					'status'   => 1
				);
				
				$this->user_model->editworkouts($_REQUEST['id'], $data);
			} else {
				$data = array(
					'title' => $_REQUEST['title'],
					'description' => $_REQUEST['description'],
					'line' => $_REQUEST['line'],
					'code'  => $_REQUEST['code'],
					'modified_date'  => $updateddate,
					'status'   => 1
				);
				$this->user_model->insertworkouts($data);
			}
		}
	} 
	
	public function deletevideo(){
		if(isset($_REQUEST['id']) && $_REQUEST['id']!=""){
			$this->db->where('id', $_REQUEST['id']);
			$this->db->delete('workouts');
		}
	}
}