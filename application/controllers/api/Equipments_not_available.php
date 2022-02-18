<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Equipments_not_available extends API
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_api_equipments_not_available');
	}

	/**
	 * @api {get} /equipments_not_available/all Get all equipments_not_availables.
	 * @apiVersion 0.1.0
	 * @apiName AllEquipmentsnotavailable 
	 * @apiGroup equipments_not_available
	 * @apiHeader {String} X-Api-Key Equipments not availables unique access-key.
	 * @apiPermission Equipments not available Cant be Accessed permission name : api_equipments_not_available_all
	 *
	 * @apiParam {String} [Filter=null] Optional filter of Equipments not availables.
	 * @apiParam {String} [Field="All Field"] Optional field of Equipments not availables : id, equipment_name, equipment_condition, equipment_size, equipment_description, equipment_barcode, equipment_category_id, equipment_image.
	 * @apiParam {String} [Start=0] Optional start index of Equipments not availables.
	 * @apiParam {String} [Limit=10] Optional limit data of Equipments not availables.
	 *
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of equipments_not_available.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError NoDataEquipments not available Equipments not available data is nothing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function all_get()
	{
		$this->is_allowed('api_equipments_not_available_all', false);

		$filter = $this->get('filter');
		$field = $this->get('field');
		$limit = $this->get('limit') ? $this->get('limit') : $this->limit_page;
		$start = $this->get('start');

		$select_field = ['id', 'equipment_name', 'equipment_condition', 'equipment_size', 'equipment_description', 'equipment_barcode', 'equipment_category_id', 'equipment_image'];
		$equipments_not_availables = $this->model_api_equipments_not_available->get($filter, $field, $limit, $start, $select_field);
		$total = $this->model_api_equipments_not_available->count_all($filter, $field);

		$equipments_not_available_arr = [];

		foreach ($equipments_not_availables as $equipments_not_available) {
							if(!empty($equipments_not_available->equipment_image)) {
					$equipments_not_available->equipment_image  = BASE_URL.'uploads/equipments/'.$equipments_not_available->equipment_image;
				} else {
					$equipments_not_available->equipment_image  = $equipments_not_available->equipment_image;
				}
			$equipments_not_available_arr[] = $equipments_not_available;
		}

		$data['equipments_not_available'] = $equipments_not_available_arr;
				
		$this->response([
			'status' 	=> true,
			'message' 	=> 'Data Equipments not available',
			'data'	 	=> $data,
			'total' 	=> $total
		], API::HTTP_OK);
	}

	
	/**
	 * @api {get} /equipments_not_available/detail Detail Equipments not available.
	 * @apiVersion 0.1.0
	 * @apiName DetailEquipments not available
	 * @apiGroup equipments_not_available
	 * @apiHeader {String} X-Api-Key Equipments not availables unique access-key.
	 * @apiPermission Equipments not available Cant be Accessed permission name : api_equipments_not_available_detail
	 *
	 * @apiParam {Integer} Id Mandatory id of Equipments not availables.
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of equipments_not_available.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError Equipments not availableNotFound Equipments not available data is not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function detail_get()
	{
		$this->is_allowed('api_equipments_not_available_detail', false);

		$this->requiredInput(['']);

		$id = $this->get('');

		$select_field = ['id', 'equipment_name', 'equipment_condition', 'equipment_size', 'equipment_description', 'equipment_barcode', 'equipment_category_id', 'equipment_image'];
		$data['equipments_not_available'] = $this->model_api_equipments_not_available->find($id, $select_field);

		if ($data['equipments_not_available']) {
							if(!empty($equipments_not_available->equipment_image)) {
					$data['equipments_not_available']->equipment_image = BASE_URL.'uploads/equipments/'.$data['equipments_not_available']->equipment_image;
				} else {
					$data['equipments_not_available']->equipment_image = $data['equipments_not_available']->equipment_image;
				}
			
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Detail Equipments not available',
				'data'	 	=> $data
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Equipments not available not found'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

	
	/**
	 * @api {post} /equipments_not_available/add Add Equipments not available.
	 * @apiVersion 0.1.0
	 * @apiName AddEquipments not available
	 * @apiGroup equipments_not_available
	 * @apiHeader {String} X-Api-Key Equipments not availables unique access-key.
	 * @apiPermission Equipments not available Cant be Accessed permission name : api_equipments_not_available_add
	 *
 	 * @apiParam {String} Id Mandatory id of Equipments not availables. Input Id Max Length : 11. 
	 * @apiParam {String} Equipment_name Mandatory equipment_name of Equipments not availables. Input Equipment Name Max Length : 4096. 
	 * @apiParam {String} Equipment_condition Mandatory equipment_condition of Equipments not availables. Input Equipment Condition Max Length : 100. 
	 * @apiParam {String} Equipment_size Mandatory equipment_size of Equipments not availables. Input Equipment Size Max Length : 100. 
	 * @apiParam {String} Equipment_description Mandatory equipment_description of Equipments not availables. Input Equipment Description Max Length : 4096. 
	 * @apiParam {String} Equipment_barcode Mandatory equipment_barcode of Equipments not availables. Input Equipment Barcode Max Length : 4096. 
	 * @apiParam {String} Equipment_category_id Mandatory equipment_category_id of Equipments not availables. Input Equipment Category Id Max Length : 11. 
	 * @apiParam {File} Equipment_image Mandatory equipment_image of Equipments not availables. Input Equipment Image Max Length : 4096. 
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
		$this->is_allowed('api_equipments_not_available_add', false);

		$this->form_validation->set_rules('id', 'Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('equipment_name', 'Equipment Name', 'trim|required|max_length[4096]');
		$this->form_validation->set_rules('equipment_condition', 'Equipment Condition', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('equipment_size', 'Equipment Size', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('equipment_description', 'Equipment Description', 'trim|required|max_length[4096]');
		$this->form_validation->set_rules('equipment_barcode', 'Equipment Barcode', 'trim|required|max_length[4096]');
		$this->form_validation->set_rules('equipment_category_id', 'Equipment Category Id', 'trim|required|max_length[11]');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'id' => $this->input->post('id'),
				'equipment_name' => $this->input->post('equipment_name'),
				'equipment_condition' => $this->input->post('equipment_condition'),
				'equipment_size' => $this->input->post('equipment_size'),
				'equipment_description' => $this->input->post('equipment_description'),
				'equipment_barcode' => $this->input->post('equipment_barcode'),
				'equipment_category_id' => $this->input->post('equipment_category_id'),
			];
			if (!is_dir(FCPATH . '/uploads/equipments_not_available')) {
				mkdir(FCPATH . '/uploads/equipments_not_available');
			}
			
			$config = [
				'upload_path' 	=> './uploads/equipments_not_available/',
					'required' 		=> true
			];
			
			if ($upload = $this->upload_file('equipment_image', $config)){
				$upload_data = $this->upload->data();
				$save_data['equipment_image'] = $upload['file_name'];
			}

			$save_equipments_not_available = $this->model_api_equipments_not_available->store($save_data);

			if ($save_equipments_not_available) {
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
	 * @api {post} /equipments_not_available/update Update Equipments not available.
	 * @apiVersion 0.1.0
	 * @apiName UpdateEquipments not available
	 * @apiGroup equipments_not_available
	 * @apiHeader {String} X-Api-Key Equipments not availables unique access-key.
	 * @apiPermission Equipments not available Cant be Accessed permission name : api_equipments_not_available_update
	 *
	 * @apiParam {String} Id Mandatory id of Equipments not availables. Input Id Max Length : 11. 
	 * @apiParam {String} Equipment_name Mandatory equipment_name of Equipments not availables. Input Equipment Name Max Length : 4096. 
	 * @apiParam {String} Equipment_condition Mandatory equipment_condition of Equipments not availables. Input Equipment Condition Max Length : 100. 
	 * @apiParam {String} Equipment_size Mandatory equipment_size of Equipments not availables. Input Equipment Size Max Length : 100. 
	 * @apiParam {String} Equipment_description Mandatory equipment_description of Equipments not availables. Input Equipment Description Max Length : 4096. 
	 * @apiParam {String} Equipment_barcode Mandatory equipment_barcode of Equipments not availables. Input Equipment Barcode Max Length : 4096. 
	 * @apiParam {String} Equipment_category_id Mandatory equipment_category_id of Equipments not availables. Input Equipment Category Id Max Length : 11. 
	 * @apiParam {File} Equipment_image Mandatory equipment_image of Equipments not availables. Input Equipment Image Max Length : 4096. 
	 * @apiParam {Integer}  Mandatory  of Equipments Not Available.
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
		$this->is_allowed('api_equipments_not_available_update', false);

		
		$this->form_validation->set_rules('id', 'Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('equipment_name', 'Equipment Name', 'trim|required|max_length[4096]');
		$this->form_validation->set_rules('equipment_condition', 'Equipment Condition', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('equipment_size', 'Equipment Size', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('equipment_description', 'Equipment Description', 'trim|required|max_length[4096]');
		$this->form_validation->set_rules('equipment_barcode', 'Equipment Barcode', 'trim|required|max_length[4096]');
		$this->form_validation->set_rules('equipment_category_id', 'Equipment Category Id', 'trim|required|max_length[11]');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'id' => $this->input->post('id'),
				'equipment_name' => $this->input->post('equipment_name'),
				'equipment_condition' => $this->input->post('equipment_condition'),
				'equipment_size' => $this->input->post('equipment_size'),
				'equipment_description' => $this->input->post('equipment_description'),
				'equipment_barcode' => $this->input->post('equipment_barcode'),
				'equipment_category_id' => $this->input->post('equipment_category_id'),
			];
			if (!is_dir(FCPATH . '/uploads/equipments_not_available')) {
				mkdir(FCPATH . '/uploads/equipments_not_available');
			}
			
			$config = [
				'upload_path' 	=> './uploads/equipments_not_available/',
					'required' 		=> true
			];
			
			if ($upload = $this->upload_file('equipment_image', $config)){
				$upload_data = $this->upload->data();
				$save_data['equipment_image'] = $upload['file_name'];
			}

			$save_equipments_not_available = $this->model_api_equipments_not_available->change($this->post(''), $save_data);

			if ($save_equipments_not_available) {
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
	 * @api {post} /equipments_not_available/delete Delete Equipments not available. 
	 * @apiVersion 0.1.0
	 * @apiName DeleteEquipments not available
	 * @apiGroup equipments_not_available
	 * @apiHeader {String} X-Api-Key Equipments not availables unique access-key.
	 	 * @apiPermission Equipments not available Cant be Accessed permission name : api_equipments_not_available_delete
	 *
	 * @apiParam {Integer} Id Mandatory id of Equipments not availables .
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
		$this->is_allowed('api_equipments_not_available_delete', false);

		$equipments_not_available = $this->model_api_equipments_not_available->find($this->post(''));

		if (!$equipments_not_available) {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Equipments not available not found'
			], API::HTTP_NOT_ACCEPTABLE);
		} else {
			$delete = $this->model_api_equipments_not_available->remove($this->post(''));

			if (!empty($equipments_not_available->equipment_image)) {
				$path = FCPATH . '/uploads/equipments_not_available/' . $equipments_not_available->equipment_image;

				if (is_file($path)) {
					$delete_file = unlink($path);
				}
			}

		}
		
		if ($delete) {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Equipments not available deleted',
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Equipments not available not delete'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

}

/* End of file Equipments not available.php */
/* Location: ./application/controllers/api/Equipments not available.php */
