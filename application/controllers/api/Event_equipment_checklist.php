<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Event_equipment_checklist extends API
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_api_event_equipment_checklist');
	}

	/**
	 * @api {get} /event_equipment_checklist/all Get all event_equipment_checklists.
	 * @apiVersion 0.1.0
	 * @apiName AllEventequipmentchecklist 
	 * @apiGroup event_equipment_checklist
	 * @apiHeader {String} X-Api-Key Event equipment checklists unique access-key.
	 * @apiHeader {String} X-Token Event equipment checklists unique token.
	 * @apiPermission Event equipment checklist Cant be Accessed permission name : api_event_equipment_checklist_all
	 *
	 * @apiParam {String} [Filter=null] Optional filter of Event equipment checklists.
	 * @apiParam {String} [Field="All Field"] Optional field of Event equipment checklists : id, event_id, equipment_id.
	 * @apiParam {String} [Start=0] Optional start index of Event equipment checklists.
	 * @apiParam {String} [Limit=10] Optional limit data of Event equipment checklists.
	 *
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of event_equipment_checklist.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError NoDataEvent equipment checklist Event equipment checklist data is nothing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function all_get()
	{
		$this->is_allowed('api_event_equipment_checklist_all');

		$filter = $this->get('filter');
		$field = $this->get('field');
		$limit = $this->get('limit') ? $this->get('limit') : $this->limit_page;
		$start = $this->get('start');

		$select_field = ['id', 'event_id', 'equipment_id'];
		$event_equipment_checklists = $this->model_api_event_equipment_checklist->get($filter, $field, $limit, $start, $select_field);
		$total = $this->model_api_event_equipment_checklist->count_all($filter, $field);

		$data['event_equipment_checklist'] = $event_equipment_checklists;
				
		$this->response([
			'status' 	=> true,
			'message' 	=> 'Data Event equipment checklist',
			'data'	 	=> $data,
			'total' 	=> $total
		], API::HTTP_OK);
	}

	
	/**
	 * @api {get} /event_equipment_checklist/detail Detail Event equipment checklist.
	 * @apiVersion 0.1.0
	 * @apiName DetailEvent equipment checklist
	 * @apiGroup event_equipment_checklist
	 * @apiHeader {String} X-Api-Key Event equipment checklists unique access-key.
	 * @apiHeader {String} X-Token Event equipment checklists unique token.
	 * @apiPermission Event equipment checklist Cant be Accessed permission name : api_event_equipment_checklist_detail
	 *
	 * @apiParam {Integer} Id Mandatory id of Event equipment checklists.
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of event_equipment_checklist.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError Event equipment checklistNotFound Event equipment checklist data is not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function detail_get()
	{
		$this->is_allowed('api_event_equipment_checklist_detail');

		$this->requiredInput(['id']);

		$id = $this->get('id');

		$select_field = ['id', 'event_id', 'equipment_id'];
		$data['event_equipment_checklist'] = $this->model_api_event_equipment_checklist->find($id, $select_field);

		if ($data['event_equipment_checklist']) {
			
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Detail Event equipment checklist',
				'data'	 	=> $data
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Event equipment checklist not found'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

	
	/**
	 * @api {post} /event_equipment_checklist/add Add Event equipment checklist.
	 * @apiVersion 0.1.0
	 * @apiName AddEvent equipment checklist
	 * @apiGroup event_equipment_checklist
	 * @apiHeader {String} X-Api-Key Event equipment checklists unique access-key.
	 * @apiHeader {String} X-Token Event equipment checklists unique token.
	 * @apiPermission Event equipment checklist Cant be Accessed permission name : api_event_equipment_checklist_add
	 *
 	 * @apiParam {String} Event_id Mandatory event_id of Event equipment checklists. Input Event Id Max Length : 11. 
	 * @apiParam {String} Equipment_id Mandatory equipment_id of Event equipment checklists. Input Equipment Id Max Length : 11. 
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
		$this->is_allowed('api_event_equipment_checklist_add');

		$this->form_validation->set_rules('event_id', 'Event Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('equipment_id', 'Equipment Id', 'trim|required|max_length[11]');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'event_id' => $this->input->post('event_id'),
				'equipment_id' => $this->input->post('equipment_id'),
			];
			
			$save_event_equipment_checklist = $this->model_api_event_equipment_checklist->store($save_data);

			if ($save_event_equipment_checklist) {
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
	 * @api {post} /event_equipment_checklist/update Update Event equipment checklist.
	 * @apiVersion 0.1.0
	 * @apiName UpdateEvent equipment checklist
	 * @apiGroup event_equipment_checklist
	 * @apiHeader {String} X-Api-Key Event equipment checklists unique access-key.
	 * @apiHeader {String} X-Token Event equipment checklists unique token.
	 * @apiPermission Event equipment checklist Cant be Accessed permission name : api_event_equipment_checklist_update
	 *
	 * @apiParam {String} Event_id Mandatory event_id of Event equipment checklists. Input Event Id Max Length : 11. 
	 * @apiParam {String} Equipment_id Mandatory equipment_id of Event equipment checklists. Input Equipment Id Max Length : 11. 
	 * @apiParam {Integer} id Mandatory id of Event Equipment Checklist.
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
		$this->is_allowed('api_event_equipment_checklist_update');

		
		$this->form_validation->set_rules('event_id', 'Event Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('equipment_id', 'Equipment Id', 'trim|required|max_length[11]');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'event_id' => $this->input->post('event_id'),
				'equipment_id' => $this->input->post('equipment_id'),
			];
			
			$save_event_equipment_checklist = $this->model_api_event_equipment_checklist->change($this->post('id'), $save_data);

			if ($save_event_equipment_checklist) {
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
	 * @api {post} /event_equipment_checklist/delete Delete Event equipment checklist. 
	 * @apiVersion 0.1.0
	 * @apiName DeleteEvent equipment checklist
	 * @apiGroup event_equipment_checklist
	 * @apiHeader {String} X-Api-Key Event equipment checklists unique access-key.
	 * @apiHeader {String} X-Token Event equipment checklists unique token.
	 	 * @apiPermission Event equipment checklist Cant be Accessed permission name : api_event_equipment_checklist_delete
	 *
	 * @apiParam {Integer} Id Mandatory id of Event equipment checklists .
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
		$this->is_allowed('api_event_equipment_checklist_delete');

		$event_equipment_checklist = $this->model_api_event_equipment_checklist->find($this->post('id'));

		if (!$event_equipment_checklist) {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Event equipment checklist not found'
			], API::HTTP_NOT_ACCEPTABLE);
		} else {
			$delete = $this->model_api_event_equipment_checklist->remove($this->post('id'));

			}
		
		if ($delete) {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Event equipment checklist deleted',
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Event equipment checklist not delete'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

}

/* End of file Event equipment checklist.php */
/* Location: ./application/controllers/api/Event equipment checklist.php */