<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send extends Sales_user_Controller {

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
			redirect('my_account/sales/sales_package', 'location');
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
		$this->load->library('users/wholesale_user_details');
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

		// check for presence of wholesale user_id coming from
		// create sales package by product clicks report
		// or, from options['product_clicks']
		$this->data['ws_user_details'] = $this->wholesale_user_details->initialize(
			array(
				'user_id' => (@$user_id ?: @$this->data['sa_options']['product_clicks'])
			)
		);

		// set some data for the email view
		$this->data['username'] = ucwords(strtolower(trim($this->wholesale_user_details->fname).' '.trim($this->wholesale_user_details->lname)));
		$this->data['email_message'] = $this->sales_package_details->email_message;
		$this->data['access_link'] = 'javascript:;';
		$this->data['items'] = $this->sales_package_details->items;

		// author
		if (
			$this->sales_package_details->sales_user == '1'
			OR $this->sales_package_details->author == 'admin'
		)
		{
			$this->data['author_name'] = 'In-House';
			$this->data['author'] = 'admin'; // admin/system
			$this->data['author_email'] = $this->webspace_details->info_email;
			$this->data['author_id'] = $this->session->admin_id;
			$this->data['sales_user'] = '';
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
			$this->data['sales_user'] = $this->sales_user_details->email;

			// add where clause for logged in sales user
			$where['tbluser_data_wholesale.admin_sales_email'] = $this->sales_user_details->email;
		}

		// get data
		// limits and per page
		$per_page = 300;
		$limit = $per_page > 0 ? array($per_page) : array();

		// active user list
		// where clauses
		$where['tbluser_data_wholesale.is_active'] = '1';
		if ($this->session->admin_sales_loggedin)
		{
			$where['tbluser_data_wholesale.admin_sales_email'] = $this->sales_user_details->email;
		}
		$this->data['users'] = $this->wholesale_users_list->select(
			$where, // where
			array( // order by
				'tbluser_data_wholesale.store_name' => 'asc'
			),
			$limit
		);
		//$this->data['user_id'] = '';
		$this->data['users_per_page'] = $per_page;
		$this->data['total_users'] = $this->wholesale_users_list->count_all;
		$this->data['number_of_pages'] =
			$per_page > 0
			? ceil($this->data['total_users'] / $this->data['users_per_page'])
			: $this->data['total_users']
		;
		// by default
		$this->data['page'] = '1';

		// need to show loading at start
		$this->data['show_loading'] = TRUE;
		$this->data['search_string'] = FALSE;

		// breadcrumbs
		$this->data['page_breadcrumb'] = array(
			'sales_package' => 'Sales Packages',
			'send' => 'Send'
		);

		// set data variables...
		$this->data['role'] = 'sales';
		$this->data['file'] = 'sa_send';
		$this->data['page_title'] = 'Sales Package Sending';
		$this->data['page_description'] = 'Send Sales Packages To Users';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template_my_account/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * Send Sales Package
	 *
	 * @return	void
	 */
	public function sa($id = '')
	{
		// input post data
		/* *
		Array
		(
		    [sales_package_id] => 12
			[send_to] => current_user / new_user / all_users
			[sales_user] => rsbgm@rcpixel.com 			// not available on modify from admin
		    [reference_designer] => basixblacklabel 	// not available on modify from admin
		    [admin_sales_email] => rsbgm@rcpixel.com	// not available on modify from admin
		    [admin_sales_id] => 90 						// not available on modify from admin
		    [access_level] => 2

				//current_user
				[email] => Array
			        (
			            [0] => rsbgm@rcpixel.com
			        )

				//new_user
			    [email] => // new user input field

			// empty for current_user
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

			[emails] => // current user set to email (up to ten and comma separated), empty on new_user
			[search_string] => // used for searching users from current list

			[active_users]
			[inactive_users]
		)
		// */
		if ( ! $this->input->post())
		{
			// set flash data
			$this->session->set_flashdata('error', 'no_input_data');

			// redirect user
			redirect('my_account/sales/sales_package/send/index/'.$id, 'location');
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
			// connect to database
			$DB = $this->load->database('instyle', TRUE);

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
				'reference_designer' => $this->input->post('reference_designer')
			);
			$DB->insert('tbluser_data_wholesale', $post_user);
			$users = array($this->input->post('email'));
		}
		else if ($this->input->post('send_to') === 'all_users')
		{
			// code to send to all users...
		}
		else
		{
			// latest current user email processing
			$users = explode(',', $this->input->post('emails'));
		}

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

			redirect('my_account/sales/sales_package/send/index/'.$id, 'location');
		}

		// set flash data
		$this->session->set_flashdata('success', 'sa_email_sent');

		// redirect user
		redirect('my_account/sales/sales_package/send/index/'.$id, 'location');
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
