<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_ide/general/urls.html
     */
    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index() {
		$this->load->helper('cookie');
        $this->load->view('login');
    }

    public function validate() {
        //Including validation library
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><span>', '</div></span>');

        //Validating Fields
        $rules[] = array('field' => 'username', 'label' => 'Username', 'rules' => 'required');
        $rules[] = array('field' => 'password', 'label' => 'Password', 'rules' => 'required|callback_validate_login', 'errors' => array('validate_login' => 'Incorrect username or password.'));

        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            // Validation failed
            return $this->index();
        } else {
            // Validation succeeded!
            redirect('dashboard', 'redirect');
        }
    }
	
	public function validatesignup() {
        //Including validation library
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><span>', '</div></span>');

        //Validating Fields
        $rules[] = array('field' => 'name', 'label' => 'Name', 'rules' => 'required');
		$rules[] = array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email|callback_validate_signup','errors' => array('validate_signup' => 'Your email does not exist.'));

        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            // Validation failed
            return $this->signupreq();
        } else {
			
			$data = array();
			$data['name'] = $this->input->post('name');
			$data['email'] = $this->input->post('email');
			$data['notes'] = $this->input->post('notes');
			$user = $this->user_model->users_request($data);
			
			$to_email = 'phil@foundersapproach.com';
			$subject = 'New User Registration Request';
			$message = '<h3>Hello Admin,</h3><p>A new user has signed up online for your website. <br/><br/><b>Name: </b>'.$data['name'].'<br/><b>Email: </b>'.$data['email'].'<br/><b>Notes: </b>'.$data['notes'].'</p><br/><br/><p>Thanks<br/>The Baseline Motion Team</p>';
			//$headers = 'From: noreply @ company . com';
			
			$headers = "MIME-Version: 1.0" . "\r\n"; 
			$headers .= 'From: Baseline Motion <no-reply@baselinemotion.com>'. "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
			
			//mail($to_email,$subject,$message,$headers);
			//mail('derek@baselinemotion.com',$subject,$message,$headers);
			
            // Validation succeeded!.
			$this->session->set_flashdata('msg', "We have received your request and will be in touch soon.");
            $this->session->set_flashdata('msg_class', 'success');
            redirect('login/signupreq', 'redirect');
        }
    }

	public function validate_signup($str) {
        // Create array for database fields & data
        $data = array();
        $data['name'] = $this->input->post('name');
        $data['email'] = $str;
		$data['user_email'] = $str;
		$user = $this->user_model->ValidateEmail($data);
		 
        if (count($user['records']) == 1) {
            return false;
        } else {
            return true;
        }
    }
	
	public function updatejsonuser($userid)
	{
		$this->load->model('user_model');
		$data = array();
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
				CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/api/GetPatientAssessments?patientId=".$userid,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"x-zumo-auth: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJkZXJla0AzcHNwb3J0cy5jb20iLCJ2ZXIiOiIzIiwiaXNzIjoiaHR0cHM6Ly9raW5ldGlzZW5zZWNsb3Vkd2VzdHVzYXBwLmF6dXJld2Vic2l0ZXMubmV0LyIsImF1ZCI6Imh0dHBzOi8va2luZXRpc2Vuc2VjbG91ZHdlc3R1c2FwcC5henVyZXdlYnNpdGVzLm5ldC8iLCJleHAiOjE1ODk1NjAzMjksIm5iZiI6MTU4Njk2ODMyOX0.hGvDGy4Yr05SaG2HnB4hlFTV82X2MNEgGkJQEIypm2w",
					"zumo-api-version: 2.0.0"
				),
			));

			$img = $_SERVER["DOCUMENT_ROOT"].'/patientjsonobj/'.$userid;
			if(!is_dir($img)) {
				mkdir($img,0777,true);
			}
			
			$response = curl_exec($curl);
			$fp = fopen($img.'/results.json', 'w');
			fwrite($fp, json_encode($response));   // here it will print the array pretty
			fclose($fp);
			
			$updatearray = array();
			$updatearray['fetchobj'] = 1;
			$updatearray['fetchdate'] = date('Y-m-d h:i:s');
			$this->user_model->usersEdit($userid, $updatearray);
			
		return true;
	}

    public function validate_login($str) {
        // Create array for database fields & data
        $data = array();
        $data['username'] = $this->input->post('username');
        $data['password'] = $str;
		$this->load->helper('cookie');
        $user = $this->user_model->ValidateLogin($data);
        if (count($user['records']) == 1) {
			$this->load->helper('string');
			$rand_password_code = random_string('numeric', 16);
           // if ($user['records'][0]->confirmed == 1) {

				$curl = curl_init();
				$user99 = $this->user_model->parentuser($user['records'][0]->parentid);
				
				curl_setopt_array($curl, array(
					CURLOPT_URL => KINETISENSE_API_URL."/api/KinetisenseLogin",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => "{\n  \"username\": \"".$user99['records'][0]->email."\",\n  \"password\": \"".$user99['records'][0]->password."\",\n  \"version\": \"1\"\n}",
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
				/*print_r($auth_token);
				exit;*/
				if ($err) {
					//echo "cURL Error #:" . $err;
					$this->session->set_flashdata('msg', $err);
					$this->session->set_flashdata('msg_class', 'failure');
					redirect('login', 'redirect');
				} else {
					//echo $response;
					if($auth_token!=""){
						$this->session->set_userdata(array('username' => $user['records'][0]->username,
							'user_id' => $user['records'][0]->id,
							'profile_pic' => $user['records'][0]->profile_pic,
							'patientid' => $user['records'][0]->patientid,
							'user_type' => $user['records'][0]->user_type,
							'fetchobj' => $user['records'][0]->fetchobj,
							'device_token' => $rand_password_code,
							'authtoken' => $auth_token
						));

						//$this->updatejsonuser($user['records'][0]->patientid);
						
						
						if ($this->input->post('remember')) {
							set_cookie(array(
								'name' => 'username',
								'value' => $data['username'],
								'expire' => time()+86500,
								'domain' => '.baseline.foundersapproach.org',
								'path'   => '/',
								'prefix' => 'actx_'
							));

							set_cookie(array(
								'name' => 'password',
								'value' => $data['password'],
								'expire' => time()+86500,
								'domain' => '.baseline.foundersapproach.org',
								'path'   => '/',
								'prefix' => 'actx_'
							));	
						}
						
						$updateddata = array(); 
						$updateddata['device_token'] = $rand_password_code;
						$this->user_model->Edit($user['records'][0]->id, $updateddata);
						return true;
					}
					else{
						$this->session->set_flashdata('msg', $response);
						$this->session->set_flashdata('msg_class', 'failure');
						redirect('login', 'redirect');
					}
				}
			   
              
				
            // } else {
            //     $this->session->set_flashdata('msg', "please verify your account");
            //     $this->session->set_flashdata('msg_class', 'failure');
            //     redirect('login', 'redirect');
            // }
        } else {
            return false;
        }
    }

    public function chkEmail() {
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><span>', '</div></span>');

        //Validating Fields
        $rules[] = array('field' => 'email', 'label' => 'Email', 'rules' => 'required|callback_validate_email', 'errors' => array('validate_email' => 'Your email does not exist.'));

        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            // Validation failed
            return $this->forgotpassword();
        } else {
            $search = array('user_email' => $this->input->post('email'));
            $result = $this->user_model->Get(NULL, $search);
            if (count($result['countFiltered']) > 0 && !empty($result['records'])) {
                if ($result['records'][0]->confirmed == 1) {

                    $this->load->helper('string');
                    $rand_password_code = random_string('numeric', 6);

                    $data['reset_password_code'] = $rand_password_code;
                    $this->user_model->Edit($result['records'][0]->id, $data);

                    $this->sendVerificationEmail($type = 'Reset Password', $result['records'][0], $rand_password_code);


                    $this->session->set_flashdata('msg', "Please check your email for password reset link.");
                    $this->session->set_flashdata('msg_class', 'success');
                    redirect('login/reset_password', 'redirect');
                } else {
                    $this->session->set_flashdata('msg', "Please verify your account.");
                    $this->session->set_flashdata('msg_class', 'failure');
                    redirect('login/forgotpassword', 'redirect');
                }
            } else {
                $this->session->set_flashdata('msg', "Please enter valid email address.");
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('login/forgotpassword', 'redirect');
            }
        }
    }

    public function reset_password() {
        $user_id = $this->input->get('user_id');
        if ($user_id) {
            $data['title'] = 'Reset Password';
            $data['user_id'] = $user_id;
            $this->load->view('login/reset_password', $data);
        } else {
            redirect('login', 'redirect');
        }
    }
	
	public function create_password() {
        $user_id = $this->input->get('user_id');
        if ($user_id) {
            $data['title'] = 'Create Password';
            $data['user_id'] = $user_id;
            $this->load->view('login/create_password', $data);
        } else {
            redirect('login', 'redirect');
        }
    }
	
	
	public function forgotpassword() {
        $this->load->view('login/forgotpassword');
    }
	
	public function signupreq() {
        $this->load->view('login/signupreq');
    }

    public function verify_reset_password_code() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

        //Validating Fields
        $rules[] = array('field' => 'reset_password_code', 'label' => 'Code ', 'rules' => 'required');
        $rules[] = array('field' => 'password', 'label' => 'Password', 'rules' => 'required|matches[conf_password]');
        $rules[] = array('field' => 'conf_password', 'label' => 'Confirm Password', 'rules' => 'required');

        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {

            return $this->reset_password();
        
		} else {
			
            $user_id = $this->input->get_post('user_id');
            $result = $this->user_model->Get($user_id);
			//print_r($result);
            if (!empty($result)) {

                $user_email = $result->user_email;
                $user_id = $result->id;
                $search = array('reset_password_code' => $this->input->post('reset_password_code'));
                $code_result = $this->user_model->Get(NULL, $search);
			//	print_r($code_result);
                if (!empty($code_result['records'])) {
					
                   // $data['password'] = md5($this->input->post('password'));
				    $data['password'] = $this->user_model->encryptData($this->input->post('password'),$result->ivv_code);
					$data['reset_password_code'] = '';
					
					//print_r($data);
                    $this->user_model->Edit($code_result['records'][0]->id, $data);

                    $this->session->set_flashdata('msg', "Your password has been changed successfully.");
                    $this->session->set_flashdata('msg_class', 'success');
                    redirect('login', 'redirect');
					
                } else {
                    $this->load->helper('string');
                    $rand_password_code = random_string('numeric', 6);

                    $data['reset_password_code'] = $rand_password_code;
                    $this->user_model->Edit($user_id, $data);

                    $this->sendVerificationEmail($type = 'Reset Password', $result, $rand_password_code);
                    $this->session->set_flashdata('msg', "Reset link is expired. Please request reset password again.");
                    $this->session->set_flashdata('msg_class', 'failure');
                    redirect('login', 'redirect');
                }
            } else {
                $this->session->set_flashdata('msg', "Please check your code");
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('login', 'redirect');
            }
        }
    }

    public function validate_email($str) {
        // Create array for database fields & data
        $data = array();
        $data['user_email'] = $str;
        $user = $this->user_model->ValidateEmail($data);
		
        if (isset($user['records']->id) && $user['records']->id != "") {
            //if ($user['records']->confirmed == 1) {
                $this->load->helper('string');
                $rand_password_code = random_string('numeric', 6);
                $data['reset_password_code'] = $rand_password_code;
                $this->user_model->Edit($user['records']->id, $data);
                $this->sendVerificationEmail($type = 'Reset Password', $user['records'], $rand_password_code);
                $this->session->set_flashdata('msg', "Please check your email for reset password link.");
                $this->session->set_flashdata('msg_class', 'success');
                redirect('login', 'redirect');
            // } else {
            //     $this->session->set_flashdata('msg', "Please verify your account");
            //     $this->session->set_flashdata('msg_class', 'failure');
            //     redirect('login', 'redirect');
            // }
        } else {
            return false;
        }
    }

    public function register_success() {
        $data['title'] = 'Registartion Success';
        $this->load->view('registration_success', $data);
    }

    public function sendVerificationEmail($type = 'Login', $result_arr = array(), $emailHash) {
		$this->load->library('email');
        if ($type == 'Reset Password') {
            $usr_id = isset($result_arr->id) ? $result_arr->id : '';
            $usr_email = isset($result_arr->user_email) ? $result_arr->user_email : '';
			//$usr_email = 'divyesh@foundersapproach.com';
            $subject = "Your password reset  for Baseline Motion";
            $link = base_url() . "login/reset_password?user_id=" . $usr_id."&token=". $emailHash;
            
			$param = array();
            $template = 'reset_password.html';
            $param['RESET_PASSWORD_URL'] = $link;
            $param['USERNAME'] = isset($result_arr->user_fname) ? $result_arr->user_fname . " " . $result_arr->user_lname : $result_arr->username;
            $param['RESET_PASSWORD_CODE'] = $emailHash;
            $param['LOGO'] = base_url() . "public/images/logo-black.png";
			// $this->email->from('your@example.com', 'Your Name');
			
			/*
			$this->email->set_mailtype("html");
			$this->email->message('<h3>Dear, '.$param['USERNAME'].'</h3><p>Here is the Your Reset Password Link: <a href="'.$param['RESET_PASSWORD_URL'].'">Click Here</a>.<br/>Here is the 6 digit numeric code : <b>'.$param['RESET_PASSWORD_CODE'].'</b></p><br/><br/><p>Thanks<br/>The Baseline Motion Team</p>');
			$this->email->subject($subject);
			$this->email->to($usr_email);
			$this->email->send(); */
			
			$to_email = $usr_email;
			//$to_email = 'divyesh@foundersapproach.com';
			$subject = $subject;
			$message = '<h3 style="font-weight:400;">Dear '.$param['USERNAME'].',</h3><p>You recently requested a password reset on the Baseline Motion website. Click this link below to reset your password.<br/> <a href="'.$param['RESET_PASSWORD_URL'].'">'.$param['RESET_PASSWORD_URL'].'</a></p><br/><br/><p>Thanks<br/>The Baseline Motion Team</p>';
			$headers = "MIME-Version: 1.0" . "\r\n"; 
			$headers .= 'From: Baseline Motion <no-reply@baselinemotion.com>'. "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 

			mail($to_email,$subject,$message,$headers);
            //$this->amazonemail->sendEmail($usr_email, $subject, $param, $template);
        } else {
            $usr_email = isset($result_arr['email']) ? $result_arr['email'] : '';
            $subject = "Please confirm your " . SITE_NAME . " account";
            $link = base_url() . "login/verify_email?verificationcode=" . $emailHash;
            $param = array();
            $template = 'user_activatation.html';
            $param['LOGIN_URL'] = $link;
            $param['USERNAME'] = isset($result_arr['name']) ? $result_arr['name'] : '';
            $param['LOGO'] = base_url() . "/assets/layouts/layout/img/logo.png";
            $this->amazonemail->sendEmail($usr_email, $subject, $param, $template);
        }
    }

    public function verify_email() {
        $emailHash = $this->input->get('verificationcode');
        $search = array('signup_hash' => $emailHash);
        $result = $this->user_model->Get(NULL, $search);

        if (count($result['countFiltered']) > 0 && !empty($result['records'])) {
            //Account has already been confirmed
            if ($result['records'][0]->confirmed == 1) {
                $this->session->set_flashdata('msg', "Your account has been already verified.");
                $this->session->set_flashdata('msg_class', 'success');
                redirect('login', 'redirect');
            }
            //Confirm account
            else {
                $add_min = date("Y-m-d H:i:s", strtotime($result['records'][0]->created_on . "+72 hour"));
                if ($add_min > date("Y-m-d H:i:s")) {
                    $data['confirmed'] = 1;
                    $this->user_model->Edit($result['records'][0]->id, $data);
                    $this->session->set_userdata(array('username' => $result['records'][0]->username,
                        'user_id' => $result['records'][0]->id,
                        'profile_pic' => $result['records'][0]->profile_pic
                    ));
                    redirect('dashboard', 'redirect');
                } else {
                    $del_result = $this->user_model->Delete($result['records'][0]->id);
                    $this->session->set_flashdata('msg', "Your activation code has been expired. Please try again.");
                    $this->session->set_flashdata('msg_class', 'failure');
                    redirect('login', 'redirect');
                }
            }
        }
        //Incorrect or expired confirmation hash
        else {
            $this->session->set_flashdata('msg', "Your activation code has been Invalid or expired.");
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('welcome', 'redirect');
        }
    }
}