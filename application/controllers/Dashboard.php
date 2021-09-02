<?php
defined('BASEPATH') or exit('No direct script access allowed'); 
class Dashboard extends MY_Controller
{
	///Dashboard Page
	public function index()
	{
	 
		$this->load->model('kinetisense_model');
		$data = array();
		$token = $this->session->get_userdata()['authtoken'];

		
	
	 
		 
		// echo '<pre>';
		// print_r($token);
		// echo '</pre>';
		// die;
		$patientid = $this->session->get_userdata()['patientid'];  
		 
		 
	 
		$fetchobj = $this->session->get_userdata()['fetchobj']; 
		 

		 

		///Get Data Of User By API
		if ($fetchobj) { 
			 
			$str = GetFileContents($patientid);  
			 
			if ($str == 0) {
				$data['res'] = GetPatientAssessments($token, $patientid);
			} else {
				$data['res'] = $str; 
			}
		} else {
			$data['res'] = GetPatientAssessments($token, $patientid);
		}

		///Get Data Of User By Database
		$data['indexKAMS'] = $this->kinetisense_model->getscores($patientid);

		$this->load->view('template/header');
		$this->load->view('dashboard/dashboard', $data);

		//$this->load->view('template/footer');
	}

	///Assessments Page
	public function assessments()
	{
		$data = array();
		$token = $this->session->get_userdata()['authtoken'];
		$patientid = $this->session->get_userdata()['patientid'];
		$fetchobj = $this->session->get_userdata()['fetchobj'];

		///Get Data Of User By API
		if ($fetchobj) {
			$str = GetFileContents($patientid);
			if ($str == 0) {
				$data['res'] = GetPatientAssessments($token, $patientid);
			} else {
				$data['res'] = $str;
			}
		} else {
			$data['res'] = GetPatientAssessments($token, $patientid);
		}
		///Get practitioner Data
		$data['practitioner'] = GetPractitioner($token);

		///GetClinic Data
		$data['clinic'] = GetClinic($token);

		$this->load->view('template/header');
		$this->load->view('dashboard/assessments', $data);
		//$this->load->view('template/footer');
	}

	///Assessments Workout  Page
	public function assessmentsworkout()
	{
		$data = array();
		$token = $this->session->get_userdata()['authtoken'];
		$patientid = $this->session->get_userdata()['patientid'];
		$fetchobj = $this->session->get_userdata()['fetchobj'];

		///Get Data Of User By API
		if ($fetchobj) {
			$str = GetFileContents($patientid);
			if ($str == 0) {
				$data['res'] = GetPatientAssessments($token, $patientid);
			} else {
				$data['res'] = $str;
			}
		} else {
			$data['res'] = GetPatientAssessments($token, $patientid);
		}

		///Get practitioner Data
		$data['practitioner'] = GetPractitioner($token);

		///GetClinic Data
		$data['clinic'] = GetClinic($token);

		$this->load->view('template/header');
		$this->load->view('dashboard/assessmentsworkout', $data);
		//$this->load->view('template/footer');
	}

	///Assessments Detail Page
	public function detailassessments()
	{
		$data = array();
		$token = $this->session->get_userdata()['authtoken'];
		$patientid = $this->session->get_userdata()['patientid'];
		$this->load->model('kinetisense_model');
		$fetchobj = $this->session->get_userdata()['fetchobj'];

		///Get Data Of User By API
		if ($fetchobj) {
			$str = GetFileContents($patientid);
			if ($str == 0) {
				$data['res'] = GetPatientAssessments($token, $patientid);
			} else {
				$data['res'] = $str;
			}
		} else {
			$data['res'] = GetPatientAssessments($token, $patientid);
		}

		$data['indexKAMS'] = $this->kinetisense_model->getscores($patientid);
		$this->load->view('template/header');
		$this->load->view('dashboard/detailassessments', $data);
	}

	///My Work Out Page
	public function myworkout()
	{
		$data = array();
		$token = $this->session->get_userdata()['authtoken'];
		$patientid = $this->session->get_userdata()['patientid'];
		$this->load->model('user_model');
		$this->load->model('kinetisense_model');
		$fetchobj = $this->session->get_userdata()['fetchobj']; 
		$data['workouts'] = $this->user_model->getworkouts($patientid); 

		///Get Data Of User By API
		if ($fetchobj) {
			$str = GetFileContents($patientid);
			if ($str == 0) {
				$data['res'] = GetPatientAssessments($token, $patientid);
			} else {
				$data['res'] = $str;
			}
		} else {
			$data['res'] = GetPatientAssessments($token, $patientid);
		} 

		$rulesdata = array();
		$workrules = $this->user_model->usersfetchrules($patientid);
		if ($workrules->num_rows() > 0) {
			// Got some rows, return as assoc array
			$workrulesobj = $workrules->result();
			foreach ($workrulesobj as $workrule) {
				if ($workrule->line != "") {
					$nm = str_replace(' ', '', $workrule->name);
					$rulesdata[$nm]['name'] = $workrule->name;
					$rulesdata[$nm]['param_name'] = $workrule->param_name;
					$rulesdata[$nm]['param_sign'] = $workrule->param_sign;
					$rulesdata[$nm]['param_value'] = $workrule->param_value;
					$rulesdata[$nm]['line'] = $workrule->line;
				}
			}
		} 
		$data['rulesdata'] = $rulesdata;
		$data['indexKAMS'] = $this->kinetisense_model->getscores($patientid); 
		$this->load->view('template/header');
		$this->load->view('dashboard/myworkout', $data);
	}

	public function workout()
	{
		$data = array();
		$token = $this->session->get_userdata()['authtoken'];
		$patientid = $this->session->get_userdata()['patientid'];
		$this->load->model('user_model');

		$data['workouts'] = $this->user_model->getworkouts($patientid);

		$this->load->view('template/header');
		$this->load->view('dashboard/workout', $data);
		$this->load->view('template/footer');
	}

	public function workoutsobj()
	{
		$data = array(); 
		 
		$token = $this->session->get_userdata()['authtoken'];
		$patientid = $this->session->get_userdata()['patientid']; 
		$data['res'] = GetPatientAssessments($token, $patientid);
		$this->load->view('template/header');
		$this->load->view('dashboard/workoutsobj', $data);
		$this->load->view('template/footer');
	}
}
