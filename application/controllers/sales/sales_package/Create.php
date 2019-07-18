<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends Admin_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
    }
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index - Create Sales Package
	 *
	 * Creates a sales package given an input sales page name with some default values
	 * inserted to database.
	 *
	 * @return	void
	 */
	public function index()
	{
		// load pertinent library/model/helpers
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('sales_package_name', 'Sales Package Name', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			// load pertinent library/model/helpers
			$this->load->library('sales_package/sales_package_list');
			
			// get data
			$this->data['packages'] = $this->sales_package_list->select();
			
			// set data variables...
			$this->data['file'] = 'sales_package';
			$this->data['page_title'] = 'Sales Package';
			$this->data['page_description'] = 'Create Sales Packages';
			
			// load views...
			$this->load->view($this->config->slash_item('admin_folder').$this->config->slash_item('admin_template').'template', $this->data);
		}
		else
		{
			echo 'Processing...';
		
			// connect to database
			$DB = $this->load->database('instyle', TRUE);
		
			// insert record
			$post_ary = $this->input->post();
			// set necessary variables
			$post_ary['sales_user'] = '1'; // This is created at admin by super admin so we assign super sales
			$post_ary['email_subject'] = $this->input->post('sales_package_name');
			$post_ary['email_message'] = "<p>Here are several designs for your review.<br>Please respond with items of interest for you stores.<br></p>";
			$post_ary['date_create'] = date('Y-m-d', time());
			$post_ary['last_modified'] = strtotime($post_ary['date_create']);
			$post_ary['author'] = 'admin'; // default when at admin by super admin (set to system for system generate items)
			// unset unneeded variables
			//unset($post_ary['pword_again']);
			$DB->set($post_ary);
			$q = $DB->insert('sales_packages');
			$insert_id = $DB->insert_id();
			
			// set flash data
			$this->session->set_flashdata('success', 'create_sales_package');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/edit/index/'.$insert_id);
		}
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * PRIVATE - Create Plugin Scripts and CSS for the page
	 *
	 * @return	void
	 */
	private function _create_plugin_scripts()
	{
		$assets_url = base_url('assets/metronic');
		
		/****************
		 * page plugins style sheets inserted at <head>
		 */
		$this->data['page_level_plugins'] = '';
		
			// ladda - show loading or progress bar on buttons
			$this->data['page_level_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
			';
			// datatable
			$this->data['page_level_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
			';
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
			';
		
		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '
		';
		
		/****************
		 * page plugins scripts inserted at <bottom>
		 */
		$this->data['page_level_footer_plugins'] = '';
		
			// ladda - show loading or progress bar on buttons
			$this->data['page_level_footer_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>
			';
			// datatable
			$this->data['page_level_footer_plugins'].= '
				<script src="'.$assets_url.'/assets/global/scripts/datatable.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
			';
			// bootstrap select
			$this->data['page_level_footer_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
		
		/****************
		 * page scripts inserted at <bottom>
		 */
		$this->data['page_level_scripts'] = '';
		
			// button spinners for ladda
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/ui-buttons-spinners.min.js" type="text/javascript"></script>
			';
			// datatable
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/table-datatables-sales_package_list.js" type="text/javascript"></script>
			';
			// bootstrap select
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
	}
	
	// ----------------------------------------------------------------------
	
}