<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_v_raw_material_financial_quarter extends MY_Model {

	private $primary_key    = NULL;
	private $table_name 	= 'v_raw_material_financial_quarter';
	private $field_search 	= ['Raw_Material', 'qty', 'quarter'];

	private $financial_year = "";
	private $curr_year = "";


	public function __construct()
	{
		$config = array(
			'primary_key' 	=> $this->primary_key,
			'table_name' 	=> $this->table_name,
			'field_search' 	=> $this->field_search,
		);

		parent::__construct($config);
		$this->initialise_config();
	}

	private function initialise_config() {
		$curr_detail = $this->db->query("select YEAR(NOW()) as year")->row();
		$this->curr_year = $curr_detail->year;

		if( !empty(trim($this->input->get('financial_year')) ) ) {
			$this->financial_year = trim($this->input->get('financial_year'));
		} else {
			$this->financial_year = $this->curr_year;
		}
	}

	public function this_filter() {
		$where = NULL;

		foreach($this->input->get() as $key => $val) {
			$val = trim($val);

			if($key == 'product_name' && !empty(trim($val))) {
				$where .= " {$this->table_name}.Raw_Material" . " LIKE '%" . trim($val) . "%' ";
				$where .= " AND ";
			}
		}

		$where .= " {$this->table_name}.year = '" . $this->financial_year. "' ";

		if(!empty($where)) {
			$where = '('.$where.')';
		}

		return $where;
	}



	private function create_json($query_data) {
		$return_array = array();
		$min_val = $this->db->query("select min(quarter) as val from {$this->table_name} where year = '{$this->financial_year}'")->row()->val;
		$max_val = $this->db->query("select max(quarter) as val from {$this->table_name} where year = '{$this->financial_year}'")->row()->val;

		foreach($query_data as $qd) {
			if(array_key_exists($qd->Raw_Material, $return_array)) {
				$return_array[$qd->Raw_Material][$qd->quarter]['qty'] += floatval($qd->qty);
			} else {
				$return_array[$qd->Raw_Material] = array();
				for($i = $min_val; $i <= $max_val; $i++){
					$return_array[$qd->Raw_Material][$i] = array('qty' => 0);
				}
				$return_array[$qd->Raw_Material][$qd->quarter]['qty'] += floatval($qd->qty);
			}
		}
		return $return_array;
	}

	public function dynamic_column(){
		$min_val = $this->db->query("select min(quarter) as val from {$this->table_name} where year = '{$this->financial_year}'")->row()->val;
		$max_val = $this->db->query("select max(quarter) as val from {$this->table_name} where year = '{$this->financial_year}'")->row()->val;

		$col = array();
		for($i = $min_val; $i <= $max_val; $i++){
			for($i = $min_val; $i <= $max_val; $i++){
				array_push($col, "Quarter {$i}");
			}
		}
		return $col;

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
					$where .= "v_raw_material_financial_quarter.".$field . " LIKE '%" . $q . "%' ";
				} else {
					$where .= "OR " . "v_raw_material_financial_quarter.".$field . " LIKE '%" . $q . "%' ";
				}
				$iterasi++;
			}

			$where = '('.$where.')';
		} else {
			$where .= "(" . "v_raw_material_financial_quarter.".$field . " LIKE '%" . $q . "%' )";
		}
		$this->join_avaiable();
		$this->db->where($where);

		$this->db->select("Raw_Material");
		$this->db->distinct();
		return $this->db->count_all_results($this->table_name);

	}

	public function get($q = null, $field = null, $limit = 0, $offset = 0, $select_field = [])
	{
		$iterasi = 1;
		$num = count($this->field_search);
		$where = NULL;
		$q = $this->scurity($q);
		$search = $this->this_filter();

		if(!empty($search)) {
			$where .= $search ;
		}

		if (is_array($select_field) AND count($select_field)) {
			$this->db->select($select_field);
		}

		$this->join_avaiable();

		if(!empty($where)) {
			$this->db->where($where);
		}
		$query = $this->db->get($this->table_name);

		return $this->create_json($query->result());
	}

	public function join_avaiable() {

		return $this;
	}

}

/* End of file Model_v_raw_material_financial_quarter.php */
/* Location: ./application/models/Model_v_raw_material_financial_quarter.php */
