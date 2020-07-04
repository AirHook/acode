<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Sales_user_Controller {

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
	 * Index - Edit User
	 *
	 * Edit selected user
	 *
	 * @return	void
	 */
	public function index()
	{

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('users/sales_user_details');
		$this->load->library('designers/designers_list');

        // initialize properties
        if ( ! $this->sales_user_details->initialize(array('admin_sales_id' => $this->sales_user_details->admin_sales_id)))
        {
            // set flash data
            $this->session->set_flashdata('error', 'user_not_found');

            redirect($this->config->slash_item('admin_folder').'users/sales');
        }

        if ( ! $this->session->flashdata('clear_recent_sales'))
        {
            // update recent list for admin users edited
            $this->webspace_details->update_recent_users(array(
                'user_type' => 'sales_users',
                'user_id' => $this->sales_user_details->admin_sales_id,
                'user_name' => $this->sales_user_details->fname.' '.$this->sales_user_details->lname
            ));
        }

        // some pertinent data
        if (@$this->webspace_details->options['site_type'] != 'hub_site')
        {
            $this->data['designers'] = $this->designers_list->select(
                array(
                    'designer.url_structure' => @$this->webspace_details->slug
                )
            );
        }
        else $this->data['designers'] = $this->designers_list->select();

        // need to show loading at start
        $this->data['show_loading'] = FALSE;
        $this->data['search'] = FALSE;

        // breadcrumbs
        $this->data['page_breadcrumb'] = array(
            'profile' => 'Profile'
        );

        // set data variables...
        $this->data['role'] = 'sales';
        $this->data['file'] = 'users_sales_profile';
        $this->data['page_title'] = 'Sales User Profile';
        $this->data['page_description'] = 'User Details';

        // load views...
        $this->load->view('admin/metronic/template_my_account/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Creaet Plugin Scripts and CSS for the page
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
			// form validation
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/form-validation-users_sales_edit.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
