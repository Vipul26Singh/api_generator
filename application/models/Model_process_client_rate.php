<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_process_client_rate extends MY_Model {

	private $primary_key 	= 'process_client_rate_id';
	private $table_name 	= 'process_client_rate';
	private $field_search 	= ['fk_client_id', 'fk_process_master_id', 'unit_price', 'start_date', 'end_date'];

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
	                $where .= "process_client_rate.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "process_client_rate.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "process_client_rate.".$field . " = '" . $q . "' )";
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
	                $where .= "process_client_rate.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "process_client_rate.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "process_client_rate.".$field . " = '" . $q . "' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('process_client_rate.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('client_master', 'client_master.client_id = process_client_rate.fk_client_id', 'LEFT');
	    $this->db->join('job_work_process_master', 'job_work_process_master.process_master_id = process_client_rate.fk_process_master_id', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_process_client_rate.php */
/* Location: ./application/models/Model_process_client_rate.php */
