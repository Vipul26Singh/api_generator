<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Events_past extends API
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_api_events_past');
	}

	/**
	 * @api {get} /events_past/all Get all events_pasts.
	 * @apiVersion 0.1.0
	 * @apiName AllEventspast 
	 * @apiGroup events_past
	 * @apiHeader {String} X-Api-Key Events pasts unique access-key.
	 * @apiPermission Events past Cant be Accessed permission name : api_events_past_all
	 *
	 * @apiParam {String} [Filter=null] Optional filter of Events pasts.
	 * @apiParam {String} [Field="All Field"] Optional field of Events pasts : id, event_name, event_type, event_location, check_in_date, check_out_date, event_image.
	 * @apiParam {String} [Start=0] Optional start index of Events pasts.
	 * @apiParam {String} [Limit=10] Optional limit data of Events pasts.
	 *
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of events_past.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError NoDataEvents past Events past data is nothing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function all_get()
	{
		$this->is_allowed('api_events_past_all', false);

		$filter = $this->get('filter');
		$field = $this->get('field');
		$limit = $this->get('limit') ? $this->get('limit') : $this->limit_page;
		$start = $this->get('start');

		$select_field = ['id', 'event_name', 'event_type', 'event_location', 'check_in_date', 'check_out_date', 'event_image'];
		$events_pasts = $this->model_api_events_past->get($filter, $field, $limit, $start, $select_field);
		$total = $this->model_api_events_past->count_all($filter, $field);

		$events_past_arr = [];

		foreach ($events_pasts as $events_past) {
							if(!empty($events_past->event_image)) {
					$events_past->event_image  = BASE_URL.'uploads/events/'.$events_past->event_image;
				} else {
					$events_past->event_image  = $events_past->event_image;
				}
			$events_past_arr[] = $events_past;
		}

		$data['events_past'] = $events_past_arr;
				
		$this->response([
			'status' 	=> true,
			'message' 	=> 'Data Events past',
			'data'	 	=> $data,
			'total' 	=> $total
		], API::HTTP_OK);
	}

	
	/**
	 * @api {get} /events_past/detail Detail Events past.
	 * @apiVersion 0.1.0
	 * @apiName DetailEvents past
	 * @apiGroup events_past
	 * @apiHeader {String} X-Api-Key Events pasts unique access-key.
	 * @apiPermission Events past Cant be Accessed permission name : api_events_past_detail
	 *
	 * @apiParam {Integer} Id Mandatory id of Events pasts.
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of events_past.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError Events pastNotFound Events past data is not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function detail_get()
	{
		$this->is_allowed('api_events_past_detail', false);

		$this->requiredInput(['']);

		$id = $this->get('');

		$select_field = ['id', 'event_name', 'event_type', 'event_location', 'check_in_date', 'check_out_date', 'event_image'];
		$data['events_past'] = $this->model_api_events_past->find($id, $select_field);

		if ($data['events_past']) {
							if(!empty($events_past->event_image)) {
					$data['events_past']->event_image = BASE_URL.'uploads/events/'.$data['events_past']->event_image;
				} else {
					$data['events_past']->event_image = $data['events_past']->event_image;
				}
			
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Detail Events past',
				'data'	 	=> $data
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Events past not found'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

	
	/**
	 * @api {post} /events_past/add Add Events past.
	 * @apiVersion 0.1.0
	 * @apiName AddEvents past
	 * @apiGroup events_past
	 * @apiHeader {String} X-Api-Key Events pasts unique access-key.
	 * @apiPermission Events past Cant be Accessed permission name : api_events_past_add
	 *
 	 * @apiParam {String} Id Mandatory id of Events pasts. Input Id Max Length : 11. 
	 * @apiParam {String} Event_name Mandatory event_name of Events pasts. Input Event Name Max Length : 2048. 
	 * @apiParam {String} Event_type Mandatory event_type of Events pasts. Input Event Type Max Length : 128. 
	 * @apiParam {String} Event_location Mandatory event_location of Events pasts. Input Event Location Max Length : 4096. 
	 * @apiParam {String} [Check_in_date] Optional check_in_date of Events pasts.  
	 * @apiParam {String} [Check_out_date] Optional check_out_date of Events pasts.  
	 * @apiParam {File} Event_image Mandatory event_image of Events pasts.  
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
		$this->is_allowed('api_events_past_add', false);

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
			if (!is_dir(FCPATH . '/uploads/events_past')) {
				mkdir(FCPATH . '/uploads/events_past');
			}
			
			$config = [
				'upload_path' 	=> './uploads/events_past/',
					'required' 		=> true
			];
			
			if ($upload = $this->upload_file('event_image', $config)){
				$upload_data = $this->upload->data();
				$save_data['event_image'] = $upload['file_name'];
			}

			$save_events_past = $this->model_api_events_past->store($save_data);

			if ($save_events_past) {
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
	 * @api {post} /events_past/update Update Events past.
	 * @apiVersion 0.1.0
	 * @apiName UpdateEvents past
	 * @apiGroup events_past
	 * @apiHeader {String} X-Api-Key Events pasts unique access-key.
	 * @apiPermission Events past Cant be Accessed permission name : api_events_past_update
	 *
	 * @apiParam {String} Id Mandatory id of Events pasts. Input Id Max Length : 11. 
	 * @apiParam {String} Event_name Mandatory event_name of Events pasts. Input Event Name Max Length : 2048. 
	 * @apiParam {String} Event_type Mandatory event_type of Events pasts. Input Event Type Max Length : 128. 
	 * @apiParam {String} Event_location Mandatory event_location of Events pasts. Input Event Location Max Length : 4096. 
	 * @apiParam {String} [Check_in_date] Optional check_in_date of Events pasts.  
	 * @apiParam {String} [Check_out_date] Optional check_out_date of Events pasts.  
	 * @apiParam {File} Event_image Mandatory event_image of Events pasts.  
	 * @apiParam {Integer}  Mandatory  of Events Past.
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
		$this->is_allowed('api_events_past_update', false);

		
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
			if (!is_dir(FCPATH . '/uploads/events_past')) {
				mkdir(FCPATH . '/uploads/events_past');
			}
			
			$config = [
				'upload_path' 	=> './uploads/events_past/',
					'required' 		=> true
			];
			
			if ($upload = $this->upload_file('event_image', $config)){
				$upload_data = $this->upload->data();
				$save_data['event_image'] = $upload['file_name'];
			}

			$save_events_past = $this->model_api_events_past->change($this->post(''), $save_data);

			if ($save_events_past) {
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
	 * @api {post} /events_past/delete Delete Events past. 
	 * @apiVersion 0.1.0
	 * @apiName DeleteEvents past
	 * @apiGroup events_past
	 * @apiHeader {String} X-Api-Key Events pasts unique access-key.
	 	 * @apiPermission Events past Cant be Accessed permission name : api_events_past_delete
	 *
	 * @apiParam {Integer} Id Mandatory id of Events pasts .
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
		$this->is_allowed('api_events_past_delete', false);

		$events_past = $this->model_api_events_past->find($this->post(''));

		if (!$events_past) {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Events past not found'
			], API::HTTP_NOT_ACCEPTABLE);
		} else {
			$delete = $this->model_api_events_past->remove($this->post(''));

			if (!empty($events_past->event_image)) {
				$path = FCPATH . '/uploads/events_past/' . $events_past->event_image;

				if (is_file($path)) {
					$delete_file = unlink($path);
				}
			}

		}
		
		if ($delete) {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Events past deleted',
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Events past not delete'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

}

/* End of file Events past.php */
/* Location: ./application/controllers/api/Events past.php */
