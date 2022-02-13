<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Events Controller
*| --------------------------------------------------------------------------
*| Events site
*|
*/
class Events extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_events');
	}

	/**
	* show all Eventss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('events_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['eventss'] = $this->model_events->get( $filter, $field, $this->limit_page, $offset);
		$this->data['events_counts'] = $this->model_events->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/events/index/',
			'total_rows'   => $this->model_events->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Events List');
		$this->render('backend/standart/administrator/events/events_list', $this->data);
	}
	
	/**
	* Add new eventss
	*
	*/
	public function add()
	{
		$this->is_allowed('events_add');

		$this->template->title('Events New');
		$this->render('backend/standart/administrator/events/events_add', $this->data);
	}

	/**
	* Add New Eventss
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('events_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('events_event_image_name', 'Event Image', 'trim|required|max_length[4096]');
		$this->form_validation->set_rules('event_name', 'Event Name', 'trim|required|max_length[2048]');
		$this->form_validation->set_rules('event_type', 'Event Type', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('event_location', 'Event Location', 'trim|max_length[4096]');
		

		if ($this->form_validation->run()) {
			$events_event_image_uuid = $this->input->post('events_event_image_uuid');
			$events_event_image_name = $this->input->post('events_event_image_name');
		
			$save_data = [
					'event_name' => ($this->input->post('event_name') === '') ? NULL : $this->input->post('event_name'),
					'event_type' => ($this->input->post('event_type') === '') ? NULL : $this->input->post('event_type'),
					'event_location' => ($this->input->post('event_location') === '') ? NULL : $this->input->post('event_location'),
				'check_in_date' => date('Y-m-d H:i:s'),
				'check_out_date' => date('Y-m-d H:i:s'),
			];

			if (!is_dir(FCPATH . '/uploads/events/')) {
				mkdir(FCPATH . '/uploads/events/');
			}

			if (!empty($events_event_image_name)) {
				$events_event_image_name_copy = date('YmdHis') . '-' . $events_event_image_name;

				rename(FCPATH . 'uploads/tmp/' . $events_event_image_uuid . '/' . $events_event_image_name, 
						FCPATH . 'uploads/events/' . $events_event_image_name_copy);

				if (!is_file(FCPATH . '/uploads/events/' . $events_event_image_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['event_image'] = $events_event_image_name_copy;
			}
		
			
			$save_events = $this->model_events->store($save_data);

			if ($save_events) {
				$this->data['id']          = $save_events;
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/events/edit/' . $save_events, 'Edit Events'),
						anchor('administrator/events', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/events/edit/' . $save_events, 'Edit Events')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/events');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/events');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Eventss
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('events_update');

		$this->data['events'] = $this->model_events->find($id);

		$this->template->title('Events Update');
		$this->render('backend/standart/administrator/events/events_update', $this->data);
	}

	/**
	* Update Eventss
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('events_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('events_event_image_name', 'Event Image', 'trim|required|max_length[4096]');
		$this->form_validation->set_rules('event_name', 'Event Name', 'trim|required|max_length[2048]');
		$this->form_validation->set_rules('event_type', 'Event Type', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('event_location', 'Event Location', 'trim|max_length[4096]');
		
		if ($this->form_validation->run()) {
			$events_event_image_uuid = $this->input->post('events_event_image_uuid');
			$events_event_image_name = $this->input->post('events_event_image_name');
		
			$save_data = [
					'event_name' => ($this->input->post('event_name') === '') ? NULL : $this->input->post('event_name'),
					'event_type' => ($this->input->post('event_type') === '') ? NULL : $this->input->post('event_type'),
					'event_location' => ($this->input->post('event_location') === '') ? NULL : $this->input->post('event_location'),
				'check_in_date' => date('Y-m-d H:i:s'),
				'check_out_date' => date('Y-m-d H:i:s'),
			];

			if (!is_dir(FCPATH . '/uploads/events/')) {
				mkdir(FCPATH . '/uploads/events/');
			}

			if (!empty($events_event_image_uuid)) {
				$events_event_image_name_copy = date('YmdHis') . '-' . $events_event_image_name;

				rename(FCPATH . 'uploads/tmp/' . $events_event_image_uuid . '/' . $events_event_image_name, 
						FCPATH . 'uploads/events/' . $events_event_image_name_copy);

				if (!is_file(FCPATH . '/uploads/events/' . $events_event_image_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['event_image'] = $events_event_image_name_copy;
			}
		
			

			$save_events = $this->model_events->change($id, $save_data);

			if ($save_events) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/events', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/events');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/events');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Eventss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('events_delete');

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
            set_message(cclang('has_been_deleted', 'events'), 'success');
        } else {
            set_message(cclang('error_delete', 'events'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Eventss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('events_view');

		$this->data['events'] = $this->model_events->join_avaiable()->select_string()->find($id);

		$this->template->title('Events Detail');
		$this->render('backend/standart/administrator/events/events_view', $this->data);
	}
	
	/**
	* delete Eventss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$events = $this->model_events->find($id);

		if (!empty($events->event_image)) {
			$path = FCPATH . '/uploads/events/' . $events->event_image;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		
		
		return $this->model_events->remove($id);
	}
	
	/**
	* Upload Image Events	* 
	* @return JSON
	*/
	public function upload_event_image_file()
	{
		if (!$this->is_allowed('events_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'events',
		]);
	}

	/**
	* Delete Image Events	* 
	* @return JSON
	*/
	public function delete_event_image_file($uuid)
	{
		if (!$this->is_allowed('events_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'event_image', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'events',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/events/'
        ]);
	}

	/**
	* Get Image Events	* 
	* @return JSON
	*/
	public function get_event_image_file($id)
	{
		if (!$this->is_allowed('events_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$events = $this->model_events->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'event_image', 
            'table_name'        => 'events',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/events/',
            'delete_endpoint'   => 'administrator/events/delete_event_image_file'
        ]);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('events_export');

		$this->model_events->export('events', 'events');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('events_export');

		$this->model_events->pdf('events', 'events');
	}
}


/* End of file events.php */
/* Location: ./application/controllers/administrator/Events.php */
