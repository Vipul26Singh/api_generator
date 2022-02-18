<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Events_ongoing extends API
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_api_events_ongoing');
	}

	/**
	 * @api {get} /events_ongoing/all Get all events_ongoings.
	 * @apiVersion 0.1.0
	 * @apiName AllEventsongoing 
	 * @apiGroup events_ongoing
	 * @apiHeader {String} X-Api-Key Events ongoings unique access-key.
	 * @apiPermission Events ongoing Cant be Accessed permission name : api_events_ongoing_all
	 *
	 * @apiParam {String} [Filter=null] Optional filter of Events ongoings.
	 * @apiParam {String} [Field="All Field"] Optional field of Events ongoings : id, event_name, event_type, event_location, check_in_date, check_out_date, event_image.
	 * @apiParam {String} [Start=0] Optional start index of Events ongoings.
	 * @apiParam {String} [Limit=10] Optional limit data of Events ongoings.
	 *
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of events_ongoing.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError NoDataEvents ongoing Events ongoing data is nothing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function all_get()
	{
		$this->is_allowed('api_events_ongoing_all', false);

		$filter = $this->get('filter');
		$field = $this->get('field');
		$limit = $this->get('limit') ? $this->get('limit') : $this->limit_page;
		$start = $this->get('start');

		$select_field = ['id', 'event_name', 'event_type', 'event_location', 'check_in_date', 'check_out_date', 'event_image'];
		$events_ongoings = $this->model_api_events_ongoing->get($filter, $field, $limit, $start, $select_field);
		$total = $this->model_api_events_ongoing->count_all($filter, $field);

		$events_ongoing_arr = [];

		foreach ($events_ongoings as $events_ongoing) {
							if(!empty($events_ongoing->event_image)) {
					$events_ongoing->event_image  = BASE_URL.'uploads/events/'.$events_ongoing->event_image;
				} else {
					$events_ongoing->event_image  = $events_ongoing->event_image;
				}
			$events_ongoing_arr[] = $events_ongoing;
		}

		$data['events_ongoing'] = $events_ongoing_arr;
				
		$this->response([
			'status' 	=> true,
			'message' 	=> 'Data Events ongoing',
			'data'	 	=> $data,
			'total' 	=> $total
		], API::HTTP_OK);
	}

	
	/**
	 * @api {get} /events_ongoing/detail Detail Events ongoing.
	 * @apiVersion 0.1.0
	 * @apiName DetailEvents ongoing
	 * @apiGroup events_ongoing
	 * @apiHeader {String} X-Api-Key Events ongoings unique access-key.
	 * @apiPermission Events ongoing Cant be Accessed permission name : api_events_ongoing_detail
	 *
	 * @apiParam {Integer} Id Mandatory id of Events ongoings.
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of events_ongoing.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError Events ongoingNotFound Events ongoing data is not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function detail_get()
	{
		$this->is_allowed('api_events_ongoing_detail', false);

		$this->requiredInput(['']);

		$id = $this->get('');

		$select_field = ['id', 'event_name', 'event_type', 'event_location', 'check_in_date', 'check_out_date', 'event_image'];
		$data['events_ongoing'] = $this->model_api_events_ongoing->find($id, $select_field);

		if ($data['events_ongoing']) {
							if(!empty($events_ongoing->event_image)) {
					$data['events_ongoing']->event_image = BASE_URL.'uploads/events/'.$data['events_ongoing']->event_image;
				} else {
					$data['events_ongoing']->event_image = $data['events_ongoing']->event_image;
				}
			
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Detail Events ongoing',
				'data'	 	=> $data
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Events ongoing not found'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

	
	/**
	 * @api {post} /events_ongoing/add Add Events ongoing.
	 * @apiVersion 0.1.0
	 * @apiName AddEvents ongoing
	 * @apiGroup events_ongoing
	 * @apiHeader {String} X-Api-Key Events ongoings unique access-key.
	 * @apiPermission Events ongoing Cant be Accessed permission name : api_events_ongoing_add
	 *
 	 * @apiParam {String} Id Mandatory id of Events ongoings. Input Id Max Length : 11. 
	 * @apiParam {String} Event_name Mandatory event_name of Events ongoings. Input Event Name Max Length : 2048. 
	 * @apiParam {String} Event_type Mandatory event_type of Events ongoings. Input Event Type Max Length : 128. 
	 * @apiParam {String} Event_location Mandatory event_location of Events ongoings. Input Event Location Max Length : 4096. 
	 * @apiParam {String} [Check_in_date] Optional check_in_date of Events ongoings.  
	 * @apiParam {String} [Check_out_date] Optional check_out_date of Events ongoings.  
	 * @apiParam {File} Event_image Mandatory event_image of Events ongoings.  
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError ValidationError Error validation.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function add_post()
	{
		$this->is_allowed('api_events_ongoing_add', false);

		$this->form_validation->set_rules('id', 'Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('event_name', 'Event Name', 'trim|required|max_length[2048]');
		$this->form_validation->set_rules('event_type', 'Event Type', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('event_location', 'Event Location', 'trim|required|max_length[4096]');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'id' => $this->input->post('id'),
				'event_name' => $this->input->post('event_name'),
				'event_type' => $this->input->post('event_type'),
				'event_location' => $this->input->post('event_location'),
				'check_in_date' => date('Y-m-d H:i:s'),
				'check_out_date' => date('Y-m-d H:i:s'),
			];
			if (!is_dir(FCPATH . '/uploads/events_ongoing')) {
				mkdir(FCPATH . '/uploads/events_ongoing');
			}
			
			$config = [
				'upload_path' 	=> './uploads/events_ongoing/',
					'required' 		=> true
			];
			
			if ($upload = $this->upload_file('event_image', $config)){
				$upload_data = $this->upload->data();
				$save_data['event_image'] = $upload['file_name'];
			}

			$save_events_ongoing = $this->model_api_events_ongoing->store($save_data);

			if ($save_events_ongoing) {
				$this->response([
					'status' 	=> true,
					'message' 	=> 'Your data has been successfully stored into the database'
				], API::HTTP_OK);

			} else {
				$this->response([
					'status' 	=> false,
					'message' 	=> cclang('data_not_change')
				], API::HTTP_NOT_ACCEPTABLE);
			}

		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> validation_errors()
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

	/**
	 * @api {post} /events_ongoing/update Update Events ongoing.
	 * @apiVersion 0.1.0
	 * @apiName UpdateEvents ongoing
	 * @apiGroup events_ongoing
	 * @apiHeader {String} X-Api-Key Events ongoings unique access-key.
	 * @apiPermission Events ongoing Cant be Accessed permission name : api_events_ongoing_update
	 *
	 * @apiParam {String} Id Mandatory id of Events ongoings. Input Id Max Length : 11. 
	 * @apiParam {String} Event_name Mandatory event_name of Events ongoings. Input Event Name Max Length : 2048. 
	 * @apiParam {String} Event_type Mandatory event_type of Events ongoings. Input Event Type Max Length : 128. 
	 * @apiParam {String} Event_location Mandatory event_location of Events ongoings. Input Event Location Max Length : 4096. 
	 * @apiParam {String} [Check_in_date] Optional check_in_date of Events ongoings.  
	 * @apiParam {String} [Check_out_date] Optional check_out_date of Events ongoings.  
	 * @apiParam {File} Event_image Mandatory event_image of Events ongoings.  
	 * @apiParam {Integer}  Mandatory  of Events Ongoing.
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError ValidationError Error validation.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function update_post()
	{
		$this->is_allowed('api_events_ongoing_update', false);

		
		$this->form_validation->set_rules('id', 'Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('event_name', 'Event Name', 'trim|required|max_length[2048]');
		$this->form_validation->set_rules('event_type', 'Event Type', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('event_location', 'Event Location', 'trim|required|max_length[4096]');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'id' => $this->input->post('id'),
				'event_name' => $this->input->post('event_name'),
				'event_type' => $this->input->post('event_type'),
				'event_location' => $this->input->post('event_location'),
				'check_in_date' => date('Y-m-d H:i:s'),
				'check_out_date' => date('Y-m-d H:i:s'),
			];
			if (!is_dir(FCPATH . '/uploads/events_ongoing')) {
				mkdir(FCPATH . '/uploads/events_ongoing');
			}
			
			$config = [
				'upload_path' 	=> './uploads/events_ongoing/',
					'required' 		=> true
			];
			
			if ($upload = $this->upload_file('event_image', $config)){
				$upload_data = $this->upload->data();
				$save_data['event_image'] = $upload['file_name'];
			}

			$save_events_ongoing = $this->model_api_events_ongoing->change($this->post(''), $save_data);

			if ($save_events_ongoing) {
				$this->response([
					'status' 	=> true,
					'message' 	=> 'Your data has been successfully updated into the database'
				], API::HTTP_OK);

			} else {
				$this->response([
					'status' 	=> false,
					'message' 	=> cclang('data_not_change')
				], API::HTTP_NOT_ACCEPTABLE);
			}

		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> validation_errors()
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}
	
	/**
	 * @api {post} /events_ongoing/delete Delete Events ongoing. 
	 * @apiVersion 0.1.0
	 * @apiName DeleteEvents ongoing
	 * @apiGroup events_ongoing
	 * @apiHeader {String} X-Api-Key Events ongoings unique access-key.
	 	 * @apiPermission Events ongoing Cant be Accessed permission name : api_events_ongoing_delete
	 *
	 * @apiParam {Integer} Id Mandatory id of Events ongoings .
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError ValidationError Error validation.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function delete_post()
	{
		$this->is_allowed('api_events_ongoing_delete', false);

		$events_ongoing = $this->model_api_events_ongoing->find($this->post(''));

		if (!$events_ongoing) {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Events ongoing not found'
			], API::HTTP_NOT_ACCEPTABLE);
		} else {
			$delete = $this->model_api_events_ongoing->remove($this->post(''));

			if (!empty($events_ongoing->event_image)) {
				$path = FCPATH . '/uploads/events_ongoing/' . $events_ongoing->event_image;

				if (is_file($path)) {
					$delete_file = unlink($path);
				}
			}

		}
		
		if ($delete) {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Events ongoing deleted',
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Events ongoing not delete'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

}

/* End of file Events ongoing.php */
/* Location: ./application/controllers/api/Events ongoing.php */
