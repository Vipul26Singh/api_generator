<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_v_missing_hsn extends MY_Model {

				private $primary_key    = NULL;
		private $table_name 	= 'v_missing_hsn';
	private $field_search 	= ['product_master_id', 'product_name'];

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
	                $where .= "v_missing_hsn.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "v_missing_hsn.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "v_missing_hsn.".$field . " LIKE '%" . $q . "%' )";
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
	                $where .= "v_missing_hsn.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "v_missing_hsn.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "v_missing_hsn.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
	$this->db->limit($limit, $offset);
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		
    	return $this;
	}

}

/* End of file Model_v_missing_hsn.php */
/* Location: ./application/models/Model_v_missing_hsn.php */
