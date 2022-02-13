<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Equipments extends API
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_api_equipments');
	}

	/**
	 * @api {get} /equipments/all Get all equipmentss.
	 * @apiVersion 0.1.0
	 * @apiName AllEquipments 
	 * @apiGroup equipments
	 * @apiHeader {String} X-Api-Key Equipmentss unique access-key.
	 * @apiHeader {String} X-Token Equipmentss unique token.
	 * @apiPermission Equipments Cant be Accessed permission name : api_equipments_all
	 *
	 * @apiParam {String} [Filter=null] Optional filter of Equipmentss.
	 * @apiParam {String} [Field="All Field"] Optional field of Equipmentss : id, equipment_name, equipment_condition, equipment_size, equipment_description, equipment_barcode, equipment_category_id, equipment_image.
	 * @apiParam {String} [Start=0] Optional start index of Equipmentss.
	 * @apiParam {String} [Limit=10] Optional limit data of Equipmentss.
	 *
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of equipments.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError NoDataEquipments Equipments data is nothing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function all_get()
	{
		$this->is_allowed('api_equipments_all');

		$filter = $this->get('filter');
		$field = $this->get('field');
		$limit = $this->get('limit') ? $this->get('limit') : $this->limit_page;
		$start = $this->get('start');

		$select_field = ['id', 'equipment_name', 'equipment_condition', 'equipment_size', 'equipment_description', 'equipment_barcode', 'equipment_category_id', 'equipment_image'];
		$equipmentss = $this->model_api_equipments->get($filter, $field, $limit, $start, $select_field);
		$total = $this->model_api_equipments->count_all($filter, $field);

		$equipments_arr = [];

		foreach ($equipmentss as $equipments) {
			$equipments->equipment_image  = BASE_URL.'uploads/equipments/'.$equipments->equipment_image;
			$equipments_arr[] = $equipments;
		}

		$data['equipments'] = $equipments_arr;
				
		$this->response([
			'status' 	=> true,
			'message' 	=> 'Data Equipments',
			'data'	 	=> $data,
			'total' 	=> $total
		], API::HTTP_OK);
	}

	
	/**
	 * @api {get} /equipments/detail Detail Equipments.
	 * @apiVersion 0.1.0
	 * @apiName DetailEquipments
	 * @apiGroup equipments
	 * @apiHeader {String} X-Api-Key Equipmentss unique access-key.
	 * @apiHeader {String} X-Token Equipmentss unique token.
	 * @apiPermission Equipments Cant be Accessed permission name : api_equipments_detail
	 *
	 * @apiParam {Integer} Id Mandatory id of Equipmentss.
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of equipments.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError EquipmentsNotFound Equipments data is not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function detail_get()
	{
		$this->is_allowed('api_equipments_detail');

		$this->requiredInput(['id']);

		$id = $this->get('id');

		$select_field = ['id', 'equipment_name', 'equipment_condition', 'equipment_size', 'equipment_description', 'equipment_barcode', 'equipment_category_id', 'equipment_image'];
		$data['equipments'] = $this->model_api_equipments->find($id, $select_field);

		if ($data['equipments']) {
			$data['equipments']->equipment_image = BASE_URL.'uploads/equipments/'.$data['equipments']->equipment_image;
			
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Detail Equipments',
				'data'	 	=> $data
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Equipments not found'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

	
	/**
	 * @api {post} /equipments/add Add Equipments.
	 * @apiVersion 0.1.0
	 * @apiName AddEquipments
	 * @apiGroup equipments
	 * @apiHeader {String} X-Api-Key Equipmentss unique access-key.
	 * @apiHeader {String} X-Token Equipmentss unique token.
	 * @apiPermission Equipments Cant be Accessed permission name : api_equipments_add
	 *
 	 * @apiParam {String} Equipment_name Mandatory equipment_name of Equipmentss. Input Equipment Name Max Length : 4096. 
	 * @apiParam {String} Equipment_condition Mandatory equipment_condition of Equipmentss. Input Equipment Condition Max Length : 100, In List : OLD,NEW,BAD,FAIR. 
	 * @apiParam {String} Equipment_size Mandatory equipment_size of Equipmentss. Input Equipment Size Max Length : 100, In List : LONG,VERY LONG,SHORT,VERY SHORT,NA. 
	 * @apiParam {String} [Equipment_description] Optional equipment_description of Equipmentss. Input Equipment Description Max Length : 4096. 
	 * @apiParam {String} [Equipment_barcode] Optional equipment_barcode of Equipmentss. Input Equipment Barcode Max Length : 4096. 
	 * @apiParam {String} Equipment_category_id Mandatory equipment_category_id of Equipmentss. Input Equipment Category Id Max Length : 11. 
	 * @apiParam {File} [Equipment_image] Optional equipment_image of Equipmentss.  
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
		$this->is_allowed('api_equipments_add');

		$this->form_validation->set_rules('equipment_name', 'Equipment Name', 'trim|required|max_length[4096]');
		$this->form_validation->set_rules('equipment_condition', 'Equipment Condition', 'trim|required|max_length[100]|in_list[OLD,NEW,BAD,FAIR]');
		$this->form_validation->set_rules('equipment_size', 'Equipment Size', 'trim|required|max_length[100]|in_list[LONG,VERY LONG,SHORT,VERY SHORT,NA]');
		$this->form_validation->set_rules('equipment_description', 'Equipment Description', 'trim|max_length[4096]');
		$this->form_validation->set_rules('equipment_barcode', 'Equipment Barcode', 'trim|max_length[4096]');
		$this->form_validation->set_rules('equipment_category_id', 'Equipment Category Id', 'trim|required|max_length[11]');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'equipment_name' => $this->input->post('equipment_name'),
				'equipment_condition' => $this->input->post('equipment_condition'),
				'equipment_size' => $this->input->post('equipment_size'),
				'equipment_description' => $this->input->post('equipment_description'),
				'equipment_barcode' => $this->input->post('equipment_barcode'),
				'equipment_category_id' => $this->input->post('equipment_category_id'),
			];
			
			$config = [
				'upload_path' 	=> './uploads/equipments/',
					'required' 		=> false
			];
			
			if ($upload = $this->upload_file('equipment_image', $config)){
				$upload_data = $this->upload->data();
				$save_data['equipment_image'] = $upload['file_name'];
			}

			$save_equipments = $this->model_api_equipments->store($save_data);

			if ($save_equipments) {
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
	 * @api {post} /equipments/update Update Equipments.
	 * @apiVersion 0.1.0
	 * @apiName UpdateEquipments
	 * @apiGroup equipments
	 * @apiHeader {String} X-Api-Key Equipmentss unique access-key.
	 * @apiHeader {String} X-Token Equipmentss unique token.
	 * @apiPermission Equipments Cant be Accessed permission name : api_equipments_update
	 *
	 * @apiParam {String} Equipment_name Mandatory equipment_name of Equipmentss. Input Equipment Name Max Length : 4096. 
	 * @apiParam {String} Equipment_condition Mandatory equipment_condition of Equipmentss. Input Equipment Condition Max Length : 100, In List : OLD,NEW,BAD,FAIR. 
	 * @apiParam {String} Equipment_size Mandatory equipment_size of Equipmentss. Input Equipment Size Max Length : 100, In List : LONG,VERY LONG,SHORT,VERY SHORT,NA. 
	 * @apiParam {String} [Equipment_description] Optional equipment_description of Equipmentss. Input Equipment Description Max Length : 4096. 
	 * @apiParam {String} [Equipment_barcode] Optional equipment_barcode of Equipmentss. Input Equipment Barcode Max Length : 4096. 
	 * @apiParam {String} Equipment_category_id Mandatory equipment_category_id of Equipmentss. Input Equipment Category Id Max Length : 11. 
	 * @apiParam {File} [Equipment_image] Optional equipment_image of Equipmentss.  
	 * @apiParam {Integer} id Mandatory id of Equipments.
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
		$this->is_allowed('api_equipments_update');

		
		$this->form_validation->set_rules('equipment_name', 'Equipment Name', 'trim|required|max_length[4096]');
		$this->form_validation->set_rules('equipment_condition', 'Equipment Condition', 'trim|required|max_length[100]|in_list[OLD,NEW,BAD,FAIR]');
		$this->form_validation->set_rules('equipment_size', 'Equipment Size', 'trim|required|max_length[100]|in_list[LONG,VERY LONG,SHORT,VERY SHORT,NA]');
		$this->form_validation->set_rules('equipment_description', 'Equipment Description', 'trim|max_length[4096]');
		$this->form_validation->set_rules('equipment_barcode', 'Equipment Barcode', 'trim|max_length[4096]');
		$this->form_validation->set_rules('equipment_category_id', 'Equipment Category Id', 'trim|required|max_length[11]');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'equipment_name' => $this->input->post('equipment_name'),
				'equipment_condition' => $this->input->post('equipment_condition'),
				'equipment_size' => $this->input->post('equipment_size'),
				'equipment_description' => $this->input->post('equipment_description'),
				'equipment_barcode' => $this->input->post('equipment_barcode'),
				'equipment_category_id' => $this->input->post('equipment_category_id'),
			];
			
			$config = [
				'upload_path' 	=> './uploads/equipments/',
					'required' 		=> false
			];
			
			if ($upload = $this->upload_file('equipment_image', $config)){
				$upload_data = $this->upload->data();
				$save_data['equipment_image'] = $upload['file_name'];
			}

			$save_equipments = $this->model_api_equipments->change($this->post('id'), $save_data);

			if ($save_equipments) {
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
	 * @api {post} /equipments/delete Delete Equipments. 
	 * @apiVersion 0.1.0
	 * @apiName DeleteEquipments
	 * @apiGroup equipments
	 * @apiHeader {String} X-Api-Key Equipmentss unique access-key.
	 * @apiHeader {String} X-Token Equipmentss unique token.
	 	 * @apiPermission Equipments Cant be Accessed permission name : api_equipments_delete
	 *
	 * @apiParam {Integer} Id Mandatory id of Equipmentss .
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
		$this->is_allowed('api_equipments_delete');

		$equipments = $this->model_api_equipments->find($this->post('id'));

		if (!$equipments) {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Equipments not found'
			], API::HTTP_NOT_ACCEPTABLE);
		} else {
			$delete = $this->model_api_equipments->remove($this->post('id'));

			if (!empty($equipments->equipment_image)) {
				$path = FCPATH . '/uploads/equipments/' . $equipments->equipment_image;

				if (is_file($path)) {
					$delete_file = unlink($path);
				}
			}

		}
		
		if ($delete) {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Equipments deleted',
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Equipments not delete'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

}

/* End of file Equipments.php */
/* Location: ./application/controllers/api/Equipments.php */