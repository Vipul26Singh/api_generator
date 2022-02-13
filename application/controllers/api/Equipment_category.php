<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Equipment_category extends API
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_api_equipment_category');
	}

	/**
	 * @api {get} /equipment_category/all Get all equipment_categorys.
	 * @apiVersion 0.1.0
	 * @apiName AllEquipmentcategory 
	 * @apiGroup equipment_category
	 * @apiHeader {String} X-Api-Key Equipment categorys unique access-key.
	 * @apiHeader {String} X-Token Equipment categorys unique token.
	 * @apiPermission Equipment category Cant be Accessed permission name : api_equipment_category_all
	 *
	 * @apiParam {String} [Filter=null] Optional filter of Equipment categorys.
	 * @apiParam {String} [Field="All Field"] Optional field of Equipment categorys : id, name, image.
	 * @apiParam {String} [Start=0] Optional start index of Equipment categorys.
	 * @apiParam {String} [Limit=10] Optional limit data of Equipment categorys.
	 *
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of equipment_category.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError NoDataEquipment category Equipment category data is nothing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function all_get()
	{
		$this->is_allowed('api_equipment_category_all');

		$filter = $this->get('filter');
		$field = $this->get('field');
		$limit = $this->get('limit') ? $this->get('limit') : $this->limit_page;
		$start = $this->get('start');

		$select_field = ['id', 'name', 'image'];
		$equipment_categorys = $this->model_api_equipment_category->get($filter, $field, $limit, $start, $select_field);
		$total = $this->model_api_equipment_category->count_all($filter, $field);

		$equipment_category_arr = [];

		foreach ($equipment_categorys as $equipment_category) {
			$equipment_category->image  = BASE_URL.'uploads/equipment_category/'.$equipment_category->image;
			$equipment_category_arr[] = $equipment_category;
		}

		$data['equipment_category'] = $equipment_category_arr;
				
		$this->response([
			'status' 	=> true,
			'message' 	=> 'Data Equipment category',
			'data'	 	=> $data,
			'total' 	=> $total
		], API::HTTP_OK);
	}

	
	/**
	 * @api {get} /equipment_category/detail Detail Equipment category.
	 * @apiVersion 0.1.0
	 * @apiName DetailEquipment category
	 * @apiGroup equipment_category
	 * @apiHeader {String} X-Api-Key Equipment categorys unique access-key.
	 * @apiHeader {String} X-Token Equipment categorys unique token.
	 * @apiPermission Equipment category Cant be Accessed permission name : api_equipment_category_detail
	 *
	 * @apiParam {Integer} Id Mandatory id of Equipment categorys.
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of equipment_category.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError Equipment categoryNotFound Equipment category data is not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function detail_get()
	{
		$this->is_allowed('api_equipment_category_detail');

		$this->requiredInput(['id']);

		$id = $this->get('id');

		$select_field = ['id', 'name', 'image'];
		$data['equipment_category'] = $this->model_api_equipment_category->find($id, $select_field);

		if ($data['equipment_category']) {
			$data['equipment_category']->image = BASE_URL.'uploads/equipment_category/'.$data['equipment_category']->image;
			
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Detail Equipment category',
				'data'	 	=> $data
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Equipment category not found'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

	
	/**
	 * @api {post} /equipment_category/add Add Equipment category.
	 * @apiVersion 0.1.0
	 * @apiName AddEquipment category
	 * @apiGroup equipment_category
	 * @apiHeader {String} X-Api-Key Equipment categorys unique access-key.
	 * @apiHeader {String} X-Token Equipment categorys unique token.
	 * @apiPermission Equipment category Cant be Accessed permission name : api_equipment_category_add
	 *
 	 * @apiParam {String} Name Mandatory name of Equipment categorys. Input Name Max Length : 512. 
	 * @apiParam {File} Image Mandatory image of Equipment categorys.  
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
		$this->is_allowed('api_equipment_category_add');

		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[512]');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'name' => $this->input->post('name'),
			];
			if (!is_dir(FCPATH . '/uploads/equipment_category')) {
				mkdir(FCPATH . '/uploads/equipment_category');
			}
			
			$config = [
				'upload_path' 	=> './uploads/equipment_category/',
					'required' 		=> true
			];
			
			if ($upload = $this->upload_file('image', $config)){
				$upload_data = $this->upload->data();
				$save_data['image'] = $upload['file_name'];
			}

			$save_equipment_category = $this->model_api_equipment_category->store($save_data);

			if ($save_equipment_category) {
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
	 * @api {post} /equipment_category/update Update Equipment category.
	 * @apiVersion 0.1.0
	 * @apiName UpdateEquipment category
	 * @apiGroup equipment_category
	 * @apiHeader {String} X-Api-Key Equipment categorys unique access-key.
	 * @apiHeader {String} X-Token Equipment categorys unique token.
	 * @apiPermission Equipment category Cant be Accessed permission name : api_equipment_category_update
	 *
	 * @apiParam {String} Name Mandatory name of Equipment categorys. Input Name Max Length : 512. 
	 * @apiParam {File} Image Mandatory image of Equipment categorys.  
	 * @apiParam {Integer} id Mandatory id of Equipment Category.
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
		$this->is_allowed('api_equipment_category_update');

		
		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[512]');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'name' => $this->input->post('name'),
			];
			if (!is_dir(FCPATH . '/uploads/equipment_category')) {
				mkdir(FCPATH . '/uploads/equipment_category');
			}
			
			$config = [
				'upload_path' 	=> './uploads/equipment_category/',
					'required' 		=> true
			];
			
			if ($upload = $this->upload_file('image', $config)){
				$upload_data = $this->upload->data();
				$save_data['image'] = $upload['file_name'];
			}

			$save_equipment_category = $this->model_api_equipment_category->change($this->post('id'), $save_data);

			if ($save_equipment_category) {
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
	 * @api {post} /equipment_category/delete Delete Equipment category. 
	 * @apiVersion 0.1.0
	 * @apiName DeleteEquipment category
	 * @apiGroup equipment_category
	 * @apiHeader {String} X-Api-Key Equipment categorys unique access-key.
	 * @apiHeader {String} X-Token Equipment categorys unique token.
	 	 * @apiPermission Equipment category Cant be Accessed permission name : api_equipment_category_delete
	 *
	 * @apiParam {Integer} Id Mandatory id of Equipment categorys .
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
		$this->is_allowed('api_equipment_category_delete');

		$equipment_category = $this->model_api_equipment_category->find($this->post('id'));

		if (!$equipment_category) {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Equipment category not found'
			], API::HTTP_NOT_ACCEPTABLE);
		} else {
			$delete = $this->model_api_equipment_category->remove($this->post('id'));

			if (!empty($equipment_category->image)) {
				$path = FCPATH . '/uploads/equipment_category/' . $equipment_category->image;

				if (is_file($path)) {
					$delete_file = unlink($path);
				}
			}

		}
		
		if ($delete) {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Equipment category deleted',
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Equipment category not delete'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

}

/* End of file Equipment category.php */
/* Location: ./application/controllers/api/Equipment category.php */