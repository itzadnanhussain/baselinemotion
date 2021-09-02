<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Workoutobject extends MY_Controller {
	
	public function index()
	{
		$data = array();
		$curl = curl_init();
		$token = $this->session->get_userdata()['authtoken'];
		$patientid = '9d0885e0629249109e3b3d4d5b9c3145';
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/api/GetPatientAssessments?patientId=".$patientid,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"x-zumo-auth: ".$token,
				"zumo-api-version: 2.0.0"
			),
		));

		$response = curl_exec($curl);
		/*print_r($response);
		exit;*/
		$data['res'] = json_decode($response);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$data['status'] = 0;
			$data['error'] = $err;
		} else {
			$data['status'] = 1;
		}

		$this->load->view('template/header');
		$this->load->view('workoutobject/rowanhanby',$data);
		$this->load->view('template/footer');
	}
	
	public function rowanhanby()
	{
		$data = array();
		$curl = curl_init();
		$token = $this->session->get_userdata()['authtoken'];
		$patientid = '9d0885e0629249109e3b3d4d5b9c3145';
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/api/GetPatientAssessments?patientId=".$patientid,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"x-zumo-auth: ".$token,
				"zumo-api-version: 2.0.0"
			),
		));

		$response = curl_exec($curl);
		/*print_r($response);
		exit;*/
		$data['res'] = json_decode($response);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$data['status'] = 0;
			$data['error'] = $err;
		} else {
			$data['status'] = 1;
		}

		$this->load->view('template/header');
		$this->load->view('workoutobject/rowanhanby',$data);
		$this->load->view('template/footer');
	}
	
	public function aleclehtman()
	{
		$data = array();
		$curl = curl_init();
		$token = $this->session->get_userdata()['authtoken'];
		$patientid = 'c3b2f710bfbe4bdeb0c62356e6921066';
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/api/GetPatientAssessments?patientId=".$patientid,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"x-zumo-auth: ".$token,
				"zumo-api-version: 2.0.0"
			),
		));

		$response = curl_exec($curl);
		/*print_r($response);
		exit;*/
		$data['res'] = json_decode($response);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$data['status'] = 0;
			$data['error'] = $err;
		} else {
			$data['status'] = 1;
		}

		$this->load->view('template/header');
		$this->load->view('workoutobject/aleclehtman',$data);
		$this->load->view('template/footer');
	}
	
	public function thomashanby()
	{
		$data = array();
		$curl = curl_init();
		$token = $this->session->get_userdata()['authtoken'];
		$patientid = '744f48b0424845bc9958633fe084d244';
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/api/GetPatientAssessments?patientId=".$patientid,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"x-zumo-auth: ".$token,
				"zumo-api-version: 2.0.0"
			),
		));

		$response = curl_exec($curl);
		/*print_r($response);
		exit;*/
		$data['res'] = json_decode($response);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$data['status'] = 0;
			$data['error'] = $err;
		} else {
			$data['status'] = 1;
		}

		$this->load->view('template/header');
		$this->load->view('workoutobject/thomashanby',$data);
		$this->load->view('template/footer');
	}
	
	public function gradygarraffa()
	{
		$data = array();
		$curl = curl_init();
		$token = $this->session->get_userdata()['authtoken'];
		$patientid = '30be811dd74b484fa8fa2f8d8c7919e0';
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/api/GetPatientAssessments?patientId=".$patientid,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"x-zumo-auth: ".$token,
				"zumo-api-version: 2.0.0"
			),
		));

		$response = curl_exec($curl);
		/*print_r($response);
		exit;*/
		$data['res'] = json_decode($response);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$data['status'] = 0;
			$data['error'] = $err;
		} else {
			$data['status'] = 1;
		}

		$this->load->view('template/header');
		$this->load->view('workoutobject/gradygarraffa',$data);
		$this->load->view('template/footer');
	}
	
	public function jacklawrence()
	{
		$data = array();
		$curl = curl_init();
		$token = $this->session->get_userdata()['authtoken'];
		$patientid = 'f17d004ab3c14803959f3c5a78e2ae34';
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/api/GetPatientAssessments?patientId=".$patientid,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"x-zumo-auth: ".$token,
				"zumo-api-version: 2.0.0"
			),
		));

		$response = curl_exec($curl);
		/*print_r($response);
		exit;*/
		$data['res'] = json_decode($response);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$data['status'] = 0;
			$data['error'] = $err;
		} else {
			$data['status'] = 1;
		}

		$this->load->view('template/header');
		$this->load->view('workoutobject/jacklawrence',$data);
		$this->load->view('template/footer');
	}
	
}