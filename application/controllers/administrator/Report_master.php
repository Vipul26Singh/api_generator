<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Report Web Controller
*| --------------------------------------------------------------------------
*| Report Web site
*|
*/
class Report_master extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_report_web');
	}

	/**
	* show all Report Webs
	*
	* @var $offset String
	*/
	public function index()
	{
		$this->is_allowed('report_dashboard');

		$this->data['report_list'] = $this->db->query("select * from report_web where parent_report_id is null order by sequence")->result();

		$this->template->title('Reports');
		$this->data['heading'] = "Reports";
		$this->render('backend/standart/administrator/reports/report_list', $this->data);
	}

		/**
	* View view Report Webs
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('report_dashboard');
		$this_report = $this->db->query("select * from report_web where id = {$id}")->row();

		$child_reports = $this->db->query("select * from report_web where parent_report_id = {$id} order by sequence")->result();

		if(empty($child_reports)) {
			redirect(base_url() . '/administrator/' . $this_report->table_name); 
		} else {
			$this->data['report_list'] = $child_reports;
			$this->data['heading'] = $this_report->report_name . " -> Sub Report";
			$this->template->title("Sub Report");
			$this->render('backend/standart/administrator/reports/report_list', $this->data);
		}
	}
}


/* End of file report_web.php */
/* Location: ./application/controllers/administrator/Report Web.php */

