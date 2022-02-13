<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Equipment Category Controller
*| --------------------------------------------------------------------------
*| Equipment Category site
*|
*/
class Equipment_category extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_equipment_category');
	}

	/**
	* show all Equipment Categorys
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('equipment_category_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['equipment_categorys'] = $this->model_equipment_category->get( $filter, $field, $this->limit_page, $offset);
		$this->data['equipment_category_counts'] = $this->model_equipment_category->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/equipment_category/index/',
			'total_rows'   => $this->model_equipment_category->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Equipment Category List');
		$this->render('backend/standart/administrator/equipment_category/equipment_category_list', $this->data);
	}
	
	/**
	* Add new equipment_categorys
	*
	*/
	public function add()
	{
		$this->is_allowed('equipment_category_add');

		$this->template->title('Equipment Category New');
		$this->render('backend/standart/administrator/equipment_category/equipment_category_add', $this->data);
	}

	/**
	* Add New Equipment Categorys
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('equipment_category_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('equipment_category_image_name', 'Image', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[512]');
		

		if ($this->form_validation->run()) {
			$equipment_category_image_uuid = $this->input->post('equipment_category_image_uuid');
			$equipment_category_image_name = $this->input->post('equipment_category_image_name');
		
			$save_data = [
					'name' => ($this->input->post('name') === '') ? NULL : $this->input->post('name'),
			];

			if (!is_dir(FCPATH . '/uploads/equipment_category/')) {
				mkdir(FCPATH . '/uploads/equipment_category/');
			}

			if (!empty($equipment_category_image_name)) {
				$equipment_category_image_name_copy = date('YmdHis') . '-' . $equipment_category_image_name;

				rename(FCPATH . 'uploads/tmp/' . $equipment_category_image_uuid . '/' . $equipment_category_image_name, 
						FCPATH . 'uploads/equipment_category/' . $equipment_category_image_name_copy);

				if (!is_file(FCPATH . '/uploads/equipment_category/' . $equipment_category_image_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['image'] = $equipment_category_image_name_copy;
			}
		
			
			$save_equipment_category = $this->model_equipment_category->store($save_data);

			if ($save_equipment_category) {
				$this->data['id']          = $save_equipment_category;
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/equipment_category/edit/' . $save_equipment_category, 'Edit Equipment Category'),
						anchor('administrator/equipment_category', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/equipment_category/edit/' . $save_equipment_category, 'Edit Equipment Category')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/equipment_category');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/equipment_category');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Equipment Categorys
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('equipment_category_update');

		$this->data['equipment_category'] = $this->model_equipment_category->find($id);

		$this->template->title('Equipment Category Update');
		$this->render('backend/standart/administrator/equipment_category/equipment_category_update', $this->data);
	}

	/**
	* Update Equipment Categorys
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('equipment_category_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('equipment_category_image_name', 'Image', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[512]');
		
		if ($this->form_validation->run()) {
			$equipment_category_image_uuid = $this->input->post('equipment_category_image_uuid');
			$equipment_category_image_name = $this->input->post('equipment_category_image_name');
		
			$save_data = [
					'name' => ($this->input->post('name') === '') ? NULL : $this->input->post('name'),
			];

			if (!is_dir(FCPATH . '/uploads/equipment_category/')) {
				mkdir(FCPATH . '/uploads/equipment_category/');
			}

			if (!empty($equipment_category_image_uuid)) {
				$equipment_category_image_name_copy = date('YmdHis') . '-' . $equipment_category_image_name;

				rename(FCPATH . 'uploads/tmp/' . $equipment_category_image_uuid . '/' . $equipment_category_image_name, 
						FCPATH . 'uploads/equipment_category/' . $equipment_category_image_name_copy);

				if (!is_file(FCPATH . '/uploads/equipment_category/' . $equipment_category_image_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['image'] = $equipment_category_image_name_copy;
			}
		
			

			$save_equipment_category = $this->model_equipment_category->change($id, $save_data);

			if ($save_equipment_category) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/equipment_category', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/equipment_category');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/equipment_category');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Equipment Categorys
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('equipment_category_delete');

		$this->load->helper('file');

		$arr_id = $this->input->get('id');
		$remove = false;

		if (!empty($id)) {
			$remove = $this->_remove($id);
		} elseif (count($arr_id) >0) {
			foreach ($arr_id as $id) {
				$remove = $this->_remove($id);
			}
		}

		if ($remove) {
            set_message(cclang('has_been_deleted', 'equipment_category'), 'success');
        } else {
            set_message(cclang('error_delete', 'equipment_category'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Equipment Categorys
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('equipment_category_view');

		$this->data['equipment_category'] = $this->model_equipment_category->join_avaiable()->select_string()->find($id);

		$this->template->title('Equipment Category Detail');
		$this->render('backend/standart/administrator/equipment_category/equipment_category_view', $this->data);
	}
	
	/**
	* delete Equipment Categorys
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$equipment_category = $this->model_equipment_category->find($id);

		if (!empty($equipment_category->image)) {
			$path = FCPATH . '/uploads/equipment_category/' . $equipment_category->image;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		
		
		return $this->model_equipment_category->remove($id);
	}
	
	/**
	* Upload Image Equipment Category	* 
	* @return JSON
	*/
	public function upload_image_file()
	{
		if (!$this->is_allowed('equipment_category_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'equipment_category',
		]);
	}

	/**
	* Delete Image Equipment Category	* 
	* @return JSON
	*/
	public function delete_image_file($uuid)
	{
		if (!$this->is_allowed('equipment_category_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'image', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'equipment_category',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/equipment_category/'
        ]);
	}

	/**
	* Get Image Equipment Category	* 
	* @return JSON
	*/
	public function get_image_file($id)
	{
		if (!$this->is_allowed('equipment_category_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$equipment_category = $this->model_equipment_category->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'image', 
            'table_name'        => 'equipment_category',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/equipment_category/',
            'delete_endpoint'   => 'administrator/equipment_category/delete_image_file'
        ]);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('equipment_category_export');

		$this->model_equipment_category->export('equipment_category', 'equipment_category');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('equipment_category_export');

		$this->model_equipment_category->pdf('equipment_category', 'equipment_category');
	}
}


/* End of file equipment_category.php */
/* Location: ./application/controllers/administrator/Equipment Category.php */
