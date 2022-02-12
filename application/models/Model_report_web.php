<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_report_web extends MY_Model {

		private $primary_key 	= 'id';
		private $table_name 	= 'report_web';
	private $field_search 	= ['report_name', 'table_name', 'parent_report_id', 'icon', 'sequence', 'columns'];
	private $user_restriction = '';
	private $field_search_type = array("report_name" => "input","table_name" => "input","parent_report_id" => "select","icon" => "input","sequence" => "number","columns" => "input");
	private $export_select_string = '';

	public function __construct()
	{
		$this->export_select_string = $this->get_export_select_string();
		$config = array(
			'primary_key' 	=> $this->primary_key,
		 	'table_name' 	=> $this->table_name,
		 	'field_search' 	=> $this->field_search,
			'user_restriction' => $this->user_restriction,
			'export_select_string' => $this->export_select_string,
			'field_search_type' => $this->field_search_type,
		 );

		parent::__construct($config);
	}

		public function select_string() {
			$select_string = '';
			
			$select_string .= "tab_parent_report_id.id as tab_parent_report_id_value, tab_parent_report_id.report_name as tab_parent_report_id_label,"	;
						$select_string .= "report_web.*";
			$this->db->select($select_string, FALSE);
			return $this;
		}

		public function get_export_select_string() {
			$select_string = '';
                        			$select_string .= "report_name as report_name,";
						$select_string .= "table_name as table_name,";
			                        $select_string .= " (select relt1.report_name from report_web relt1 where relt1.id = report_web.parent_report_id ) as parent_report_id,";
                        			$select_string .= "icon as icon,";
						$select_string .= "sequence as sequence,";
						$select_string .= "columns as columns,";
						$select_string = rtrim($select_string, ",");
			
                        return $select_string;	
		}

	public function count_all($q = null, $field = null)
	{
		$iterasi = 1;
		$num = count($this->field_search);
		$where = NULL;
		$q = $this->scurity($q);
		$field = $this->scurity($field);


		if (!empty($field)) {
				$where .= "(" . "report_web.".$field . " LIKE '%" . $q . "%' )";
		}

	        $search = $this->search_filter();

                if(!empty($search)) {
                        if(!empty($where)) {
                                $where .= " and ";
                        }
                        $where .= $search ;
                }

                if($this->apply_user_filter()) {
                        if(!empty($where)) {
                                $where .= " and ";
                        }

                        $where .= " report_web.created_by = {$this->aauth->get_user_id()} ";
                }


		$this->join_avaiable();

		if(!empty($where)) {
			$this->db->where($where);
		}

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

		if( !empty($field) ) {
                                $where .= "(" . "report_web.".$field . " LIKE '%" . $q . "%' )";
                }

                $search = $this->search_filter();
		$this->select_string();

                if(!empty($search)) {
                        if(!empty($where)) {
                                $where .= " and ";
                        }
                        $where .= $search ;
                }

                if($this->apply_user_filter()) {
                        if(!empty($where)) {
                                $where .= " and ";
                        }

                        $where .= " report_web.created_by = {$this->aauth->get_user_id()} ";

                }

                if (is_array($select_field) AND count($select_field)) {
                        $this->db->select($select_field);
                }

		$this->join_avaiable();
	
		if(!empty($where)) {
			$this->db->where($where);
		}

		$this->db->limit($limit, $offset);
					$this->db->order_by('report_web.'.$this->primary_key, "DESC");
							$query = $this->db->get($this->table_name);

			return $query->result();
	}

	public function join_avaiable() {
					$this->db->join('report_web tab_parent_report_id', 'tab_parent_report_id.id = report_web.parent_report_id', 'LEFT');
		
			return $this;
	}

}

/* End of file Model_report_web.php */
/* Location: ./application/models/Model_report_web.php */
