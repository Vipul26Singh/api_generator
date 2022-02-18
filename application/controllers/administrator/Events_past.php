<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Events Past Controller
*| --------------------------------------------------------------------------
*| Events Past site
*|
*/
class Events_past extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_events_past');
	}

	/**
	* show all Events Pasts
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('events_past_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['events_pasts'] = $this->model_events_past->get( $filter, $field, $this->limit_page, $offset);
		$this->data['events_past_counts'] = $this->model_events_past->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/events_past/index/',
			'total_rows'   => $this->model_events_past->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Events Past List');
		$this->render('backend/standart/administrator/events_past/events_past_list', $this->data);
	}
	
	/**
	* Add new events_pasts
	*
	*/
	public function add()
	{
		$this->is_allowed('events_past_add');

		$this->template->title('Events Past New');
		$this->render('backend/standart/administrator/events_past/events_past_add', $this->data);
	}

	/**
	* Add New Events Pasts
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('events_past_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('id', 'Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('event_name', 'Event Name', 'trim|required|max_length[2048]');
		$this->form_validation->set_rules('event_type', 'Event Type', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('event_location', 'Event Location', 'trim|required|max_length[4096]');
		$this->form_validation->set_rules('events_past_event_image_name', 'Event Image', 'trim|required|max_length[4096]');
		

		if ($this->form_validation->run()) {
			$events_past_event_image_uuid = $this->input->post('events_past_event_image_uuid');
			$events_past_event_image_name = $this->input->post('events_past_event_image_name');
		
			$save_data = [
					'id' => ($this->input->post('id') === '') ? NULL : $this->input->post('id'),
					'event_name' => ($this->input->post('event_name') === '') ? NULL : $this->input->post('event_name'),
					'event_type' => ($this->input->post('event_type') === '') ? NULL : $this->input->post('event_type'),
					'event_location' => ($this->input->post('event_location') === '') ? NULL : $this->input->post('event_location'),
				'check_in_date' => date('Y-m-d H:i:s'),
				'check_out_date' => date('Y-m-d H:i:s'),
			];

			if (!is_dir(FCPATH . '/uploads/events_past/')) {
				mkdir(FCPATH . '/uploads/events_past/');
			}

			if (!empty($events_past_event_image_name)) {
				$events_past_event_image_name_copy = date('YmdHis') . '-' . $events_past_event_image_name;

				rename(FCPATH . 'uploads/tmp/' . $events_past_event_image_uuid . '/' . $events_past_event_image_name, 
						FCPATH . 'uploads/events_past/' . $events_past_event_image_name_copy);

				if (!is_file(FCPATH . '/uploads/events_past/' . $events_past_event_image_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['event_image'] = $events_past_event_image_name_copy;
			}
		
			
			$save_events_past = $this->model_events_past->store($save_data);

			if ($save_events_past) {
				$this->data['id']          = $save_events_past;
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/events_past/edit/' . $save_events_past, 'Edit Events Past'),
						anchor('administrator/events_past', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/events_past/edit/' . $save_events_past, 'Edit Events Past')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/events_past');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/events_past');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Events Pasts
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('events_past_update');

		$this->data['events_past'] = $this->model_events_past->find($id);

		$this->template->title('Events Past Update');
		$this->render('backend/standart/administrator/events_past/events_past_update', $this->data);
	}

	/**
	* Update Events Pasts
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('events_past_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('id', 'Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('event_name', 'Event Name', 'trim|required|max_length[2048]');
		$this->form_validation->set_rules('event_type', 'Event Type', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('event_location', 'Event Location', 'trim|required|max_length[4096]');
		$this->form_validation->set_rules('events_past_event_image_name', 'Event Image', 'trim|required|max_length[4096]');
		
		if ($this->form_validation->run()) {
			$events_past_event_image_uuid = $this->input->post('events_past_event_image_uuid');
			$events_past_event_image_name = $this->input->post('events_past_event_image_name');
		
			$save_data = [
					'id' => ($this->input->post('id') === '') ? NULL : $this->input->post('id'),
					'event_name' => ($this->input->post('event_name') === '') ? NULL : $this->input->post('event_name'),
					'event_type' => ($this->input->post('event_type') === '') ? NULL : $this->input->post('event_type'),
					'event_location' => ($this->input->post('event_location') === '') ? NULL : $this->input->post('event_location'),
				'check_in_date' => date('Y-m-d H:i:s'),
				'check_out_date' => date('Y-m-d H:i:s'),
			];

			if (!is_dir(FCPATH . '/uploads/events_past/')) {
				mkdir(FCPATH . '/uploads/events_past/');
			}

			if (!empty($events_past_event_image_uuid)) {
				$events_past_event_image_name_copy = date('YmdHis') . '-' . $events_past_event_image_name;

				rename(FCPATH . 'uploads/tmp/' . $events_past_event_image_uuid . '/' . $events_past_event_image_name, 
						FCPATH . 'uploads/events_past/' . $events_past_event_image_name_copy);

				if (!is_file(FCPATH . '/uploads/events_past/' . $events_past_event_image_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['event_image'] = $events_past_event_image_name_copy;
			}
		
			

			$save_events_past = $this->model_events_past->change($id, $save_data);

			if ($save_events_past) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/events_past', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/events_past');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/events_past');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Events Pasts
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('events_past_delete');

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
            set_message(cclang('has_been_deleted', 'events_past'), 'success');
        } else {
            set_message(cclang('error_delete', 'events_past'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Events Pasts
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('events_past_view');

		$this->data['events_past'] = $this->model_events_past->join_avaiable()->select_string()->find($id);

		$this->template->title('Events Past Detail');
		$this->render('backend/standart/administrator/events_past/events_past_view', $this->data);
	}
	
	/**
	* delete Events Pasts
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$events_past = $this->model_events_past->find($id);

		if (!empty($events_past->event_image)) {
			$path = FCPATH . '/uploads/events_past/' . $events_past->event_image;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		
		
		return $this->model_events_past->remove($id);
	}
	
	/**
	* Upload Image Events Past	* 
	* @return JSON
	*/
	public function upload_event_image_file()
	{
		if (!$this->is_allowed('events_past_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'events_past',
		]);
	}

	/**
	* Delete Image Events Past	* 
	* @return JSON
	*/
	public function delete_event_image_file($uuid)
	{
		if (!$this->is_allowed('events_past_delete', false)) {
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
            'table_name'        => 'events_past',
            'primary_key'       => '',
            'upload_path'       => 'uploads/events_past/'
        ]);
	}

	/**
	* Get Image Events Past	* 
	* @return JSON
	*/
	public function get_event_image_file($id)
	{
		if (!$this->is_allowed('events_past_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$events_past = $this->model_events_past->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'event_image', 
            'table_name'        => 'events_past',
            'primary_key'       => '',
            'upload_path'       => 'uploads/events_past/',
            'delete_endpoint'   => 'administrator/events_past/delete_event_image_file'
        ]);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('events_past_export');

		$this->model_events_past->export('events_past', 'events_past');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('events_past_export');

		$this->model_events_past->pdf('events_past', 'events_past');
	}
}


/* End of file events_past.php */
/* Location: ./application/controllers/administrator/Events Past.php */
