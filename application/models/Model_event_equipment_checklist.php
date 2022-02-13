<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_event_equipment_checklist extends MY_Model {

		private $primary_key 	= 'id';
		private $table_name 	= 'event_equipment_checklist';
	private $field_search 	= ['event_id', 'equipment_id'];
	private $user_restriction = '';
	private $field_search_type = array("event_id" => "select","equipment_id" => "select");
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
			
			$select_string .= "tab_event_id.id as tab_event_id_value, tab_event_id.event_name as tab_event_id_label,"	;
			
			$select_string .= "tab_equipment_id.id as tab_equipment_id_value, tab_equipment_id.equipment_name as tab_equipment_id_label,"	;
						$select_string .= "event_equipment_checklist.*";
			$this->db->select($select_string, FALSE);
			return $this;
		}

		public function get_export_select_string() {
			$select_string = '';
                                                $select_string .= " (select relt1.event_name from events relt1 where relt1.id = event_equipment_checklist.event_id ) as `event_id`,";
                                                $select_string .= " (select relt2.equipment_name from equipments relt2 where relt2.id = event_equipment_checklist.equipment_id ) as `equipment_id`,";
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
				$where .= "(" . "event_equipment_checklist.".$field . " LIKE '%" . $q . "%' )";
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

                        $where .= " event_equipment_checklist.created_by = {$this->aauth->get_user_id()} ";
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
                                $where .= "(" . "event_equipment_checklist.".$field . " LIKE '%" . $q . "%' )";
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

                        $where .= " event_equipment_checklist.created_by = {$this->aauth->get_user_id()} ";

                }

                if (is_array($select_field) AND count($select_field)) {
                        $this->db->select($select_field);
                }

		$this->join_avaiable();
	
		if(!empty($where)) {
			$this->db->where($where);
		}

		$this->db->limit($limit, $offset);
					$this->db->order_by('event_equipment_checklist.'.$this->primary_key, "DESC");
							$query = $this->db->get($this->table_name);

			return $query->result();
	}

	public function join_avaiable() {
					$this->db->join('events tab_event_id', 'tab_event_id.id = event_equipment_checklist.event_id', 'LEFT');
					$this->db->join('equipments tab_equipment_id', 'tab_equipment_id.id = event_equipment_checklist.equipment_id', 'LEFT');
		
			return $this;
	}

}

/* End of file Model_event_equipment_checklist.php */
/* Location: ./application/models/Model_event_equipment_checklist.php */
