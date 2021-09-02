<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {
		
		$user_id = $this->session->userdata('user_id');
		$this->load->model('user_model');
		$updateddata = array(); 
		$updateddata['device_token'] = '';
		$this->user_model->Edit($user_id, $updateddata);

		$this->session->sess_destroy();
		$this->load->helper('cookie');
		delete_cookie('actx_username');
		delete_cookie('actx_password');
		redirect('login', 'redirect');
	}
}
