<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
    public $user_data;
    function __construct() {
        parent::__construct();
        if(!$this->session->userdata('username')) {
            redirect('login', 'redirect');
        } else {
            $this->load->model('user_model');
            $this->user_data = $this->user_model->Get($this->session->userdata('user_id'));
			if($this->user_data->device_token != $this->session->userdata('device_token'))
				redirect('logout', 'redirect');
        }
    }
}