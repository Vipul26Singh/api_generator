<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_audit_trail extends MY_Model {

		private $primary_key 	= 'id';
		private $table_name 	= 'audit_trail';
	private $field_search 	= ['operation', 'old_data', 'new_data', 'fk_user_id', 'operation_date', 'table_reference_col_1', 'table_reference_val_1', 'table_reference_col_2', 'table_reference_val_2', 'model_name', 'user_name'];

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
	                $where .= "audit_trail.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "audit_trail.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "audit_trail.".$field . " LIKE '%" . $q . "%' )";
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
	                $where .= "audit_trail.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "audit_trail.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "audit_trail.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
	$this->db->limit($limit, $offset);
	$this->db->order_by('audit_trail.'.$this->primary_key, "DESC");
			$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('aauth_users', 'aauth_users.id = audit_trail.fk_user_id', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_audit_trail.php */
/* Location: ./application/models/Model_audit_trail.php */
