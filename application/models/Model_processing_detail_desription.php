<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_processing_detail_desription extends MY_Model {

		private $primary_key 	= 'detail_id';
		private $table_name 	= 'processing_detail_desription';
	private $field_search 	= ['processing_quantity', 'processing_date'];

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
	                $where .= "processing_detail_desription.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "processing_detail_desription.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "processing_detail_desription.".$field . " = '" . $q . "' )";
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
	                $where .= "processing_detail_desription.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "processing_detail_desription.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "processing_detail_desription.".$field . " = '" . $q . "' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
	$this->db->limit($limit, $offset);
	$this->db->order_by('processing_detail_desription.'.$this->primary_key, "DESC");
			$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('processing_detail', 'processing_detail.processing_detail_id = processing_detail_desription.fk_processing_detail_id', 'LEFT');
	    
    	return $this;
	}

	public function add_receipt($process_id, $processing_qty) {
		$is_location_enabled = get_option('location_track', 'NO');
		$is_auto_process = get_option("auto_process", "NO");
		$process_detail = $this->db->query("select * from processing_detail where processing_detail_id = '{$process_id}'")->result();
		$print_detail = '';
		foreach($process_detail as $pd) {
			$recepie_detail = $this->db->query("SELECT fk_raw_material_id, quantity * {$pd->quantity_processed} as qty FROM job_work_recipe where fk_job_work_process_master_id = {$pd->fk_process_id}")->result();

			foreach($recepie_detail as $rd) {
				$raw_material_stock = $this->db->query("select * from raw_material_stock where fk_raw_material_id = '{$rd->fk_raw_material_id}' and quantity > {$rd->qty} order by raw_mat_stck_id")->result();

				if(!empty($raw_material_stock)){
					$raw_material = $this->db->query("select * from raw_material where raw_mat_id = '{$raw_material_stock[0]->fk_raw_material_id}'")->result();
					if(!empty($raw_material)){
						$uom = $this->db->query("select * from uom_master where uom_id = '{$raw_material[0]->fk_uom_id}'")->result();

						if($is_auto_process == 'YES'){
							$this->db->query("update raw_material_stock set quantity = quantity - {$rd->qty} where raw_mat_stck_id = {$raw_material_stock[0]->raw_mat_stck_id}");
						}

						if($is_location_enabled == 'YES') {
							$location = $this->db->query("select * from location_master where location_master_id = '{$raw_material_stock[0]->fk_location_id}'")->result();
							$print_detail .= "<p>Fetch {$rd->qty} {$uom[0]->uom_name} of {$raw_material[0]->name} from {$location[0]->location_name}.</p>";
						} else {
							$print_detail .= "<p>Fetch {$rd->qty} {$uom[0]->uom_name} of {$raw_material[0]->name} .</p>";
						}
					}
				}

			}

		}

		$save_data = [
			'fk_processing_detail_id' => $process_id,
			'processing_quantity' =>  $processing_qty,
			'print_detail' => $print_detail,
		];

		$save_processing_detail_desription = $this->store($save_data);

		return $save_processing_detail_desription;

	}



}

/* End of file Model_processing_detail_desription.php */
/* Location: ./application/models/Model_processing_detail_desription.php */
