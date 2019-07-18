<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send extends Admin_Controller {

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
	 * Index - Send Sales Package
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();
		
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'campaigns/sales_package');
		}
		
		// load pertinent library/model/helpers
		$this->load->library('products/product_details');	// used to set image paths
		$this->load->library('users/wholesale_users_list');		// to get list of wholesale users
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('sales_package/update_sales_package');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('users[]', 'Select Emails', 'required');
		$this->form_validation->set_message('required', 'Please select at least one email.');
		
		if ($this->form_validation->run() == FALSE)
		{
			// initialize certain properties
			$this->sales_package_details->initialize(array('sales_package_id'=>$id));
			
			// get data
			$this->data['users'] = $this->wholesale_users_list->select(array('tbluser_data_wholesale.is_active'=>'1'));
			
			// set data variables...
			$this->data['file'] = 'sales_package';
			$this->data['page_title'] = 'Sales Package';
			$this->data['page_description'] = 'Send Sales Packages';
			
			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		}
		else
		{
			if ($this->input->post())
			{
				// send the sales package
				$this->load->library('sales_package/sales_package_sending');
				$this->sales_package_sending->initialize($this->input->post());
				
				if ( ! $this->sales_package_sending->send())
				{
					$this->session->set_flashdata('error', 'error_sending_package');
					
					redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/send/index/'.$id, 'location');
				}
			}
			
			// set flash data
			$this->session->set_flashdata('success', 'sales_package_sent');
			
			redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/send/index/'.$id, 'location');
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
		 * page styles plugins inserted at <head>
		 * after global mandatory styles, before theme global styles
		 */
		$this->data['page_level_styles_plugins'] = '';
		
			// ladda - show loading or progress bar on buttons
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
			';
			// bootstrap select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
			';
			// multi-select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/jquery-multi-select/css/multi-select.css" rel="stylesheet" type="text/css" />
			';
		
		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '';
		
		/****************
		 * page js plugins inserted at <bottom>
		 * after core plugins, before global scripts
		 */
		$this->data['page_level_plugins'] = '';
		
			// unveil - simple image lazy loading
			$this->data['page_level_plugins'].= '
				<script src="'.base_url().'assets/custom/js/jquery.unveil.js" type="text/javascript"></script>
			';
			// ladda - show loading or progress bar on buttons
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>
			';
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// multi-select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
			';
		
		/****************
		 * page scripts inserted at <bottom>
		 * after global scripts, before theme layout scripts
		 */
		$this->data['page_level_scripts'] = '';
		
			// button spinners for ladda
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/ui-buttons-spinners.min.js" type="text/javascript"></script>
			';
			// bootstrap select
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
			// handle multiSelect
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/sales_package-send.js" type="text/javascript"></script>
			';
	}
	
	// ----------------------------------------------------------------------
	
}