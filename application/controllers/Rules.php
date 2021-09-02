<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rules extends CI_Controller {
 
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index()
	{
		$this->load->model('user_model');
		$data = array();
		$data["paramname"] = $this->user_model->fetchparams("KAMS");
		$data["signlist"] = $this->user_model->fetchsigns();
		
		if( isset($_REQUEST['id']) && $_REQUEST['id']!="" ) {
			$data["videosembed"] = $this->user_model->fetchkams($_REQUEST['id']);
		}
		
		$this->load->view('template/header');
		$this->load->view('rules/kams', $data);
		$this->load->view('template/footer');
	}
	
	public function load_functional()
	{
		$this->load->model('user_model');
		$result = $this->user_model->selectPostureRules();
		$output = '<h3 align="center">Functional Rules</h3>
				<div class="table-responsive">
					<table id="orig_videos_data" class="table table-bordered table-striped">
						<thead><tr>
						   <th>Sr. No</th>
						   <th>Rules Name</th>
						   <th>Parameter Name</th>
						   <th>Rules Sign</th>
						   <th>Rules Value</th>
						   <th>Select Line</th>
						   <th>Created Date</th>
						   <th>Status</th>
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
				
				$sel = "";
				if($row->status == 1)
					$sel = "checked";
				
				
				$output .= '
					<tr>
						<td>'.$count.'</td>
						<td>'.$row->name.'</td>
						<td>'.$row->param_label.'</td>
						<td>'.$row->param_sign.'</td>
						<td>'.$row->param_value.'</td>
						<td>'.$line.'</td>
						<td><span id="timeupd'.$count.'" class="date"></span></td>
						<td><label class="switch"><input class="switchstatus" frmid="'.$row->id.'" type="checkbox" '.$sel.'><span class="slider round"></span></label></td>
						<td><a href="'.base_url().'rules/functional?id='.$row->id.'">Edit</a> <a href="javascript:deletefunctional(\''.$row->id.'\');">Delete</a></td>
					</tr>';
				$output .= '<script>var strDateTime'.$count.' = "'.$rr888.' GMT"; var myDate'.$count.' = new Date(strDateTime'.$count.'); var str11'.$count.' = myDate'.$count.'.toLocaleString(); var str_array'.$count.' = str11'.$count.'.split(\', \'); jQuery(document).ready(function(){ var t'.$count.' = str_array'.$count.'[1]; var end'.$count.' = t'.$count.'.indexOf(" "); var st11'.$count.' = t'.$count.'.lastIndexOf(":"); var res125'.$count.' = t'.$count.'.substring(st11'.$count.', end'.$count.'); var res11'.$count.' = t'.$count.'.replace(res125'.$count.', ""); var r1'.$count.' = str11'.$count.'.replace(",", ""); jQuery("#timeupd'.$count.'").html(r1'.$count.'); }); </script>';
			}
		}
	  $output .= '</tbody></table></div>';
	  echo $output;
	}
	
	public function load_posture()
	{
		$this->load->model('user_model');
		$result = $this->user_model->selectPostureRules();
		$output = '<h3 align="center">Posture Rules</h3>
				<div class="table-responsive">
					<table id="orig_videos_data" class="table table-bordered table-striped">
						<thead><tr>
						   <th>Sr. No</th>
						   <th>Rules Name</th>
						   <th>Parameter Name</th>
						   <th>Rules Sign</th>
						   <th>Rules Value</th>
						   <th>Select Line</th>
						   <th>Created Date</th>
						   <th>Status</th>
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
				
				$sel = "";
				if($row->status == 1)
					$sel = "checked";
				
				
				$output .= '
					<tr>
						<td>'.$count.'</td>
						<td>'.$row->name.'</td>
						<td>'.$row->param_label.'</td>
						<td>'.$row->param_sign.'</td>
						<td>'.$row->param_value.'</td>
						<td>'.$line.'</td>
						<td><span id="timeupd'.$count.'" class="date"></span></td>
						<td><label class="switch"><input class="switchstatus" frmid="'.$row->id.'" type="checkbox" '.$sel.'><span class="slider round"></span></label></td>
						<td><a href="'.base_url().'rules/posture?id='.$row->id.'">Edit</a> <a href="javascript:deleteposture(\''.$row->id.'\');">Delete</a></td>
					</tr>';
				$output .= '<script>var strDateTime'.$count.' = "'.$rr888.' GMT"; var myDate'.$count.' = new Date(strDateTime'.$count.'); var str11'.$count.' = myDate'.$count.'.toLocaleString(); var str_array'.$count.' = str11'.$count.'.split(\', \'); jQuery(document).ready(function(){ var t'.$count.' = str_array'.$count.'[1]; var end'.$count.' = t'.$count.'.indexOf(" "); var st11'.$count.' = t'.$count.'.lastIndexOf(":"); var res125'.$count.' = t'.$count.'.substring(st11'.$count.', end'.$count.'); var res11'.$count.' = t'.$count.'.replace(res125'.$count.', ""); var r1'.$count.' = str11'.$count.'.replace(",", ""); jQuery("#timeupd'.$count.'").html(r1'.$count.'); }); </script>';
			}
		}
	  $output .= '</tbody></table></div>';
	  echo $output;
	}
	
	public function load_wallangel()
	{
		$this->load->model('user_model');
		$result = $this->user_model->selectWallangelRules();
		$output = '<h3 align="center">Posture Angel Rules</h3>
				<div class="table-responsive">
					<table id="orig_videos_data" class="table table-bordered table-striped">
						<thead><tr>
						   <th>Sr. No</th>
						   <th>Rules Name</th>
						   <th>Parameter Name</th>
						   <th>Rules Sign</th>
						   <th>Rules Value</th>
						   <th>Select Line</th>
						   <th>Created Date</th>
						   <th>Status</th>
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
				
				$sel = "";
				if($row->status == 1)
					$sel = "checked";
				
				
				$output .= '
					<tr>
						<td>'.$count.'</td>
						<td>'.$row->name.'</td>
						<td>'.$row->param_label.'</td>
						<td>'.$row->param_sign.'</td>
						<td>'.$row->param_value.'</td>
						<td>'.$line.'</td>
						<td><span id="timeupd'.$count.'" class="date"></span></td>
						<td><label class="switch"><input class="switchstatus" frmid="'.$row->id.'" type="checkbox" '.$sel.'><span class="slider round"></span></label></td>
						<td><a href="'.base_url().'rules/wallangel?id='.$row->id.'">Edit</a> <a href="javascript:deletewallangel(\''.$row->id.'\');">Delete</a></td>
					</tr>';
				$output .= '<script>var strDateTime'.$count.' = "'.$rr888.' GMT"; var myDate'.$count.' = new Date(strDateTime'.$count.'); var str11'.$count.' = myDate'.$count.'.toLocaleString(); var str_array'.$count.' = str11'.$count.'.split(\', \'); jQuery(document).ready(function(){ var t'.$count.' = str_array'.$count.'[1]; var end'.$count.' = t'.$count.'.indexOf(" "); var st11'.$count.' = t'.$count.'.lastIndexOf(":"); var res125'.$count.' = t'.$count.'.substring(st11'.$count.', end'.$count.'); var res11'.$count.' = t'.$count.'.replace(res125'.$count.', ""); var r1'.$count.' = str11'.$count.'.replace(",", ""); jQuery("#timeupd'.$count.'").html(r1'.$count.'); }); </script>';
			}
		}
	  $output .= '</tbody></table></div>';
	  echo $output;
	}
	
	public function load_overhead()
	{
		$this->load->model('user_model');
		$result = $this->user_model->selectOverheadRules();
		$output = '<h3 align="center">Overhead Rules</h3>
				<div class="table-responsive">
					<table id="orig_videos_data" class="table table-bordered table-striped">
						<thead><tr>
						   <th>Sr. No</th>
						   <th>Rules Name</th>
						   <th>Parameter Name</th>
						   <th>Rules Sign</th>
						   <th>Rules Value</th>
						   <th>Select Line</th>
						   <th>Created Date</th>
						   <th>Status</th>
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
				
				$sel = "";
				if($row->status == 1)
					$sel = "checked";
				
				
				$output .= '
					<tr>
						<td>'.$count.'</td>
						<td>'.$row->name.'</td>
						<td>'.$row->param_label.'</td>
						<td>'.$row->param_sign.'</td>
						<td>'.$row->param_value.'</td>
						<td>'.$line.'</td>
						<td><span id="timeupd'.$count.'" class="date"></span></td>
						<td><label class="switch"><input class="switchstatus" frmid="'.$row->id.'" type="checkbox" '.$sel.'><span class="slider round"></span></label></td>
						<td><a href="'.base_url().'rules/overhead?id='.$row->id.'">Edit</a> <a href="javascript:deleteoverhead(\''.$row->id.'\');">Delete</a></td>
					</tr>';
				$output .= '<script>var strDateTime'.$count.' = "'.$rr888.' GMT"; var myDate'.$count.' = new Date(strDateTime'.$count.'); var str11'.$count.' = myDate'.$count.'.toLocaleString(); var str_array'.$count.' = str11'.$count.'.split(\', \'); jQuery(document).ready(function(){ var t'.$count.' = str_array'.$count.'[1]; var end'.$count.' = t'.$count.'.indexOf(" "); var st11'.$count.' = t'.$count.'.lastIndexOf(":"); var res125'.$count.' = t'.$count.'.substring(st11'.$count.', end'.$count.'); var res11'.$count.' = t'.$count.'.replace(res125'.$count.', ""); var r1'.$count.' = str11'.$count.'.replace(",", ""); jQuery("#timeupd'.$count.'").html(r1'.$count.'); }); </script>';
			}
		}
	  $output .= '</tbody></table></div>';
	  echo $output;
	}
	
	public function load_rom()
	{
		$this->load->model('user_model');
		$result = $this->user_model->selectROMRules();
		$output = '<h3 align="center">ROM Rules</h3>
				<div class="table-responsive">
					<table id="orig_videos_data" class="table table-bordered table-striped">
						<thead><tr>
						   <th>Sr. No</th>
						   <th>Rules Name</th>
						   <th>Parameter Name</th>
						   <th>Rules Sign</th>
						   <th>Rules Value</th>
						   <th>Select Line</th>
						   <th>Created Date</th>
						   <th>Status</th>
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
				
				$sel = "";
				if($row->status == 1)
					$sel = "checked";
				
				$output .= '
					<tr>
						<td>'.$count.'</td>
						<td>'.$row->name.'</td>
						<td>'.$row->param_label.'</td>
						<td>'.$row->param_sign.'</td>
						<td>'.$row->param_value.'</td>
						<td>'.$line.'</td>
						<td><span id="timeupd'.$count.'" class="date"></span></td>
						<td><label class="switch"><input class="switchstatus" frmid="'.$row->id.'" type="checkbox" '.$sel.'><span class="slider round"></span></label></td>
						<td><a href="'.base_url().'rules/rom?id='.$row->id.'">Edit</a> <a href="javascript:deleterom(\''.$row->id.'\');">Delete</a></td>
					</tr>';
				$output .= '<script>var strDateTime'.$count.' = "'.$rr888.' GMT"; var myDate'.$count.' = new Date(strDateTime'.$count.'); var str11'.$count.' = myDate'.$count.'.toLocaleString(); var str_array'.$count.' = str11'.$count.'.split(\', \'); jQuery(document).ready(function(){ var t'.$count.' = str_array'.$count.'[1]; var end'.$count.' = t'.$count.'.indexOf(" "); var st11'.$count.' = t'.$count.'.lastIndexOf(":"); var res125'.$count.' = t'.$count.'.substring(st11'.$count.', end'.$count.'); var res11'.$count.' = t'.$count.'.replace(res125'.$count.', ""); var r1'.$count.' = str11'.$count.'.replace(",", ""); jQuery("#timeupd'.$count.'").html(r1'.$count.'); }); </script>';
			}
		}
	  $output .= '</tbody></table></div>';
	  echo $output;
	}
	
	public function load_kams()
	{
		$this->load->model('user_model');
		$result = $this->user_model->selectKAMSRules();
		$output = '<h3 align="center">KAMS Rules</h3>
				<div class="table-responsive">
					<table id="orig_videos_data" class="table table-bordered table-striped">
						<thead><tr>
						   <th>Sr. No</th>
						   <th>Rules Name</th>
						   <th>Parameter Name</th>
						   <th>Rules Sign</th>
						   <th>Rules Value</th>
						   <th>Select Line</th>
						   <th>Created Date</th>
						   <th>Status</th>
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
				
				$sel = "";
				if($row->status == 1)
					$sel = "checked";
				
				$output .= '
					<tr>
						<td>'.$count.'</td>
						<td>'.$row->name.'</td>
						<td>'.$row->param_label.'</td>
						<td>'.$row->param_sign.'</td>
						<td>'.$row->param_value.'</td>
						<td>'.$line.'</td>
						<td><span id="timeupd'.$count.'" class="date"></span></td>
						<td><label class="switch"><input class="switchstatus" frmid="'.$row->id.'" type="checkbox" '.$sel.'><span class="slider round"></span></label></td>
						<td><a href="'.base_url().'rules/kams?id='.$row->id.'">Edit</a> <a href="javascript:deletekams(\''.$row->id.'\');">Delete</a></td>
					</tr>';
				$output .= '<script>var strDateTime'.$count.' = "'.$rr888.' GMT"; var myDate'.$count.' = new Date(strDateTime'.$count.'); var str11'.$count.' = myDate'.$count.'.toLocaleString(); var str_array'.$count.' = str11'.$count.'.split(\', \'); jQuery(document).ready(function(){ var t'.$count.' = str_array'.$count.'[1]; var end'.$count.' = t'.$count.'.indexOf(" "); var st11'.$count.' = t'.$count.'.lastIndexOf(":"); var res125'.$count.' = t'.$count.'.substring(st11'.$count.', end'.$count.'); var res11'.$count.' = t'.$count.'.replace(res125'.$count.', ""); var r1'.$count.' = str11'.$count.'.replace(",", ""); jQuery("#timeupd'.$count.'").html(r1'.$count.'); }); </script>';
			}
		}
	  $output .= '</tbody></table></div>';
	  echo $output;
	}
	
	public function load_reverselunge()
	{
		$this->load->model('user_model');
		$result = $this->user_model->selectKAMSRules();
		$output = '<h3 align="center">Reverse Lunge Rules</h3>
				<div class="table-responsive">
					<table id="orig_videos_data" class="table table-bordered table-striped">
						<thead><tr>
						   <th>Sr. No</th>
						   <th>Rules Name</th>
						   <th>Parameter Name</th>
						   <th>Rules Sign</th>
						   <th>Rules Value</th>
						   <th>Select Line</th>
						   <th>Created Date</th>
						   <th>Status</th>
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
				
				$sel = "";
				if($row->status == 1)
					$sel = "checked";
				
				$output .= '
					<tr>
						<td>'.$count.'</td>
						<td>'.$row->name.'</td>
						<td>'.$row->param_label.'</td>
						<td>'.$row->param_sign.'</td>
						<td>'.$row->param_value.'</td>
						<td>'.$line.'</td>
						<td><span id="timeupd'.$count.'" class="date"></span></td>
						<td><label class="switch"><input class="switchstatus" frmid="'.$row->id.'" type="checkbox" '.$sel.'><span class="slider round"></span></label></td>
						<td><a href="'.base_url().'rules/reverselunge?id='.$row->id.'">Edit</a> <a href="javascript:deletereverselunge(\''.$row->id.'\');">Delete</a></td>
					</tr>';
				$output .= '<script>var strDateTime'.$count.' = "'.$rr888.' GMT"; var myDate'.$count.' = new Date(strDateTime'.$count.'); var str11'.$count.' = myDate'.$count.'.toLocaleString(); var str_array'.$count.' = str11'.$count.'.split(\', \'); jQuery(document).ready(function(){ var t'.$count.' = str_array'.$count.'[1]; var end'.$count.' = t'.$count.'.indexOf(" "); var st11'.$count.' = t'.$count.'.lastIndexOf(":"); var res125'.$count.' = t'.$count.'.substring(st11'.$count.', end'.$count.'); var res11'.$count.' = t'.$count.'.replace(res125'.$count.', ""); var r1'.$count.' = str11'.$count.'.replace(",", ""); jQuery("#timeupd'.$count.'").html(r1'.$count.'); }); </script>';
			}
		}
	  $output .= '</tbody></table></div>';
	  echo $output;
	}
	
	public function addkamsrules()
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
					'name' => $_REQUEST['name'],
					'param_name' => $_REQUEST['param_name'],
					'line' => $_REQUEST['line'],
					'param_sign'  => $_REQUEST['param_sign'],
					'param_value'  => $_REQUEST['param_value'],
					'rules_type'  => $_REQUEST['rules_type'],
					'user_id' => $this->session->get_userdata()['user_id']
				);
				
				$this->user_model->editrules($_REQUEST['id'], $data);
			} else {
				$data = array(
					'name' => $_REQUEST['name'],
					'param_name' => $_REQUEST['param_name'],
					'param_sign'  => $_REQUEST['param_sign'],
					'param_value'  => $_REQUEST['param_value'],
					'rules_type'  => $_REQUEST['rules_type'],
					'line' => $_REQUEST['line'],
					'user_id' => 1
				);
				
				//print_r($data);
				$this->user_model->insertrules($data);
			}
		}
	}
	
	public function overhead()
	{
		$this->load->model('user_model');
		$data = array();
		
		if( isset($_REQUEST['id']) && $_REQUEST['id']!="" ) {
			$data["videosembed"] = $this->user_model->fetchkams($_REQUEST['id']);
		}
		
		$user_id = $this->session->get_userdata()['user_id'];
		$data["paramname"] = $this->user_model->fetchparams("Overhead");
		$data["signlist"] = $this->user_model->fetchsigns();
		
		$this->load->view('template/header');
		$this->load->view('rules/overhead', $data);
		$this->load->view('template/footer');
	}
	
	public function reverselunge()
	{
		$this->load->model('user_model');
		$data = array();
		
		if( isset($_REQUEST['id']) && $_REQUEST['id']!="" ) {
			$data["videosembed"] = $this->user_model->fetchkams($_REQUEST['id']);
		}
		
		$user_id = $this->session->get_userdata()['user_id'];
		$data["paramname"] = $this->user_model->fetchparams("KAMS");
		$data["signlist"] = $this->user_model->fetchsigns();
		
		$this->load->view('template/header');
		$this->load->view('rules/reverselunge', $data);
		$this->load->view('template/footer');
	}
	
	public function wallangel()
	{
		$this->load->model('user_model');
		$data = array();
		
		if( isset($_REQUEST['id']) && $_REQUEST['id']!="" ) {
			$data["videosembed"] = $this->user_model->fetchkams($_REQUEST['id']);
		}
		
		$user_id = $this->session->get_userdata()['user_id'];
		$data["paramname"] = $this->user_model->fetchparams("WallAngel");
		$data["signlist"] = $this->user_model->fetchsigns();
		
		$this->load->view('template/header');
		$this->load->view('rules/wallangel', $data);
		$this->load->view('template/footer');
	}
	
	public function rom()
	{
		$this->load->model('user_model');
		$data = array();
		
		if( isset($_REQUEST['id']) && $_REQUEST['id']!="" ) {
			$data["videosembed"] = $this->user_model->fetchkams($_REQUEST['id']);
		}
		
		$user_id = $this->session->get_userdata()['user_id'];
		$data["paramname"] = $this->user_model->fetchparams("ROM");
		$data["signlist"] = $this->user_model->fetchsigns();
		
		$this->load->view('template/header');
		$this->load->view('rules/rom', $data);
		$this->load->view('template/footer');
	}
	
	public function kams()
	{
		$this->load->model('user_model');
		$data = array();
		
		if( isset($_REQUEST['id']) && $_REQUEST['id']!="" ) {
			$data["videosembed"] = $this->user_model->fetchkams($_REQUEST['id']);
		}
		
		
		$user_id = $this->session->get_userdata()['user_id'];
		$data["paramname"] = $this->user_model->fetchparams("KAMS");
		$data["signlist"] = $this->user_model->fetchsigns();
		
		$this->load->view('template/header');
		$this->load->view('rules/kams', $data);
		$this->load->view('template/footer');
	}
	
	public function functional()
	{
		$this->load->model('user_model');
		$data = array();
		$user_id = $this->session->get_userdata()['user_id'];
		
		if( isset($_REQUEST['id']) && $_REQUEST['id']!="" ) {
			$data["videosembed"] = $this->user_model->fetchkams($_REQUEST['id']);
		}
		
		$data["paramname"] = $this->user_model->fetchparams("Posture");
		$data["signlist"] = $this->user_model->fetchsigns();
		
		$this->load->view('template/header');
		$this->load->view('rules/functional', $data);
		$this->load->view('template/footer');
	}
	
	public function posture()
	{
		$this->load->model('user_model');
		$data = array();
		$user_id = $this->session->get_userdata()['user_id'];
		
		if( isset($_REQUEST['id']) && $_REQUEST['id']!="" ) {
			$data["videosembed"] = $this->user_model->fetchkams($_REQUEST['id']);
		}
		
		$data["paramname"] = $this->user_model->fetchparams("Posture");
		$data["signlist"] = $this->user_model->fetchsigns();
		
		$this->load->view('template/header');
		$this->load->view('rules/posture', $data);
		$this->load->view('template/footer');
	}
	
	public function load_data()
	{
		$this->load->model('user_model');
		$result = $this->user_model->selectvideos();
		$output = '<h3 align="center">Assigned Videos</h3>
				<div class="table-responsive">
					<table id="orig_videos_data" class="table table-bordered table-striped">
						<thead><tr>
						   <th>Sr. No</th>
						   <th>User</th>
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
				$output .= '
					<tr>
						<td>'.$count.'</td>
						<td>'.$row->first_name.' '.$row->last_name.'</td>
						<td>'.$row->code.'</td>
						<td>'.$createdate.'</td>
						<td><a href="'.base_url().'workout_videos?id='.$row->id.'">Edit</a> <a href="javascript:deleteData(\''.$row->id.'\');">Delete</a></td>
					</tr>
					';
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
	
	public function import()
	{
		$this->load->model('user_model');
		//print_r($_REQUEST);
		if(isset($_REQUEST['user_id']) && sizeof($_REQUEST['user_id'])>0){
			foreach($_REQUEST['user_id'] as $userid){
				if(isset($_REQUEST['id']))
					$this->user_model->deletevideos($_REQUEST['id']);
				
				$data = array(
					'user_id' => $userid,
					'code'  => $_REQUEST['code'],
					'status'   => 1
				);
				$this->user_model->insertvideos($data);
			}
		}
	} 
	
	public function updaterules(){
		$this->load->model('user_model');
		if(isset($_REQUEST['id']) && $_REQUEST['id']!=""){
			$data = array(
				'user_id' => $_REQUEST['id'],
				'status'  => $_REQUEST['status']
			);
			$this->user_model->editrules($_REQUEST['id'], $data);
			echo "success";
		}
		else{
			echo "failed";
		}
	}
	
	public function deleterules(){
		if(isset($_REQUEST['id']) && $_REQUEST['id']!=""){
			$this->db->where('id', $_REQUEST['id']);
			$this->db->delete('workout_rules');
		}
	}
}