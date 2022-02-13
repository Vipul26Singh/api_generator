<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_equipments extends MY_Model {

		private $primary_key 	= 'id';
		private $table_name 	= 'equipments';
	private $field_search 	= ['equipment_image', 'equipment_name', 'equipment_condition', 'equipment_size', 'equipment_description'];
	private $user_restriction = '';
	private $field_search_type = array("equipment_image" => "file","equipment_name" => "input","equipment_category_id" => "select","equipment_condition" => "custom_select","equipment_size" => "custom_select","equipment_barcode" => "input","equipment_description" => "input");
	private $export_select_string = '';

	public function __construct()
	{
		$this->export_select_string = $this->get_export_select_string();
		$config = array(
			'primary_key' 	=> $this->primary_key,
		 	'table_name' 	=> $this->table_name,
		 	'field_search' 	=> $this->field_search,
			'user_restriction' => $this->user_restriction,
			'export_select_string' => $this->export_select_string,
			'field_search_type' => $this->field_search_type,
		 );

		parent::__construct($config);
	}

		public function select_string() {
			$select_string = '';
			
			$select_string .= "tab_equipment_category_id.id as tab_equipment_category_id_value, tab_equipment_category_id.name as tab_equipment_category_id_label,"	;
						$select_string .= "equipments.*";
			$this->db->select($select_string, FALSE);
			return $this;
		}

		public function get_export_select_string() {
			$select_string = '';
                        			$select_string .= "equipment_name as `equipment_name`,";
			                        $select_string .= " (select relt1.name from equipment_category relt1 where relt1.id = equipments.equipment_category_id ) as `equipment_category_id`,";
                        			$select_string .= "equipment_condition as `equipment_condition`,";
						$select_string .= "equipment_size as `equipment_size`,";
						$select_string .= "equipment_barcode as `equipment_barcode`,";
						$select_string .= "equipment_description as `equipment_description`,";
						$select_string = rtrim($select_string, ",");
			
                        return $select_string;	
		}

	public function count_all($q = null, $field = null)
	{
		$iterasi = 1;
		$num = count($this->field_search);
		$where = NULL;
		$q = $this->scurity($q);
		$field = $this->scurity($field);


		if (!empty($field)) {
				$where .= "(" . "equipments.".$field . " LIKE '%" . $q . "%' )";
		}

	        $search = $this->search_filter();

                if(!empty($search)) {
                        if(!empty($where)) {
                                $where .= " and ";
                        }
                        $where .= $search ;
                }

                if($this->apply_user_filter()) {
                        if(!empty($where)) {
                                $where .= " and ";
                        }

                        $where .= " equipments.created_by = {$this->aauth->get_user_id()} ";
                }


		$this->join_avaiable();

		if(!empty($where)) {
			$this->db->where($where);
		}

		$query = $this->db->get($this->table_name);

		return $query->num_rows();
	}

	public function get($q = null, $field = null, $limit = 0, $offset = 0, $select_field = [])
	{
		$iterasi = 1;
		$num = count($this->field_search);
		$where = NULL;
		$q = $this->scurity($q);
		$field = $this->scurity($field);

		if( !empty($field) ) {
                                $where .= "(" . "equipments.".$field . " LIKE '%" . $q . "%' )";
                }

                $search = $this->search_filter();
		$this->select_string();

                if(!empty($search)) {
                        if(!empty($where)) {
                                $where .= " and ";
                        }
                        $where .= $search ;
                }

                if($this->apply_user_filter()) {
                        if(!empty($where)) {
                                $where .= " and ";
                        }

                        $where .= " equipments.created_by = {$this->aauth->get_user_id()} ";

                }

                if (is_array($select_field) AND count($select_field)) {
                        $this->db->select($select_field);
                }

		$this->join_avaiable();
	
		if(!empty($where)) {
			$this->db->where($where);
		}

		$this->db->limit($limit, $offset);
					$this->db->order_by('equipments.'.$this->primary_key, "DESC");
							$query = $this->db->get($this->table_name);

			return $query->result();
	}

	public function join_avaiable() {
					$this->db->join('equipment_category tab_equipment_category_id', 'tab_equipment_category_id.id = equipments.equipment_category_id', 'LEFT');
		
			return $this;
	}

}

/* End of file Model_equipments.php */
/* Location: ./application/models/Model_equipments.php */
