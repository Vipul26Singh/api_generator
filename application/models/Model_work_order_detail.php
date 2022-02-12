<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_work_order_detail extends MY_Model {

	private $primary_key 	= 'wo_detail_id';
	private $table_name 	= 'work_order_detail';
	private $field_search 	= ['fk_wo_master_id', 'fk_product_master_id', 'fk_process_id', 'quantity', 'total_price'];

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
	                $where .= "work_order_detail.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "work_order_detail.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "work_order_detail.".$field . " = '" . $q . "' )";
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
	                $where .= "work_order_detail.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "work_order_detail.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "work_order_detail.".$field . " = '" . $q . "' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('work_order_detail.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('work_order_master', 'work_order_master.wo_master_id = work_order_detail.fk_wo_master_id', 'LEFT');
	    $this->db->join('product_master', 'product_master.product_master_id = work_order_detail.fk_product_master_id', 'LEFT');
	    $this->db->join('job_work_process_master', 'job_work_process_master.process_master_id = work_order_detail.fk_process_id', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_work_order_detail.php */
/* Location: ./application/models/Model_work_order_detail.php */
