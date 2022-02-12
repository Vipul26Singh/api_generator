<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_raw_material extends MY_Model {

	private $primary_key 	= 'raw_mat_id';
	private $table_name 	= 'raw_material';
	private $field_search 	= ['name', 'fk_category_id', 'fk_uom_id', 'fk_tax_id', 'image'];

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
	                $where .= "raw_material.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "raw_material.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "raw_material.".$field . " = '" . $q . "' )";
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
	                $where .= "raw_material.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "raw_material.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "raw_material.".$field . " = '" . $q . "' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('raw_material.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('category_master', 'category_master.category_id = raw_material.fk_category_id', 'LEFT');
	    $this->db->join('uom_master', 'uom_master.uom_id = raw_material.fk_uom_id', 'LEFT');
	    $this->db->join('tax_master', 'tax_master.tax_id = raw_material.fk_tax_id', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_raw_material.php */
/* Location: ./application/models/Model_raw_material.php */
