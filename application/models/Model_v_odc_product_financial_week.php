<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_v_odc_product_financial_week extends MY_Model {

	private $primary_key    = NULL;
	private $table_name 	= 'v_odc_product_financial_week';
	private $field_search 	= ['Product', 'qty', 'load_cycle', 'week'];
        private $start_week_date = "";
        private $start_week_year = "";
        private $end_week_date = "";
	private $end_week_year = "";
        private $curr_week = "";
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
		$curr_detail = $this->db->query("select WEEK(NOW(), 0) as week, YEAR(NOW()) as year")->row();
		$this->curr_year = $curr_detail->year;
		$this->curr_week = $curr_detail->week;

		if( empty(trim($this->input->get('week_date')) ) ) {
			$curr_detail = $this->db->query("select WEEK(NOW(), 0) as week, YEAR(NOW()) as year")->row();

			if($curr_detail->week >= 4) {
				$this->start_week_date = $curr_detail->week - 4;
			} else {
				$this->start_week_date = 0;
			}
			$this->start_week_year = $curr_detail->year;

			$this->end_week_date = $curr_detail->week;
			$this->end_week_year = $curr_detail->year;
		} else {
			$start_week_date = trim($this->input->get('week_date'));
			$curr_detail = $this->db->query("select WEEK('{$start_week_date}') as week, YEAR('{$start_week_date}') as year")->row();
			$this->start_week_date = $curr_detail->week;
			$this->start_week_year = $curr_detail->year;

			$this->end_week_date = $curr_detail->week + 4;
			$this->end_week_year = $curr_detail->year;
		}

		if($this->end_week_year > $this->curr_year || ($this->end_week_year == $this->curr_year && $this->end_week_date > $this->curr_week)) {
			$this->end_week_year = $this->curr_year;
			$this->end_week_date = $this->curr_week;
		}

		if($this->end_week_year > $this->start_week_year) {
			$last_day_year = "{$this->start_week_year}-12-31";
			$curr_detail = $this->db->query("select WEEK('{$last_day_year}', 0) as week, YEAR('{$last_day_year}') as year")->row();
			$this->end_week_date = $curr_detail->week;
			$this->end_week_year = $curr_detail->year;
		}

	}

	public function this_filter() {
		$where = NULL;

		foreach($this->input->get() as $key => $val) {
			$val = trim($val);

			if($key == 'product_name' && !empty(trim($val))) {
				$where .= " {$this->table_name}.Product" . " LIKE '%" . trim($val) . "%' ";
				$where .= " AND ";
			}
		}

		$where .= " {$this->table_name}.year = '" . $this->start_week_year. "' AND ";
		$where .= " {$this->table_name}.week >= '" . $this->start_week_date. "' AND ";
		$where .= " {$this->table_name}.week <= '" . $this->end_week_date. "' ";

		if(!empty($where)) {
			$where = '('.$where.')';
		}

		return $where;
	}

	private function create_json($query_data) {
		$return_array = array();
		$min_val = $this->start_week_date;
		$max_val = $this->end_week_date;
		foreach($query_data as $qd) {
			if(array_key_exists($qd->Product, $return_array)) {
				$return_array[$qd->Product][$qd->week]['qty'] += floatval($qd->qty);
				$return_array[$qd->Product][$qd->week]['load_cycle'] += floatval($qd->load_cycle);
			} else {
				$return_array[$qd->Product] = array();
				for($i = $min_val; $i <= $max_val; $i++){
					$return_array[$qd->Product][$i] = array('qty' => 0, 'load_cycle' => 0);
				}
				$return_array[$qd->Product][$qd->week]['qty'] += floatval($qd->qty);
				$return_array[$qd->Product][$qd->week]['load_cycle'] += floatval($qd->load_cycle);
			}
		}
		return $return_array;
	}

	public function dynamic_column(){
                $min_val = $this->start_week_date;
                $max_val = $this->end_week_date;

		$col = array();
		if(!empty($min_val) && !empty($max_val)) {

			for($i = $min_val; $i <= $max_val; $i++){
				for($i = $min_val; $i <= $max_val; $i++){
					$end_date = $this->db->query("select DATE_FORMAT(date_add(date_add(MAKEDATE(year(now()), 1), INTERVAL $i week), INTERVAL 5 DAY), '%d %b') val")->row()->val;
					$start_date = $this->db->query("select DATE_FORMAT(date_sub(date_add(MAKEDATE(year(now()), 1), INTERVAL $i week), INTERVAL 1 DAY), '%d %b') val")->row()->val;
					array_push($col, "{$start_date} - {$end_date}");
				}
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
					$where .= "v_odc_product_financial_week.".$field . " LIKE '%" . $q . "%' ";
				} else {
					$where .= "OR " . "v_odc_product_financial_week.".$field . " LIKE '%" . $q . "%' ";
				}
				$iterasi++;
			}

			$where = '('.$where.')';
		} else {
			$where .= "(" . "v_odc_product_financial_week.".$field . " LIKE '%" . $q . "%' )";
		}
		$this->join_avaiable();
		$this->db->where($where);
		$this->db->select("product");
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

		$this->db->order_by('product');
		$query = $this->db->get($this->table_name);

		return $this->create_json($query->result());
	}

	public function join_avaiable() {

		return $this;
	}

}

/* End of file Model_v_odc_product_financial_week.php */
/* Location: ./application/models/Model_v_odc_product_financial_week.php */
