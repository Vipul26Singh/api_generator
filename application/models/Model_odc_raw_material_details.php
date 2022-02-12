<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_odc_raw_material_details extends MY_Model {

	private $primary_key 	= 'odc_raw_material_id';
	private $table_name 	= 'odc_raw_material_details';
	private $field_search 	= ['fk_odc_master_id', 'fk_raw_material_id', 'quantity', 'total_price'];

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
	                $where .= "odc_raw_material_details.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "odc_raw_material_details.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "odc_raw_material_details.".$field . " = '" . $q . "' )";
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
	                $where .= "odc_raw_material_details.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "odc_raw_material_details.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "odc_raw_material_details.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('odc_raw_material_details.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('odc_master', 'odc_master.odc_master_id = odc_raw_material_details.fk_odc_master_id', 'LEFT');
	    $this->db->join('raw_material', 'raw_material.raw_mat_id = odc_raw_material_details.fk_raw_material_id', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_odc_raw_material_details.php */
/* Location: ./application/models/Model_odc_raw_material_details.php */
