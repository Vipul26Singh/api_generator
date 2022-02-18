<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Events_future extends API
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_api_events_future');
	}

	/**
	 * @api {get} /events_future/all Get all events_futures.
	 * @apiVersion 0.1.0
	 * @apiName AllEventsfuture 
	 * @apiGroup events_future
	 * @apiHeader {String} X-Api-Key Events futures unique access-key.
	 * @apiPermission Events future Cant be Accessed permission name : api_events_future_all
	 *
	 * @apiParam {String} [Filter=null] Optional filter of Events futures.
	 * @apiParam {String} [Field="All Field"] Optional field of Events futures : id, event_name, event_type, event_location, check_in_date, check_out_date, event_image.
	 * @apiParam {String} [Start=0] Optional start index of Events futures.
	 * @apiParam {String} [Limit=10] Optional limit data of Events futures.
	 *
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of events_future.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError NoDataEvents future Events future data is nothing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function all_get()
	{
		$this->is_allowed('api_events_future_all', false);

		$filter = $this->get('filter');
		$field = $this->get('field');
		$limit = $this->get('limit') ? $this->get('limit') : $this->limit_page;
		$start = $this->get('start');

		$select_field = ['id', 'event_name', 'event_type', 'event_location', 'check_in_date', 'check_out_date', 'event_image'];
		$events_futures = $this->model_api_events_future->get($filter, $field, $limit, $start, $select_field);
		$total = $this->model_api_events_future->count_all($filter, $field);

		$events_future_arr = [];

		foreach ($events_futures as $events_future) {
							if(!empty($events_future->event_image)) {
					$events_future->event_image  = BASE_URL.'uploads/events/'.$events_future->event_image;
				} else {
					$events_future->event_image  = $events_future->event_image;
				}
			$events_future_arr[] = $events_future;
		}

		$data['events_future'] = $events_future_arr;
				
		$this->response([
			'status' 	=> true,
			'message' 	=> 'Data Events future',
			'data'	 	=> $data,
			'total' 	=> $total
		], API::HTTP_OK);
	}

	
	/**
	 * @api {get} /events_future/detail Detail Events future.
	 * @apiVersion 0.1.0
	 * @apiName DetailEvents future
	 * @apiGroup events_future
	 * @apiHeader {String} X-Api-Key Events futures unique access-key.
	 * @apiPermission Events future Cant be Accessed permission name : api_events_future_detail
	 *
	 * @apiParam {Integer} Id Mandatory id of Events futures.
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of events_future.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError Events futureNotFound Events future data is not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function detail_get()
	{
		$this->is_allowed('api_events_future_detail', false);

		$this->requiredInput(['']);

		$id = $this->get('');

		$select_field = ['id', 'event_name', 'event_type', 'event_location', 'check_in_date', 'check_out_date', 'event_image'];
		$data['events_future'] = $this->model_api_events_future->find($id, $select_field);

		if ($data['events_future']) {
							if(!empty($events_future->event_image)) {
					$data['events_future']->event_image = BASE_URL.'uploads/events/'.$data['events_future']->event_image;
				} else {
					$data['events_future']->event_image = $data['events_future']->event_image;
				}
			
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Detail Events future',
				'data'	 	=> $data
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Events future not found'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

	
	/**
	 * @api {post} /events_future/add Add Events future.
	 * @apiVersion 0.1.0
	 * @apiName AddEvents future
	 * @apiGroup events_future
	 * @apiHeader {String} X-Api-Key Events futures unique access-key.
	 * @apiPermission Events future Cant be Accessed permission name : api_events_future_add
	 *
 	 * @apiParam {String} Id Mandatory id of Events futures. Input Id Max Length : 11. 
	 * @apiParam {String} Event_name Mandatory event_name of Events futures. Input Event Name Max Length : 2048. 
	 * @apiParam {String} Event_type Mandatory event_type of Events futures. Input Event Type Max Length : 128. 
	 * @apiParam {String} Event_location Mandatory event_location of Events futures. Input Event Location Max Length : 4096. 
	 * @apiParam {String} [Check_in_date] Optional check_in_date of Events futures.  
	 * @apiParam {String} [Check_out_date] Optional check_out_date of Events futures.  
	 * @apiParam {File} Event_image Mandatory event_image of Events futures. Input Event Image Max Length : 4096. 
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
		$this->is_allowed('api_events_future_add', false);

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
			if (!is_dir(FCPATH . '/uploads/events_future')) {
				mkdir(FCPATH . '/uploads/events_future');
			}
			
			$config = [
				'upload_path' 	=> './uploads/events_future/',
					'required' 		=> true
			];
			
			if ($upload = $this->upload_file('event_image', $config)){
				$upload_data = $this->upload->data();
				$save_data['event_image'] = $upload['file_name'];
			}

			$save_events_future = $this->model_api_events_future->store($save_data);

			if ($save_events_future) {
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
	 * @api {post} /events_future/update Update Events future.
	 * @apiVersion 0.1.0
	 * @apiName UpdateEvents future
	 * @apiGroup events_future
	 * @apiHeader {String} X-Api-Key Events futures unique access-key.
	 * @apiPermission Events future Cant be Accessed permission name : api_events_future_update
	 *
	 * @apiParam {String} Id Mandatory id of Events futures. Input Id Max Length : 11. 
	 * @apiParam {String} Event_name Mandatory event_name of Events futures. Input Event Name Max Length : 2048. 
	 * @apiParam {String} Event_type Mandatory event_type of Events futures. Input Event Type Max Length : 128. 
	 * @apiParam {String} Event_location Mandatory event_location of Events futures. Input Event Location Max Length : 4096. 
	 * @apiParam {String} [Check_in_date] Optional check_in_date of Events futures.  
	 * @apiParam {String} [Check_out_date] Optional check_out_date of Events futures.  
	 * @apiParam {File} Event_image Mandatory event_image of Events futures. Input Event Image Max Length : 4096. 
	 * @apiParam {Integer}  Mandatory  of Events Future.
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
		$this->is_allowed('api_events_future_update', false);

		
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
			if (!is_dir(FCPATH . '/uploads/events_future')) {
				mkdir(FCPATH . '/uploads/events_future');
			}
			
			$config = [
				'upload_path' 	=> './uploads/events_future/',
					'required' 		=> true
			];
			
			if ($upload = $this->upload_file('event_image', $config)){
				$upload_data = $this->upload->data();
				$save_data['event_image'] = $upload['file_name'];
			}

			$save_events_future = $this->model_api_events_future->change($this->post(''), $save_data);

			if ($save_events_future) {
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
	 * @api {post} /events_future/delete Delete Events future. 
	 * @apiVersion 0.1.0
	 * @apiName DeleteEvents future
	 * @apiGroup events_future
	 * @apiHeader {String} X-Api-Key Events futures unique access-key.
	 	 * @apiPermission Events future Cant be Accessed permission name : api_events_future_delete
	 *
	 * @apiParam {Integer} Id Mandatory id of Events futures .
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
		$this->is_allowed('api_events_future_delete', false);

		$events_future = $this->model_api_events_future->find($this->post(''));

		if (!$events_future) {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Events future not found'
			], API::HTTP_NOT_ACCEPTABLE);
		} else {
			$delete = $this->model_api_events_future->remove($this->post(''));

			if (!empty($events_future->event_image)) {
				$path = FCPATH . '/uploads/events_future/' . $events_future->event_image;

				if (is_file($path)) {
					$delete_file = unlink($path);
				}
			}

		}
		
		if ($delete) {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Events future deleted',
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Events future not delete'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

}

/* End of file Events future.php */
/* Location: ./application/controllers/api/Events future.php */
