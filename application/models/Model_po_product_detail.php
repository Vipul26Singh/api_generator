<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_po_product_detail extends MY_Model {

	private $primary_key 	= 'po_product_detail_id';
	private $table_name 	= 'po_product_detail';
	private $field_search 	= ['fk_po_master_id', 'fk_product_id', 'quantity', 'total_cost'];

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
	                $where .= "po_product_detail.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "po_product_detail.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "po_product_detail.".$field . " = '" . $q . "' )";
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
	                $where .= "po_product_detail.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "po_product_detail.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "po_product_detail.".$field . " = '" . $q . "' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('po_product_detail.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('po_master', 'po_master.po_master_id = po_product_detail.fk_po_master_id', 'LEFT');
	    $this->db->join('product_master', 'product_master.product_master_id = po_product_detail.fk_product_id', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_po_product_detail.php */
/* Location: ./application/models/Model_po_product_detail.php */
