<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_v_raw_material_last_10_day extends MY_Model {

	private $primary_key    = NULL;
	private $table_name 	= 'v_raw_material_last_10_day';
	private $field_search 	= ['Raw_Material', 'qty', 'day'];
	private $min_date = "";
	private $max_date = "";
	private $curr_date = "";


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
		$this->curr_date = $this->db->query("select CAST(NOW() AS DATE) as val from {$this->table_name} limit 1")->row()->val;
		if( !empty($this->input->get('start_date') ) && !empty(trim($this->input->get('start_date'))) ) {
			$this->min_date = trim($this->input->get('start_date'));
		}

		if( !empty($this->input->get('end_date') ) && !empty(trim($this->input->get('end_date'))) ) {
			$this->max_date = trim($this->input->get('end_date'));
		}

		if(!empty($this->min_date) && empty($this->max_date)) {
			$this->max_date = date('Y-m-d', strtotime($this->min_date. ' + 10 days'));
		} else if(empty($this->min_date) && !empty($this->max_date)) {
			$this->min_date = date('Y-m-d', strtotime($this->max_date. ' - 10 days'));
		} else if(empty($this->min_date) && empty($this->max_date)){
			$this->min_date = $this->db->query("select CAST(NOW() AS DATE) - INTERVAL 10 DAY as val from {$this->table_name} limit 1")->row()->val;
			$this->max_date = $this->db->query("select date(NOW()) as val from {$this->table_name}  limit 1")->row()->val;
		}

		if(strtotime($this->max_date) > strtotime($this->curr_date)) {
			$this->max_date = $this->curr_date;
		}

	}

	public function resetRange() {
		$this->min_date = $this->db->query("select CAST(NOW() AS DATE) - INTERVAL 10 DAY as val from {$this->table_name} limit 1")->row()->val;
		$this->max_date = $this->db->query("select date(NOW()) as val from {$this->table_name}  limit 1")->row()->val;
	}

	public function getRange() {
		$diff = strtotime($this->max_date) - strtotime($this->min_date);

		return abs(round($diff / 86400));
	}


	public function this_filter() {
		$where = NULL;

		foreach($this->input->get() as $key => $val) {
			$val = trim($val);

			if($key == 'raw_material' && !empty(trim($val))) {
				$where .= " {$this->table_name}.Raw_Material" . " LIKE '%" . trim($val) . "%' ";
				$where .= " AND ";
			}
		}

		$where .= " {$this->table_name}.day >= '" . $this->min_date. "' AND ";
		$where .= " {$this->table_name}.day <= '" . $this->max_date. "' ";

		if(!empty($where)) {
			$where = '('.$where.')';
		}

		return $where;
	}



	private function create_json($query_data) {
		$return_array = array();
		$min_val = $this->min_date;
		$max_val = $this->max_date;

		foreach($query_data as $qd) {
			if(array_key_exists($qd->Raw_Material, $return_array)) {
				$return_array[$qd->Raw_Material][$qd->day]['qty'] += floatval($qd->qty);
			} else {
				$return_array[$qd->Raw_Material] = array();
				for($i = $min_val; $i <= $max_val; $i++){
					$return_array[$qd->Raw_Material][$i] = array('qty' => 0);
				}
				$return_array[$qd->Raw_Material][$qd->day]['qty'] += floatval($qd->qty);
			}
		}
		return $return_array;
	}

	public function dynamic_column(){
		$min_val = $this->min_date;
		$max_val = $this->max_date;


		$col = array();
		for($i = $min_val; $i <= $max_val; $i++){
			for($i = $min_val; $i <= $max_val; $i++){
				array_push($col, date('d M', strtotime($i)) );
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
					$where .= "v_raw_material_last_10_day.".$field . " LIKE '%" . $q . "%' ";
				} else {
					$where .= "OR " . "v_raw_material_last_10_day.".$field . " LIKE '%" . $q . "%' ";
				}
				$iterasi++;
			}

			$where = '('.$where.')';
		} else {
			$where .= "(" . "v_raw_material_last_10_day.".$field . " LIKE '%" . $q . "%' )";
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


		$field = $this->scurity($field);


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

/* End of file Model_v_raw_material_last_10_day.php */
/* Location: ./application/models/Model_v_raw_material_last_10_day.php */
