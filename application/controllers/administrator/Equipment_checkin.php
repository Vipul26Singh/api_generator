<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Equipment Checkin Controller
*| --------------------------------------------------------------------------
*| Equipment Checkin site
*|
*/
class Equipment_checkin extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_equipment_checkin');
	}

	/**
	* show all Equipment Checkins
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('equipment_checkin_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['equipment_checkins'] = $this->model_equipment_checkin->get( $filter, $field, $this->limit_page, $offset);
		$this->data['equipment_checkin_counts'] = $this->model_equipment_checkin->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/equipment_checkin/index/',
			'total_rows'   => $this->model_equipment_checkin->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Equipment Checkin List');
		$this->render('backend/standart/administrator/equipment_checkin/equipment_checkin_list', $this->data);
	}
	
	/**
	* Add new equipment_checkins
	*
	*/
	public function add()
	{
		$this->is_allowed('equipment_checkin_add');

		$this->template->title('Equipment Checkin New');
		$this->render('backend/standart/administrator/equipment_checkin/equipment_checkin_add', $this->data);
	}

	/**
	* Add New Equipment Checkins
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('equipment_checkin_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('equipment_id', 'Equipment Id', 'trim|required|max_length[11]');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
					'equipment_id' => ($this->input->post('equipment_id') === '') ? NULL : $this->input->post('equipment_id'),
				'equipment_in_datetime' => date('Y-m-d H:i:s'),
			];

			
			$save_equipment_checkin = $this->model_equipment_checkin->store($save_data);

			if ($save_equipment_checkin) {
				$this->data['id']          = $save_equipment_checkin;
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/equipment_checkin/edit/' . $save_equipment_checkin, 'Edit Equipment Checkin'),
						anchor('administrator/equipment_checkin', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/equipment_checkin/edit/' . $save_equipment_checkin, 'Edit Equipment Checkin')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/equipment_checkin');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/equipment_checkin');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Equipment Checkins
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('equipment_checkin_update');

		$this->data['equipment_checkin'] = $this->model_equipment_checkin->find($id);

		$this->template->title('Equipment Checkin Update');
		$this->render('backend/standart/administrator/equipment_checkin/equipment_checkin_update', $this->data);
	}

	/**
	* Update Equipment Checkins
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('equipment_checkin_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('equipment_id', 'Equipment Id', 'trim|required|max_length[11]');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
					'equipment_id' => ($this->input->post('equipment_id') === '') ? NULL : $this->input->post('equipment_id'),
				'equipment_in_datetime' => date('Y-m-d H:i:s'),
			];

			

			$save_equipment_checkin = $this->model_equipment_checkin->change($id, $save_data);

			if ($save_equipment_checkin) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/equipment_checkin', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/equipment_checkin');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/equipment_checkin');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Equipment Checkins
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('equipment_checkin_delete');

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
            set_message(cclang('has_been_deleted', 'equipment_checkin'), 'success');
        } else {
            set_message(cclang('error_delete', 'equipment_checkin'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Equipment Checkins
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('equipment_checkin_view');

		$this->data['equipment_checkin'] = $this->model_equipment_checkin->join_avaiable()->select_string()->find($id);

		$this->template->title('Equipment Checkin Detail');
		$this->render('backend/standart/administrator/equipment_checkin/equipment_checkin_view', $this->data);
	}
	
	/**
	* delete Equipment Checkins
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$equipment_checkin = $this->model_equipment_checkin->find($id);

		
		
		return $this->model_equipment_checkin->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('equipment_checkin_export');

		$this->model_equipment_checkin->export('equipment_checkin', 'equipment_checkin');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('equipment_checkin_export');

		$this->model_equipment_checkin->pdf('equipment_checkin', 'equipment_checkin');
	}
}


/* End of file equipment_checkin.php */
/* Location: ./application/controllers/administrator/Equipment Checkin.php */
