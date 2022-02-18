<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Static_pages extends API
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_api_static_pages');
	}

	/**
	 * @api {get} /static_pages/all Get all static_pagess.
	 * @apiVersion 0.1.0
	 * @apiName AllStaticpages 
	 * @apiGroup static_pages
	 * @apiHeader {String} X-Api-Key Static pagess unique access-key.
	 * @apiPermission Static pages Cant be Accessed permission name : api_static_pages_all
	 *
	 * @apiParam {String} [Filter=null] Optional filter of Static pagess.
	 * @apiParam {String} [Field="All Field"] Optional field of Static pagess : id, name, content.
	 * @apiParam {String} [Start=0] Optional start index of Static pagess.
	 * @apiParam {String} [Limit=10] Optional limit data of Static pagess.
	 *
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of static_pages.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError NoDataStatic pages Static pages data is nothing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function all_get()
	{
		$this->is_allowed('api_static_pages_all', false);

		$filter = $this->get('filter');
		$field = $this->get('field');
		$limit = $this->get('limit') ? $this->get('limit') : $this->limit_page;
		$start = $this->get('start');

		$select_field = ['id', 'name', 'content'];
		$static_pagess = $this->model_api_static_pages->get($filter, $field, $limit, $start, $select_field);
		$total = $this->model_api_static_pages->count_all($filter, $field);

		$data['static_pages'] = $static_pagess;
				
		$this->response([
			'status' 	=> true,
			'message' 	=> 'Data Static pages',
			'data'	 	=> $data,
			'total' 	=> $total
		], API::HTTP_OK);
	}

	
	/**
	 * @api {get} /static_pages/detail Detail Static pages.
	 * @apiVersion 0.1.0
	 * @apiName DetailStatic pages
	 * @apiGroup static_pages
	 * @apiHeader {String} X-Api-Key Static pagess unique access-key.
	 * @apiPermission Static pages Cant be Accessed permission name : api_static_pages_detail
	 *
	 * @apiParam {Integer} Id Mandatory id of Static pagess.
	 *
	 * @apiSuccess {Boolean} Status status response api.
	 * @apiSuccess {String} Message message response api.
	 * @apiSuccess {Array} Data data of static_pages.
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *
	 * @apiError Static pagesNotFound Static pages data is not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 403 Not Acceptable
	 *
	 */
	public function detail_get()
	{
		$this->is_allowed('api_static_pages_detail', false);

		$this->requiredInput(['id']);

		$id = $this->get('id');

		$select_field = ['id', 'name', 'content'];
		$data['static_pages'] = $this->model_api_static_pages->find($id, $select_field);

		if ($data['static_pages']) {
			
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Detail Static pages',
				'data'	 	=> $data
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Static pages not found'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

	
	/**
	 * @api {post} /static_pages/add Add Static pages.
	 * @apiVersion 0.1.0
	 * @apiName AddStatic pages
	 * @apiGroup static_pages
	 * @apiHeader {String} X-Api-Key Static pagess unique access-key.
	 * @apiPermission Static pages Cant be Accessed permission name : api_static_pages_add
	 *
 	 * @apiParam {String} Name Mandatory name of Static pagess. Input Name Max Length : 1024. 
	 * @apiParam {String} Content Mandatory content of Static pagess.  
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
		$this->is_allowed('api_static_pages_add', false);

		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[1024]');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'name' => $this->input->post('name'),
				'content' => $this->input->post('content'),
			];
			
			$save_static_pages = $this->model_api_static_pages->store($save_data);

			if ($save_static_pages) {
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
	 * @api {post} /static_pages/update Update Static pages.
	 * @apiVersion 0.1.0
	 * @apiName UpdateStatic pages
	 * @apiGroup static_pages
	 * @apiHeader {String} X-Api-Key Static pagess unique access-key.
	 * @apiPermission Static pages Cant be Accessed permission name : api_static_pages_update
	 *
	 * @apiParam {String} Name Mandatory name of Static pagess. Input Name Max Length : 1024. 
	 * @apiParam {String} Content Mandatory content of Static pagess.  
	 * @apiParam {Integer} id Mandatory id of Static Pages.
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
		$this->is_allowed('api_static_pages_update', false);

		
		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[1024]');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		
		if ($this->form_validation->run()) {

			$save_data = [
				'name' => $this->input->post('name'),
				'content' => $this->input->post('content'),
			];
			
			$save_static_pages = $this->model_api_static_pages->change($this->post('id'), $save_data);

			if ($save_static_pages) {
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
	 * @api {post} /static_pages/delete Delete Static pages. 
	 * @apiVersion 0.1.0
	 * @apiName DeleteStatic pages
	 * @apiGroup static_pages
	 * @apiHeader {String} X-Api-Key Static pagess unique access-key.
	 	 * @apiPermission Static pages Cant be Accessed permission name : api_static_pages_delete
	 *
	 * @apiParam {Integer} Id Mandatory id of Static pagess .
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
		$this->is_allowed('api_static_pages_delete', false);

		$static_pages = $this->model_api_static_pages->find($this->post('id'));

		if (!$static_pages) {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Static pages not found'
			], API::HTTP_NOT_ACCEPTABLE);
		} else {
			$delete = $this->model_api_static_pages->remove($this->post('id'));

			}
		
		if ($delete) {
			$this->response([
				'status' 	=> true,
				'message' 	=> 'Static pages deleted',
			], API::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> false,
				'message' 	=> 'Static pages not delete'
			], API::HTTP_NOT_ACCEPTABLE);
		}
	}

}

/* End of file Static pages.php */
/* Location: ./application/controllers/api/Static pages.php */
