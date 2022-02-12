<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_v_idc_product_financial_month extends MY_Model {

	private $primary_key    = NULL;
	private $table_name 	= 'v_idc_product_financial_month';
	private $field_search 	= ['Product', 'qty', 'load_cycle', 'month'];

	private $month_date = "";
	private $month_year = "";
	private $curr_month = "";
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
		$curr_detail = $this->db->query("select MONTH(NOW()) as month, YEAR(NOW()) as year")->row();
		$this->curr_year = $curr_detail->year;

		if( !empty(trim($this->input->get('month_date')) ) ) {
			$passed_time = trim($this->input->get('month_date'));
			$mnth = substr($passed_time, 0, 2);
			$year = substr($passed_time, 3, 4);
			$first_day = "{$year}-{$mnth}-01";
			$curr_detail = $this->db->query("select MONTH('{$first_day}') as month, YEAR('{$first_day}') as year")->row();
			$this->month_date = $curr_detail->month;
			$this->month_year = $curr_detail->year;
		} else {
			$curr_detail = $this->db->query("select MONTH(NOW()) as month, YEAR(NOW()) as year")->row();
			$this->curr_month = $curr_detail->month;
			$this->month_date = "";
			if($curr_detail->month <= 3) {
				$this->month_year = $curr_detail->year - 1;
			} else {
				$this->month_year = $curr_detail->year;
			}
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


		if( empty($this->month_date) ) {
			$next_year = $this->month_year + 1;
			$where .= " ( {$this->table_name}.year = '{$this->month_year}' AND {$this->table_name}.month > 3 ) OR ( {$this->table_name}.year = '{$next_year}' AND {$this->table_name}.month <= 3 AND 
			{$this->table_name}.month >= 1
			) ";
		} else {
			$where .= " {$this->table_name}.year = '" . $this->month_year. "' AND ";
			$where .= " {$this->table_name}.month = '" . $this->month_date. "' ";
		}

		if(!empty($where)) {
			$where = '('.$where.')';
		}

		return $where;
	}

	private function create_json($query_data) {
		$return_array = array();
		$last_mnth = '';

		if( empty($this->month_date) ) {
			$last_mnth = $this->curr_month;
		} else {
			$last_mnth = $this->month_date;
		}

		if( empty($this->month_date) ) {
			if($this->curr_year != $this->month_year) {
				$min_val = 1;
			} else {
				$min_val = 4;
			}

			$max_val = $last_mnth;
		} else {
			$min_val = $last_mnth;
			$max_val = $last_mnth;
		}


		foreach($query_data as $qd) {
			if(array_key_exists($qd->Product, $return_array)) {
				if(array_key_exists($qd->month, $return_array[$qd->Product])) {
					$return_array[$qd->Product][$qd->month]['qty'] += floatval($qd->qty);
					$return_array[$qd->Product][$qd->month]['load_cycle'] += floatval($qd->load_cycle);
				}
			} else {
				$return_array[$qd->Product] = array();

				if($min_val == $max_val) {
					$return_array[$qd->Product][$min_val] = array('qty' => 0, 'load_cycle' => 0);
				} else if(($min_val > 3 && $max_val > 3) || ($min_val <= 3 && $max_val <= 3)) {
					for($i = $min_val; $i <= $max_val; $i++){
						$return_array[$qd->Product][$i] = array('qty' => 0, 'load_cycle' => 0);
					}
				} else {
					for($i = 4; $i <= $max_val; $i++){
						$return_array[$qd->Product][$i] = array('qty' => 0, 'load_cycle' => 0);
					}

					for($i = 1; $i <= 3; $i++){
						$return_array[$qd->Product][$i] = array('qty' => 0, 'load_cycle' => 0);
					}
				}

				if(array_key_exists($qd->month, $return_array[$qd->Product])) {

					$return_array[$qd->Product][$qd->month]['qty'] += floatval($qd->qty);
					$return_array[$qd->Product][$qd->month]['load_cycle'] += floatval($qd->load_cycle);
				}
			}
		}
		return $return_array;
	}

	public function dynamic_column() {
		$last_mnth = '';

		if( empty($this->month_date) ) {
			$last_mnth = $this->curr_month;
		} else {
			$last_mnth = $this->month_date;
		}

		if( empty($this->month_date) ) {
			if($this->curr_year != $this->month_year) {
				$min_val = 1;
			} else {
				$min_val = 4;
			}


			$max_val = $last_mnth;
		} else {
			$min_val = $last_mnth;
			$max_val = $last_mnth;
		}


		$col = array();

		if(!empty($min_val) && !empty($max_val)) {
			if($min_val == $max_val) {
				$month = $this->db->query("select MONTHNAME(STR_TO_DATE({$max_val}, '%m')) val")->row()->val;
				array_push($col, "{$month}");	
			} else {
				for($i = 4; $i <= $max_val; $i++){
					$month = $this->db->query("select MONTHNAME(STR_TO_DATE({$i}, '%m')) val")->row()->val;
					array_push($col, "{$month}");
				}

				if($min_val < 4) {
					for($i = 1; $i <= 3; $i++){
						$month = $this->db->query("select MONTHNAME(STR_TO_DATE({$i}, '%m')) val")->row()->val;
						array_push($col, "{$month}");
					}
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
					$where .= "v_idc_product_financial_month.".$field . " LIKE '%" . $q . "%' ";
				} else {
					$where .= "OR " . "v_idc_product_financial_month.".$field . " LIKE '%" . $q . "%' ";
				}
				$iterasi++;
			}

			$where = '('.$where.')';
		} else {
			$where .= "(" . "v_idc_product_financial_month.".$field . " LIKE '%" . $q . "%' )";
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

/* End of file Model_v_idc_product_financial_month.php */
/* Location: ./application/models/Model_v_idc_product_financial_month.php */
