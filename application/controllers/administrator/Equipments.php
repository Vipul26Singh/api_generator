<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Equipments Controller
*| --------------------------------------------------------------------------
*| Equipments site
*|
*/
class Equipments extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_equipments');
	}

	/**
	* show all Equipmentss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('equipments_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['equipmentss'] = $this->model_equipments->get( $filter, $field, $this->limit_page, $offset);
		$this->data['equipments_counts'] = $this->model_equipments->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/equipments/index/',
			'total_rows'   => $this->model_equipments->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Equipments List');
		$this->render('backend/standart/administrator/equipments/equipments_list', $this->data);
	}
	
	/**
	* Add new equipmentss
	*
	*/
	public function add()
	{
		$this->is_allowed('equipments_add');

		$this->template->title('Equipments New');
		$this->render('backend/standart/administrator/equipments/equipments_add', $this->data);
	}

	/**
	* Add New Equipmentss
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('equipments_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('equipment_name', 'Equipment Name', 'trim|required|max_length[4096]');
		$this->form_validation->set_rules('equipment_category_id', 'Equipment Category Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('equipment_condition', 'Equipment Condition', 'trim|required');
		$this->form_validation->set_rules('equipment_size', 'Equipment Size', 'trim|required');
		$this->form_validation->set_rules('equipment_barcode', 'Equipment Barcode', 'trim|max_length[4096]');
		$this->form_validation->set_rules('equipment_description', 'Equipment Description', 'trim|max_length[4096]');
		

		if ($this->form_validation->run()) {
			$equipments_equipment_image_uuid = $this->input->post('equipments_equipment_image_uuid');
			$equipments_equipment_image_name = $this->input->post('equipments_equipment_image_name');
		
			$save_data = [
					'equipment_name' => ($this->input->post('equipment_name') === '') ? NULL : $this->input->post('equipment_name'),
					'equipment_category_id' => ($this->input->post('equipment_category_id') === '') ? NULL : $this->input->post('equipment_category_id'),
					'equipment_condition' => ($this->input->post('equipment_condition') === '') ? NULL : $this->input->post('equipment_condition'),
					'equipment_size' => ($this->input->post('equipment_size') === '') ? NULL : $this->input->post('equipment_size'),
					'equipment_barcode' => ($this->input->post('equipment_barcode') === '') ? NULL : $this->input->post('equipment_barcode'),
					'equipment_description' => ($this->input->post('equipment_description') === '') ? NULL : $this->input->post('equipment_description'),
			];

			if (!is_dir(FCPATH . '/uploads/equipments/')) {
				mkdir(FCPATH . '/uploads/equipments/');
			}

			if (!empty($equipments_equipment_image_name)) {
				$equipments_equipment_image_name_copy = date('YmdHis') . '-' . $equipments_equipment_image_name;

				rename(FCPATH . 'uploads/tmp/' . $equipments_equipment_image_uuid . '/' . $equipments_equipment_image_name, 
						FCPATH . 'uploads/equipments/' . $equipments_equipment_image_name_copy);

				if (!is_file(FCPATH . '/uploads/equipments/' . $equipments_equipment_image_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['equipment_image'] = $equipments_equipment_image_name_copy;
			}
		
			
			$save_equipments = $this->model_equipments->store($save_data);

			if ($save_equipments) {
				$this->data['id']          = $save_equipments;
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/equipments/edit/' . $save_equipments, 'Edit Equipments'),
						anchor('administrator/equipments', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/equipments/edit/' . $save_equipments, 'Edit Equipments')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/equipments');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/equipments');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Equipmentss
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('equipments_update');

		$this->data['equipments'] = $this->model_equipments->find($id);

		$this->template->title('Equipments Update');
		$this->render('backend/standart/administrator/equipments/equipments_update', $this->data);
	}

	/**
	* Update Equipmentss
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('equipments_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('equipment_name', 'Equipment Name', 'trim|required|max_length[4096]');
		$this->form_validation->set_rules('equipment_category_id', 'Equipment Category Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('equipment_condition', 'Equipment Condition', 'trim|required');
		$this->form_validation->set_rules('equipment_size', 'Equipment Size', 'trim|required');
		$this->form_validation->set_rules('equipment_barcode', 'Equipment Barcode', 'trim|max_length[4096]');
		$this->form_validation->set_rules('equipment_description', 'Equipment Description', 'trim|max_length[4096]');
		
		if ($this->form_validation->run()) {
			$equipments_equipment_image_uuid = $this->input->post('equipments_equipment_image_uuid');
			$equipments_equipment_image_name = $this->input->post('equipments_equipment_image_name');
		
			$save_data = [
					'equipment_name' => ($this->input->post('equipment_name') === '') ? NULL : $this->input->post('equipment_name'),
					'equipment_category_id' => ($this->input->post('equipment_category_id') === '') ? NULL : $this->input->post('equipment_category_id'),
					'equipment_condition' => ($this->input->post('equipment_condition') === '') ? NULL : $this->input->post('equipment_condition'),
					'equipment_size' => ($this->input->post('equipment_size') === '') ? NULL : $this->input->post('equipment_size'),
					'equipment_barcode' => ($this->input->post('equipment_barcode') === '') ? NULL : $this->input->post('equipment_barcode'),
					'equipment_description' => ($this->input->post('equipment_description') === '') ? NULL : $this->input->post('equipment_description'),
			];

			if (!is_dir(FCPATH . '/uploads/equipments/')) {
				mkdir(FCPATH . '/uploads/equipments/');
			}

			if (!empty($equipments_equipment_image_uuid)) {
				$equipments_equipment_image_name_copy = date('YmdHis') . '-' . $equipments_equipment_image_name;

				rename(FCPATH . 'uploads/tmp/' . $equipments_equipment_image_uuid . '/' . $equipments_equipment_image_name, 
						FCPATH . 'uploads/equipments/' . $equipments_equipment_image_name_copy);

				if (!is_file(FCPATH . '/uploads/equipments/' . $equipments_equipment_image_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['equipment_image'] = $equipments_equipment_image_name_copy;
			}
		
			

			$save_equipments = $this->model_equipments->change($id, $save_data);

			if ($save_equipments) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/equipments', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/equipments');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/equipments');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Equipmentss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('equipments_delete');

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
            set_message(cclang('has_been_deleted', 'equipments'), 'success');
        } else {
            set_message(cclang('error_delete', 'equipments'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Equipmentss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('equipments_view');

		$this->data['equipments'] = $this->model_equipments->join_avaiable()->select_string()->find($id);

		$this->template->title('Equipments Detail');
		$this->render('backend/standart/administrator/equipments/equipments_view', $this->data);
	}
	
	/**
	* delete Equipmentss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$equipments = $this->model_equipments->find($id);

		if (!empty($equipments->equipment_image)) {
			$path = FCPATH . '/uploads/equipments/' . $equipments->equipment_image;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		
		
		return $this->model_equipments->remove($id);
	}
	
	/**
	* Upload Image Equipments	* 
	* @return JSON
	*/
	public function upload_equipment_image_file()
	{
		if (!$this->is_allowed('equipments_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'equipments',
		]);
	}

	/**
	* Delete Image Equipments	* 
	* @return JSON
	*/
	public function delete_equipment_image_file($uuid)
	{
		if (!$this->is_allowed('equipments_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'equipment_image', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'equipments',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/equipments/'
        ]);
	}

	/**
	* Get Image Equipments	* 
	* @return JSON
	*/
	public function get_equipment_image_file($id)
	{
		if (!$this->is_allowed('equipments_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$equipments = $this->model_equipments->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'equipment_image', 
            'table_name'        => 'equipments',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/equipments/',
            'delete_endpoint'   => 'administrator/equipments/delete_equipment_image_file'
        ]);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('equipments_export');

		$this->model_equipments->export('equipments', 'equipments');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('equipments_export');

		$this->model_equipments->pdf('equipments', 'equipments');
	}
}


/* End of file equipments.php */
/* Location: ./application/controllers/administrator/Equipments.php */
