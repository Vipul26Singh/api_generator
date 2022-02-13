<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Equipment_checkin extends API
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_api_equipment_checkin');
	}

	/**
	 * @api {get} /equipment_checkin/all Get all equipment_checkins.
	 * @apiVersion 0.1.0
	 * @apiName AllEquipmentcheckin 
	 * @apiGroup equipment_checkin
	 * @apiHeader {String} X-Api-Key Equipment checkins unique access-key.
	 * @apiHeader {String} X-Token Equipment checkins unique token.
	 * @apiPermission Equipment checkin Cant be Accessed permission name : api_equipment_checkin_all
	 *
	 * @apiParam {String} [Filter=null] Optional filter of Equipment checkins.
	 * @apiParam {String} [Field="All Field"] Optional field of Equipment checkins : id, equipment_id, equipment_in_datetime.
	 * @apiParam {String} [Start=0] Optional start index of Equipment checkins.
	 * @apiParam {String} [Limit=10] Optional limit data of Equipment checkins.
	 *
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of equipment_checkin.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError NoDataEquipment checkin Equipment checkin data is nothing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function all_get()
	{
		$this->is_allowed('api_equipment_checkin_all');

		$filter = $this->get('filter');
		$field = $this->get('field');
		$limit = $this->get('limit') ? $this->get('limit') : $this->limit_page;
		$start = $this->get('start');

		$select_field = ['id', 'equipment_id', 'equipment_in_datetime'];
		$equipment_checkins = $this->model_api_equipment_checkin->get($filter, $field, $limit, $start, $select_field);
		$total = $this->model_api_equipment_checkin->count_all($filter, $field);

		$data['equipment_checkin'] = $equipment_checkins;
				
		$this->response([
			'status' 	=> true,
			'message' 	=> 'Data Equipment checkin',
			'data'	 	=> $data,
			'total' 	=> $total
		], API::HTTP_OK);
	}

	
	/**
	 * @api {get} /equipment_checkin/detail Detail Equipment checkin.
	 * @apiVersion 0.1.0
	 * @apiName DetailEquipment checkin
	 * @apiGroup equipment_checkin
	 * @apiHeader {String} X-Api-Key Equipment checkins unique access-key.
	 * @apiHeader {String} X-Token Equipment checkins unique token.
	 * @apiPermission Equipment checkin Cant be Accessed permission name : api_equipment_checkin_detail
	 *
	 * @apiParam {Integer} Id Mandatory id of Equipment checkins.
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of equipment_checkin.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError Equipment checkinNotFound Equipment checkin data is not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function detail_get()
	{
		$this->is_allowed('api_equipment_checkin_detail');

		$this->requiredInput(['id']);

		$id = $this->get('id');

		$select_field = ['id', 'equipment_id', 'equipment_in_datetime'];
		$data['equipment_checkin'] = $this->model_api_equipment_checkin->find($id, $select_field);

		if ($data['equipment_checkin']) {
			
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Detail Equipment checkin',
				'data'	 	=> $data
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Equipment checkin not found'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

	
	/**
	 * @api {post} /equipment_checkin/add Add Equipment checkin.
	 * @apiVersion 0.1.0
	 * @apiName AddEquipment checkin
	 * @apiGroup equipment_checkin
	 * @apiHeader {String} X-Api-Key Equipment checkins unique access-key.
	 * @apiHeader {String} X-Token Equipment checkins unique token.
	 * @apiPermission Equipment checkin Cant be Accessed permission name : api_equipment_checkin_add
	 *
 	 * @apiParam {String} Equipment_id Mandatory equipment_id of Equipment checkins. Input Equipment Id Max Length : 11. 
	 * @apiParam {String} [Equipment_in_datetime] Optional equipment_in_datetime of Equipment checkins.  
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
		$this->is_allowed('api_equipment_checkin_add');

		$this->form_validation->set_rules('equipment_id', 'Equipment Id', 'trim|required|max_length[11]');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'equipment_id' => $this->input->post('equipment_id'),
				'equipment_in_datetime' => date('Y-m-d H:i:s'),
			];
			
			$save_equipment_checkin = $this->model_api_equipment_checkin->store($save_data);

			if ($save_equipment_checkin) {
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
	 * @api {post} /equipment_checkin/update Update Equipment checkin.
	 * @apiVersion 0.1.0
	 * @apiName UpdateEquipment checkin
	 * @apiGroup equipment_checkin
	 * @apiHeader {String} X-Api-Key Equipment checkins unique access-key.
	 * @apiHeader {String} X-Token Equipment checkins unique token.
	 * @apiPermission Equipment checkin Cant be Accessed permission name : api_equipment_checkin_update
	 *
	 * @apiParam {String} Equipment_id Mandatory equipment_id of Equipment checkins. Input Equipment Id Max Length : 11. 
	 * @apiParam {String} [Equipment_in_datetime] Optional equipment_in_datetime of Equipment checkins.  
	 * @apiParam {Integer} id Mandatory id of Equipment Checkin.
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
		$this->is_allowed('api_equipment_checkin_update');

		
		$this->form_validation->set_rules('equipment_id', 'Equipment Id', 'trim|required|max_length[11]');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'equipment_id' => $this->input->post('equipment_id'),
				'equipment_in_datetime' => date('Y-m-d H:i:s'),
			];
			
			$save_equipment_checkin = $this->model_api_equipment_checkin->change($this->post('id'), $save_data);

			if ($save_equipment_checkin) {
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
	 * @api {post} /equipment_checkin/delete Delete Equipment checkin. 
	 * @apiVersion 0.1.0
	 * @apiName DeleteEquipment checkin
	 * @apiGroup equipment_checkin
	 * @apiHeader {String} X-Api-Key Equipment checkins unique access-key.
	 * @apiHeader {String} X-Token Equipment checkins unique token.
	 	 * @apiPermission Equipment checkin Cant be Accessed permission name : api_equipment_checkin_delete
	 *
	 * @apiParam {Integer} Id Mandatory id of Equipment checkins .
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
		$this->is_allowed('api_equipment_checkin_delete');

		$equipment_checkin = $this->model_api_equipment_checkin->find($this->post('id'));

		if (!$equipment_checkin) {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Equipment checkin not found'
			], API::HTTP_NOT_ACCEPTABLE);
		} else {
			$delete = $this->model_api_equipment_checkin->remove($this->post('id'));

			}
		
		if ($delete) {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Equipment checkin deleted',
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Equipment checkin not delete'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

}

/* End of file Equipment checkin.php */
/* Location: ./application/controllers/api/Equipment checkin.php */