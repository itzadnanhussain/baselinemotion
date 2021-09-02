<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Combine_scores extends CI_Controller
{

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

		if (isset($_REQUEST['id']) && $_REQUEST['id'] != "") {
			$data["videosembed"] = $this->user_model->fetchcombinescoresembed($_REQUEST['id']);
		}

		$this->load->view('template/header');
		$this->load->view('combine_scores/combine_scores', $data);
		$this->load->view('template/footer');
	}

	public function scores()
	{  
		$this->load->model('user_model');
		$data = array();
		$user_id = $this->session->get_userdata()['user_id'];
		if (isset($user_id) && $user_id != "") {
			$data["videoslist"] = $this->user_model->fetchcombinescores($user_id);
		}

		$this->load->view('template/header');
		$this->load->view('combine_scores/scores', $data);
		$this->load->view('template/footer');
	}

	public function load_data()
	{
		$this->load->model('user_model');
		$result = $this->user_model->selectcombinescores();
		$output = '<h3 align="center">Combine Scores</h3>
				<div class="table-responsive">
					<table id="orig_scores_data" class="table table-bordered table-striped">
						<thead><tr>
						   <th>Sr. No</th>
						   <th>User</th>
						   <th>Embeded Code</th>
						   <th>Created Date</th>
						   <th>Actions</th>
						</tr></thead><tbody>';

		$count = 0;

		if ($result->num_rows() > 0) {
			foreach ($result->result() as $row) {

				$date = DateTime::createFromFormat('Y-m-d H:i:s', $row->created_date);
				$createdate = $date->format('m-d-Y h:i a');

				$count = $count + 1;
				$output .= '
					<tr>
						<td>' . $count . '</td>
						<td>' . $row->first_name . ' ' . $row->last_name . '</td>
						<td>' . $row->code . '</td>
						<td>' . $createdate . '</td>
						<td><a href="' . base_url() . 'combine_scores?id=' . $row->id . '">Edit</a> <a href="javascript:deleteCombineData(\'' . $row->id . '\');">Delete</a></td>
					</tr>
					';
			}
		}

		$output .= '</tbody></table></div>';
		echo $output;
	}

	public function import()
	{

		$this->load->model('user_model');
		//print_r($_REQUEST);
		if (isset($_REQUEST['user_id']) && sizeof($_REQUEST['user_id']) > 0) {
			foreach ($_REQUEST['user_id'] as $userid) {
				if (isset($_REQUEST['id']))
					$this->user_model->deletecombinescores($_REQUEST['id']);


				$data = array(
					'user_id' => $userid,
					'code'  => $_REQUEST['code'],
					'status'   => 1
				);
				$this->user_model->insertcombinescores($data);
			}
		}
	}


	public function deletevideo()
	{
		if (isset($_REQUEST['id']) && $_REQUEST['id'] != "") {
			$this->db->where('id', $_REQUEST['id']);
			$this->db->delete('combine_scores');
		}
	}
}
