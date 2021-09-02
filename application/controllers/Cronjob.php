<?php
defined('BASEPATH') or exit('No direct script access allowed');
//Import PHPMailer classes into the global namespace
//require FCPATH.'vendor/autoload.php'; 
require FCPATH.'PHPMailer/src/Exception.php';
require FCPATH.'PHPMailer/src/PHPMailer.php';
require FCPATH.'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;




class Cronjob extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index()
	{
		$this->load->model('user_model');
		$data = array();
		$this->Email();

		///get auth token 
		$auth_token = GetAuthToken();
		//store result into $res from api 
		$res = GetPatient($auth_token);

		///define string 
		$outputstr = '';

		///get old user 
		$olduser = $this->user_model->fetcholduser();

		$data['olduser'] = $olduser;

		foreach ($res as $newuser) {
			if (!empty($newuser->email)) {
				$patient_id = $newuser->id;
				$username = $newuser->name . $newuser->surname;
				$email = $newuser->email;

				//check record already exist or not 
				if (!in_array($patient_id, $olduser)) {
					///profile pic store 
					if ($newuser->imagePath != "") {
						$imgpath = $newuser->imagePath;
						$startstr = strrpos($imgpath, "\\");
						$startstr++;
						$endstr = strlen($imgpath);
						$profile_pic = substr($imgpath, $startstr, $endstr);
					} else {
						$profile_pic = '';
					}

					$user = $this->user_model->signupnewuser($patient_id, $username, $email, $profile_pic);

					if ($user > 0)
						$olduser[] = $patient_id;

					$outputstr .= '--' . $user . '--<br/>';
				} else {
					$outputstr .= '--Match not found--<br/>';
				}
			}
		}

		$data['outputstr'] = $outputstr;
		$this->load->view('cronjob/signupuser', $data);
	}

	public function test_email()
	{
		///Test Email Here
		$result = $this->sendEmail('muhammadshaoor1707276@gmail.com', 'Test Subject', 'Hey');
		echo $result;
		die;
	}


	///index and signup both function same working 
	public function signupuser()
	{
		$this->load->model('user_model');

		$data = array();

		//$this->user_model->signupnewuser('ddddddd8864684', 'divyeshtest', 'divyeshtest@gmail.com', '','Divyesh','Test');
		//exit;

		$to_email = 'divyesh@foundersapproach.com';
		$subject = 'Cron Call Sign Up';
		$message = '<h3>Dear, Admin</h3><p>Cron is just fired now. Please check it out.</p><br/><br/><p>Thanks<br/>The Baseline Motion Team</p>';
		//$headers = 'From: noreply @ company . com';
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= 'From: Baseline Motion <no-reply@baselinemotion.com>' . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		//mail($to_email,$subject,$message,$headers);

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => KINETISENSE_API_URL . "/api/KinetisenseLogin",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n  \"username\": \"" . KINETISENSE_LOGIN_USERNAME . "\",\n  \"password\": \"" . KINETISENSE_LOGIN_PASSWORD . "\",\n  \"version\": \"1\"\n}",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"zumo-api-version: 2.0.0"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		$datauser = json_decode($response);
		$auth_token = $datauser->mobileServiceAuthenticationToken;

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/tables/Patient",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"x-zumo-auth: " . $auth_token,
				"zumo-api-version: 2.0.0"
			),
		));

		$response = curl_exec($curl);
		/*print_r($response);
		exit;*/

		$outputstr = '';
		$olduser = $this->user_model->fetcholduser();
		$data['olduser'] = $olduser;
		$res = json_decode($response);

		// print_r($res);
		foreach ($res as $newuser) {
			if ($newuser->email != "") {
				$patient_id = $newuser->id;
				$username = $newuser->name . $newuser->surname;
				$email = $newuser->email;

				if (!in_array($patient_id, $olduser)) {
					if ($newuser->imagePath != "") {
						$imgpath = $newuser->imagePath;
						$startstr = strrpos($imgpath, "\\");
						$startstr++;
						$endstr = strlen($imgpath);
						$profile_pic = substr($imgpath, $startstr, $endstr);
					} else {
						$profile_pic = '';
					}
					$user = $this->user_model->signupnewuser($patient_id, $username, $email, $profile_pic, $newuser->name, $newuser->surname);
					if ($user > 0)
						$olduser[] = $patient_id;

					$outputstr .= '--' . $user . '--<br/>';
				} else {
					/*if($newuser->imagePath!=""){
						$imgpath = $newuser->imagePath;
						$startstr = strrpos($imgpath,"\\");
						$startstr++;
						$endstr = strlen($imgpath);
						$profile_pic = substr($imgpath,$startstr,$endstr);
						
						$updatearray = array();
						$updatearray['profile_pic'] = $profile_pic;
						$this->user_model->usersEdit($patient_id, $updatearray);
					}*/
					$outputstr .= '--Match not found--<br/>';
				}
			}
		}
		$err = curl_error($curl);
		$data['outputstr'] = $outputstr;
		curl_close($curl);

		if ($err) {
			$data['status'] = 0;
			$data['error'] = $err;
		} else {
			$data['status'] = 1;
		}
		$this->load->view('cronjob/signupuser', $data);
	}


	///noti to admin  when cron is fire 
	public function verifycron()
	{
		$this->load->model('user_model');
		$data = array();
		$curl = curl_init();

		$to_email = 'divyesh@foundersapproach.com';
		$subject = 'Cron Call';
		$message = '<h3>Dear, Admin</h3><p>Cron is just fired now. Please check it out.</p><br/><br/><p>Thanks<br/>The Baseline Motion Team</p>';
		//$headers = 'From: noreply @ company . com';
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= 'From: Baseline Motion <no-reply@baselinemotion.com>' . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		mail($to_email, $subject, $message, $headers);

		return true;
	}


	public function createjsonnew()
	{

		$this->load->model('user_model');
		$data = array();
		$auth_token = GetAuthToken();
		$olduser = $this->user_model->fetcholduser();

		/*print_r($datauser);
		print_r($olduser);
		exit;*/

		$curl = curl_init();
		foreach ($olduser as $userid) {

			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/api/GetPatientAssessments?patientId=" . $userid,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"x-zumo-auth: " . $auth_token,
					"zumo-api-version: 2.0.0"
				),
			));
			$img = $_SERVER["DOCUMENT_ROOT"] . '/patientjsonobj/' . $userid;
			if (!is_dir($img)) {
				mkdir($img, 0777, true);
			}
			///get all videos against 
			$assignvideos = $this->user_model->fetchassignvideos($userid);

			$response = curl_exec($curl);
			if ((is_object(json_decode($response))) && json_encode($response) != "" && json_encode($response) != false) {

				$fp = fopen($img . '/results.json', 'w');
				fwrite($fp, json_encode($response));   // here it will print the array pretty
				fclose($fp);

				$updatearray = array();
				$updatearray['fetchobj'] = 1;
				$updatearray['fetchdate'] = date('Y-m-d h:i:s');
				$this->user_model->usersEdit($userid, $updatearray);

				$selecteddate = '';
				$maindata = array();
				$uniquedatearray = array();
				$sortdate = array();
				$response = json_decode($response);
				echo '=============================================' . $userid . '<br/>';
				//print_r($response);


				if (isset($response->romAssessments) && $response->romAssessments != "") {
					foreach ($response->romAssessments as $romsession) {
						$data1 = array();
						$date = date_create($romsession->date);
						$t = date_format($date, "m-d-Y");
						$data1['date'] = $t;
						if ($romsession->jointType == "SpineMid")
							$data1['type'] = 'Back ' . $romsession->movementType;
						else
							$data1['type'] = $romsession->jointType . ' ' . $romsession->movementType;
						$data1['score'] = round($romsession->score * 100, 2) . "%";
						$data1['scoreval'] = $romsession->score * 100;

						$t1 = date_format($date, "Y-m-d");
						$cur = $t1;

						if (!in_array($t, $uniquedatearray)) {
							$uniquedatearray[] = $t;
							$t1 = date_format($date, "Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $romsession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
						}
						$maindata[$t]['romAssessments'][] = $data1;
					}
				}

				if (isset($response->overheadSquatAssessments) && $response->overheadSquatAssessments != "") {
					foreach ($response->overheadSquatAssessments as $overheadsession) {
						$data1 = array();
						$date = date_create($overheadsession->date);
						$t = date_format($date, "m-d-Y");
						$data1['date'] = $t;
						$data1['type'] = 'Overhead Squat';
						$data1['score'] = round($overheadsession->score * 100, 2) . "%";
						$data1['scoreval'] = $overheadsession->score * 100;
						$data1['evaluationsBlob'] = $overheadsession->evaluationsBlob;

						$t1 = date_format($date, "Y-m-d");
						$cur = $t1;
						if (!in_array($t, $uniquedatearray)) {
							$uniquedatearray[] = $t;
							$t1 = date_format($date, "Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $overheadsession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
						}
						$maindata[$t]['overheadAssessments'][] = $data1;
					}
				}

				if (isset($response->reverseLungeAssessments) && $response->reverseLungeAssessments != "") {
					foreach ($response->reverseLungeAssessments as $reverselungesession) {
						$data1 = array();
						$date = date_create($reverselungesession->date);
						$t = date_format($date, "m-d-Y");
						$data1['date'] = $t;
						$data1['type'] = 'Reverse Lunge';
						$data1['score'] = round($reverselungesession->score * 100, 2) . "%";
						$data1['scoreval'] = $reverselungesession->score * 100;
						$data1['evaluationsBlob'] = $reverselungesession->evaluationsBlob;

						$t1 = date_format($date, "Y-m-d");
						$cur = $t1;

						if (!in_array($t, $uniquedatearray)) {
							$uniquedatearray[] = $t;
							$t1 = date_format($date, "Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $reverselungesession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
						}
						$maindata[$t]['reverselungeAssessments'][] = $data1;
					}
				}

				if (isset($response->wallAngelAssessments) && $response->wallAngelAssessments != "") {
					foreach ($response->wallAngelAssessments as $wallangelsession) {
						$data1 = array();
						$date = date_create($wallangelsession->date);
						$t = date_format($date, "m-d-Y");
						$data1['date'] = $t;
						$data1['type'] = 'Posture Angel';
						$data1['score'] = round($wallangelsession->score * 100, 2) . "%";
						$data1['scoreval'] = $wallangelsession->score * 100;
						$data1['evaluationsBlob'] = $wallangelsession->evaluationsBlob;

						$t1 = date_format($date, "Y-m-d");
						$cur = $t1;

						if (!in_array($t, $uniquedatearray)) {
							$uniquedatearray[] = $t;
							$t1 = date_format($date, "Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $wallangelsession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
						}
						$maindata[$t]['wallangelAssessments'][] = $data1;
					}
				}

				if (isset($response->balanceAssessments) && $response->balanceAssessments != "") {
					foreach ($response->balanceAssessments as $balancesession) {
						$data1 = array();
						$date = date_create($balancesession->date);
						$t = date_format($date, "m-d-Y");
						$data1['date'] = $t;
						$data1['type'] = 'Balance ' . $balancesession->type;
						$data1['score'] = round($balancesession->score * 100, 2) . "%";
						$data1['scoreval'] = $balancesession->score * 100;

						$t1 = date_format($date, "Y-m-d");
						$cur = $t1;

						if (!in_array($t, $uniquedatearray)) {
							$uniquedatearray[] = $t;
							$t1 = date_format($date, "Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $balancesession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
						}
						$maindata[$t]['balanceAssessments'][] = $data1;
					}
				}

				if (isset($response->verticalJumpAssessments) && $response->verticalJumpAssessments != "") {
					foreach ($response->verticalJumpAssessments as $verticaljumpsession) {
						$data1 = array();
						$date = date_create($verticaljumpsession->date);
						$t = date_format($date, "m-d-Y");
						$data1['date'] = $t;
						$data1['type'] = 'Vertical Jump';
						$data1['score'] = round($verticaljumpsession->score * 100, 2) . "%";
						$data1['scoreval'] = $verticaljumpsession->score * 100;

						$t1 = date_format($date, "Y-m-d");
						$cur = $t1;

						if (!in_array($t, $uniquedatearray)) {
							$uniquedatearray[] = $t;
							$t1 = date_format($date, "Y-m-d");
							$sortdate[] = $t1;
							$practitionerdate[$t1] = $verticaljumpsession->practitionerId;
							$maindata[$t]['date'] = $t;
							$maindata[$t]['title'] = 'KAMS';
						}
						$maindata[$t]['jumpAssessments'][] = $data1;
					}
				}

				if (isset($response->functionalAssessments) && $response->functionalAssessments != "") {
					foreach ($response->functionalAssessments as $funassesssession) {
						$data1 = array();
						$date = date_create($funassesssession->date);
						$tdate = date_format($date, "Y-m-d");
						$t = date_format($date, "m-d-Y");

						$frame = $funassesssession->assessmentFrames[0];
						//print_r($frame);

						$funframe = $frame->jointCoordsBLOB;
						if ($funframe != "") {
							$fr1 = json_decode($funframe);

							$data2 = array();
							$data2['date'] = $t;
							$data2['type'] = 'Head Tilt';
							$data2['score'] = round($fr1->AngleHead, 2);
							$data1[] = $data2;

							$data2 = array();
							$data2['date'] = $t;
							$data2['type'] = 'Eye Tilt';
							$data2['score'] = round($fr1->AngleEyes, 2);
							$data1[] = $data2;

							$data2 = array();
							$data2['date'] = $t;
							$data2['type'] = 'Shoulder Tilt';
							$data2['score'] = round($fr1->AngleShoulders, 2);
							$data1[] = $data2;

							$data2 = array();
							$data2['date'] = $t;
							$data2['type'] = 'Spine Tilt';
							$data2['score'] = round($fr1->AngleSpine, 2);
							$data1[] = $data2;

							$data2 = array();
							$data2['date'] = $t;
							$data2['type'] = 'Hip Tilt';
							$data2['score'] = round($fr1->AngleHips, 2);
							$data1[] = $data2;

							$data2 = array();
							$data2['date'] = $t;
							$data2['type'] = 'Knee Tilt';
							$data2['score'] = round($fr1->AngleKnees, 2);
							$data1[] = $data2;

							$data2 = array();
							$data2['date'] = $t;
							$data2['type'] = 'Ankle Tilt';
							$data2['score'] = round($fr1->AngleAnkles, 2);
							$data1[] = $data2;


							$data2 = array();
							$data2['date'] = $t;
							$data2['type'] = 'Head Position';
							$data2['score'] = round($fr1->DistanceHead, 2);
							$data1[] = $data2;

							$data2 = array();
							$data2['date'] = $t;
							$data2['type'] = 'Shoulder Position';
							$data2['score'] = round($fr1->DistanceShoulder, 2);
							$data1[] = $data2;

							$data2 = array();
							$data2['date'] = $t;
							$data2['type'] = 'Spine Position';
							$data2['score'] = round($fr1->DistanceSpine, 2);
							$data1[] = $data2;

							$data2 = array();
							$data2['date'] = $t;
							$data2['type'] = 'Hip Position';
							$data2['score'] = round($fr1->DistanceHip, 2);
							$data1[] = $data2;

							$data2 = array();
							$data2['date'] = $t;
							$data2['type'] = 'Knee Position';
							$data2['score'] = round($fr1->DistanceKnee, 2);
							$data1[] = $data2;

							$data2 = array();
							$data2['date'] = $t;
							$data2['type'] = 'Shoulder Plane Rotation';
							$data2['score'] = round($fr1->ShoulderPlaneRotation, 2);
							$data1[] = $data2;

							$data2 = array();
							$data2['date'] = $t;
							$data2['type'] = 'Hip Plane Rotation';
							$data2['score'] = round($fr1->HipPlaneRotation, 2);
							$data1[] = $data2;

							$data2 = array();
							$data2['date'] = $t;
							$data2['type'] = 'Knee Plane Rotation';
							$data2['score'] = round($fr1->KneePlaneRotation, 2);
							$data1[] = $data2;

							$data2 = array();
							$data2['date'] = $t;
							$data2['type'] = 'Ankle Plane Rotation';
							$data2['score'] = round($fr1->AnklePlaneRotation, 2);
							$data1[] = $data2;

							$data1[] = $data2;
							$data1['title'] = $funassesssession->tag;

							if (isset($frame->imagePath) && $frame->imagePath != "") {
								$imgpath = $frame->imagePath;
								$startstr = strrpos($imgpath, "\\");
								$startstr++;
								$endstr = strlen($imgpath);
								$profile_pic = substr($imgpath, $startstr, $endstr);

								$data2['imagePath'] = base_url() . "public/images/kinetisense/" . $this->session->userdata("patientid") . "/" . $profile_pic;
							} else
								$data2['imagePath'] = '';

							if (isset($funassesssession->videoFilePath) && $funassesssession->videoFilePath != "")
								$data2['videoFilePath'] = $funassesssession->videoFilePath;
							else
								$data2['videoFilePath'] = '';

							if (!in_array($t, $uniquedatearray)) {
								$uniquedatearray[] = $t;
								$sortdate[] = date_format($date, "Y-m-d");
								$maindata[$t]['date'] = $t;
							}
							$maindata[$t]['functionalAssessments'][] = $data1;
						}
					}
				}

				$rulesdata = array();
				$workrules = $this->user_model->usersfetchrules($userid);
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

				$rulesdata['date']['param_name'] = 'param_name';
				$rulesdata['type']['param_sign'] = 'Head Tilt';
				$rulesdata['score']['param_value'] = 'param_value';
				$rulesdata['date']['line'] = 'line';

				//echo '<pre>'; 
				foreach ($sortdate as $d1) {
					$timestamp = strtotime($d1);
					$a = array();
					$new_date = date("m-d-Y", $timestamp);

					$PostureLLdanger = 0;
					$PostureSFLdanger = 0;
					$PostureSBLdanger = 0;
					$PostureSPLdanger = 0;

					$KAMSLLdanger = 0;
					$KAMSSFLdanger = 0;
					$KAMSSBLdanger = 0;
					$KAMSSPLdanger = 0;

					$a = array();
					$d = $maindata[$new_date];
					//print_r($rulesdata);
					//print_r($d);
					if (isset($d['romAssessments'])) {
						foreach ($d['romAssessments'] as $rom) {
							//echo "690<br/>";
							$a[] = $rom['scoreval'];
							if ($rom['type'] == "Back LateralFlexionRight") {
								//echo "693<br/>";
								$score = $rom['scoreval'];
								if (isset($rulesdata['BackLateralFlexionRight']['line']) && $rulesdata['BackLateralFlexionRight']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['BackLateralFlexionRight']['param_sign'], $rulesdata['BackLateralFlexionRight']['param_value'])) {
										//echo "694<br/>";
										switch ($rulesdata['BackLateralFlexionRight']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
										//echo "695<br/>";
									}
								}
							} else if ($rom['type'] == "Back Extension") {
								$score = $rom['scoreval'];

								if (isset($rulesdata['BackExtension']['line']) && $rulesdata['BackExtension']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['BackExtension']['param_sign'], $rulesdata['BackExtension']['param_value'])) {
										switch ($rulesdata['BackExtension']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							} else if ($rom['type'] == "Back Flexion") {
								$score = $rom['scoreval'];
								if (isset($rulesdata['BackFlexion']['line']) && $rulesdata['BackFlexion']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['BackFlexion']['param_sign'], $rulesdata['BackFlexion']['param_value'])) {
										switch ($rulesdata['BackFlexion']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							} else if ($rom['type'] == "Back LateralFlexionLeft") {
								$score = $rom['scoreval'];
								if (isset($rulesdata['BackLateralFlexionLeft']['line']) && $rulesdata['BackLateralFlexionLeft']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['BackLateralFlexionLeft']['param_sign'], $rulesdata['BackLateralFlexionLeft']['param_value'])) {
										switch ($rulesdata['BackLateralFlexionLeft']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							}
						}
					}

					if (isset($d['overheadAssessments'])) {
						foreach ($d['overheadAssessments'] as $overhead) {
							//print_r('<p><b>'.$overhead['type'].'</b> <span>'.$overhead['score'].'</span></p>');
							$a[] = $overhead['scoreval'];
							$evaluations = json_decode($overhead['evaluationsBlob']);

							if (isset($evaluations->ThighsReachHorizontal)) {
								$score = round($evaluations->ThighsReachHorizontal, 2);

								if (isset($rulesdata['OverheadThighsReachHorizontal']['line']) && $rulesdata['OverheadThighsReachHorizontal']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['OverheadThighsReachHorizontal']['param_sign'], $rulesdata['OverheadThighsReachHorizontal']['param_value'])) {
										switch ($rulesdata['OverheadThighsReachHorizontal']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							}

							if (isset($evaluations->ValgusLeft)) {
								$score = round($evaluations->ValgusLeft * 100, 2);
								if (isset($rulesdata['OverheadValgusLeft']['line']) && $rulesdata['OverheadValgusLeft']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['OverheadValgusLeft']['param_sign'], $rulesdata['OverheadValgusLeft']['param_value'])) {
										switch ($rulesdata['OverheadValgusLeft']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							}

							if (isset($evaluations->ValgusRight)) {
								$score = round($evaluations->ValgusRight * 100, 2);
								if (isset($rulesdata['OverheadValgusRight']['line']) && $rulesdata['OverheadValgusRight']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['OverheadValgusRight']['param_sign'], $rulesdata['OverheadValgusRight']['param_value'])) {
										switch ($rulesdata['OverheadValgusRight']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							}

							if (isset($evaluations->ShoulderLateralTilt)) {
								$score = round($evaluations->ShoulderLateralTilt * 100, 2);
								if (isset($rulesdata['OverheadShoulderLateralTilt']['line']) && $rulesdata['OverheadShoulderLateralTilt']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['OverheadShoulderLateralTilt']['param_sign'], $rulesdata['OverheadShoulderLateralTilt']['param_value'])) {
										switch ($rulesdata['OverheadShoulderLateralTilt']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							}

							if (isset($evaluations->ShoulderAxisRotation)) {
								$score = round($evaluations->ShoulderAxisRotation * 100, 2);
								if (isset($rulesdata['OverheadShoulderAxisRotation']['line']) && $rulesdata['OverheadShoulderAxisRotation']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['OverheadShoulderAxisRotation']['param_sign'], $rulesdata['OverheadShoulderAxisRotation']['param_value'])) {
										switch ($rulesdata['OverheadShoulderAxisRotation']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							}
						}
					}

					if (isset($d['reverselungeAssessments'])) {
						foreach ($d['reverselungeAssessments'] as $reverselunge) {
							//print_r('<p><b>'.$reverselunge['type'].'</b> <span>'.$reverselunge['score'].'</span></p>');
							$a[] = $reverselunge['scoreval'];
							$evaluations = json_decode($reverselunge['evaluationsBlob']);

							if (isset($evaluations->ReachedKneelingPositionLeft)) {
								$score = round($evaluations->ReachedKneelingPositionLeft, 2);
								if (isset($rulesdata['ReverseLungeReachedKneelingPositionLeft']['line']) && $rulesdata['ReverseLungeReachedKneelingPositionLeft']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['ReverseLungeReachedKneelingPositionLeft']['param_sign'], $rulesdata['ReverseLungeReachedKneelingPositionLeft']['param_value'])) {
										switch ($rulesdata['ReverseLungeReachedKneelingPositionLeft']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							}

							if (isset($evaluations->ValgusLeft)) {
								$score = round($evaluations->ValgusLeft * 100, 2);
								if (isset($rulesdata['ReverseValgusLeft']['line']) && $rulesdata['ReverseValgusLeft']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['ReverseValgusLeft']['param_sign'], $rulesdata['ReverseValgusLeft']['param_value'])) {
										switch ($rulesdata['ReverseValgusLeft']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							}

							if (isset($evaluations->ShoulderLateralTiltLeft)) {
								$score = round($evaluations->ShoulderLateralTiltLeft * 100, 2);
								if (isset($rulesdata['ReverseShoulderLateralTiltLeft']['line']) && $rulesdata['ReverseShoulderLateralTiltLeft']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['ReverseShoulderLateralTiltLeft']['param_sign'], $rulesdata['ReverseShoulderLateralTiltLeft']['param_value'])) {
										switch ($rulesdata['ReverseShoulderLateralTiltLeft']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							}

							if (isset($evaluations->ShoulderAxisRotationLeft)) {
								$score = round($evaluations->ShoulderAxisRotationLeft * 100, 2);
								if (isset($rulesdata['ReverseShoulderAxisRotationLeft']['line']) && $rulesdata['ReverseShoulderAxisRotationLeft']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['ReverseShoulderAxisRotationLeft']['param_sign'], $rulesdata['ReverseShoulderAxisRotationLeft']['param_value'])) {
										switch ($rulesdata['ReverseShoulderAxisRotationLeft']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							}

							if (isset($evaluations->ReachedKneelingPositionRight)) {
								$score = round($evaluations->ReachedKneelingPositionRight, 2);
								if (isset($rulesdata['ReverseReachedKneelingPositionRight']['line']) && $rulesdata['ReverseReachedKneelingPositionRight']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['ReverseReachedKneelingPositionRight']['param_sign'], $rulesdata['ReverseReachedKneelingPositionRight']['param_value'])) {
										switch ($rulesdata['ReverseReachedKneelingPositionRight']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							}

							if (isset($evaluations->ValgusRight)) {
								$score = round($evaluations->ValgusRight * 100, 2);
								if (isset($rulesdata['ReverseValgusRight']['line']) && $rulesdata['ReverseValgusRight']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['ReverseValgusRight']['param_sign'], $rulesdata['ReverseValgusRight']['param_value'])) {
										switch ($rulesdata['ReverseValgusRight']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							}

							if (isset($evaluations->ShoulderLateralTiltRight)) {
								$score = round($evaluations->ShoulderLateralTiltRight * 100, 2);
								if (isset($rulesdata['ReverseShoulderLateralTiltRight']['line']) && $rulesdata['ReverseShoulderLateralTiltRight']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['ReverseShoulderLateralTiltRight']['param_sign'], $rulesdata['ReverseShoulderLateralTiltRight']['param_value'])) {
										switch ($rulesdata['ReverseShoulderLateralTiltRight']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							}

							if (isset($evaluations->ShoulderAxisRotationRight)) {
								$score = round($evaluations->ShoulderAxisRotationRight * 100, 2);
								if (isset($rulesdata['ReverseShoulderAxisRotationRight']['line']) && $rulesdata['ReverseShoulderAxisRotationRight']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['ReverseShoulderAxisRotationRight']['param_sign'], $rulesdata['ReverseShoulderAxisRotationRight']['param_value'])) {
										switch ($rulesdata['ReverseShoulderAxisRotationRight']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							}
						}
					}

					if (isset($d['wallangelAssessments'])) {
						foreach ($d['wallangelAssessments'] as $wallangel) {
							//print_r('<p><b>'.$wallangel['type'].'</b> <span>'.$wallangel['score'].'</span></p>');
							$a[] = $wallangel['scoreval'];
							$evaluations = json_decode($wallangel['evaluationsBlob']);
							//print_r(json_decode($evaluations));
							if (isset($evaluations->HeadCarriage)) {
								$score = round($evaluations->HeadCarriage * 100, 2);
								if (isset($rulesdata['WallAngelHeadCarriage']['line']) && $rulesdata['WallAngelHeadCarriage']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['WallAngelHeadCarriage']['param_sign'], $rulesdata['WallAngelHeadCarriage']['param_value'])) {
										switch ($rulesdata['WallAngelHeadCarriage']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							}
							if (isset($evaluations->ShoulderLateralTilt)) {
								$score = round($evaluations->ShoulderLateralTilt * 100, 2);
								if (isset($rulesdata['WallAngelShoulderLateralTilt']['line']) && $rulesdata['WallAngelShoulderLateralTilt']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['WallAngelShoulderLateralTilt']['param_sign'], $rulesdata['WallAngelShoulderLateralTilt']['param_value'])) {
										switch ($rulesdata['WallAngelShoulderLateralTilt']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							}
							if (isset($evaluations->HipLateralTilt)) {
								$score = round($evaluations->HipLateralTilt * 100, 2);
								if (isset($rulesdata['WallAngelHipLateralTilt']['line']) && $rulesdata['WallAngelHipLateralTilt']['line'] != "") {
									if ($this->user_model->checkresult($score, $rulesdata['WallAngelHipLateralTilt']['param_sign'], $rulesdata['WallAngelHipLateralTilt']['param_value'])) {
										switch ($rulesdata['WallAngelHipLateralTilt']['line']) {
											case "SBL":
												$KAMSSBLdanger++;
												break;
											case "SFL":
												$KAMSSFLdanger++;
												break;
											case "SPL":
												$KAMSSPLdanger++;
												break;
											default:
												$KAMSLLdanger++;
										}
									}
								}
							}
						}
					}


					if (isset($d['functionalAssessments'])) {
						foreach ($d['functionalAssessments'] as $jump) {
							for ($t = 0; $t < sizeof($jump) - 2; $t++) {
								if ($jump[$t]['type'] == 'Head Tilt') {
									//echo 'here1147<br/>';
									$score = abs($jump[$t]['score']);
									if (isset($rulesdata['FunctionalHeadTilt']['line']) && $rulesdata['FunctionalHeadTilt']['line'] != "") {
										//echo 'here1151<br/>';
										if ($this->user_model->checkresult($score, $rulesdata['FunctionalHeadTilt']['param_sign'], $rulesdata['FunctionalHeadTilt']['param_value'])) {
											//	echo 'here1143<br/>';
											switch ($rulesdata['FunctionalHeadTilt']['line']) {
												case "SBL":
													$PostureSBLdanger++;
													break;
												case "SFL":
													$PostureSFLdanger++;
													break;
												case "SPL":
													$PostureSPLdanger++;
													break;
												default:
													$PostureLLdanger++;
											}
										}
									}
								} else if ($jump[$t]['type'] == 'Eye Tilt') {
									$score = abs($jump[$t]['score']);
									if (isset($rulesdata['FunctionalEyeTilt']['line']) && $rulesdata['FunctionalEyeTilt']['line'] != "") {
										if ($this->user_model->checkresult($score, $rulesdata['FunctionalEyeTilt']['param_sign'], $rulesdata['FunctionalEyeTilt']['param_value'])) {
											switch ($rulesdata['FunctionalEyeTilt']['line']) {
												case "SBL":
													$PostureSBLdanger++;
													break;
												case "SFL":
													$PostureSFLdanger++;
													break;
												case "SPL":
													$PostureSPLdanger++;
													break;
												default:
													$PostureLLdanger++;
											}
										}
									}
								} else if ($jump[$t]['type'] == 'Shoulder Tilt') {
									$score = abs($jump[$t]['score']);
									if (isset($rulesdata['FunctionalShoulderTilt']['line']) && $rulesdata['FunctionalShoulderTilt']['line'] != "") {
										if ($this->user_model->checkresult($score, $rulesdata['FunctionalShoulderTilt']['param_sign'], $rulesdata['FunctionalShoulderTilt']['param_value'])) {
											switch ($rulesdata['FunctionalShoulderTilt']['line']) {
												case "SBL":
													$PostureSBLdanger++;
													break;
												case "SFL":
													$PostureSFLdanger++;
													break;
												case "SPL":
													$PostureSPLdanger++;
													break;
												default:
													$PostureLLdanger++;
											}
										}
									}
								} else if ($jump[$t]['type'] == 'Spine Tilt') {
									$score = abs($jump[$t]['score']);
									if (isset($rulesdata['FunctionalSpineTilt']['line']) && $rulesdata['FunctionalSpineTilt']['line'] != "") {
										if ($this->user_model->checkresult($score, $rulesdata['FunctionalSpineTilt']['param_sign'], $rulesdata['FunctionalSpineTilt']['param_value'])) {
											switch ($rulesdata['FunctionalSpineTilt']['line']) {
												case "SBL":
													$PostureSBLdanger++;
													break;
												case "SFL":
													$PostureSFLdanger++;
													break;
												case "SPL":
													$PostureSPLdanger++;
													break;
												default:
													$PostureLLdanger++;
											}
										}
									}
								} else if ($jump[$t]['type'] == 'Hip Tilt') {
									$score = abs($jump[$t]['score']);
									if (isset($rulesdata['FunctionalHipTilt']['line']) && $rulesdata['FunctionalHipTilt']['line'] != "") {
										if ($this->user_model->checkresult($score, $rulesdata['FunctionalHipTilt']['param_sign'], $rulesdata['FunctionalHipTilt']['param_value'])) {
											switch ($rulesdata['FunctionalHipTilt']['line']) {
												case "SBL":
													$PostureSBLdanger++;
													break;
												case "SFL":
													$PostureSFLdanger++;
													break;
												case "SPL":
													$PostureSPLdanger++;
													break;
												default:
													$PostureLLdanger++;
											}
										}
									}
								} else if ($jump[$t]['type'] == 'Knee Tilt') {
									$score = abs($jump[$t]['score']);
									if (isset($rulesdata['FunctionalKneeTilt']['line']) && $rulesdata['FunctionalKneeTilt']['line'] != "") {
										if ($this->user_model->checkresult($score, $rulesdata['FunctionalKneeTilt']['param_sign'], $rulesdata['FunctionalKneeTilt']['param_value'])) {
											switch ($rulesdata['FunctionalKneeTilt']['line']) {
												case "SBL":
													$PostureSBLdanger++;
													break;
												case "SFL":
													$PostureSFLdanger++;
													break;
												case "SPL":
													$PostureSPLdanger++;
													break;
												default:
													$PostureLLdanger++;
											}
										}
									}
								} else if ($jump[$t]['type'] == 'Ankle Tilt') {
									$score = abs($jump[$t]['score']);
									if (isset($rulesdata['FunctionalAnkleTilt']['line']) && $rulesdata['FunctionalAnkleTilt']['line'] != "") {
										if ($this->user_model->checkresult($score, $rulesdata['FunctionalAnkleTilt']['param_sign'], $rulesdata['FunctionalAnkleTilt']['param_value'])) {
											switch ($rulesdata['FunctionalAnkleTilt']['line']) {
												case "SBL":
													$PostureSBLdanger++;
													break;
												case "SFL":
													$PostureSFLdanger++;
													break;
												case "SPL":
													$PostureSPLdanger++;
													break;
												default:
													$PostureLLdanger++;
											}
										}
									}
								} else if ($jump[$t]['type'] == 'Head Position') {
									$HeadPosition = $jump[$t]['score'];
									$score = abs($HeadPosition) * 100;

									if (isset($rulesdata['FunctionalHeadPosition']['line']) && $rulesdata['FunctionalHeadPosition']['line'] != "") {
										if ($this->user_model->checkresult($score, $rulesdata['FunctionalHeadPosition']['param_sign'], $rulesdata['FunctionalHeadPosition']['param_value'])) {
											switch ($rulesdata['FunctionalHeadPosition']['line']) {
												case "SFL":
												case "SBL":
													if ($score < 0)
														$PostureSFLdanger++;
													else
														$PostureSBLdanger++;
													break;
												case "SPL":
													$PostureSPLdanger++;
													break;
												default:
													$PostureLLdanger++;
											}
										}
									}
								} else if ($jump[$t]['type'] == 'Shoulder Position') {
									$ShoulderPosition = $jump[$t]['score'];
									$score = abs($ShoulderPosition) * 100;
									if (isset($rulesdata['FunctionalShoulderPosition']['line']) && $rulesdata['FunctionalShoulderPosition']['line'] != "") {
										if ($this->user_model->checkresult($score, $rulesdata['FunctionalShoulderPosition']['param_sign'], $rulesdata['FunctionalShoulderPosition']['param_value'])) {
											switch ($rulesdata['FunctionalShoulderPosition']['line']) {
												case "SFL":
												case "SBL":
													if ($score < 0)
														$PostureSBLdanger++;
													else
														$PostureSFLdanger++;
													break;
												case "SPL":
													$PostureSPLdanger++;
													break;
												default:
													$PostureLLdanger++;
											}
										}
									}
								} else if ($jump[$t]['type'] == 'Spine Position') {
									$SpinePosition = $jump[$t]['score'];
									$score = abs($SpinePosition) * 100;
									if (isset($rulesdata['FunctionalSpinePosition']['line']) && $rulesdata['FunctionalSpinePosition']['line'] != "") {
										if ($this->user_model->checkresult($score, $rulesdata['FunctionalSpinePosition']['param_sign'], $rulesdata['FunctionalSpinePosition']['param_value'])) {
											switch ($rulesdata['FunctionalSpinePosition']['line']) {
												case "SFL":
												case "SBL":
													if ($score < 0)
														$PostureSBLdanger++;
													else
														$PostureSFLdanger++;
													break;
												case "SPL":
													$PostureSPLdanger++;
													break;
												default:
													$PostureLLdanger++;
											}
										}
									}
								} else if ($jump[$t]['type'] == 'Hip Position') {
									$HipPosition = $jump[$t]['score'];
									$score = abs($HipPosition) * 100;
									if (isset($rulesdata['FunctionalHipPosition']['line']) && $rulesdata['FunctionalHipPosition']['line'] != "") {
										if ($this->user_model->checkresult($score, $rulesdata['FunctionalHipPosition']['param_sign'], $rulesdata['FunctionalHipPosition']['param_value'])) {
											switch ($rulesdata['FunctionalHipPosition']['line']) {
												case "SFL":
												case "SBL":
													if ($score < 0)
														$PostureSFLdanger++;
													else
														$PostureSBLdanger++;
													break;
												case "SPL":
													$PostureSPLdanger++;
													break;
												default:
													$PostureLLdanger++;
											}
										}
									}
								} else if ($jump[$t]['type'] == 'FunctionalKneePosition') {
									$KneePosition = $jump[$t]['score'];
									$score = abs($KneePosition) * 100;
									if (isset($rulesdata['FunctionalKneePosition']['line']) && $rulesdata['FunctionalKneePosition']['line'] != "") {
										if ($this->user_model->checkresult($score, $rulesdata['FunctionalKneePosition']['param_sign'], $rulesdata['FunctionalKneePosition']['param_value'])) {
											switch ($rulesdata['FunctionalKneePosition']['line']) {
												case "SFL":
												case "SBL":
													if ($score < 0)
														$PostureSFLdanger++;
													else
														$PostureSBLdanger++;
													break;
												case "SPL":
													$PostureSPLdanger++;
													break;
												default:
													$PostureLLdanger++;
											}
										}
									}
								} else if ($jump[$t]['type'] == 'Shoulder Plane Rotation') {
									$score = abs($jump[$t]['score']);
									if (isset($rulesdata['FunctionalShoulderPlaneRotation']['line']) && $rulesdata['FunctionalShoulderPlaneRotation']['line'] != "") {
										if ($this->user_model->checkresult($score, $rulesdata['FunctionalShoulderPlaneRotation']['param_sign'], $rulesdata['FunctionalShoulderPlaneRotation']['param_value'])) {
											switch ($rulesdata['FunctionalShoulderPlaneRotation']['line']) {
												case "SBL":
													$PostureSBLdanger++;
													break;
												case "SFL":
													$PostureSFLdanger++;
													break;
												case "SPL":
													$PostureSPLdanger++;
													break;
												default:
													$PostureLLdanger++;
											}
										}
									}
								} else if ($jump[$t]['type'] == 'Hip Plane Rotation') {
									$score = abs($jump[$t]['score']);
									if (isset($rulesdata['FunctionalHipPlaneRotation']['line']) && $rulesdata['FunctionalHipPlaneRotation']['line'] != "") {
										if ($this->user_model->checkresult($score, $rulesdata['FunctionalHipPlaneRotation']['param_sign'], $rulesdata['FunctionalHipPlaneRotation']['param_value'])) {
											switch ($rulesdata['FunctionalHipPlaneRotation']['line']) {
												case "SBL":
													$PostureSBLdanger++;
													break;
												case "SFL":
													$PostureSFLdanger++;
													break;
												case "SPL":
													$PostureSPLdanger++;
													break;
												default:
													$PostureLLdanger++;
											}
										}
									}
								} else if ($jump[$t]['type'] == 'Knee Plane Rotation') {
									$score = abs($jump[$t]['score']);
									if (isset($rulesdata['FunctionalKneePlaneRotation']['line']) && $rulesdata['FunctionalKneePlaneRotation']['line'] != "") {
										if ($this->user_model->checkresult($score, $rulesdata['FunctionalKneePlaneRotation']['param_sign'], $rulesdata['FunctionalKneePlaneRotation']['param_value'])) {
											switch ($rulesdata['FunctionalKneePlaneRotation']['line']) {
												case "SBL":
													$PostureSBLdanger++;
													break;
												case "SFL":
													$PostureSFLdanger++;
													break;
												case "SPL":
													$PostureSPLdanger++;
													break;
												default:
													$PostureLLdanger++;
											}
										}
									}
								} else if ($jump[$t]['type'] == 'Ankle Plane Rotation') {
									$score = abs($jump[$t]['score']);
									if (isset($rulesdata['FunctionalAnklePlaneRotation']['line']) && $rulesdata['FunctionalAnklePlaneRotation']['line'] != "") {
										if ($this->user_model->checkresult($score, $rulesdata['FunctionalAnklePlaneRotation']['param_sign'], $rulesdata['FunctionalAnklePlaneRotation']['param_value'])) {
											switch ($rulesdata['FunctionalAnklePlaneRotation']['line']) {
												case "SBL":
													$PostureSBLdanger++;
													break;
												case "SFL":
													$PostureSFLdanger++;
													break;
												case "SPL":
													$PostureSPLdanger++;
													break;
												default:
													$PostureLLdanger++;
											}
										}
									}
								}
							}
						}
					}


					/*print_r("<br/>userid::::::".$userid);
					print_r("<br/>KAMSLLdanger::".$KAMSLLdanger);
					print_r("<br/>KAMSSFLdanger::".$KAMSSFLdanger);
					print_r("<br/>KAMSSBLdanger::".$KAMSSBLdanger);
					print_r("<br/>KAMSSPLdanger::".$KAMSSPLdanger);
					
					print_r("<br/>PostureLLdanger::".$PostureLLdanger);
					print_r("<br/>PostureSFLdanger::".$PostureSFLdanger);
					print_r("<br/>PostureSBLdanger::".$PostureSBLdanger);
					print_r("<br/>PostureSPLdanger::".$PostureSPLdanger);
					
					exit;*/

					$totaldanger = 0;
					$totaldanger = $KAMSLLdanger + $KAMSSFLdanger + $KAMSSBLdanger + $KAMSSPLdanger + $PostureLLdanger + $PostureSFLdanger + $PostureSBLdanger + $PostureSPLdanger;

					$lldanger = $KAMSLLdanger + $PostureLLdanger;
					$sflsbldanger = $KAMSSFLdanger + $PostureSFLdanger;
					$sbldanger = $KAMSSBLdanger + $PostureSBLdanger;
					$spldanger = $KAMSSPLdanger + $PostureSPLdanger;

					if ($totaldanger != 0) {
						$llper = round(($lldanger / $totaldanger) * 10);
						$sflsblper = round(($sflsbldanger / $totaldanger) * 10);
						$sblper = round(($sbldanger / $totaldanger) * 10);
						$splper = round(($spldanger / $totaldanger) * 10);
					} else {
						$llper = 0;
						$sflsblper = 0;
						$sblper = 0;
						$splper = 0;
					}

					/*	print_r("<br/>ll videos::".$llper);
					print_r("<br/>sflsbl videos::".$sflsblper);
					print_r("<br/>spl videos::".$splper);*/

					print_r("<br/>new_date::" . $new_date);

					$workout = 1;
					$llids = array();
					$sflsblids = array();
					$splids = array();
					$sblids = array();

					if ($llper > 0) {
						$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
						$this->db->order_by('rand()');
						$this->db->limit($llper);
						$ids = array('LL');
						$this->db->where_in('line', $ids);
						$this->db->from('workouts');

						$query = $this->db->get();

						if ($query->num_rows() > 0) {
							// Got some rows, return as assoc array
							$userobj = $query->result();
							foreach ($userobj as $user) {
								if ($user->id != "")
									$llids[] = $user->id;
							}
						}
					}

					if ($sflsblper > 0) {
						$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
						$this->db->order_by('rand()');
						$this->db->limit($sflsblper);
						$ids = array('SFL');
						$this->db->where_in('line', $ids);
						$this->db->from('workouts');

						$query = $this->db->get();

						if ($query->num_rows() > 0) {
							// Got some rows, return as assoc array
							$userobj = $query->result();
							foreach ($userobj as $user) {
								if ($user->id != "")
									$sflsblids[] = $user->id;
							}
						}
					}

					if ($sblper > 0) {
						$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
						$this->db->order_by('rand()');
						$this->db->limit($sblper);
						$ids = array('SBL');
						$this->db->where_in('line', $ids);
						$this->db->from('workouts');

						$query = $this->db->get();

						if ($query->num_rows() > 0) {
							// Got some rows, return as assoc array
							$userobj = $query->result();
							foreach ($userobj as $user) {
								if ($user->id != "")
									$sblids[] = $user->id;
							}
						}
					}


					if ($splper > 0) {
						$this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
						$this->db->order_by('rand()');
						$this->db->limit($splper);
						$ids = array('SPL');
						$this->db->where_in('line', $ids);
						$this->db->from('workouts');

						$query = $this->db->get();

						if ($query->num_rows() > 0) {
							// Got some rows, return as assoc array
							$userobj = $query->result();
							foreach ($userobj as $user) {
								if ($user->id != "")
									$splids[] = $user->id;
							}
						}
					}

					if (sizeof($llids) > 0 || sizeof($sflsblids) > 0 || sizeof($splids) > 0 || sizeof($sblids) > 0) {
						$data = array(
							'patient_id' => $userid,
							'assessment_date' => $new_date,
							'll_workouts'  => join(", ", $llids),
							'sflsbl_workouts'  => join(", ", $sflsblids),
							'sbl_workouts'  => join(", ", $sblids),
							'spl_workouts' => join(", ", $splids),
							'kams_ll' => $KAMSLLdanger,
							'kams_sfl' => $KAMSSFLdanger,
							'kams_sbl'  => $KAMSSBLdanger,
							'kams_spl'  => $KAMSSPLdanger,
							'posture_ll' => $PostureLLdanger,
							'posture_sfl' => $PostureSFLdanger,
							'posture_sbl' => $PostureSBLdanger,
							'posture_spl'  => $PostureSPLdanger,
							'status'   => 1
						);
						if (!in_array($new_date, $assignvideos)) {
							$this->user_model->insertassignworkouts($data);
						}
						/* else{
							$this->user_model->updateassignworkouts($userid, $new_date, $data);
						} */
					}
				}
				//print_r($maindata);
				//exit;
				echo $userid . " is fetched.<br/>";
			}
		}



		return true;
	}

	public function createjsonuser()
	{
		$this->load->model('user_model');
		$data = array();
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => KINETISENSE_API_URL . "/api/KinetisenseLogin",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n  \"username\": \"" . KINETISENSE_LOGIN_USERNAME . "\",\n  \"password\": \"" . KINETISENSE_LOGIN_PASSWORD . "\",\n  \"version\": \"1\"\n}",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"zumo-api-version: 2.0.0"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		$datauser = json_decode($response);
		$auth_token = $datauser->mobileServiceAuthenticationToken;

		$curl = curl_init();
		$userid = $_REQUEST['userid'];
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/api/GetPatientAssessments?patientId=" . $userid,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"x-zumo-auth: " . $auth_token,
				"zumo-api-version: 2.0.0"
			),
		));

		$img = $_SERVER["DOCUMENT_ROOT"] . '/patientjsonobj/' . $userid;
		if (!is_dir($img)) {
			mkdir($img, 0777, true);
		}

		$response = curl_exec($curl);
		$fp = fopen($img . '/results.json', 'w');
		fwrite($fp, json_encode($response));   // here it will print the array pretty
		fclose($fp);

		$updatearray = array();
		$updatearray['fetchobj'] = 1;
		$updatearray['fetchdate'] = date('Y-m-d h:i:s');
		$this->user_model->usersEdit($userid, $updatearray);

		echo $userid . " is fetched.";

		return true;
	}

	public function updatejsonuser($userid)
	{
		$this->load->model('user_model');
		$data = array();
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => KINETISENSE_API_URL . "/api/KinetisenseLogin",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n  \"username\": \"" . KINETISENSE_LOGIN_USERNAME . "\",\n  \"password\": \"" . KINETISENSE_LOGIN_PASSWORD . "\",\n  \"version\": \"1\"\n}",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"zumo-api-version: 2.0.0"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		$datauser = json_decode($response);
		$auth_token = $datauser->mobileServiceAuthenticationToken;

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/api/GetPatientAssessments?patientId=" . $userid,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"x-zumo-auth: " . $auth_token,
				"zumo-api-version: 2.0.0"
			),
		));

		$img = $_SERVER["DOCUMENT_ROOT"] . '/patientjsonobj/' . $userid;
		if (!is_dir($img)) {
			mkdir($img, 0777, true);
		}

		$response = curl_exec($curl);
		$fp = fopen($img . '/results.json', 'w');
		fwrite($fp, json_encode($response));   // here it will print the array pretty
		fclose($fp);

		$updatearray = array();
		$updatearray['fetchobj'] = 1;
		$updatearray['fetchdate'] = date('Y-m-d h:i:s');
		$this->user_model->usersEdit($userid, $updatearray);

		return true;
	}

	public function endpoints()
	{
		$data = array();
		$curl = curl_init();
		$this->load->model('kinetisense_model');

		$oldimages = $this->kinetisense_model->fetchimage();

		$curl55 = curl_init();

		curl_setopt_array($curl55, array(
			CURLOPT_URL => KINETISENSE_API_URL . "/api/KinetisenseLogin",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n  \"username\": \"" . KINETISENSE_LOGIN_USERNAME . "\",\n  \"password\": \"" . KINETISENSE_LOGIN_PASSWORD . "\",\n  \"version\": \"1\"\n}",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"zumo-api-version: 2.0.0"
			),
		));

		$response55 = curl_exec($curl55);
		$err = curl_error($curl55);

		curl_close($curl55);

		$datauser55 = json_decode($response55);
		$token = $datauser55->mobileServiceAuthenticationToken;

		$curl5 = curl_init();

		//https://kinetisensecloudwestusapp.azurewebsites.net/tables/UploadFile/?\$skip=5000
		curl_setopt_array($curl5, array(
			CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/tables/UploadFile/",
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

		$response5 = curl_exec($curl5);
		$err = curl_error($curl5);
		$images = json_decode($response5);
		$c = 0;
		if (isset($images) && $images != "") {
			foreach ($images as $obj) {

				if (!in_array($obj->id, $oldimages)) {
					$curl6 = curl_init();
					$url = "https://kinetisensecloudwestusapp.azurewebsites.net/api/KinetisenseDownload?id=" . $obj->id;
					echo $_SERVER["DOCUMENT_ROOT"] . "<br/><br/>";
					print_r('====' . $obj->id . '======' . $url . "<br/><br/>");

					curl_setopt($curl6, CURLOPT_HTTPHEADER, array('Content-Length: 0'));

					curl_setopt_array($curl6, array(
						CURLOPT_URL => $url,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 30,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_HTTPHEADER => array(
							"cache-control: no-cache",
							"x-zumo-auth: " . $token,
							'Content-Length: 0',
							"zumo-api-version: 2.0.0"
						),
					));

					$response6 = curl_exec($curl6);
					$err = curl_error($curl6);

					curl_close($curl6);
					$finalimages = json_decode($response6);

					print_r($response6);
					print_r($finalimages);

					$url = 'https://kinetisensestorageeast.blob.core.windows.net/';
					$res = $finalimages->resourceName;
					$res = str_replace("\\", "/", $res);
					$url .= $finalimages->containerName . "/" . $res . $finalimages->sasQueryString;
					$l = strlen($finalimages->filePath);
					$s = strrpos($finalimages->filePath, "\\");
					$s++;
					$imgname = substr($finalimages->filePath, $s, $l);
					$img = $_SERVER["DOCUMENT_ROOT"] . '/public/images/kinetisense/' . $finalimages->patientId;
					if (!is_dir($img)) {
						mkdir($img, 0777, true);
					}
					$img = $_SERVER["DOCUMENT_ROOT"] . '/public/images/kinetisense/' . $finalimages->patientId . '/' . $imgname;
					//file_put_contents($img, file_get_contents($url));

					echo $img;

					$ch = curl_init($url);
					$fp = fopen($img, 'wb');
					curl_setopt($ch, CURLOPT_FILE, $fp);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_exec($ch);
					$err = curl_error($ch);
					curl_close($ch);
					fclose($fp);

					$imgarray = array();
					$imgarray['kinetisenseImageId'] = $finalimages->id;
					$imgarray['imagePath'] = $finalimages->filePath;
					$imgarray['resourceName'] = $finalimages->resourceName;
					$imgarray['containerName'] = $finalimages->containerName;
					$imgarray['sasQueryString'] = $finalimages->sasQueryString;
					$imgarray['patientId'] = $finalimages->sasQueryString;
					$imgarray['practitionerId'] = $finalimages->sasQueryString;
					$data['indexKAMS'] = $this->kinetisense_model->addimage($imgarray);

					if ($err) {
						print_r("====================ERROR=======================" . $err);
					}

					//exit;
					//file_put_contents($img, file_get_contents($url));
					//copy($url, $img);
					/*echo "here<br/>";
				echo $url."<br/>";
				echo $img;
				exit;*/
				} else {
					echo $c . " ::::::" . $obj->id . "<br/>";
					$c++;
				}
			}
		}
		curl_close($curl5);

		if ($err) {
			$data['status'] = 0;
			$data['error'] = $err;
		} else {
			$data['status'] = 1;
		}

		$this->load->view('template/header');
		$this->load->view('dashboard/endpoints', $data);
		$this->load->view('template/footer');
	}

	public function sortFunction($a, $b)
	{
		return strtotime($b) - strtotime($a);
	}

	public function createjson()
	{
		$this->load->model('user_model');
		$data = array();

		///get token from response
		$auth_token = GetAuthToken();

		//get all users ids
		$olduser = $this->user_model->fetcholduser();
		$curl = curl_init();

		///loop on every user id 
		foreach ($olduser as $userid) {

			///get assessments for every user
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/api/GetPatientAssessments?patientId=" . $userid,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"x-zumo-auth: " . $auth_token,
					"zumo-api-version: 2.0.0"
				),
			));

			///create image folder with name of user id 
			$img = $_SERVER["DOCUMENT_ROOT"] . '/patientjsonobj/' . $userid;
			if (!is_dir($img)) {
				mkdir($img, 0777, true);
			}

			$response = curl_exec($curl);
			$fp = fopen($img . '/results.json', 'w');
			fwrite($fp, json_encode($response));
			fclose($fp);

			//$str = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/patientjsonobj/' . $userid . '/results.json');
			$res = GetFileContents($userid);
			if ($res == 0) {

				$res = GetPatientAssessments($auth_token, $userid);
			}

			$userob1 = $this->user_model->fetchuserdetails($userid);
			$uniquedatearray2 = array();
			$sortdate2 = array();

			$uniquedatearray = array();
			$sortdate = array();
			$response2 = json_decode($response);

			$newdate = array();
			$diffdate = array();

			//$diffdate[] = '06-17-2020';

			foreach ($res->romAssessments as $romsession) {
				$data1 = array();
				$date = date_create($romsession->date);
				$t = date_format($date, "m-d-Y");
				if (!in_array($t, $uniquedatearray)) {
					$uniquedatearray[] = $t;
					$t1 = date_format($date, "Y-m-d");
					$sortdate[] = $t1;
				}
			}

			foreach ($res->overheadSquatAssessments as $overheadsession) {
				$data1 = array();
				$date = date_create($overheadsession->date);
				$t = date_format($date, "m-d-Y");
				if (!in_array($t, $uniquedatearray)) {
					$uniquedatearray[] = $t;
					$t1 = date_format($date, "Y-m-d");
					$sortdate[] = $t1;
				}
			}

			foreach ($res->reverseLungeAssessments as $reverselungesession) {
				$data1 = array();
				$date = date_create($reverselungesession->date);
				$t = date_format($date, "m-d-Y");
				if (!in_array($t, $uniquedatearray)) {
					$uniquedatearray[] = $t;
					$t1 = date_format($date, "Y-m-d");
					$sortdate[] = $t1;
				}
			}

			foreach ($res->wallAngelAssessments as $wallangelsession) {
				$data1 = array();
				$date = date_create($wallangelsession->date);
				$t = date_format($date, "m-d-Y");
				if (!in_array($t, $uniquedatearray)) {
					$uniquedatearray[] = $t;
					$t1 = date_format($date, "Y-m-d");
					$sortdate[] = $t1;
				}
			}

			foreach ($res->balanceAssessments as $balancesession) {
				$data1 = array();
				$date = date_create($balancesession->date);
				$t = date_format($date, "m-d-Y");
				if (!in_array($t, $uniquedatearray)) {
					$uniquedatearray[] = $t;
					$t1 = date_format($date, "Y-m-d");
					$sortdate[] = $t1;
				}
			}

			foreach ($res->verticalJumpAssessments as $verticaljumpsession) {
				$data1 = array();
				$date = date_create($verticaljumpsession->date);
				$t = date_format($date, "m-d-Y");
				if (!in_array($t, $uniquedatearray)) {
					$uniquedatearray[] = $t;
					$t1 = date_format($date, "Y-m-d");
					$sortdate[] = $t1;
				}
			}

			foreach ($res->functionalAssessments as $funassesssession) {
				$date = date_create($funassesssession->date);
				$tdate = date_format($date, "Y-m-d");
				$t = date_format($date, "m-d-Y");
				if (!in_array($t, $uniquedatearray)) {
					$uniquedatearray[] = $t;
					$sortdate[] = date_format($date, "Y-m-d");
				}
			}

			if (sizeof($sortdate) > 1) {
				foreach ($sortdate as $d1) {
					$timestamp = strtotime($d1);
					$new_date = date("m-d-Y", $timestamp);
					$newdate[] = $new_date;
				}
			}

			foreach ($response2->romAssessments as $romsession) {
				$data1 = array();
				$date = date_create($romsession->date);
				$t = date_format($date, "m-d-Y");
				if (!in_array($t, $uniquedatearray2)) {
					$uniquedatearray2[] = $t;
					$t1 = date_format($date, "Y-m-d");
					$sortdate2[] = $t1;
				}
			}


			foreach ($response2->overheadSquatAssessments as $overheadsession) {
				$data1 = array();
				$date = date_create($overheadsession->date);
				$t = date_format($date, "m-d-Y");
				if (!in_array($t, $uniquedatearray2)) {
					$uniquedatearray2[] = $t;
					$t1 = date_format($date, "Y-m-d");
					$sortdate2[] = $t1;
				}
			}

			foreach ($response2->reverseLungeAssessments as $reverselungesession) {
				$data1 = array();
				$date = date_create($reverselungesession->date);
				$t = date_format($date, "m-d-Y");
				if (!in_array($t, $uniquedatearray2)) {
					$uniquedatearray2[] = $t;
					$t1 = date_format($date, "Y-m-d");
					$sortdate2[] = $t1;
				}
			}

			foreach ($response2->wallAngelAssessments as $wallangelsession) {
				$data1 = array();
				$date = date_create($wallangelsession->date);
				$t = date_format($date, "m-d-Y");
				if (!in_array($t, $uniquedatearray2)) {
					$uniquedatearray2[] = $t;
					$t1 = date_format($date, "Y-m-d");
					$sortdate2[] = $t1;
				}
			}

			foreach ($response2->balanceAssessments as $balancesession) {
				$data1 = array();
				$date = date_create($balancesession->date);
				$t = date_format($date, "m-d-Y");
				if (!in_array($t, $uniquedatearray2)) {
					$uniquedatearray2[] = $t;
					$t1 = date_format($date, "Y-m-d");
					$sortdate2[] = $t1;
				}
			}

			foreach ($response2->verticalJumpAssessments as $verticaljumpsession) {
				$data1 = array();
				$date = date_create($verticaljumpsession->date);
				$t = date_format($date, "m-d-Y");
				if (!in_array($t, $uniquedatearray2)) {
					$uniquedatearray2[] = $t;
					$t1 = date_format($date, "Y-m-d");
					$sortdate2[] = $t1;
				}
			}

			foreach ($response2->functionalAssessments as $funassesssession) {
				$date = date_create($funassesssession->date);
				$tdate = date_format($date, "Y-m-d");
				$t = date_format($date, "m-d-Y");
				if (!in_array($t, $uniquedatearray2)) {
					$uniquedatearray2[] = $t;
					$sortdate2[] = date_format($date, "Y-m-d");
				}
			}

			if (sizeof($sortdate2) > 1) {
				foreach ($sortdate2 as $d1) {
					$timestamp = strtotime($d1);
					$new_date = date("m-d-Y", $timestamp);
					if (!in_array($new_date, $newdate)) {
						$diffdate[] = $new_date;
					}
				}
			}

			if (sizeof($diffdate) > 0) {
				//echo $userid.'-------------------------<br/>';
				//print_r($userob1[0]);
				$fname = $userob1[0]->first_name;
				$lname = $userob1[0]->last_name;
				$assesmentdt = join(", ", $diffdate);

				$to_email = $userob1[0]->user_email;
				//$to_email = 'phil@foundersapproach.com';
				$subject = 'New Assessment Added to the Baseline Motion Portal!';
				$message = '<p style="padding:20px; margin-bottom:30px; text-align:center; background:black; "><img style="max-width:300px; width:100%;" src="https://portal.baselinemotion.com/public/images/logo-white.png"></p><p>Hi ' . $fname . ' ' . $lname . ',</p><p>Your newest assessment from <b>' . $assesmentdt . '</b> has posted onto your Baseline profile. Please feel free to check out your scores as well as our suggested workouts to improve in the future! <br/><br/><a href="https://portal.baselinemotion.com" target="_blank">https://portal.baselinemotion.com</a></p><p>Thanks<br/>The Baseline Motion Team</p>';

				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= 'Cc: derek@baselinemotion.com' . "\r\n";
				$headers .= 'From: Baseline Motion <no-reply@baselinemotion.com>' . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

				echo mail($to_email, $subject, $message, $headers);
				//echo mail('divyesh@foundersapproach.com',$subject,$message,$headers);
				//exit;
			}
		}
	}


	public function edituser()
	{
		$this->load->model('user_model');
		$data = array();
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => KINETISENSE_API_URL . "/api/KinetisenseLogin",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n  \"username\": \"" . KINETISENSE_LOGIN_USERNAME . "\",\n  \"password\": \"" . KINETISENSE_LOGIN_PASSWORD . "\",\n  \"version\": \"1\"\n}",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"zumo-api-version: 2.0.0"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		$datauser = json_decode($response);
		$auth_token = $datauser->mobileServiceAuthenticationToken;

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/tables/Patient",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"x-zumo-auth: " . $auth_token,
				"zumo-api-version: 2.0.0"
			),
		));

		$response = curl_exec($curl);
		/*print_r($response);
		exit;*/
		$outputstr = '';
		$olduser = $this->user_model->fetcholduser();
		$data['olduser'] = $olduser;
		$res = json_decode($response);
		// print_r($res);
		foreach ($res as $newuser) {
			$patient_id = $newuser->id;
			if (in_array($patient_id, $olduser)) {
				$patient_id = $newuser->id;
				$username = $newuser->name . $newuser->surname;
				$email = $newuser->email;

				if ($newuser->imagePath != "") {
					$imgpath = $newuser->imagePath;
					$startstr = strrpos($imgpath, "\\");
					$startstr++;
					$endstr = strlen($imgpath);
					$profile_pic = substr($imgpath, $startstr, $endstr);
				} else {
					$profile_pic = '';
				}
				$user = $this->user_model->updateuser($patient_id, $username, $email, $profile_pic, $newuser->name, $newuser->surname);
				if ($user > 0)
					$olduser[] = $patient_id;

				$outputstr .= '--' . $user . '--<br/>';
			}
		}
		$err = curl_error($curl);

		$data['outputstr'] = $outputstr;
		curl_close($curl);

		if ($err) {
			$data['status'] = 0;
			$data['error'] = $err;
		} else {
			$data['status'] = 1;
		}

		$this->load->view('cronjob/edituser', $data);
	}

	///Function Modified 
	///ApiSendEmail Mail For Not Responding Api 

	///sendEmail
	function Email()
	{
		// Load the email library 
		$this->load->library('email');
		// Mail config
		$to =  'divyesh@foundersapproach.com';
		$from = 'no-reply@baselinemotion.com';
		$fromName = 'Baselinemotion.com';
		$mailSubject = 'Cron Call';
		// Mail content
		$mailContent = '
           <h4>Inform You That:</h4>  
           <h3>Dear, Admin</h3><p>Cron is just fired now. Please check it out.</p><br/><br/><p>Thanks<br/>The Baseline Motion Team</p>';

		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->to($to);
		$this->email->from($from, $fromName);
		$this->email->subject($mailSubject);
		$this->email->message($mailContent);

		// Send email & return status
		return $this->email->send() ? true : false;
	}


	///php mailer function 
	/////
	function sendEmail($to, $subject, $message, $from = 'no-reply@baselinemotion.com', $fromname = 'Baselinemotion')
	{

		// Replace sender@example.com with your "From" address.
		// This address must be verified with Amazon SES.
		$sender = $from;
		$senderName = $fromname;
		$recipient = $to;
		$usernameSmtp = 'AKIAVPVVEXS65CGO64UE';
		$passwordSmtp = 'BMlSeC/G4/DZn9GlqfTxy/uEu4Tp76YdFU9xdLC+8shy';
		$host = 'email-smtp.us-east-1.amazonaws.com';
		$port = 587;
		// The plain-text body of the email
		$bodyText =  "Email Test\r\nThis email was sent through the Amazon SES SMTP interface using the PHPMailer class.";

		// The HTML-formatted body of the email
		$bodyHtml = '<h1>Email Test</h1>
	    <p>This email was sent through the
	    <a href="https://aws.amazon.com/ses">Amazon SES</a> SMTP
	    interface using the <a href="https://github.com/PHPMailer/PHPMailer">
	    PHPMailer</a> class.</p>';

		$bodyText = $message;
		$bodyHtml = $message;

		$mail = new PHPMailer(true);

		try {

			// Specify the SMTP settings.
			$mail->isSMTP();
			$mail->setFrom($sender, $senderName);
			$mail->Username   = $usernameSmtp;
			$mail->Password   = $passwordSmtp;
			$mail->Host       = $host;
			$mail->Port       = $port;
			$mail->SMTPAuth   = true;
			$mail->SMTPSecure = 'tls';
			#    $mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);

			// Specify the message recipients.
			$mail->addAddress($recipient);
			// You can also add CC, BCC, and additional To recipients here.

			// Specify the content of the message.
			$mail->isHTML(true);
			$mail->Subject    = $subject;
			$mail->Body       = $bodyHtml;
			$mail->AltBody    = $bodyText;


			$mail->Send();

			echo "Email sent!", PHP_EOL;

			return true;
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
}
