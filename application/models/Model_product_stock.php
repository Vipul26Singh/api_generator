<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_product_stock extends MY_Model {

	private $primary_key 	= 'product_stock_id';
	private $table_name 	= 'product_stock';
	private $field_search 	= ['batch_no', 'quantity', 'fk_product_id', 'entry_date', 'total_price', 'fk_challan_no', 'fk_location_id', 'fk_client_id'];

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
	                $where .= "product_stock.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "product_stock.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "product_stock.".$field . " = '" . $q . "' )";
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
	                $where .= "product_stock.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "product_stock.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "product_stock.".$field . " = '" . $q . "' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('product_stock.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('product_master', 'product_master.product_master_id = product_stock.fk_product_id', 'LEFT');
	    $this->db->join('idc_master', 'idc_master.idc_id = product_stock.fk_challan_no', 'LEFT');
	    $this->db->join('location_master', 'location_master.location_master_id = product_stock.fk_location_id', 'LEFT');
	    $this->db->join('client_master', 'client_master.client_id = product_stock.fk_client_id', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_product_stock.php */
/* Location: ./application/models/Model_product_stock.php */
