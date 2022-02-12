<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_product_master extends MY_Model {

	private $primary_key 	= 'product_master_id';
	private $table_name 	= 'product_master';
	private $field_search 	= ['image', 'product_name', 'fk_category_id', 'fk_uom_id', 'product_type', 'fk_tax_id'];

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
	                $where .= "product_master.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "product_master.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "product_master.".$field . " = '" . $q . "' )";
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
	                $where .= "product_master.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "product_master.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "product_master.".$field . " = '" . $q . "' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('product_master.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('category_master', 'category_master.category_id = product_master.fk_category_id', 'LEFT');
	    $this->db->join('uom_master', 'uom_master.uom_id = product_master.fk_uom_id', 'LEFT');
	    $this->db->join('tax_master', 'tax_master.tax_id = product_master.fk_tax_id', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_product_master.php */
/* Location: ./application/models/Model_product_master.php */
