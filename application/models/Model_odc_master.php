<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_odc_master extends MY_Model {

	private $primary_key 	= 'odc_master_id';
		private $table_name 	= 'odc_master';
	private $field_search 	= ['fk_client_id', 'fk_idc_id', 'vehicle_no', 'odc_type', 'date', 'odc_remarks', 'shipping_address', 'shipping_country', 'shipping_state', 'shipping_city', 'is_rejected', 'odc_challan_no'];

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
	                $where .= "odc_master.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "odc_master.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "odc_master.".$field . " = '" . $q . "' )";
	}

	if($this->aauth->is_member('Clients')) {
		$user_id = $this->session->userdata('id');
		$user_detail = $this->db->query("select * from aauth_users where id = {$user_id}")->row();

		$client_id = 0;
		if(!empty($user_detail) && !empty($user_detail->fk_client_id)) {
			$client_id = $user_detail->fk_client_id;
		}
		$where .= " and (odc_master.fk_client_id IN( select client_id from client_master where client_id = {$client_id} or client_parent_comapny = {$client_id}) ) ";

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
	                $where .= "odc_master.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "odc_master.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "odc_master.".$field . " = '" . $q . "' )";
	}

	if($this->aauth->is_member('Clients')) {
		$user_id = $this->session->userdata('id');
		$user_detail = $this->db->query("select * from aauth_users where id = {$user_id}")->row();

		$client_id = 0;
		if(!empty($user_detail) && !empty($user_detail->fk_client_id)) {
			$client_id = $user_detail->fk_client_id;
		}
		 $where .= " and (odc_master.fk_client_id IN( select client_id from client_master where client_id = {$client_id} or client_parent_comapny = {$client_id}) ) ";

	}


        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
	$this->db->limit($limit, $offset);
	$this->db->order_by('odc_master.'.$this->primary_key, "DESC");
			$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('client_master', 'client_master.client_id = odc_master.fk_client_id', 'LEFT');
	    //$this->db->join('idc_master', 'idc_master.idc_id = odc_master.fk_idc_id', 'LEFT');
	    $this->db->join('country_master', 'country_master.country_id = odc_master.shipping_country', 'LEFT');
	    $this->db->join('state_master', 'state_master.state_id = odc_master.shipping_state', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_odc_master.php */
/* Location: ./application/models/Model_odc_master.php */
