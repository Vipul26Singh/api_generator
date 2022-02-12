<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_job_work_recipe extends MY_Model {

		private $primary_key 	= 'recipe_id';
		private $table_name 	= 'job_work_recipe';
	private $field_search 	= ['fk_job_work_process_master_id', 'fk_raw_material_id', 'quantity'];

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
	                $where .= "job_work_recipe.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "job_work_recipe.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "job_work_recipe.".$field . " = '" . $q . "' )";
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
					$where .= "job_work_recipe.".$field . " LIKE '%" . $q . "%' ";
				} else {
					$where .= "OR " . "job_work_recipe.".$field . " LIKE '%" . $q . "%' ";
				}
				$iterasi++;
			}

			$where = '('.$where.')';
		} else {
			$where .= "(" . "job_work_recipe.".$field . " = '" . $q . "' )";
		}

		if (is_array($select_field) AND count($select_field)) {
			$this->db->select($select_field);
		}

		$this->join_avaiable();
		$this->db->where($where);
		$this->db->limit($limit, $offset);
		$this->db->order_by('job_work_recipe.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('job_work_process_master', 'job_work_process_master.process_master_id = job_work_recipe.fk_job_work_process_master_id', 'LEFT');
	    $this->db->join('raw_material', 'raw_material.raw_mat_id = job_work_recipe.fk_raw_material_id', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_job_work_recipe.php */
/* Location: ./application/models/Model_job_work_recipe.php */
