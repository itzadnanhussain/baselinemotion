<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pre_Event extends CI_Controller
{
    ///Load User Model
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    ///Load Index View Of Pre Event 
    public function index()
    {
        $this->load->model('user_model');
        $data = array();
        $user_id = $this->session->get_userdata()['user_id'];

        if (isset($user_id) && $user_id != "") {
            $data["videoslist"] = $this->user_model->fetchchecklist($user_id);
        }

        ///view load code 
        $this->load->view('template/header');
        $this->load->view('pre_event/checklist', $data);
        $this->load->view('template/footer');
    }


    ///Manage Pre event checklist  here 
    public function  manage_pre_event()
    {
        ///For Post Request By Ajax
        if ($this->input->is_ajax_request()) {

            if (isset($_POST['user_id']) && sizeof($_POST['user_id']) > 0) {
                foreach ($_POST['user_id'] as $userid) {
                    if (isset($_POST['id'])) {
                        // $this->user_model->deletecombinescores($_POST['id']);
                        deleteRecordWhere('pre_events', array('id' => $_POST['id']));
                    }
                    $data = array(
                        'user_id' => $userid,
                        'code'  => $_POST['code'],
                        'status'   => 1
                    );

                    // $this->user_model->insertcombinescores($data);
                    addNew('pre_events', $data);
                }
                ///Success
                $data = array('code' => 'success');
                echo json_encode($data);
                die;
            } else {
                ///credential not correct
                $data = array('code' => 'warning');
                echo json_encode($data);
                die;
            }
        } else {

            $data = array();
            ///Get User List
            $data["userlist"] = $this->user_model->fetchuser();


            ///Get Table Records Joins 
            $tableSelect = "tb1.*, tb2.first_name,tb2.last_name";
            $tableInfo = "pre_events tb1, users tb2-tb2.id=tb1.user_id-left";
            $result = getByWhere($tableInfo, $tableSelect, array(), array('id', 'DESC'));



            // $result = getByWhere('pre_events');
            if ($result) {
                $data['result'] = $result;
            }

            ///For Edit Purpose
            if (isset($_GET['id']) && $_GET['id'] != "") {
                $data["videosembed"] = $this->user_model->fetchpre_events($_GET['id']);
                // $data["videosembed"] = getByWhere('pre_events','*',array('id'=>$_GET['id']));
                // $data["videosembed"] =(array)$data['videosembed'];
            }

            ///view load code 
            $this->load->view('template/header');
            $this->load->view('pre_event/manage_details', $data);
            $this->load->view('template/footer');
        }

    }


    ///Delete Records
    public function DeleteRecord()
    {
        $table = $this->uri->segment(2);
        $feild = $this->uri->segment(3);
        $value = $this->uri->segment(4);
        $result = deleteRecordWhere($table, array($feild => $value));

        if ($result) {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    

    ///testfn
    public function test()
    {
        $str = 'VGhpcyBpcyBhbiBlbmNvZGVkIHN0cmluZw==';
        echo base64_decode($str);
        die;
    }
}
