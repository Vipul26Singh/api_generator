<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Equipments Available Controller
*| --------------------------------------------------------------------------
*| Equipments Available site
*|
*/
class Equipments_available extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_equipments_available');
	}

	/**
	* show all Equipments Availables
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('equipments_available_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['equipments_availables'] = $this->model_equipments_available->get( $filter, $field, $this->limit_page, $offset);
		$this->data['equipments_available_counts'] = $this->model_equipments_available->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/equipments_available/index/',
			'total_rows'   => $this->model_equipments_available->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Equipments Available List');
		$this->render('backend/standart/administrator/equipments_available/equipments_available_list', $this->data);
	}
	
	/**
	* Add new equipments_availables
	*
	*/
	public function add()
	{
		$this->is_allowed('equipments_available_add');

		$this->template->title('Equipments Available New');
		$this->render('backend/standart/administrator/equipments_available/equipments_available_add', $this->data);
	}

	/**
	* Add New Equipments Availables
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('equipments_available_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('id', 'Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('equipments_available_equipment_image_name', 'Equipment Image', 'trim|required');
		$this->form_validation->set_rules('equipment_name', 'Equipment Name', 'trim|required|max_length[4096]');
		$this->form_validation->set_rules('equipment_condition', 'Equipment Condition', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('equipment_size', 'Equipment Size', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('equipment_description', 'Equipment Description', 'trim|required|max_length[4096]');
		$this->form_validation->set_rules('equipment_barcode', 'Equipment Barcode', 'trim|required|max_length[4096]');
		$this->form_validation->set_rules('equipment_category_id', 'Equipment Category Id', 'trim|required|max_length[11]');
		

		if ($this->form_validation->run()) {
			$equipments_available_equipment_image_uuid = $this->input->post('equipments_available_equipment_image_uuid');
			$equipments_available_equipment_image_name = $this->input->post('equipments_available_equipment_image_name');
		
			$save_data = [
					'id' => ($this->input->post('id') === '') ? NULL : $this->input->post('id'),
					'equipment_name' => ($this->input->post('equipment_name') === '') ? NULL : $this->input->post('equipment_name'),
					'equipment_condition' => ($this->input->post('equipment_condition') === '') ? NULL : $this->input->post('equipment_condition'),
					'equipment_size' => ($this->input->post('equipment_size') === '') ? NULL : $this->input->post('equipment_size'),
					'equipment_description' => ($this->input->post('equipment_description') === '') ? NULL : $this->input->post('equipment_description'),
					'equipment_barcode' => ($this->input->post('equipment_barcode') === '') ? NULL : $this->input->post('equipment_barcode'),
					'equipment_category_id' => ($this->input->post('equipment_category_id') === '') ? NULL : $this->input->post('equipment_category_id'),
			];

			if (!is_dir(FCPATH . '/uploads/equipments_available/')) {
				mkdir(FCPATH . '/uploads/equipments_available/');
			}

			if (!empty($equipments_available_equipment_image_name)) {
				$equipments_available_equipment_image_name_copy = date('YmdHis') . '-' . $equipments_available_equipment_image_name;

				rename(FCPATH . 'uploads/tmp/' . $equipments_available_equipment_image_uuid . '/' . $equipments_available_equipment_image_name, 
						FCPATH . 'uploads/equipments_available/' . $equipments_available_equipment_image_name_copy);

				if (!is_file(FCPATH . '/uploads/equipments_available/' . $equipments_available_equipment_image_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['equipment_image'] = $equipments_available_equipment_image_name_copy;
			}
		
			
			$save_equipments_available = $this->model_equipments_available->store($save_data);

			if ($save_equipments_available) {
				$this->data['id']          = $save_equipments_available;
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/equipments_available/edit/' . $save_equipments_available, 'Edit Equipments Available'),
						anchor('administrator/equipments_available', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/equipments_available/edit/' . $save_equipments_available, 'Edit Equipments Available')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/equipments_available');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/equipments_available');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
	/**
	* delete Equipments Availables
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('equipments_available_delete');

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
            set_message(cclang('has_been_deleted', 'equipments_available'), 'success');
        } else {
            set_message(cclang('error_delete', 'equipments_available'), 'error');
        }

		redirect_back();
	}

	
	/**
	* delete Equipments Availables
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$equipments_available = $this->model_equipments_available->find($id);

		if (!empty($equipments_available->equipment_image)) {
			$path = FCPATH . '/uploads/equipments_available/' . $equipments_available->equipment_image;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		
		
		return $this->model_equipments_available->remove($id);
	}
	
	/**
	* Upload Image Equipments Available	* 
	* @return JSON
	*/
	public function upload_equipment_image_file()
	{
		if (!$this->is_allowed('equipments_available_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'equipments_available',
		]);
	}

	/**
	* Delete Image Equipments Available	* 
	* @return JSON
	*/
	public function delete_equipment_image_file($uuid)
	{
		if (!$this->is_allowed('equipments_available_delete', false)) {
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
            'table_name'        => 'equipments_available',
            'primary_key'       => '',
            'upload_path'       => 'uploads/equipments_available/'
        ]);
	}

	/**
	* Get Image Equipments Available	* 
	* @return JSON
	*/
	public function get_equipment_image_file($id)
	{
		if (!$this->is_allowed('equipments_available_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$equipments_available = $this->model_equipments_available->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'equipment_image', 
            'table_name'        => 'equipments_available',
            'primary_key'       => '',
            'upload_path'       => 'uploads/equipments/',
            'delete_endpoint'   => 'administrator/equipments_available/delete_equipment_image_file'
        ]);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('equipments_available_export');

		$this->model_equipments_available->export('equipments_available', 'equipments_available');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('equipments_available_export');

		$this->model_equipments_available->pdf('equipments_available', 'equipments_available');
	}
}


/* End of file equipments_available.php */
/* Location: ./application/controllers/administrator/Equipments Available.php */
