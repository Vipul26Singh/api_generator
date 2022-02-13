<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Events extends API
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_api_events');
	}

	/**
	 * @api {get} /events/all Get all eventss.
	 * @apiVersion 0.1.0
	 * @apiName AllEvents 
	 * @apiGroup events
	 * @apiHeader {String} X-Api-Key Eventss unique access-key.
	 * @apiPermission Events Cant be Accessed permission name : api_events_all
	 *
	 * @apiParam {String} [Filter=null] Optional filter of Eventss.
	 * @apiParam {String} [Field="All Field"] Optional field of Eventss : id, event_name, event_type, event_location, check_in_date, check_out_date, event_image.
	 * @apiParam {String} [Start=0] Optional start index of Eventss.
	 * @apiParam {String} [Limit=10] Optional limit data of Eventss.
	 *
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of events.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError NoDataEvents Events data is nothing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function all_get()
	{
		$this->is_allowed('api_events_all', false);

		$filter = $this->get('filter');
		$field = $this->get('field');
		$limit = $this->get('limit') ? $this->get('limit') : $this->limit_page;
		$start = $this->get('start');

		$select_field = ['id', 'event_name', 'event_type', 'event_location', 'check_in_date', 'check_out_date', 'event_image'];
		$eventss = $this->model_api_events->get($filter, $field, $limit, $start, $select_field);
		$total = $this->model_api_events->count_all($filter, $field);

		$events_arr = [];

		foreach ($eventss as $events) {
			$events->event_image  = BASE_URL.'uploads/events/'.$events->event_image;
			$events_arr[] = $events;
		}

		$data['events'] = $events_arr;
				
		$this->response([
			'status' 	=> true,
			'message' 	=> 'Data Events',
			'data'	 	=> $data,
			'total' 	=> $total
		], API::HTTP_OK);
	}

	
	/**
	 * @api {get} /events/detail Detail Events.
	 * @apiVersion 0.1.0
	 * @apiName DetailEvents
	 * @apiGroup events
	 * @apiHeader {String} X-Api-Key Eventss unique access-key.
	 * @apiPermission Events Cant be Accessed permission name : api_events_detail
	 *
	 * @apiParam {Integer} Id Mandatory id of Eventss.
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of events.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError EventsNotFound Events data is not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function detail_get()
	{
		$this->is_allowed('api_events_detail', false);

		$this->requiredInput(['id']);

		$id = $this->get('id');

		$select_field = ['id', 'event_name', 'event_type', 'event_location', 'check_in_date', 'check_out_date', 'event_image'];
		$data['events'] = $this->model_api_events->find($id, $select_field);

		if ($data['events']) {
			$data['events']->event_image = BASE_URL.'uploads/events/'.$data['events']->event_image;
			
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Detail Events',
				'data'	 	=> $data
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Events not found'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

	
	/**
	 * @api {post} /events/add Add Events.
	 * @apiVersion 0.1.0
	 * @apiName AddEvents
	 * @apiGroup events
	 * @apiHeader {String} X-Api-Key Eventss unique access-key.
	 * @apiPermission Events Cant be Accessed permission name : api_events_add
	 *
 	 * @apiParam {String} Event_name Mandatory event_name of Eventss. Input Event Name Max Length : 2048. 
	 * @apiParam {String} Event_type Mandatory event_type of Eventss. Input Event Type Max Length : 128. 
	 * @apiParam {String} Event_location Mandatory event_location of Eventss. Input Event Location Max Length : 4096. 
	 * @apiParam {String} [Check_in_date] Optional check_in_date of Eventss.  
	 * @apiParam {String} [Check_out_date] Optional check_out_date of Eventss.  
	 * @apiParam {File} [Event_image] Optional event_image of Eventss.  
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
		$this->is_allowed('api_events_add', false);

		$this->form_validation->set_rules('event_name', 'Event Name', 'trim|required|max_length[2048]');
		$this->form_validation->set_rules('event_type', 'Event Type', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('event_location', 'Event Location', 'trim|required|max_length[4096]');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'event_name' => $this->input->post('event_name'),
				'event_type' => $this->input->post('event_type'),
				'event_location' => $this->input->post('event_location'),
				'check_in_date' => date('Y-m-d H:i:s'),
				'check_out_date' => date('Y-m-d H:i:s'),
			];
			
			$config = [
				'upload_path' 	=> './uploads/events/',
					'required' 		=> false
			];
			
			if ($upload = $this->upload_file('event_image', $config)){
				$upload_data = $this->upload->data();
				$save_data['event_image'] = $upload['file_name'];
			}

			$save_events = $this->model_api_events->store($save_data);

			if ($save_events) {
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
	 * @api {post} /events/update Update Events.
	 * @apiVersion 0.1.0
	 * @apiName UpdateEvents
	 * @apiGroup events
	 * @apiHeader {String} X-Api-Key Eventss unique access-key.
	 * @apiPermission Events Cant be Accessed permission name : api_events_update
	 *
	 * @apiParam {String} Event_name Mandatory event_name of Eventss. Input Event Name Max Length : 2048. 
	 * @apiParam {String} Event_type Mandatory event_type of Eventss. Input Event Type Max Length : 128. 
	 * @apiParam {String} Event_location Mandatory event_location of Eventss. Input Event Location Max Length : 4096. 
	 * @apiParam {String} [Check_in_date] Optional check_in_date of Eventss.  
	 * @apiParam {String} [Check_out_date] Optional check_out_date of Eventss.  
	 * @apiParam {File} [Event_image] Optional event_image of Eventss.  
	 * @apiParam {Integer} id Mandatory id of Events.
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
		$this->is_allowed('api_events_update', false);

		
		$this->form_validation->set_rules('event_name', 'Event Name', 'trim|required|max_length[2048]');
		$this->form_validation->set_rules('event_type', 'Event Type', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('event_location', 'Event Location', 'trim|required|max_length[4096]');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'event_name' => $this->input->post('event_name'),
				'event_type' => $this->input->post('event_type'),
				'event_location' => $this->input->post('event_location'),
				'check_in_date' => date('Y-m-d H:i:s'),
				'check_out_date' => date('Y-m-d H:i:s'),
			];
			
			$config = [
				'upload_path' 	=> './uploads/events/',
					'required' 		=> false
			];
			
			if ($upload = $this->upload_file('event_image', $config)){
				$upload_data = $this->upload->data();
				$save_data['event_image'] = $upload['file_name'];
			}

			$save_events = $this->model_api_events->change($this->post('id'), $save_data);

			if ($save_events) {
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
	 * @api {post} /events/delete Delete Events. 
	 * @apiVersion 0.1.0
	 * @apiName DeleteEvents
	 * @apiGroup events
	 * @apiHeader {String} X-Api-Key Eventss unique access-key.
	 	 * @apiPermission Events Cant be Accessed permission name : api_events_delete
	 *
	 * @apiParam {Integer} Id Mandatory id of Eventss .
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
		$this->is_allowed('api_events_delete', false);

		$events = $this->model_api_events->find($this->post('id'));

		if (!$events) {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Events not found'
			], API::HTTP_NOT_ACCEPTABLE);
		} else {
			$delete = $this->model_api_events->remove($this->post('id'));

			if (!empty($events->event_image)) {
				$path = FCPATH . '/uploads/events/' . $events->event_image;

				if (is_file($path)) {
					$delete_file = unlink($path);
				}
			}

		}
		
		if ($delete) {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Events deleted',
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Events not delete'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

}

/* End of file Events.php */
/* Location: ./application/controllers/api/Events.php */