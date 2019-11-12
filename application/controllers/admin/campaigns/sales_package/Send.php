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
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'campaigns/sales_package');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helpers('state_country');
		$this->load->library('sales_package/sales_package_list');
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('products/product_details');
		$this->load->library('designers/designers_list');
		$this->load->library('categories/categories_tree');
		$this->load->library('users/wholesale_users_list');
		$this->load->library('users/sales_user_details');
		$this->load->library('color_list');
		$this->load->library('form_validation');

		// initialize sales package properties
		$this->data['sa_details'] = $this->sales_package_details->initialize(
			array(
				'sales_package_id'=>$id
			)
		);

		// disect some information from sales package
		$this->data['sa_items'] = $this->sales_package_details->items;
		$this->data['sa_options'] = $this->sales_package_details->options;

		// author
		if ($this->sales_package_details->sales_user == '1')
		{
			$this->data['author_name'] = $this->webspace_details->name;
			$this->data['author'] = 'admin'; // admin/system
			$this->data['author_email'] = $this->webspace_details->info_email;
			$this->data['author_id'] = $this->session->admin_id;
		}
		else
		{
			$this->sales_user_details->initialize(
				array(
					'admin_sales_id' => $this->sales_package_details->sales_user
				)
			);

			$this->data['author_name'] = $this->sales_user_details->fname.' '.$this->sales_user_details->lname;
			$this->data['author'] = $this->data['author_name'];
			$this->data['author_email'] = $this->sales_user_details->email;
			$this->data['author_id'] = $this->sales_user_details->admin_sales_id;
		}

		// get data
		if (@$user_id)
		{
			$this->data['users'] = $this->wholesale_users_list->select(
				array( // where
					'tbluser_data_wholesale.user_id' => $user_id
				),
				array( // order by
					'tbluser_data_wholesale.store_name' => 'asc'
				)
			);
			$this->data['user_id'] = $user_id;
		}
		else
		{
			$this->data['users'] = $this->wholesale_users_list->select(
				array( // where
					'tbluser_data_wholesale.is_active' => '1'
				),
				array( // order by
					'tbluser_data_wholesale.store_name' => 'asc'
				)
			);
			$this->data['user_id'] = '';
		}
		$this->data['total_users'] = $this->wholesale_users_list->row_count;
		$this->data['users_per_page'] = 20;
		$this->data['end_cur_users'] = floor($this->data['total_users'] / $this->data['users_per_page']) + 1;

		// need to show loading at start
		$this->data['show_loading'] = FALSE;
		$this->data['search_string'] = FALSE;

		// set data variables...
		$this->data['file'] = 'sa_send';
		$this->data['page_title'] = 'Sales Package Sending';
		$this->data['page_description'] = 'Send Sales Packages To Users';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template5/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * Send Sales Package
	 *
	 * @return	void
	 */
	public function sa($id = '')
	{
		//echo '<pre>';
		//print_r($this->input->post());
		//die();

		// input post data
		/* *
		Array
		(
		    [sales_package_id] => 12
		    [send_to] => current_user
		    [reference_designer] =>
		    [admin_sales_email] =>
		    [admin_sales_id] =>
		    [email] => Array
		        (
		            [0] => rsbgm@rcpixel.com
		        )

		    [firstname] =>
		    [lastname] =>
		    [store_name] =>
		    [fed_tax_id] =>
		    [telephone] =>
		    [address1] =>
		    [address2] =>
		    [city] =>
		    [state] =>
		    [country] =>
		    [zipcode] =>
		)
		// */
		if ( ! $this->input->post())
		{
			// set flash data
			$this->session->set_flashdata('error', 'no_input_data');

			// redirect user
			redirect('admin/campaigns/sales_package/send/index/'.$id, 'location');
		}

		// load pertinent library/model/helpers
		$this->load->library('sales_package/sales_package_details');
		$this->sales_package_details->initialize(
			array(
				'sales_package_id'=>$id
			)
		);

		/***********
		 * Process Users
		 */
		if ($this->input->post('send_to') === 'new_user')
		{
			// add user to wholesale list and set user array
			$post_user = array(
				'email' => $this->input->post('email'),
				'pword' => 'shopseven2019', // set default
				'firstname' => $this->input->post('firstname'),
				'lastname' => $this->input->post('lastname'),
				'store_name' => $this->input->post('store_name'),
				'fed_tax_id' => $this->input->post('fed_tax_id'),
				'telephone' => $this->input->post('telephone'),
				'address1' => $this->input->post('address1'),
				'address2' => $this->input->post('address2'),
				'city' => $this->input->post('city'),
				'state' => $this->input->post('state'),
				'country' => $this->input->post('country'),
				'zipcode' => $this->input->post('zipcode'),
				'create_date' => date('Y-m-d', time()),
				'admin_sales_id' => $this->input->post('admin_sales_id'),
				'admin_sales_email' => $this->input->post('admin_sales_email'),
				'reference_designer' => $this->input->post('ereference_designermail')
			);
			$this->DB->insert('tbluser_data_wholesale', $post_user);
			$users = array($this->input->post('email'));
		}
		else $users = $this->input->post('email');

		// send the sales package
		$this->load->library('sales_package/sales_package_sending');
		$this->sales_package_sending->initialize(
			array(
				'sales_package_id' => $id,
				'w_prices' => $this->sales_package_details->options['w_prices'],
				'w_images' => $this->sales_package_details->options['w_images'],
				'linesheets_only' => $this->sales_package_details->options['linesheets_only'],
				'users' => $users
			)
		);

		if ( ! $this->sales_package_sending->send())
		{
			$this->session->set_flashdata('error', 'error_sending_package');

			redirect('admin/campaigns/sales_package/send/index/'.$id, 'location');
		}

		// set data variables...
		$this->data['file'] = 'sa_send_success';
		$this->data['page_title'] = 'Sales Package Sending';
		$this->data['page_description'] = 'Send Sales Packages To Users';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template5/template', $this->data);
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
			// datepicker & date-time-pickers
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
			';
			// summernote wysiwyg
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
			';
			// fancybox
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" media="screen" />
				<link href="'.$assets_url.'/assets/global/plugins/fancybox/source/helpers/jquery.fancybox-buttons.css" rel="stylesheet" type="text/css" media="screen" />
			';
			// toaster notification
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '
		';

		/****************
		 * page plugins scripts inserted at <bottom>
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
			// datepicker & date-time-pickers
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
			';
			// unveil - lazy script for images
			$this->data['page_level_plugins'].= '
				<script src="'.base_url().'assets/custom/js/jquery.unveil.js" type="text/javascript"></script>
			';
			// summernote wysiwyg
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
			';
			// fancybox
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/fancybox/source/helpers/jquery.fancybox-buttons.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/fancybox/source/helpers/jquery.fancybox-media.js" type="text/javascript"></script>
			';
			// jquery loading
			$this->data['page_level_plugins'].= '
			<script src="'.base_url().'assets/custom/jscript/jquery-loading/jquery.loading.min.js" type="text/javascript"></script>
			';
			// toaster notification
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
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
			// handle form validation, datepickers, and scripts
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/admin-sa_send-components.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
