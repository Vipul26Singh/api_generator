<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_invoice_details extends MY_Model {

	private $primary_key 	= 'invoice_detail_id';
	private $table_name 	= 'invoice_details';
	private $field_search 	= ['fk_inv_master_id', 'line_item_name', 'line_item_quantity', 'line_item_total_cost', 'line_item_taxed_amount'];

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
	                $where .= "invoice_details.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "invoice_details.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "invoice_details.".$field . " = '" . $q . "' )";
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
	                $where .= "invoice_details.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "invoice_details.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "invoice_details.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('invoice_details.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('invoice_master', 'invoice_master.invoice_master_id = invoice_details.fk_inv_master_id', 'LEFT');
	    $this->db->join('tax_master', 'tax_master.tax_id = invoice_details.line_item_tax', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_invoice_details.php */
/* Location: ./application/models/Model_invoice_details.php */
