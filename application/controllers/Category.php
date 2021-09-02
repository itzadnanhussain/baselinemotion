<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Category extends MY_Controller
{
	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('category/category');
		$this->load->view('template/footer');
	}
	public function get_category()
	{
		$JSON = array();
		$cat_id = $this->input->post('cat_id');
		if ($cat_id) {
			$this->load->model('category_model');
			$cat_data = $this->category_model->get_category($cat_id);
			$JSON['flag'] = true;
			$JSON['data'] = $cat_data;
		} else {
			$JSON['flag'] = false;
			$JSON['msg'] = 'Something went wrong Please try again after reloading page';
		}
		echo json_encode($JSON);
		exit(0);
	}

	public function get_category_data()
	{
		$this->load->model('category_model');
		$start = $this->input->get('iDisplayStart');
		$limit = $this->input->get('iDisplayLength');
		$search = $this->input->get('sSearch');
		$sort_col = $this->input->get('iSortingCols');
		$sort = $this->input->get('sSortDir_0');
		$sort_col = 'categoryName';
		if ($sort_col == 0) {
			$sort_col = 'categoryName';
		}
		$result = $this->category_model->get_category('', $search, $limit, $start, $sort_col, $sort);
		$record = array();
		$k = 0;
		foreach ($result['data'] as $value) {
			$record[$k]['categoryName'] = $value->categoryName;
			$record[$k]['image'] = $value->image;
			$record[$k]['action'] = '<a href="javascript:void(0)" class="btn btn-success btn-flat btn-xs edit-category" data-id="' . $value->id . '"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-flat btn-xs delete-category" data-id="' . $value->id . '"><i class="fa fa-edit"></i>&nbsp;&nbsp;Delete</a>';
			// print_r($value);
			$k++;
			# code...
		}
		$result['data'] = $record;
		// exit(0);
		$result['sEcho'] = $this->input->get('sEcho');
		echo json_encode($result);
		exit(0);
	}
	
	public function add_edit_category()
	{
		$JSON = array();
		$this->load->model('category_model');
		$this->load->library('form_validation');
		$action = $this->input->post('form-action');
		$formConfig = array(
			array(
				'field' => 'category-name',
				'label' => 'Category Name',
				'rules' => 'trim|required',
				array(
					'required'   => '%s required',
				)
			)
		);
		$this->form_validation->set_rules($formConfig);

		if ($this->form_validation->run() == FALSE) {
			$JSON['flag'] = false;
			$JSON['msg'] = 'Please Check Form!!';
		} else {
			$data = array();
			$data['categoryName'] =  $this->input->post('category-name');
			if ($action && $action == 'add') {
				$id = $this->category_model->Add($data);
				if (!empty($id)) {
					$JSON['flag'] = true;
					$JSON['msg'] = 'Successfully Added !!';
				} else {
					$JSON['flag'] = false;
					$JSON['msg'] = 'Something went wrong Please try again after reloading page';
				}
			} else if ($action == 'edit') {
				$cat_id = $this->input->post('cat-id');
				if ($cat_id && !empty($cat_id)) {
					$cat_data = $this->category_model->Edit($cat_id, $data);
					$JSON['flag'] = true;
					$JSON['msg'] = 'Successfully Edited !!';
				} else {
					$JSON['flag'] = false;
					$JSON['msg'] = 'Something went wrong Please try again after reloading page';
				}
			} else {
				$JSON['flag'] = false;
				$JSON['msg'] = 'Something went wrong Please try again after reloading page';
			}
		}

		echo json_encode($JSON);
		exit(0);
	}

	public function delete_category()
	{
		$JSON = array();
		$data = array();
		$data['isDelete'] = 1;
		$cat_id = $this->input->post('cat_id');

		if ($cat_id) {
			$this->load->model('category_model');
			$cat_data = $this->category_model->Edit($cat_id, $data);
			$JSON['flag'] = true;
			$JSON['msg'] = 'Successfully Deleted !!';
		} else {
			$JSON['flag'] = false;
			$JSON['msg'] = 'Something went wrong Please try again after reloading page';
		}

		echo json_encode($JSON);
		exit(0);
	}
}
