<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_v_raw_material_month extends MY_Model {

				private $primary_key    = NULL;
		private $table_name 	= 'v_raw_material_month';
	private $field_search 	= ['Raw_Material', 'qty'];
	private $user_restriction = '';
	private $field_search_type = array("Raw_Material" => "input","qty" => "input");
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
						$select_string .= "v_raw_material_month.*";
			$this->db->select($select_string, FALSE);
			return $this;
		}

		public function get_export_select_string() {
			$select_string = '';
                        			$select_string .= "Raw_Material as Raw_Material,";
						$select_string .= "qty as qty,";
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
				$where .= "(" . "v_raw_material_month.".$field . " LIKE '%" . $q . "%' )";
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

                        $where .= " v_raw_material_month.created_by = {$this->aauth->get_user_id()} ";
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
                                $where .= "(" . "v_raw_material_month.".$field . " LIKE '%" . $q . "%' )";
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

                        $where .= " v_raw_material_month.created_by = {$this->aauth->get_user_id()} ";

                }

                if (is_array($select_field) AND count($select_field)) {
                        $this->db->select($select_field);
                }

		$this->join_avaiable();
	
		if(!empty($where)) {
			$this->db->where($where);
		}

		$this->db->limit($limit, $offset);
						$query = $this->db->get($this->table_name);

			return $query->result();
	}

	public function join_avaiable() {
		
			return $this;
	}

}

/* End of file Model_v_raw_material_month.php */
/* Location: ./application/models/Model_v_raw_material_month.php */
