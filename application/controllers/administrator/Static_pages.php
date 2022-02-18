<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Static Pages Controller
*| --------------------------------------------------------------------------
*| Static Pages site
*|
*/
class Static_pages extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_static_pages');
	}

	/**
	* show all Static Pagess
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('static_pages_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['static_pagess'] = $this->model_static_pages->get( $filter, $field, $this->limit_page, $offset);
		$this->data['static_pages_counts'] = $this->model_static_pages->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/static_pages/index/',
			'total_rows'   => $this->model_static_pages->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Static Pages List');
		$this->render('backend/standart/administrator/static_pages/static_pages_list', $this->data);
	}
	
	
		/**
	* Update view Static Pagess
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('static_pages_update');

		$this->data['static_pages'] = $this->model_static_pages->find($id);

		$this->template->title('Static Pages Update');
		$this->render('backend/standart/administrator/static_pages/static_pages_update', $this->data);
	}

	/**
	* Update Static Pagess
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('static_pages_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[1024]');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
					'name' => ($this->input->post('name') === '') ? NULL : $this->input->post('name'),
					'content' => ($this->input->post('content') === '') ? NULL : $this->input->post('content'),
			];

			

			$save_static_pages = $this->model_static_pages->change($id, $save_data);

			if ($save_static_pages) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/static_pages', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/static_pages');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/static_pages');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Static Pagess
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('static_pages_delete');

		$this->load->helper('file');

		$arr_id = $this->input->get('id');
		$remove = false;

		if (!empty($id)) {
			$remove = $this->_remove($id);
		} elseif (count($arr_id) >0) {
			foreach ($arr_id as $id) {
				$remove = $this->_remove($id);
			}
		}

		if ($remove) {
            set_message(cclang('has_been_deleted', 'static_pages'), 'success');
        } else {
            set_message(cclang('error_delete', 'static_pages'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Static Pagess
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('static_pages_view');

		$this->data['static_pages'] = $this->model_static_pages->join_avaiable()->select_string()->find($id);

		$this->template->title('Static Pages Detail');
		$this->render('backend/standart/administrator/static_pages/static_pages_view', $this->data);
	}
	
	/**
	* delete Static Pagess
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$static_pages = $this->model_static_pages->find($id);

		
		
		return $this->model_static_pages->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('static_pages_export');

		$this->model_static_pages->export('static_pages', 'static_pages');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('static_pages_export');

		$this->model_static_pages->pdf('static_pages', 'static_pages');
	}
}


/* End of file static_pages.php */
/* Location: ./application/controllers/administrator/Static Pages.php */
