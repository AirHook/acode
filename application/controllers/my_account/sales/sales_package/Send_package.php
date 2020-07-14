<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send_package extends Sales_user_Controller {

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
	public function index()
	{
		// let's ensure that there are no sales session for modify
		if (
			$this->session->sa_mod_items
			OR $this->session->sa_mod_des_slug
			OR $this->session->sa_mod_slug_segs
		)
		{
			// first, remove sa modify details
			unset($_SESSION['sa_mod_id']);
			unset($_SESSION['sa_mod_items']);
			unset($_SESSION['sa_mod_slug_segs']);
			unset($_SESSION['sa_mod_options']);
			unset($_SESSION['sa_mod_des_slug']);

			// check for sa create session
			if ( ! $this->session->sa_items)
			{
				// unset all session and send to create page
				unset($_SESSION['sa_id']);
				unset($_SESSION['sa_des_slug']);
				unset($_SESSION['sa_slug_segs']);
				unset($_SESSION['sa_items']);
				unset($_SESSION['sa_name']); // used at view
				unset($_SESSION['sa_email_subject']); // used at view
				unset($_SESSION['sa_email_message']); // used at view
				unset($_SESSION['sa_options']);

				// set session flashdata
				$this->session->set_flashdata('error', 'no_id_passed');

				// redirect user
				redirect('my_account/sales/sales_package/create', 'location');
			}
		}

		/***********
		 * Process the input data
		 */
		//  session data
		/* *
		$_SESSION['date_create'] = $this->input->post('date_create');
		$_SESSION['last_modified'] = $this->input->post('last_modified');
		$_SESSION['sa_name'] = $this->input->post('sales_package_name');
		$_SESSION['sa_email_subject'] = $this->input->post('email_subject');
		$_SESSION['sa_email_message'] = $this->input->post('email_message');
		$_SESSION['sa_options'] = json_encode($this->input->post('options'));
		// other needed items from session
		[sales_package_items] -> sa_items
		// */

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helpers('state_country');
		$this->load->library('products/product_details');
		$this->load->library('users/wholesale_users_list');

		// set some data
		$this->data['date_create'] = $this->session->date_create;
		$this->data['last_modified'] = $this->session->last_modified;
		$this->data['sa_name'] = $this->session->sa_name;
		$this->data['sa_email_subject'] = $this->session->sa_email_subject;
		$this->data['sa_email_message'] = $this->session->sa_email_message;
		$this->data['sa_options'] = json_decode($this->session->sa_options, TRUE);

		$this->data['sa_items'] = json_decode($this->session->sa_items, TRUE);

		// there is post data but we can get the renderred data instead
		$this->data['sales_user'] = $this->sales_user_details->admin_sales_id;
		$this->data['author_name'] = $this->sales_user_details->fname.' '.$this->sales_user_details->lname;
		$this->data['author'] = $this->data['author_name'];
		$this->data['author_email'] = $this->sales_user_details->email;
		$this->data['author_id'] = $this->sales_user_details->admin_sales_id;

		// get user list data
		// limits and per page
		$per_page = 20;
		$limit = $per_page > 0 ? array($per_page) : array();
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
		$this->data['show_loading'] = FALSE;
		$this->data['search'] = FALSE;

		// breadcrumbs
		$this->data['page_breadcrumb'] = array(
			'sales_package' => 'Sales Packages',
			'send' => 'Send'
		);

		// set data variables...
		$this->data['role'] = 'sales';
		$this->data['file'] = 'sa_send_package'; //'sa_send';
		$this->data['page_title'] = 'Sales Package Sending';
		$this->data['page_description'] = 'Send Sales Packages To Users';

		// load views...
		$this->load->view('admin/metronic/template_my_account/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * Send Sales Package
	 *
	 * @return	void
	 */
	public function send()
	{
		// input post data
		/* *
		Array
		(
			[send_to] => current_user/new_user
			[sales_package_id] => 12 // --> not present for sending not saved sales package
			[sales_user] => rsbgm@rcpixel.com
		    [reference_designer] => basixblacklabel
		    [admin_sales_email] => rsbgm@rcpixel.com
		    [admin_sales_id] => 90
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
		)
		// */
		if ( ! $this->input->post())
		{
			// set flash data
			$this->session->set_flashdata('error', 'no_input_post');

			// redirect user
			redirect('my_account/sales/sales_package/create', 'location');
		}

		// load pertinent library/model/helpers
		$this->load->library('email');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('products/product_details');

		/***********
		 * Process Users
		 */
		// doing the sending in this class directly

		// first, we double check if user is valid
		if ( ! $this->wholesale_user_details->initialize(array('email'=>$this->input->post('email'))))
		{
			// set flash data
			$this->session->set_flashdata('error', 'invalid_user');

			// redirect user
			redirect('my_account/sales/sales_package/create', 'location');
		}

		// set emailtracker_id
		$data['emailtracker_id'] =
			$this->wholesale_user_details->user_id
			.'wi0014t'
			.time()
		;

		// lets set the hashed time code here so that the batched hold the same tc only
		$tc = md5(@date('Y-m-d', time()));

		$data['username'] = $this->input->post('store_name');
		$data['email_message'] = $this->input->post('email_message');

		$data['access_link'] = site_url(
			'sales_package/link/index/'
			.'X/' // --> supposedly sales_package_id for saved sa via Sales_package_sending.php
			.$this->wholesale_user_details->user_id.'/'
			.$tc
		);

		$data['items'] = json_decode($this->session->product_clicks_sa_items, TRUE);
		$data['email'] = $this->input->post('email');
		$data['w_prices'] = 'Y';
		$data['w_images'] = 'N';
		$data['linesheets_only'] = 'N';
		$data['sales_username'] = $this->input->post('sales_user');
		$data['sales_ref_designer'] = $this->wholesale_user_details->designer;
		$data['reference_designer'] = $this->wholesale_user_details->reference_designer;
		$data['logo'] = $this->config->item('PROD_IMG_URL').$this->wholesale_user_details->designer_logo;

		$this->email->clear(TRUE);

		$this->email->from($this->input->post('sales_user'), $this->wholesale_user_details->admin_sales_email);
		$this->email->reply_to($this->wholesale_user_details->admin_sales_email);
		//$this->email->cc($this->CI->config->item('info_email'));
		$this->email->bcc($this->config->item('info_email').', '.$this->config->item('dev1_email').', help@shop7thavenue.com');

		$this->email->subject($this->input->post('email_subject'));

		$this->email->to($this->input->post('email'));

		// let's get the message
		$message = $this->load->view('templates/sales_package', $data, TRUE);
		$this->email->message($message);

		if (ENVIRONMENT === 'development')
		{
			// set flashdata
			//$this->CI->session->set_flashdata('success', 'pacakge_sent'); return TRUE;

			/* */
			echo $message;
			echo '<br />';
			echo '<br />';
			echo '<a href="'.site_url('my_account/sales/sales_package').'">continue...</a>';
			$this->session->set_flashdata('success', 'send_product_clicks');
			die();
			// */

			//echo $message;
			//die();
		}
		else
		{
			if ( ! $this->email->send())
			{
				// set flash data
				$this->session->set_flashdata('error', 'sending_unsuccessful');

				// redirect user
				redirect('my_account/sales/sales_package/create', 'location');
			}
		}

		// set flash data
		$this->session->set_flashdata('success', 'send_product_clicks');

		// send user back
		redirect('my_account/sales/sales_package', 'location');
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
