<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Crud Controller
*| --------------------------------------------------------------------------
*| crud site
*|
*/
class Add_column extends Admin	
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * show all cruds
	 *
	 * @var $offset String
	 */
	public function index()
	{
		$tables=$this->db->query("SELECT t.TABLE_NAME AS myTables FROM INFORMATION_SCHEMA.TABLES AS t WHERE t.TABLE_SCHEMA = '{$this->db->database}' and t.TABLE_TYPE = 'BASE TABLE'")->result_array();    
		foreach($tables as $key => $val) {
			$this->load->dbforge();

			$fields = array();
			$create_index = "";
			$update_index = "";
	
			if( !$this->db->field_exists('created_by', $val['myTables']) ) {
				$fields['created_by'] = array('type' => 'INT');
				$create_index = "ALTER TABLE `{$val['myTables']}` ADD INDEX {$val['myTables']}_created_by_index (`created_by`)";
			}

			if( !$this->db->field_exists('updated_by', $val['myTables']) ) {
                                $fields['updated_by'] = array('type' => 'INT', 'null' => TRUE, 'default' => NULL);
				$update_index = "ALTER TABLE `{$val['myTables']}` ADD INDEX {$val['myTables']}_updated_by_index (`updated_by`)";
                        }

			if( !$this->db->field_exists('updated_at', $val['myTables']) ) {
                                $fields['updated_at'] = array('type' => 'TIMESTAMP', 'null' => TRUE, 'default' => NULL);
                        }

			if( !$this->db->field_exists('created_at', $val['myTables']) ) {
                                $fields['created_at'] = array('type' => 'TIMESTAMP', 'null' => TRUE, 'default' => NULL);
                        }

			$this->dbforge->add_column($val['myTables'], $fields);
	
			if(!empty($create_index)) {
				$this->db->query($create_index);
			}

			if(!empty($update_index)) {
                                $this->db->query($update_index);
                        }
		}

		set_message('Database modified', 'success');
		redirect_back();
	}

}

/* End of file Crud.php */
/* Location: ./application/controllers/administrator/Crud.php */
