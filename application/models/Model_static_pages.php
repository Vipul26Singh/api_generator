<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_static_pages extends MY_Model {

		private $primary_key 	= 'id';
		private $table_name 	= 'static_pages';
	private $field_search 	= ['name', 'content'];
	private $user_restriction = '';
	private $field_search_type = array();
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
						$select_string .= "static_pages.*";
			$this->db->select($select_string, FALSE);
			return $this;
		}

		public function get_export_select_string() {
			$select_string = '';
                        			$select_string .= "name as `name`,";
						$select_string .= "content as `content`,";
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
				$where .= "(" . "static_pages.".$field . " LIKE '%" . $q . "%' )";
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

                        $where .= " static_pages.created_by = {$this->aauth->get_user_id()} ";
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
                                $where .= "(" . "static_pages.".$field . " LIKE '%" . $q . "%' )";
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

                        $where .= " static_pages.created_by = {$this->aauth->get_user_id()} ";

                }

                if (is_array($select_field) AND count($select_field)) {
                        $this->db->select($select_field);
                }

		$this->join_avaiable();
	
		if(!empty($where)) {
			$this->db->where($where);
		}

		$this->db->limit($limit, $offset);
					$this->db->order_by('static_pages.'.$this->primary_key, "DESC");
							$query = $this->db->get($this->table_name);

			return $query->result();
	}

	public function join_avaiable() {
		
			return $this;
	}

}

/* End of file Model_static_pages.php */
/* Location: ./application/models/Model_static_pages.php */
