<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends Front
{
	
	public function __construct()
	{
		parent::__construct();
	}


	public function export()
	{
		$this->db->query(" 
			set global sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
		"); 

		$this->db->query(" 
			set session sql_mode=’STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION’;
		");

	}
}
