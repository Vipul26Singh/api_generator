<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_company_setting extends MY_Model {

	private $primary_key 	= 'main_company_id';
	private $table_name 	= 'company_setting';
	private $field_search 	= ['company_name', 'company_address', 'company_country', 'company_state', 'company_city', 'company_gstin', 'company_contact_number', 'company_email_id'];

	public function __construct()
	{
		$config = array(
			'primary_key' 	=> $this->primary_key,
		 	'table_name' 	=> $this->table_name,
		 	'field_search' 	=> $this->field_search,
		 );

		parent::__construct($config);
	}

	public function count_all($q = null, $field = null)
	{
		$iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
		$field = $this->scurity($field);

        if (empty($field)) {
	        foreach ($this->field_search as $field) {
	            if ($iterasi == 1) {
	                $where .= "company_setting.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "company_setting.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "company_setting.".$field . " = '" . $q . "' )";
        }

		$this->join_avaiable();
        $this->db->where($where);
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

        if (empty($field)) {
	        foreach ($this->field_search as $field) {
	            if ($iterasi == 1) {
	                $where .= "company_setting.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "company_setting.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "company_setting.".$field . " = '" . $q . "' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('company_setting.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('country_master', 'country_master.country_id = company_setting.company_country', 'LEFT');
	    $this->db->join('state_master', 'state_master.state_id = company_setting.company_state', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_company_setting.php */
/* Location: ./application/models/Model_company_setting.php */
