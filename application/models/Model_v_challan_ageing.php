<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_v_challan_ageing extends MY_Model {

				private $primary_key    = NULL;
		private $table_name 	= 'v_challan_ageing';
	private $field_search 	= ['client_company_name', 'idc_challan_no', 'product_name', 'process_name', 'quantity_in', 'quantity_out', 'created_at', 'age_days', 'age_hours'];
	private $user_restriction = '';
	private $field_search_type = array("client_company_name" => "input","idc_challan_no" => "input","product_name" => "input","process_name" => "input","quantity_in" => "input","quantity_out" => "number","created_at" => "timestamp","age_days" => "number","age_hours" => "number");
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
						$select_string .= "v_challan_ageing.*";
			$this->db->select($select_string, FALSE);
			return $this;
		}

		public function get_export_select_string() {
			$select_string = '';
                        			$select_string .= "client_company_name as `Client Company`,";
						$select_string .= "idc_challan_no as `Inward Challan No`,";
						$select_string .= "product_name as `Product`,";
						$select_string .= "process_name as `Process`,";
						$select_string .= "quantity_in as `Quantity In`,";
						$select_string .= "quantity_out as `Quantity Out`,";
						$select_string .= "created_at as `Accepted Date`,";
						$select_string .= "age_days as `Age Days`,";
						$select_string .= "age_hours as `Age Hours`,";
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
				$where .= "(" . "v_challan_ageing.".$field . " LIKE '%" . $q . "%' )";
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

                        $where .= " v_challan_ageing.created_by = {$this->aauth->get_user_id()} ";
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
                                $where .= "(" . "v_challan_ageing.".$field . " LIKE '%" . $q . "%' )";
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

                        $where .= " v_challan_ageing.created_by = {$this->aauth->get_user_id()} ";

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

/* End of file Model_v_challan_ageing.php */
/* Location: ./application/models/Model_v_challan_ageing.php */
