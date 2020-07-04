<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send_product_clicks extends Admin_Controller {

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
		if ( ! $this->input->get('date') OR ! $this->input->get('user'))
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'campaigns/sales_package', 'location');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');

		// connect to database for use by model
		$DB = $this->load->database('instyle', TRUE);

		// get user details manually
		$DB->query('SET SESSION group_concat_max_len = 1000000');
		$DB->select('GROUP_CONCAT(tbl_login_detail_wholesale.logindata) AS logindata');
		$DB->select('tbluser_data_wholesale.*');
		$DB->select('
			tbladmin_sales.admin_sales_id,
			tbladmin_sales.admin_sales_user,
			tbladmin_sales.admin_sales_lname
		');
		$DB->from('tbl_login_detail_wholesale');
		$DB->join(
			'tbluser_data_wholesale',
			'tbluser_data_wholesale.email = tbl_login_detail_wholesale.email',
			'left'
		);
		$DB->join(
			'tbladmin_sales',
			'tbladmin_sales.admin_sales_email = tbluser_data_wholesale.admin_sales_email',
			'left'
		);
		$DB->where('tbl_login_detail_wholesale.create_date', $this->input->get('date'));
		$DB->where('tbl_login_detail_wholesale.email', $this->input->get('user'));
		$q1 = $DB->get();

		//echo $DB->last_query(); die();

		$user_details = $q1->row();

		// set some data
		$this->data['date'] = $this->input->get('date');
		$this->data['ws_user_details'] = $user_details;
		$this->data['sales_user'] = ucwords(strtolower($user_details->admin_sales_user.' '.$user_details->admin_sales_lname));

		// sample combined & not combined product cliks array:
		/* *
		Array
		{
			[product_clicks] => Array
		        (
		            [5706P] => Array
		                (
		                    [0] => 1
		                    [1] => 1
		                )

		            [5565N] => Array
		                (
		                    [0] => 1
		                    [1] => 1
		                )

		            [1384N] => 1
		            [1154V] => 1
		            [4444P] => 1
		            [2546K] => 1
		            [8141F] => 1
		            [8488A] => 1
		            [1381A] => 1
		        )
		}
		// */

		// decode and combine $logindata into one array
		// usual contents of $logindata are: 'active_time', 'page_visist', 'product_clicks'
		// then, get the 'product_clicks'
		$json_str = str_replace('},{', '}|{', $user_details->logindata);
		$json_arys = explode('|', $json_str);
		$logindata = array();
		foreach ($json_arys as $json)
		{
			// merge all arrays within the json data
			$temp_ary = json_decode($json, TRUE);
			$logindata = is_array($temp_ary) ? array_merge_recursive($logindata, $temp_ary) : array_merge_recursive($logindata);
		}

		// set 'product_clicks' array
		$this->data['sa_items'] = array();
		if ( ! empty(@$logindata['product_clicks']))
		{
			foreach ($logindata['product_clicks'] as $key => $val)
			{
				if ( ! is_int($key) OR ! in_array($key, $this->data['sa_items']))
				{
					array_push($this->data['sa_items'], $key);
				}
			}
		}

		// this usualy doesn't happen but if product clicks array is empty...
		if (empty($this->data['sa_items']))
		{
			echo 'Something went wrong.<br />Sorry for the inconvenience.<br />Checkout our website instead <a href="'.site_url().'">here</a>.';
			exit;
		}

		// save sa_items into session for the send process
		$this->session->product_clicks_sa_items = json_encode($this->data['sa_items']);

		// set data variables...
		$this->data['file'] = 'sa_send_product_clicks';
		$this->data['page_title'] = 'Sales Package Sending';
		$this->data['page_description'] = 'Send Sales Packages To Users';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * Send Sales Package
	 *
	 * @return	void
	 */
	public function send()
	{
		echo '<pre>';
		print_r($this->input->post());
		die();
		// input post data
		/* *
		Array
		(
		    [date] => 2020-05-24
			[sales_user] => Rey Millares
		    [store_name] => Rey Store
		    [email_subject] => Products of Interests
		    [email_message] => Here are designs that are now available. Review them for your store.
		    [files] =>
		    [email] => rsbgm@rcpixel.com
		)
		// */
		if ( ! $this->input->post())
		{
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/campaigns/sales_package', 'location');
		}

		// load pertinent library/model/helpers
		$this->load->library('email');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('products/product_details');

		/***********
		 * Process Users
		 */
		// only one email
		// and doing the sending in this class directly

		// first, we double check if user is valid
		if ( ! $this->wholesale_user_details->initialize(array('email'=>$this->input->post('email'))))
		{
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/campaigns/sales_package', 'location');
		}

		// lets set the hashed time code here so that the batched hold the same tc only
		$tc = md5(@date('Y-m-d', time()));

		$data['username'] = $this->input->post('store_name');
		$data['email_message'] = $this->input->post('email_message');

		$data['access_link'] = site_url('shop/'.$this->wholesale_user_details->reference_designer);

		$data['items'] = json_decode($this->session->product_clicks_sa_items, TRUE);
		$data['email'] = $this->input->post('email');
		$data['w_prices'] = 'Y';
		$data['w_images'] = 'N';
		$data['linesheets_only'] = 'N';
		$data['sales_username'] = $this->input->post('sales_user');
		$data['sales_ref_designer'] = $this->wholesale_user_details->reference_designer;

		$data['access_link'] = site_url(
			'sales_package/product_clicks/index/'
			.$this->input->post('date').'/'
			.$this->wholesale_user_details->user_id.'/'
			.$tc
		);

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
			echo '<a href="'.site_url('admin/campaigns/sales_package').'">continue...</a>';
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
				$this->session->set_flashdata('error', 'no_id_passed');

				// redirect user
				redirect('admin/campaigns/sales_package', 'location');
			}
		}

		// set flash data
		$this->session->set_flashdata('success', 'send_product_clicks');

		// send user back
		redirect('admin/campaigns/sales_package', 'location');
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
