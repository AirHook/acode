<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Csv extends Admin_Controller {

	/**
	 * DB Object
	 *
	 * @var	object
	 */
	protected $DB;

	
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
    }
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();
		
		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_users_list_csv');
		$this->load->library('users/sales_users_list');
		$this->load->library('designers/designers_list', array('with_products'=>TRUE));
		// initialize sales package
		// check if there is a default sales package - set_as_default as '1'
		//$this->load->library('sales_package/sales_package_details');
		//$this->data['default_sales_package'] = $this->sales_package_details->initialize(array('set_as_default'=>'1'));
		
		// get data
		if (
			(@$this->webspace_details->options['site_type'] == 'sat_site'
			OR @$this->webspace_details->options['site_type'] == 'sal_site')
			&& ! $this->config->item('hub_site')
		)
		{
			$params = array(
				'tbluser_data_wholesale.reference_designer'=>
					$this->webspace_details->slug == 'basix-black-label'
					? 'basixblacklabel'
					: $this->webspace_details->slug
			);
		}
		else $params = array();
		$this->data['users'] = $this->wholesale_users_list_csv->select($params);
		
		// get some data
		$this->data['designers'] = $this->designers_list->select();
		$this->data['sales_users'] = $this->sales_users_list->select(array('is_active'=>'1'));
		
		// set data variables...
		$this->data['file'] = 'users_wholesale_csv';
		$this->data['page_title'] = 'Wholesale Users CSV';
		$this->data['page_description'] = 'Editable';
		
		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * PUBLIC - Update data function
	 *
	 * @return	void
	 */
	public function update()
	{
		// insert record
		$post_ary = $this->input->post();
		// set necessary variables
		//$post_ary['account_status'] = '1';
		// process/add some variables
		//if ($post_ary['pword'] == '') unset($post_ary['pword']);
		// unset unneeded variables
		unset($post_ary['user_id']);
		
		// update record
		$this->DB->where('user_id', $this->input->post('user_id'));
		$this->DB->update('tbluser_data_wholesale', $post_ary);
		
		echo 'Update';
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * PUBLIC - Delete data function
	 *
	 * @return	void
	 */
	public function del($user_id)
	{
		// update record
		$this->DB->where('user_id', $user_id);
		$this->DB->delete('tbluser_data_wholesale');
		
		echo 'Deleted';
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
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
			';
			// bootstrap fileinput
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
			';
			// datatable
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
			';
		
		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '
		';
		
		/****************
		 * page js plugins inserted at <bottom>
		 * after core plugins, before global scripts
		 */
		$this->data['page_level_plugins'] = '';
		
			// ladda - show loading or progress bar on buttons
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>
			';
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// bootstrap fileinput
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
			';
			// datatable
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/scripts/datatable.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
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
			// handle bootstrap select - make select class '.bs-select' a boostrap select picker
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
			// handle datatable
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/table-datatables-users_admins_list.js" type="text/javascript"></script>
			';
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/table-datatables-users_wholesale_list_csv.js" type="text/javascript"></script>
			';
	}
	
	// ----------------------------------------------------------------------
	
}