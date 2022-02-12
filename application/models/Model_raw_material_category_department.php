<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_raw_material_category_department extends MY_Model {

		private $primary_key 	= 'id';
		private $table_name 	= 'raw_material_category_department';
	private $field_search 	= ['fk_category_id', 'fk_department_id'];

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
	                $where .= "raw_material_category_department.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "raw_material_category_department.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "raw_material_category_department.".$field . " = '" . $q . "' )";
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
	                $where .= "raw_material_category_department.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "raw_material_category_department.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "raw_material_category_department.".$field . " = '" . $q . "' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
	$this->db->limit($limit, $offset);
	$this->db->order_by('raw_material_category_department.'.$this->primary_key, "DESC");
			$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('category_master', 'category_master.category_id = raw_material_category_department.fk_category_id', 'LEFT');
	    $this->db->join('department_master', 'department_master.department_id = raw_material_category_department.fk_department_id', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_raw_material_category_department.php */
/* Location: ./application/models/Model_raw_material_category_department.php */
