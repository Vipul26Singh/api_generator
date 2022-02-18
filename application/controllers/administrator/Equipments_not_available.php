<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Equipments Not Available Controller
*| --------------------------------------------------------------------------
*| Equipments Not Available site
*|
*/
class Equipments_not_available extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_equipments_not_available');
	}

	/**
	* show all Equipments Not Availables
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('equipments_not_available_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['equipments_not_availables'] = $this->model_equipments_not_available->get( $filter, $field, $this->limit_page, $offset);
		$this->data['equipments_not_available_counts'] = $this->model_equipments_not_available->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/equipments_not_available/index/',
			'total_rows'   => $this->model_equipments_not_available->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Equipments Not Available List');
		$this->render('backend/standart/administrator/equipments_not_available/equipments_not_available_list', $this->data);
	}
	
	
	
	/**
	* delete Equipments Not Availables
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('equipments_not_available_delete');

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
            set_message(cclang('has_been_deleted', 'equipments_not_available'), 'success');
        } else {
            set_message(cclang('error_delete', 'equipments_not_available'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Equipments Not Availables
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('equipments_not_available_view');

		$this->data['equipments_not_available'] = $this->model_equipments_not_available->join_avaiable()->select_string()->find($id);

		$this->template->title('Equipments Not Available Detail');
		$this->render('backend/standart/administrator/equipments_not_available/equipments_not_available_view', $this->data);
	}
	
	/**
	* delete Equipments Not Availables
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$equipments_not_available = $this->model_equipments_not_available->find($id);

		if (!empty($equipments_not_available->equipment_image)) {
			$path = FCPATH . '/uploads/equipments_not_available/' . $equipments_not_available->equipment_image;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		
		
		return $this->model_equipments_not_available->remove($id);
	}
	
	/**
	* Upload Image Equipments Not Available	* 
	* @return JSON
	*/
	public function upload_equipment_image_file()
	{
		if (!$this->is_allowed('equipments_not_available_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'equipments_not_available',
		]);
	}

	/**
	* Delete Image Equipments Not Available	* 
	* @return JSON
	*/
	public function delete_equipment_image_file($uuid)
	{
		if (!$this->is_allowed('equipments_not_available_delete', false)) {
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
            'table_name'        => 'equipments_not_available',
            'primary_key'       => '',
            'upload_path'       => 'uploads/equipments_not_available/'
        ]);
	}

	/**
	* Get Image Equipments Not Available	* 
	* @return JSON
	*/
	public function get_equipment_image_file($id)
	{
		if (!$this->is_allowed('equipments_not_available_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$equipments_not_available = $this->model_equipments_not_available->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'equipment_image', 
            'table_name'        => 'equipments_not_available',
            'primary_key'       => '',
            'upload_path'       => 'uploads/equipments_not_available/',
            'delete_endpoint'   => 'administrator/equipments_not_available/delete_equipment_image_file'
        ]);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('equipments_not_available_export');

		$this->model_equipments_not_available->export('equipments_not_available', 'equipments_not_available');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('equipments_not_available_export');

		$this->model_equipments_not_available->pdf('equipments_not_available', 'equipments_not_available');
	}
}


/* End of file equipments_not_available.php */
/* Location: ./application/controllers/administrator/Equipments Not Available.php */
