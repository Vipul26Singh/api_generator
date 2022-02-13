<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Event Equipment Checklist Controller
*| --------------------------------------------------------------------------
*| Event Equipment Checklist site
*|
*/
class Event_equipment_checklist extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_event_equipment_checklist');
	}

	/**
	* show all Event Equipment Checklists
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('event_equipment_checklist_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['event_equipment_checklists'] = $this->model_event_equipment_checklist->get( $filter, $field, $this->limit_page, $offset);
		$this->data['event_equipment_checklist_counts'] = $this->model_event_equipment_checklist->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/event_equipment_checklist/index/',
			'total_rows'   => $this->model_event_equipment_checklist->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Event Equipment Checklist List');
		$this->render('backend/standart/administrator/event_equipment_checklist/event_equipment_checklist_list', $this->data);
	}
	
	/**
	* Add new event_equipment_checklists
	*
	*/
	public function add()
	{
		$this->is_allowed('event_equipment_checklist_add');

		$this->template->title('Event Equipment Checklist New');
		$this->render('backend/standart/administrator/event_equipment_checklist/event_equipment_checklist_add', $this->data);
	}

	/**
	* Add New Event Equipment Checklists
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('event_equipment_checklist_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('event_id', 'Event Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('equipment_id', 'Equipment Id', 'trim|required|max_length[11]');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
					'event_id' => ($this->input->post('event_id') === '') ? NULL : $this->input->post('event_id'),
					'equipment_id' => ($this->input->post('equipment_id') === '') ? NULL : $this->input->post('equipment_id'),
			];

			
			$save_event_equipment_checklist = $this->model_event_equipment_checklist->store($save_data);

			if ($save_event_equipment_checklist) {
				$this->data['id']          = $save_event_equipment_checklist;
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/event_equipment_checklist/edit/' . $save_event_equipment_checklist, 'Edit Event Equipment Checklist'),
						anchor('administrator/event_equipment_checklist', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/event_equipment_checklist/edit/' . $save_event_equipment_checklist, 'Edit Event Equipment Checklist')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/event_equipment_checklist');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/event_equipment_checklist');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Event Equipment Checklists
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('event_equipment_checklist_update');

		$this->data['event_equipment_checklist'] = $this->model_event_equipment_checklist->find($id);

		$this->template->title('Event Equipment Checklist Update');
		$this->render('backend/standart/administrator/event_equipment_checklist/event_equipment_checklist_update', $this->data);
	}

	/**
	* Update Event Equipment Checklists
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('event_equipment_checklist_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('event_id', 'Event Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('equipment_id', 'Equipment Id', 'trim|required|max_length[11]');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
					'event_id' => ($this->input->post('event_id') === '') ? NULL : $this->input->post('event_id'),
					'equipment_id' => ($this->input->post('equipment_id') === '') ? NULL : $this->input->post('equipment_id'),
			];

			

			$save_event_equipment_checklist = $this->model_event_equipment_checklist->change($id, $save_data);

			if ($save_event_equipment_checklist) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/event_equipment_checklist', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/event_equipment_checklist');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/event_equipment_checklist');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Event Equipment Checklists
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('event_equipment_checklist_delete');

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
            set_message(cclang('has_been_deleted', 'event_equipment_checklist'), 'success');
        } else {
            set_message(cclang('error_delete', 'event_equipment_checklist'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Event Equipment Checklists
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('event_equipment_checklist_view');

		$this->data['event_equipment_checklist'] = $this->model_event_equipment_checklist->join_avaiable()->select_string()->find($id);

		$this->template->title('Event Equipment Checklist Detail');
		$this->render('backend/standart/administrator/event_equipment_checklist/event_equipment_checklist_view', $this->data);
	}
	
	/**
	* delete Event Equipment Checklists
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$event_equipment_checklist = $this->model_event_equipment_checklist->find($id);

		
		
		return $this->model_event_equipment_checklist->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('event_equipment_checklist_export');

		$this->model_event_equipment_checklist->export('event_equipment_checklist', 'event_equipment_checklist');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('event_equipment_checklist_export');

		$this->model_event_equipment_checklist->pdf('event_equipment_checklist', 'event_equipment_checklist');
	}
}


/* End of file event_equipment_checklist.php */
/* Location: ./application/controllers/administrator/Event Equipment Checklist.php */
