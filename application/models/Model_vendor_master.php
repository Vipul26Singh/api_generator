<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_vendor_master extends MY_Model {

	private $primary_key 	= 'vendor_mast_id';
	private $table_name 	= 'vendor_master';
	private $field_search 	= ['vendor_name', 'vendor_company_name', 'vendor_address', 'vendor_contact_number', 'vendor_address_country', 'vendor_address_state', 'vendor_address_city', 'vendor_gstn'];

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
	                $where .= "vendor_master.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "vendor_master.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "vendor_master.".$field . " = '" . $q . "' )";
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
	                $where .= "vendor_master.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "vendor_master.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "vendor_master.".$field . " = '" . $q . "' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('vendor_master.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('country_master', 'country_master.country_id = vendor_master.vendor_address_country', 'LEFT');
	    $this->db->join('state_master', 'state_master.state_id = vendor_master.vendor_address_state', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_vendor_master.php */
/* Location: ./application/models/Model_vendor_master.php */
