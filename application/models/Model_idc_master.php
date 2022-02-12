<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_idc_master extends MY_Model {

	private $primary_key 	= 'idc_id';
	private $table_name 	= 'idc_master';
	private $field_search 	= ['idc_challan_no', 'vehicle_number', 'challan_date', 'is_processed'];

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
					$where .= "idc_master.".$field . " LIKE '%" . $q . "%' ";
				} else {
					$where .= "OR " . "idc_master.".$field . " LIKE '%" . $q . "%' ";
				}
				$iterasi++;
			}

			$where = '('.$where.')';
		} else {
			$where .= "(" . "idc_master.".$field . " = '" . $q . "' )";
		}

		if($this->aauth->is_member('Clients')) {
			$user_id = $this->session->userdata('id');
			$user_detail = $this->db->query("select * from aauth_users where id = {$user_id}")->row();

			$client_id = 0;
			if(!empty($user_detail) && !empty($user_detail->fk_client_id)) {
				$client_id = $user_detail->fk_client_id;
			}
			$where .= " and (idc_master.fk_client_id IN( select client_id from client_master where client_id = {$client_id} or client_parent_comapny = {$client_id}) ) ";
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
					$where .= "idc_master.".$field . " LIKE '%" . $q . "%' ";
				} else {
					$where .= "OR " . "idc_master.".$field . " LIKE '%" . $q . "%' ";
				}
				$iterasi++;
			}

			$where = '('.$where.')';
		} else {
			$where .= "(" . "idc_master.".$field . " = '" . $q . "' )";
		}

		if (is_array($select_field) AND count($select_field)) {
			$this->db->select($select_field);
		}

		if($this->aauth->is_member('Clients')) {
			$user_id = $this->session->userdata('id');
			$user_detail = $this->db->query("select * from aauth_users where id = {$user_id}")->row();

			$client_id = 0;
			if(!empty($user_detail) && !empty($user_detail->fk_client_id)) {
				$client_id = $user_detail->fk_client_id;
			}
			 $where .= " and (idc_master.fk_client_id IN( select client_id from client_master where client_id = {$client_id} or client_parent_comapny = {$client_id}) ) ";

		}

		$this->join_avaiable();
		$this->db->where($where);
		$this->db->limit($limit, $offset);
		$this->db->order_by('idc_master.'.$this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);


		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('client_master', 'client_master.client_id = idc_master.fk_client_id', 'LEFT');
		$this->db->join('vendor_master', 'vendor_master.vendor_mast_id = idc_master.fk_vendor_id', 'LEFT');
		$this->db->join('work_order_master', 'work_order_master.wo_master_id = idc_master.fk_wo_id', 'LEFT');
		$this->db->join('po_master', 'po_master.po_master_id = idc_master.fk_po_id', 'LEFT');
		$this->db->join('invoice_master', 'invoice_master.invoice_master_id = idc_master.fk_inv_id', 'LEFT');

		return $this;
	}

}

/* End of file Model_idc_master.php */
/* Location: ./application/models/Model_idc_master.php */
