<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
	public function index()
	{
		$this->load->model('kinetisense_model');

		$data = array();
		$curl = curl_init();
		$token = $this->session->get_userdata()['authtoken'];
		$patientid = $this->session->get_userdata()['patientid'];
		$fetchobj = $this->session->get_userdata()['fetchobj'];

		if ($fetchobj) {

			$str = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/patientjsonobj/' . $patientid . '/results.json');
			$data['res'] = json_decode(json_decode($str));
		} else {
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/api/GetPatientAssessments?patientId=" . $patientid,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"x-zumo-auth: " . $token,
					"zumo-api-version: 2.0.0"
				),
			));

			$response = curl_exec($curl);
			$data['res'] = json_decode($response);
		}
		$data['indexKAMS'] = $this->kinetisense_model->getscores($patientid);

		/*	$curl2 = curl_init();
		curl_setopt_array($curl2, array(
		  CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/tables/Practitioner",
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

		$response2 = curl_exec($curl2);
		$data['practitioner'] = json_decode($response2);
	
		$curl3 = curl_init();
		curl_setopt_array($curl3, array(
		  CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/tables/Clinic",
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

		$response3 = curl_exec($curl3);
		$data['clinic'] = json_decode($response3);
	
		$err = curl_error($curl);
		curl_close($curl);

		$err2 = curl_error($curl2);
		curl_close($curl2);


		if ($err) {
			$data['status'] = 0;
			$data['error'] = $err;
		} else {
			$data['status'] = 1;
		}
		
		if ($err2) {
			$data['status'] = 0;
			$data['error'] = $err2;
		} else {
			$data['status'] = 1;
		}
		
		*/

		$this->load->view('template/header');
		$this->load->view('dashboard/dashboard', $data);

		//$this->load->view('template/footer');
	}

	public function assessments()
	{
		$data = array();
		$curl = curl_init();
		$token = $this->session->get_userdata()['authtoken'];
		$patientid = $this->session->get_userdata()['patientid'];

		$fetchobj = $this->session->get_userdata()['fetchobj'];

		if ($fetchobj) {

			$str = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/patientjsonobj/' . $patientid . '/results.json');
			$data['res'] = json_decode(json_decode($str));
		} else {

			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/api/GetPatientAssessments?patientId=" . $patientid,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"x-zumo-auth: " . $token,
					"zumo-api-version: 2.0.0"
				),
			));

			$response = curl_exec($curl);
			$data['res'] = json_decode($response);
		}

		$curl2 = curl_init();
		curl_setopt_array($curl2, array(
			CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/tables/Practitioner",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"x-zumo-auth: " . $token,
				"zumo-api-version: 2.0.0"
			),
		));

		$response2 = curl_exec($curl2);
		$data['practitioner'] = json_decode($response2);

		$curl3 = curl_init();
		curl_setopt_array($curl3, array(
			CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/tables/Clinic",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"x-zumo-auth: " . $token,
				"zumo-api-version: 2.0.0"
			),
		));

		$response3 = curl_exec($curl3);
		$data['clinic'] = json_decode($response3);

		$err = curl_error($curl);
		curl_close($curl);

		$err2 = curl_error($curl2);
		curl_close($curl2);


		if ($err) {
			$data['status'] = 0;
			$data['error'] = $err;
		} else {
			$data['status'] = 1;
		}

		if ($err2) {
			$data['status'] = 0;
			$data['error'] = $err2;
		} else {
			$data['status'] = 1;
		}

		$this->load->view('template/header');
		$this->load->view('dashboard/assessments', $data);
		//$this->load->view('template/footer');
	}

	public function detailassessments()
	{
		$data = array();
		$curl = curl_init();
		$token = $this->session->get_userdata()['authtoken'];
		$patientid = $this->session->get_userdata()['patientid'];
		$this->load->model('kinetisense_model');
		$fetchobj = $this->session->get_userdata()['fetchobj'];

		if ($fetchobj) {

			$str = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/patientjsonobj/' . $patientid . '/results.json');
			$data['res'] = json_decode(json_decode($str));
		} else {

			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/api/GetPatientAssessments?patientId=" . $patientid,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"x-zumo-auth: " . $token,
					"zumo-api-version: 2.0.0"
				),
			));

			$response = curl_exec($curl);
			/*print_r($response);
			exit;*/
			$data['res'] = json_decode($response);
		}

		$data['indexKAMS'] = $this->kinetisense_model->getscores($patientid);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$data['status'] = 0;
			$data['error'] = $err;
		} else {
			$data['status'] = 1;
		}

		$this->load->view('template/header');
		$this->load->view('dashboard/detailassessments', $data);
	}

	public function myworkout()
	{
		$data = array();
		$curl = curl_init();
		$token = $this->session->get_userdata()['authtoken'];
		$patientid = $this->session->get_userdata()['patientid'];
		$this->load->model('user_model');
		$this->load->model('kinetisense_model');
		$fetchobj = $this->session->get_userdata()['fetchobj'];

		$data['workouts'] = $this->user_model->getworkouts($patientid);

		if ($fetchobj) {

			$str = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/patientjsonobj/' . $patientid . '/results.json');
			$data['res'] = json_decode(json_decode($str));
		} else {

			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/api/GetPatientAssessments?patientId=" . $patientid,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"x-zumo-auth: " . $token,
					"zumo-api-version: 2.0.0"
				),
			));

			$response = curl_exec($curl);
			/*print_r($response);
			exit;*/
			$data['res'] = json_decode($response);
		}

		$data['indexKAMS'] = $this->kinetisense_model->getscores($patientid);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$data['status'] = 0;
			$data['error'] = $err;
		} else {
			$data['status'] = 1;
		}

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
		$curl = curl_init();
		$token = $this->session->get_userdata()['authtoken'];
		$patientid = $this->session->get_userdata()['patientid'];

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/api/GetPatientAssessments?patientId=" . $patientid,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"x-zumo-auth: " . $token,
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
		$this->load->view('dashboard/workoutsobj', $data);
		$this->load->view('template/footer');
	}
}
