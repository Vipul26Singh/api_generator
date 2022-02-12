<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_product_group_details extends MY_Model {

	private $primary_key 	= 'product_group_detail_id';
	private $table_name 	= 'product_group_details';
	private $field_search 	= ['fk_grouped_product_id', 'fk_product_id', 'product_item_quantiity'];

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
	                $where .= "product_group_details.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "product_group_details.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "product_group_details.".$field . " = '" . $q . "' )";
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
	                $where .= "product_group_details.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "product_group_details.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "product_group_details.".$field . " = '" . $q . "' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('product_group_details.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('product_group', 'product_group.grouped_product_id = product_group_details.fk_grouped_product_id', 'LEFT');
	    $this->db->join('product_master', 'product_master.product_master_id = product_group_details.fk_product_id', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_product_group_details.php */
/* Location: ./application/models/Model_product_group_details.php */
