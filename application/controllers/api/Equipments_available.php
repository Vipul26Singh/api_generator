<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Equipments_available extends API
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_api_equipments_available');
	}

	/**
	 * @api {get} /equipments_available/all Get all equipments_availables.
	 * @apiVersion 0.1.0
	 * @apiName AllEquipmentsavailable 
	 * @apiGroup equipments_available
	 * @apiHeader {String} X-Api-Key Equipments availables unique access-key.
	 * @apiPermission Equipments available Cant be Accessed permission name : api_equipments_available_all
	 *
	 * @apiParam {String} [Filter=null] Optional filter of Equipments availables.
	 * @apiParam {String} [Field="All Field"] Optional field of Equipments availables : id, equipment_name, equipment_condition, equipment_size, equipment_description, equipment_barcode, equipment_category_id, equipment_image.
	 * @apiParam {String} [Start=0] Optional start index of Equipments availables.
	 * @apiParam {String} [Limit=10] Optional limit data of Equipments availables.
	 *
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of equipments_available.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError NoDataEquipments available Equipments available data is nothing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function all_get()
	{
		$this->is_allowed('api_equipments_available_all', false);

		$filter = $this->get('filter');
		$field = $this->get('field');
		$limit = $this->get('limit') ? $this->get('limit') : $this->limit_page;
		$start = $this->get('start');

		$select_field = ['id', 'equipment_name', 'equipment_condition', 'equipment_size', 'equipment_description', 'equipment_barcode', 'equipment_category_id', 'equipment_image'];
		$equipments_availables = $this->model_api_equipments_available->get($filter, $field, $limit, $start, $select_field);
		$total = $this->model_api_equipments_available->count_all($filter, $field);

		$equipments_available_arr = [];

		foreach ($equipments_availables as $equipments_available) {
							if(!empty($equipments_available->equipment_image)) {
					$equipments_available->equipment_image  = BASE_URL.'uploads/equipments/'.$equipments_available->equipment_image;
				} else {
					$equipments_available->equipment_image  = $equipments_available->equipment_image;
				}
			$equipments_available_arr[] = $equipments_available;
		}

		$data['equipments_available'] = $equipments_available_arr;
				
		$this->response([
			'status' 	=> true,
			'message' 	=> 'Data Equipments available',
			'data'	 	=> $data,
			'total' 	=> $total
		], API::HTTP_OK);
	}

	
	/**
	 * @api {get} /equipments_available/detail Detail Equipments available.
	 * @apiVersion 0.1.0
	 * @apiName DetailEquipments available
	 * @apiGroup equipments_available
	 * @apiHeader {String} X-Api-Key Equipments availables unique access-key.
	 * @apiPermission Equipments available Cant be Accessed permission name : api_equipments_available_detail
	 *
	 * @apiParam {Integer} Id Mandatory id of Equipments availables.
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of equipments_available.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError Equipments availableNotFound Equipments available data is not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function detail_get()
	{
		$this->is_allowed('api_equipments_available_detail', false);

		$this->requiredInput(['']);

		$id = $this->get('');

		$select_field = ['id', 'equipment_name', 'equipment_condition', 'equipment_size', 'equipment_description', 'equipment_barcode', 'equipment_category_id', 'equipment_image'];
		$data['equipments_available'] = $this->model_api_equipments_available->find($id, $select_field);

		if ($data['equipments_available']) {
							if(!empty($equipments_available->equipment_image)) {
					$data['equipments_available']->equipment_image = BASE_URL.'uploads/equipments/'.$data['equipments_available']->equipment_image;
				} else {
					$data['equipments_available']->equipment_image = $data['equipments_available']->equipment_image;
				}
			
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Detail Equipments available',
				'data'	 	=> $data
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Equipments available not found'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

	
	/**
	 * @api {post} /equipments_available/add Add Equipments available.
	 * @apiVersion 0.1.0
	 * @apiName AddEquipments available
	 * @apiGroup equipments_available
	 * @apiHeader {String} X-Api-Key Equipments availables unique access-key.
	 * @apiPermission Equipments available Cant be Accessed permission name : api_equipments_available_add
	 *
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
		$this->is_allowed('api_equipments_available_add', false);

		
		if ($this->form_validation->run()) {

			$save_data = [
			];
			
			$save_equipments_available = $this->model_api_equipments_available->store($save_data);

			if ($save_equipments_available) {
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
	 * @api {post} /equipments_available/update Update Equipments available.
	 * @apiVersion 0.1.0
	 * @apiName UpdateEquipments available
	 * @apiGroup equipments_available
	 * @apiHeader {String} X-Api-Key Equipments availables unique access-key.
	 * @apiPermission Equipments available Cant be Accessed permission name : api_equipments_available_update
	 *
	 * @apiParam {Integer}  Mandatory  of Equipments Available.
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
		$this->is_allowed('api_equipments_available_update', false);

		
		
		if ($this->form_validation->run()) {

			$save_data = [
			];
			
			$save_equipments_available = $this->model_api_equipments_available->change($this->post(''), $save_data);

			if ($save_equipments_available) {
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
	 * @api {post} /equipments_available/delete Delete Equipments available. 
	 * @apiVersion 0.1.0
	 * @apiName DeleteEquipments available
	 * @apiGroup equipments_available
	 * @apiHeader {String} X-Api-Key Equipments availables unique access-key.
	 	 * @apiPermission Equipments available Cant be Accessed permission name : api_equipments_available_delete
	 *
	 * @apiParam {Integer} Id Mandatory id of Equipments availables .
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
		$this->is_allowed('api_equipments_available_delete', false);

		$equipments_available = $this->model_api_equipments_available->find($this->post(''));

		if (!$equipments_available) {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Equipments available not found'
			], API::HTTP_NOT_ACCEPTABLE);
		} else {
			$delete = $this->model_api_equipments_available->remove($this->post(''));

			if (!empty($equipments_available->equipment_image)) {
				$path = FCPATH . '/uploads/equipments/' . $equipments_available->equipment_image;

				if (is_file($path)) {
					$delete_file = unlink($path);
				}
			}

		}
		
		if ($delete) {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Equipments available deleted',
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Equipments available not delete'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

}

/* End of file Equipments available.php */
/* Location: ./application/controllers/api/Equipments available.php */
