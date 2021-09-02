<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Csv_import extends CI_Controller {
 
 public function __construct()
 {
  parent::__construct();
  $this->load->model('csv_import_model');
  $this->load->library('csvimport');
 }

 function index()
 {
	$this->load->view('template/header');
	$this->load->view('csv_import');
	$this->load->view('template/footer');
 }

 function load_data()
 {
  $result = $this->csv_import_model->select();
  $output = '
   <h3 align="center">Imported Scores from CSV File</h3>
        <div class="table-responsive">
         <table id="orig_csv_data" class="table table-bordered table-striped">
          <thead><tr>
           <th>#</th>
           <th>Patient Id</th>
           <th>Date</th>
           <th>Time</th>
           <th>Balance Index</th>
		   <th>Flexibility Index</th>
		   <th>Core Stability Index</th>
		   <th>Dynamic Posture Index</th>
		   <th>Lower Extremity Power Score</th>
		   <th>Functional Asymmetry Index</th>
		   <th>Susceptibility to Injury Index</th>
          </tr></thead><tbody>
  ';
  $count = 0;
  if($result->num_rows() > 0)
  {
   foreach($result->result() as $row)
   {
    $count = $count + 1;
    $output .= '
    <tr>
     <td>'.$count.'</td>
     <td>'.$row->patient_id.'</td>
     <td>'.$row->date.'</td>
     <td>'.$row->time.'</td>
     <td>'.$row->balance_index.'</td>
	 <td>'.$row->flexibility_index.'</td>
	 <td>'.$row->core_stability_index.'</td>
	 <td>'.$row->dynamic_posture_index.'</td>
	 <td>'.$row->lower_extremity_power_score.'</td>
	 <td>'.$row->functional_asymmetry_index.'</td>
	 <td>'.$row->susceptibility_to_injury_index.'</td>
    </tr>
    ';
   }
  }
  else
  {
   $output .= '
   <tr>
       <td colspan="11" align="center">Data not Available</td>
      </tr>
   ';
  }
  $output .= '<tbody></table></div>';
  echo $output;
 }

	function import()
	{
		$file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
		$olddata = $this->csv_import_model->olddatafetch();
		//print_r($olddata);
		$data = array();
		foreach($file_data as $row)
		{
			//print_r($row);
			$first = reset($row);
			
			if(isset($first) && $first!=""){
				$str = $first ."---". $row["Date"];
				//echo 'here1'.$str;
				if (!in_array($str, $olddata)){
					$data[] = array(
						'patient_id' => $first,
						'date' => $row["Date"],
						'time' => $row["Time"],
						'balance_index' => $row["Balance Index"],
						'flexibility_index' => $row["Flexibility Index"],
						'core_stability_index' => $row["Core Stability Index"],
						'dynamic_posture_index' => $row["Dynamic Posture Index"],
						'lower_extremity_power_score' => $row["Lower Extremity Power Score"],
						'functional_asymmetry_index' => $row["Functional Asymmetry Index"],
						'susceptibility_to_injury_index' => $row["Susceptibility to Injury Index"]
					);
				}
			}
			
		}
		
		//print_r($data);
		if(sizeof($data)>0)
			$this->csv_import_model->insert($data);
	} 
}