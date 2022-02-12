<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_client_advance_payment extends MY_Model {

	private $primary_key 	= 'id';
	private $table_name 	= 'client_advance_payment';
	private $field_search 	= ['fk_client_id', 'transaction_date', 'amount'];

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
	                $where .= "client_advance_payment.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "client_advance_payment.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "client_advance_payment.".$field . " = '" . $q . "' )";
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
	                $where .= "client_advance_payment.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "client_advance_payment.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "client_advance_payment.".$field . " = '" . $q . "' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('client_advance_payment.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('client_master', 'client_master.client_id = client_advance_payment.fk_client_id', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_client_advance_payment.php */
/* Location: ./application/models/Model_client_advance_payment.php */
