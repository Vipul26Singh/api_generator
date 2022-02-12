<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_client_master extends MY_Model {

		private $primary_key 	= 'client_id';
		private $table_name 	= 'client_master';
	private $field_search 	= ['client_name', 'client_company_name', 'client_parent_comapny', 'client_billing_address', 'client_contact_number', 'fk_client_address_country_id', 'fk_client_address_state_id', 'client_address_city', 'is_gst_applicable', 'client_gstn'];
	private $user_restriction = '';
	private $field_search_type = array("client_name" => "input","client_company_name" => "input","client_parent_comapny" => "select","client_billing_address" => "input","client_contact_number" => "input","fk_client_address_country_id" => "select","fk_client_address_state_id" => "select","client_address_city" => "input","is_gst_applicable" => "yes_no","client_gstn" => "input");
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
			
			$select_string .= "tab_client_parent_comapny.client_id as tab_client_parent_comapny_value, tab_client_parent_comapny.client_company_name as tab_client_parent_comapny_label,"	;
			
			$select_string .= "tab_fk_client_address_country_id.country_id as tab_fk_client_address_country_id_value, tab_fk_client_address_country_id.country_name as tab_fk_client_address_country_id_label,"	;
			
			$select_string .= "tab_fk_client_address_state_id.state_id as tab_fk_client_address_state_id_value, tab_fk_client_address_state_id.state_name as tab_fk_client_address_state_id_label,"	;
						$select_string .= "client_master.*";
			$this->db->select($select_string, FALSE);
			return $this;
		}

		public function get_export_select_string() {
			$select_string = '';
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
				$where .= "(" . "client_master.".$field . " LIKE '%" . $q . "%' )";
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

                        $where .= " client_master.created_by = {$this->aauth->get_user_id()} ";
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
                                $where .= "(" . "client_master.".$field . " LIKE '%" . $q . "%' )";
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

                        $where .= " client_master.created_by = {$this->aauth->get_user_id()} ";

                }

                if (is_array($select_field) AND count($select_field)) {
                        $this->db->select($select_field);
                }

		$this->join_avaiable();
	
		if(!empty($where)) {
			$this->db->where($where);
		}

		$this->db->limit($limit, $offset);
					$this->db->order_by('client_master.'.$this->primary_key, "DESC");
							$query = $this->db->get($this->table_name);

			return $query->result();
	}

	public function join_avaiable() {
					$this->db->join('client_master tab_client_parent_comapny', 'tab_client_parent_comapny.client_id = client_master.client_parent_comapny', 'LEFT');
					$this->db->join('country_master tab_fk_client_address_country_id', 'tab_fk_client_address_country_id.country_id = client_master.fk_client_address_country_id', 'LEFT');
					$this->db->join('state_master tab_fk_client_address_state_id', 'tab_fk_client_address_state_id.state_id = client_master.fk_client_address_state_id', 'LEFT');
		
			return $this;
	}

}

/* End of file Model_client_master.php */
/* Location: ./application/models/Model_client_master.php */
