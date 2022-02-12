<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Report Web Controller
*| --------------------------------------------------------------------------
*| Report Web site
*|
*/
class Report_web extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_report_web');
	}

	/**
	* show all Report Webs
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('report_web_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['report_webs'] = $this->model_report_web->get( $filter, $field, $this->limit_page, $offset);
		$this->data['report_web_counts'] = $this->model_report_web->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/report_web/index/',
			'total_rows'   => $this->model_report_web->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Report Web List');
		$this->render('backend/standart/administrator/report_web/report_web_list', $this->data);
	}
	
	/**
	* Add new report_webs
	*
	*/
	public function add()
	{
		$this->is_allowed('report_web_add');

		$this->template->title('Report Web New');
		$this->render('backend/standart/administrator/report_web/report_web_add', $this->data);
	}

	/**
	* Add New Report Webs
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('report_web_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('report_name', 'Report Name', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('table_name', 'Table Name', 'trim|required|max_length[2048]');
		$this->form_validation->set_rules('parent_report_id', 'Parent Report Id', 'trim|max_length[11]');
		$this->form_validation->set_rules('icon', 'Icon', 'trim|required|max_length[25]');
		$this->form_validation->set_rules('sequence', 'Sequence', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('columns', 'Columns', 'trim|max_length[4096]');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
					'report_name' => ($this->input->post('report_name') === '') ? NULL : $this->input->post('report_name'),
					'table_name' => ($this->input->post('table_name') === '') ? NULL : $this->input->post('table_name'),
					'parent_report_id' => ($this->input->post('parent_report_id') === '') ? NULL : $this->input->post('parent_report_id'),
					'icon' => ($this->input->post('icon') === '') ? NULL : $this->input->post('icon'),
					'sequence' => ($this->input->post('sequence') === '') ? NULL : $this->input->post('sequence'),
					'columns' => ($this->input->post('columns') === '') ? NULL : $this->input->post('columns'),
			];

			
			$save_report_web = $this->model_report_web->store($save_data);

			if ($save_report_web) {
				$this->data['id']          = $save_report_web;
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/report_web/edit/' . $save_report_web, 'Edit Report Web'),
						anchor('administrator/report_web', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/report_web/edit/' . $save_report_web, 'Edit Report Web')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/report_web');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/report_web');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Report Webs
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('report_web_update');

		$this->data['report_web'] = $this->model_report_web->find($id);

		$this->template->title('Report Web Update');
		$this->render('backend/standart/administrator/report_web/report_web_update', $this->data);
	}

	/**
	* Update Report Webs
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('report_web_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('report_name', 'Report Name', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('table_name', 'Table Name', 'trim|required|max_length[2048]');
		$this->form_validation->set_rules('parent_report_id', 'Parent Report Id', 'trim|max_length[11]');
		$this->form_validation->set_rules('icon', 'Icon', 'trim|required|max_length[25]');
		$this->form_validation->set_rules('sequence', 'Sequence', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('columns', 'Columns', 'trim|max_length[4096]');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
					'report_name' => ($this->input->post('report_name') === '') ? NULL : $this->input->post('report_name'),
					'table_name' => ($this->input->post('table_name') === '') ? NULL : $this->input->post('table_name'),
					'parent_report_id' => ($this->input->post('parent_report_id') === '') ? NULL : $this->input->post('parent_report_id'),
					'icon' => ($this->input->post('icon') === '') ? NULL : $this->input->post('icon'),
					'sequence' => ($this->input->post('sequence') === '') ? NULL : $this->input->post('sequence'),
					'columns' => ($this->input->post('columns') === '') ? NULL : $this->input->post('columns'),
			];

			

			$save_report_web = $this->model_report_web->change($id, $save_data);

			if ($save_report_web) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/report_web', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/report_web');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/report_web');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Report Webs
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('report_web_delete');

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
            set_message(cclang('has_been_deleted', 'report_web'), 'success');
        } else {
            set_message(cclang('error_delete', 'report_web'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Report Webs
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('report_web_view');

		$this->data['report_web'] = $this->model_report_web->join_avaiable()->select_string()->find($id);

		$this->template->title('Report Web Detail');
		$this->render('backend/standart/administrator/report_web/report_web_view', $this->data);
	}
	
	/**
	* delete Report Webs
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$report_web = $this->model_report_web->find($id);

		
		
		return $this->model_report_web->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('report_web_export');

		$this->model_report_web->export('report_web', 'report_web');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('report_web_export');

		$this->model_report_web->pdf('report_web', 'report_web');
	}
}


/* End of file report_web.php */
/* Location: ./application/controllers/administrator/Report Web.php */
