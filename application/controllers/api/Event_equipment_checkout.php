<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Event_equipment_checkout extends API
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_api_event_equipment_checkout');
	}

	/**
	 * @api {get} /event_equipment_checkout/all Get all event_equipment_checkouts.
	 * @apiVersion 0.1.0
	 * @apiName AllEventequipmentcheckout 
	 * @apiGroup event_equipment_checkout
	 * @apiHeader {String} X-Api-Key Event equipment checkouts unique access-key.
	 * @apiHeader {String} X-Token Event equipment checkouts unique token.
	 * @apiPermission Event equipment checkout Cant be Accessed permission name : api_event_equipment_checkout_all
	 *
	 * @apiParam {String} [Filter=null] Optional filter of Event equipment checkouts.
	 * @apiParam {String} [Field="All Field"] Optional field of Event equipment checkouts : id, event_id, equipment_id, equipment_out_datetime.
	 * @apiParam {String} [Start=0] Optional start index of Event equipment checkouts.
	 * @apiParam {String} [Limit=10] Optional limit data of Event equipment checkouts.
	 *
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of event_equipment_checkout.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError NoDataEvent equipment checkout Event equipment checkout data is nothing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function all_get()
	{
		$this->is_allowed('api_event_equipment_checkout_all');

		$filter = $this->get('filter');
		$field = $this->get('field');
		$limit = $this->get('limit') ? $this->get('limit') : $this->limit_page;
		$start = $this->get('start');

		$select_field = ['id', 'event_id', 'equipment_id', 'equipment_out_datetime'];
		$event_equipment_checkouts = $this->model_api_event_equipment_checkout->get($filter, $field, $limit, $start, $select_field);
		$total = $this->model_api_event_equipment_checkout->count_all($filter, $field);

		$data['event_equipment_checkout'] = $event_equipment_checkouts;
				
		$this->response([
			'status' 	=> true,
			'message' 	=> 'Data Event equipment checkout',
			'data'	 	=> $data,
			'total' 	=> $total
		], API::HTTP_OK);
	}

	
	/**
	 * @api {get} /event_equipment_checkout/detail Detail Event equipment checkout.
	 * @apiVersion 0.1.0
	 * @apiName DetailEvent equipment checkout
	 * @apiGroup event_equipment_checkout
	 * @apiHeader {String} X-Api-Key Event equipment checkouts unique access-key.
	 * @apiHeader {String} X-Token Event equipment checkouts unique token.
	 * @apiPermission Event equipment checkout Cant be Accessed permission name : api_event_equipment_checkout_detail
	 *
	 * @apiParam {Integer} Id Mandatory id of Event equipment checkouts.
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of event_equipment_checkout.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError Event equipment checkoutNotFound Event equipment checkout data is not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function detail_get()
	{
		$this->is_allowed('api_event_equipment_checkout_detail');

		$this->requiredInput(['id']);

		$id = $this->get('id');

		$select_field = ['id', 'event_id', 'equipment_id', 'equipment_out_datetime'];
		$data['event_equipment_checkout'] = $this->model_api_event_equipment_checkout->find($id, $select_field);

		if ($data['event_equipment_checkout']) {
			
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Detail Event equipment checkout',
				'data'	 	=> $data
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Event equipment checkout not found'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

	
	/**
	 * @api {post} /event_equipment_checkout/add Add Event equipment checkout.
	 * @apiVersion 0.1.0
	 * @apiName AddEvent equipment checkout
	 * @apiGroup event_equipment_checkout
	 * @apiHeader {String} X-Api-Key Event equipment checkouts unique access-key.
	 * @apiHeader {String} X-Token Event equipment checkouts unique token.
	 * @apiPermission Event equipment checkout Cant be Accessed permission name : api_event_equipment_checkout_add
	 *
 	 * @apiParam {String} Event_id Mandatory event_id of Event equipment checkouts. Input Event Id Max Length : 11. 
	 * @apiParam {String} Equipment_id Mandatory equipment_id of Event equipment checkouts. Input Equipment Id Max Length : 11. 
	 * @apiParam {String} [Equipment_out_datetime] Optional equipment_out_datetime of Event equipment checkouts.  
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
		$this->is_allowed('api_event_equipment_checkout_add');

		$this->form_validation->set_rules('event_id', 'Event Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('equipment_id', 'Equipment Id', 'trim|required|max_length[11]');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'event_id' => $this->input->post('event_id'),
				'equipment_id' => $this->input->post('equipment_id'),
				'equipment_out_datetime' => date('Y-m-d H:i:s'),
			];
			
			$save_event_equipment_checkout = $this->model_api_event_equipment_checkout->store($save_data);

			if ($save_event_equipment_checkout) {
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
	 * @api {post} /event_equipment_checkout/update Update Event equipment checkout.
	 * @apiVersion 0.1.0
	 * @apiName UpdateEvent equipment checkout
	 * @apiGroup event_equipment_checkout
	 * @apiHeader {String} X-Api-Key Event equipment checkouts unique access-key.
	 * @apiHeader {String} X-Token Event equipment checkouts unique token.
	 * @apiPermission Event equipment checkout Cant be Accessed permission name : api_event_equipment_checkout_update
	 *
	 * @apiParam {String} Event_id Mandatory event_id of Event equipment checkouts. Input Event Id Max Length : 11. 
	 * @apiParam {String} Equipment_id Mandatory equipment_id of Event equipment checkouts. Input Equipment Id Max Length : 11. 
	 * @apiParam {String} [Equipment_out_datetime] Optional equipment_out_datetime of Event equipment checkouts.  
	 * @apiParam {Integer} id Mandatory id of Event Equipment Checkout.
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
		$this->is_allowed('api_event_equipment_checkout_update');

		
		$this->form_validation->set_rules('event_id', 'Event Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('equipment_id', 'Equipment Id', 'trim|required|max_length[11]');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'event_id' => $this->input->post('event_id'),
				'equipment_id' => $this->input->post('equipment_id'),
				'equipment_out_datetime' => date('Y-m-d H:i:s'),
			];
			
			$save_event_equipment_checkout = $this->model_api_event_equipment_checkout->change($this->post('id'), $save_data);

			if ($save_event_equipment_checkout) {
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
	 * @api {post} /event_equipment_checkout/delete Delete Event equipment checkout. 
	 * @apiVersion 0.1.0
	 * @apiName DeleteEvent equipment checkout
	 * @apiGroup event_equipment_checkout
	 * @apiHeader {String} X-Api-Key Event equipment checkouts unique access-key.
	 * @apiHeader {String} X-Token Event equipment checkouts unique token.
	 	 * @apiPermission Event equipment checkout Cant be Accessed permission name : api_event_equipment_checkout_delete
	 *
	 * @apiParam {Integer} Id Mandatory id of Event equipment checkouts .
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
		$this->is_allowed('api_event_equipment_checkout_delete');

		$event_equipment_checkout = $this->model_api_event_equipment_checkout->find($this->post('id'));

		if (!$event_equipment_checkout) {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Event equipment checkout not found'
			], API::HTTP_NOT_ACCEPTABLE);
		} else {
			$delete = $this->model_api_event_equipment_checkout->remove($this->post('id'));

			}
		
		if ($delete) {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Event equipment checkout deleted',
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Event equipment checkout not delete'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

}

/* End of file Event equipment checkout.php */
/* Location: ./application/controllers/api/Event equipment checkout.php */