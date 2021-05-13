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
	public function index($id = '', $user_id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/campaigns/lookbook', 'location');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helpers('state_country');
		$this->load->library('sales_package/sales_package_list');
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('lookbook/lookbook_details');
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');
		$this->load->library('designers/designers_list');
		$this->load->library('categories/categories_tree');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/wholesale_users_list');
		$this->load->library('users/sales_user_details');
		$this->load->library('color_list');
		$this->load->library('form_validation');

		// initialize sales package properties
		$this->data['sa_details'] = $this->lookbook_details->initialize(
			array(
				'lookbook_id'=>$id
			)
		);

		if ( ! $this->data['sa_details'])
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/campaigns/lookbook', 'location');
		}

		// disect some information from sales package
		$this->data['lb_items'] = $this->data['sa_details']->items;
		$this->data['sa_items_count'] = count($this->data['lb_items']);
		$this->data['lb_options'] = $this->data['sa_details']->options;

		// check for presence of wholesale user_id coming from
		// create sales package by product clicks report
		// or, from options['product_clicks']
		$this->data['ws_user_details'] = $this->wholesale_user_details->initialize(
			array(
				'user_id' => ($user_id ?: @$this->data['sa_options']['product_clicks'])
			)
		);

		// set some data for the email view
		//$this->data['username'] = ucwords(strtolower(trim($this->wholesale_user_details->fname).' '.trim($this->wholesale_user_details->lname)));
		$this->data['email_message'] = $this->lookbook_details->email_message;
		$this->data['access_link'] = 'javascript:;';
		$this->data['items'] = $this->lookbook_details->items;

		// author
		if ($this->lookbook_details->user_role == 'admin')
		{
			$this->data['author_name'] = $this->lookbook_details->user_name; // usually 'In-House' being admin
			$this->data['author'] = $this->lookbook_details->user_role; // usually 'admin' being admin (or 'sales')
			$this->data['author_email'] = $this->lookbook_details->user_email;
			$this->data['author_id'] = $this->lookbook_details->user_id;

			$this->data['sales_user'] = '';
		}
		else
		{
			$this->sales_user_details->initialize(
				array(
					'admin_sales_id' => $this->lookbook_details->user_id
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

		// other data params
		$this->data['logo'] =
			$this->lookbook_details->designer_logo
			? $this->config->item('PROD_IMG_URL').$this->lookbook_details->designer_logo
			: $this->config->item('PROD_IMG_URL').'assets/images/logo/logo-'.$this->lookbook_details->designer.'.png';
		;

		// get data
		// limits and per page example: 300
		$per_page = 0;
		$limit = $per_page > 0 ? array($per_page) : array();

		// active user list
		// where clauses
		$where['tbluser_data_wholesale.is_active'] = '1';
		if ($this->session->admin_sales_loggedin)
		{
			$where['tbluser_data_wholesale.admin_sales_email'] = $this->sales_user_details->email;
		}
		if ($this->webspace_details->options['site_type'] != 'hub_site')
		{
			$where['tbluser_data_wholesale.reference_designer'] = $this->webspace_details->slug;
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
		$this->data['search_string'] = FALSE;

		// breadcrumbs
		$this->data['page_breadcrumb'] = array(
			'sales_package' => 'Lookbook',
			'send' => 'Send'
		);

		// set data variables...
		$this->data['role'] = 'admin';
		$this->data['file'] = 'sa_lookbook_send'; // 'sa_send';
		$this->data['page_title'] = 'Lookbook Sending';
		$this->data['page_description'] = 'Send Lookbook To Users';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
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
		echo '<pre>';
		print_r($this->input->post());
		die();
		Array
		(
		    [lookbook_id] => 1
		    [send_to] => current_user
		    [sales_user] =>
		    [reference_designer] => instylenewyork
		    [admin_sales_email] => help@instylenewyork.com
		    [admin_sales_id] => 0
		    [access_level] => 2

				//current_user
				[email] => Array
					(
						[0] => rsbgm@rcpixel.com
					)

				//new_user
				[email] => // new user input field

				//sent to a friedn
				[email_a_friend] => rsbgm@rcpixel.com

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
		    [emails] => joe@innerconcept.com // current user set to email (up to ten and comma separated), empty on new_user
		    [search_string] => // used for searching users from current list
		    [active_users] => 1
		)
		// */
		if ( ! $this->input->post())
		{
			// set flash data
			$this->session->set_flashdata('error', 'no_input_data');

			// redirect user
			redirect('admin/campaigns/lookbook/modify/index/'.$id, 'location');
		}

		// load pertinent library/model/helpers
		$this->load->library('lookbook/lookbook_details');
		$this->load->library('email');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');
		$this->load->library('categories/categories_tree');
		$this->load->library('lookbook/m_pdf_lookbook');

		// get lookbook details
		$lookbook_details = $this->lookbook_details->initialize(
			array(
				'lookbook_id'=>$id
			)
		);

		/***********
		 * Process Users
		 */
		// doing the sending in this class directly
		// capture the email input first
		$emails = $this->input->post('email');

		if ($this->input->post('send_to') === 'new_user')
		{
			// add new user
			$post_ary = $this->input->post();
			unset($post_ary['send_to']);
			unset($post_ary['lookbook_id']);
			unset($post_ary['sales_user']);
			unset($post_ary['emails']);
			unset($post_ary['search_string']);

			$post_ary['create_date'] = date('Y-m-d', time());
			$post_ary['active_date'] = date('Y-m-d', time());
			$post_ary['is_active'] = '1';
			$post_ary['pword'] = 'shop72021';

			// add user to mailgun list
			// no need to validate email as these are stores
			// force add users to mailgun
			// use input fields to capture any updates
			if (ENVIRONMENT != 'development')
			{
				switch ($this->input->post('reference_designer'))
				{
					case 'tempoparis':
						$list_name = 'ws_tempo@mg.shop7thavenue.com';
						$designer_name = 'Tempo Paris';
					break;
					case 'basixblacklabel':
						$list_name = 'wholesale_users@mg.shop7thavenue.com';
						$designer_name = 'Basix Black Label';
					break;
					case 'chaarmfurs':
						$list_name = 'wholesale_users@mg.shop7thavenue.com';
						$designer_name = 'Chaarm Furs';
					break;
					case 'issueny':
						$list_name = 'wholesale_users@mg.shop7thavenue.com';
						$designer_name = 'Issue New York';
					break;
					default:
						$list_name = 'wholesale_users@mg.shop7thavenue.com';
						$designer_name = $this->webspace_details->name;
				}

				if ($list_name)
				{
					$params['address'] = $this->input->post('email');
					$params['fname'] = $this->input->post('firstname');
					$params['lname'] = $this->input->post('lastname');
					$params_vars = array(
						'designer' => $designer_name,
						'designer_slug' => $this->input->post('reference_designer'),
						'store_name' => $this->input->post('store_name')
					);
					$params['vars'] = json_encode($params_vars);
					$params['description'] = 'Wholesale User';
					$params['list_name'] = $list_name;
					$this->load->library('mailgun/list_member_add', $params);
					$res = $this->list_member_add->add();
					$this->list_member_add->clear();
				}
			}

			// connect to database
			$DB = $this->load->database('instyle', TRUE);
			$query = $DB->insert('tbluser_data_wholesale', $post_ary);
			$insert_id = $DB->insert_id();
		}
		else if ($this->input->post('send_to') === 'a_friend')
		{
			// code to send to a friend
			// currently nothing to process when sending to a friend
			// overrides the initial capturing of the email input above
			$emails = $this->input->post('email_a_friend');
		}
		else if ($this->input->post('send_to') === 'all_users')
		{
			// code to send to all users...
		}

		// get options
		$lb_options = $lookbook_details->options;

		// if new user, user is already added from above code
		// if current user, user is current...
		$email_ary = is_array($emails) ? $emails : array($emails);

		/**
		// create the lookbook pdf
		*/
		$lookbook_temp_dir = 'uploads/lookbook_temp/';
		$items_array = $lookbook_details->items;
		$i = 2;
		$html = '';
		foreach ($items_array as $item => $options)
		{
			// get product details
			$exp = explode('_', $item);
			$product = $this->product_details->initialize(
				array(
					'tbl_product.prod_no' => $exp[0],
					'color_code' => $exp[1]
				)
			);

			if ( ! $product)
			{
				// a catch all system
				continue;
			}

			// some data
			$style_no = $item;
			$prod_no = $exp[0];
			$color_code = $exp[1];
			$color_name = $this->product_details->get_color_name($color_code);
			$price =
				@$lb_options['w_prices'] == 'Y'
				? (@$options[2] ?: $product->wholesale_price)
				: ''
			;
			$category = $this->categories_tree->get_name($options[1]);

			// get available sizes
			$size_names = $this->size_names->get_size_names($product->size_mode);
			$sizes = array();
			foreach ($size_names as $size_label => $s)
			{
				// do not show zero stock sizes
				if ($product->$size_label === '0') continue;

				// create available sizes with stocks array
				$sizes[$s] = $product->$size_label;
			}
			$available_sizes =
				@$lb_options['w_sizes'] == 'Y'
				? $sizes
				: array()
			;

			/**
			* get logo and set it on lookbook_temp folder
			*/
			if ( ! file_exists($product->designer_logo))
			{
				// get default logo folder
				$source_designer_logo = 'assets/images/logo/logo-'.$product->designer_slug.'.png';
				$logo_image_file = 'logo-'.$product->designer_slug.'.png';
			}
			else
			{
				$source_designer_logo = $product->designer_logo;
				$exp1 = explode('/', $source_designer_logo);
				$logo_image_file = $exp1[count($exp1) - 1];
			}

			$config['image_library']	= 'gd2';
			$config['quality']			= '100%';
			$config['source_image'] 	= $source_designer_logo;
			$config['new_image'] 		= $lookbook_temp_dir.$logo_image_file;
			$config['maintain_ratio'] 	= TRUE;
			$config['width']         	= 292;
			$config['height']       	= 47;
			$this->load->library('image_lib');
			$this->image_lib->initialize($config);
			if ( ! $this->image_lib->resize())
			{
				// nothing more to do...
				echo 'ERROR: Logo regeneration error.<br />';
				echo $source_designer_logo;
				echo $this->image_lib->display_errors();
				exit;
			}
			$this->image_lib->clear();

			/**
			* create lookbook
			*/
			$this->load->helper('create_linesheet');
			$create = create_lookbook(
				$i,
				$prod_no,
				$color_name,
				$price,
				$lookbook_temp_dir,
				$product->media_path,
				$product->media_name,
				$lookbook_temp_dir.$logo_image_file,
				$category,
				$available_sizes
			);

			if ( ! $create)
			{
				// nothing more to do...
				echo 'Error in creating lookbook.';
				exit;
			}
			// */

			if ($i > 2) $html.= '<pagebreak>';

			$html.= '<img src="'.base_url().$create.'" />';

			$i = $i + 2;
		}

		// generate pdf
		$this->m_pdf_lookbook->pdf->WriteHTML($html);

		// set filename and file path
		$pdf_file_path = 'assets/pdf/pdf_lookbook.pdf';

		// download it "D" - download, "I" - inline, "F" - local file, "S" - string
		//$this->m_pdf_lookbook->pdf->Output(); // output to browser
		$this->m_pdf_lookbook->pdf->Output($pdf_file_path, "F");

		if (ENVIRONMENT === 'development')
		{
			// The location of the PDF file
			// on the server
			$filename = $pdf_file_path;

			// Header content type
			header("Content-type: application/pdf");

			header("Content-Length: " . filesize($filename));

			// Send the file to the browser.
			readfile($filename);

			die();
		}

		/**
		// send the email
		*/
		foreach ($email_ary as $email)
		{
			if ($this->input->post('send_to') === 'a_friend')
			{
				$data['username'] = '';
			}
			else
			{
				$this->wholesale_user_details->initialize(array('email' => $email));

				// set emailtracker_id
				$data['emailtracker_id'] =
					$this->wholesale_user_details->user_id
					.'wi0014t'
					.time()
				;

				// lets set the hashed time code here so that the batched hold the same tc only
				//$tc = md5(@date('Y-m-d', time()));

				$data['username'] = $this->input->post('store_name') ?: $this->wholesale_user_details->store_name;
			}

			$data['email_message'] = $lookbook_details->email_message;

			// access link
			/* *
			$data['access_link'] = site_url(
				'sales_package/link/index/'
				.'X/' // --> supposedly sales_package_id for saved sa via Sales_package_sending.php
				.$this->wholesale_user_details->user_id.'/' // --> using user id as this is for wholesale user
				.$tc
			);
			// */

			// since this is not a saved sales package, we use $items_csv and append to url as query string
			$data['items'] = $lookbook_details->items;
			$data['access_link'].= '?items_csv='.implode(',', $data['items']);

			// check for sa options
			$lb_options = $lookbook_details->options;

			$email_message = '
				<img src="'.base_url().'link/open.html?id='.@$emailtracker_id.'" alt="" />
				<br /><br />'
				.($data['username'] ? 'Dear '.$data['username'] : 'Hello')
				.',
				<br /><br />
				'.$data['email_message'].'<br />
				<br /><br />
				<br />
			';

			$this->email->clear(TRUE);

			if ($this->webspace_details->options['site_type'] == 'hub_site')
			{
				$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);
				$this->email->reply_to($this->webspace_details->info_email);

				$cc_email = $this->webspace_details->info_email;
			}
			else
			{
				$this->email->from($lookbook_details->user_email, $lookbook_details->user_name);
				$this->email->reply_to($lookbook_details->user_email);

				$cc_email = $this->webspace_details->info_email.','.$lookbook_details->user_email;
			}

			/* *
			$this->email->cc($cc_email);
			$this->email->bcc($this->config->item('dev1_email'));
			// */

			$this->email->subject($lookbook_details->email_subject);

			$this->email->to($email);

			// attach lookbook
			$this->email->attach($pdf_file_path);

			// set message
			$this->email->message($email_message);

			if (ENVIRONMENT === 'development')
			{
				// set flashdata
				//$this->CI->session->set_flashdata('success', 'pacakge_sent'); return TRUE;

				/* */
				echo $message;
				echo '<br />';
				echo '<br />';
				echo '<a href="'.site_url('admin/campaigns/lookbook').'">continue...</a>';
				$this->session->set_flashdata('success', 'send_product_clicks');
				echo '<br />';
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

					// send user back
					redirect('admin/campaigns/lookbook/send/index/'.$id, 'location');
				}
			}
		}

		// set flash data
		$this->session->set_flashdata('success', 'sa_email_sent');

		// send user back
		redirect('admin/campaigns/lookbook/send/index/'.$id, 'location');
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/admin-lb_send-components.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
