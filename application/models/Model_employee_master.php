<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_employee_master extends MY_Model {

		private $primary_key 	= 'employee_id';
		private $table_name 	= 'employee_master';
	private $field_search 	= ['employee_name', 'employee_address', 'fk_employee_department_id', 'fk_employee_designation_id', 'fk_login_user_id', 'employee_photo'];

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
	                $where .= "employee_master.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "employee_master.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "employee_master.".$field . " LIKE '%" . $q . "%' )";
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
	                $where .= "employee_master.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "employee_master.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "employee_master.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
	$this->db->limit($limit, $offset);
	$this->db->order_by('employee_master.'.$this->primary_key, "DESC");
			$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('department_master', 'department_master.department_id = employee_master.fk_employee_department_id', 'LEFT');
	    $this->db->join('designation_master', 'designation_master.designation_id = employee_master.fk_employee_designation_id', 'LEFT');
	    $this->db->join('aauth_users', 'aauth_users.id = employee_master.fk_login_user_id', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_employee_master.php */
/* Location: ./application/models/Model_employee_master.php */
