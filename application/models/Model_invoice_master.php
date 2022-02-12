<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_invoice_master extends MY_Model {

	private $primary_key 	= 'invoice_master_id';
	private $table_name 	= 'invoice_master';
	private $field_search 	= ['inv_no', 'fk_client_id', 'inv_date', 'shipping_address', 'billing_address', 'billed_amount', 'inv_due_date'];

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
	                $where .= "invoice_master.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "invoice_master.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "invoice_master.".$field . " = '" . $q . "' )";
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
	                $where .= "invoice_master.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "invoice_master.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "invoice_master.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('invoice_master.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('client_master', 'client_master.client_id = invoice_master.fk_client_id', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_invoice_master.php */
/* Location: ./application/models/Model_invoice_master.php */
