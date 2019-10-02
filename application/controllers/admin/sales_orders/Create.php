<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Create extends Admin_Controller
{
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();
	}

	// --------------------------------------------------------------------

	/**
	 * Primary method - index
	 *
	 * @return	void
	 */
	function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helper('state_country_helper');
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('form_validation');
		$this->load->library('sales_orders/sales_orders_list');
		$this->load->library('designers/designers_list');
		$this->load->library('users/wholesale_users_list');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('categories/categories_tree');
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');
		$this->load->library('color_list');

		// set validation rules
		$this->form_validation->set_rules('delivery_date', 'Deliver Data', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// let's ensure that there are no admin session for so mod
			if ($this->session->admin_so_mod_size_qty)
			{
				// new po admin access
				unset($_SESSION['admin_so_user_id']); // store or consumer and 0 for manual input
				unset($_SESSION['admin_so_user_cat']); // ws, cs
				unset($_SESSION['admin_so_slug_segs']);
				unset($_SESSION['admin_so_dely_date']);
				unset($_SESSION['admin_so_items']);
				// remove po mod details
				unset($_SESSION['admin_so_mod_so_id']);
				unset($_SESSION['admin_so_mod_so_items']);
			}

			// get color list for the add product not in list
			$this->data['colors'] = $this->color_list->select();

			// get ws user list for the select store button
			// NOTE: consider sales resource login
			$this->data['users'] = $this->wholesale_users_list->select();

			// check for user id session to fill out bill to/ship to address
			if ($this->session->admin_so_user_id)
			{
				if ($this->session->admin_so_user_cat == 'ws')
				{
					$this->data['store_details'] = $this->wholesale_user_details->initialize(
						array(
							'user_id' => $this->session->admin_so_user_id
						)
					);
				}

				if ($this->session->admin_so_user_cat == 'cs')
				{
					$this->data['store_details'] = $this->consumer_user_details->initialize(
						array(
							'user_id' => $this->session->admin_so_user_id
						)
					);
				}
			}

			// admin - either all designers or per designer admin
			// get designer/s for the category tree
			// NOTE: consider sales resource login
			$this->data['designers'] =
				$this->webspace_details->options['site_type'] == 'hub_site'
				? $this->designers_list->select()
				: $this->designers_list->select(
					array(
						'des_id' => $this->webspace_details->des_id
					)
				)
			;

			// get slug segments to show correct thumbs collection
			if ($this->session->admin_so_slug_segs)
			{
				$this->data['slug_segs'] = explode('/', $this->session->admin_so_slug_segs);

				// process the active slug segments
				// getting the last category segment for the product listing
				// getting the first segment as designer
				$category_slug = end($this->data['slug_segs']);
				$category_id = $this->categories_tree->get_id($category_slug);
				$designer_slug = reset($this->data['slug_segs']);

				// set array for where condition of get product list
				// based on above category and designer items
				$where['designer.url_structure'] = $designer_slug;
				$where['tbl_product.categories LIKE'] = '%'.$category_id.'%';

				if (@$where)
				{
					// get the products list
					$params['show_private'] = TRUE; // all items general public (Y) - N for private
					$params['view_status'] = 'ALL'; // ALL items view status (Y, Y1, Y2, N)
					$params['variant_publish'] = 'ALL'; // ALL variant level color publish (view status)
					$params['group_products'] = FALSE; // group per product number or per variant
					// show items even without stocks at all
					$params['with_stocks'] = FALSE;
					$this->load->library('products/products_list', $params);
					$this->data['products'] = $this->products_list->select(
						$where,
						array( // order conditions
							'seque' => 'desc',
							'tbl_product.prod_no' => 'desc'
						)
					);
					$this->data['products_count'] = $this->products_list->row_count;
				}
			}

			// set po number
			$this->data['so_number'] = $this->sales_orders_list->max_so_number() + 1;
			for($c = strlen($this->data['so_number']);$c < 6;$c++)
			{
				$this->data['so_number'] = '0'.$this->data['so_number'];
			}

			/*****
			 * Check for items in session
			 */
			// check for po items
			$this->data['so_items'] =
				$this->session->admin_so_items
				? json_decode($this->session->admin_so_items, TRUE)
				: array()
			;
			// let's count how many items on per size lable basis
			$items_count = 0;
			foreach ($this->data['so_items'] as $item => $options)
			{
				if (is_array($options))
				{
					// count all sizes of the item
					$items_count += count($options);
				}
				else $items_count += 1; // count the item as one
			}
			$this->data['items_count'] = $items_count;

			// set company information
			$this->data['company_name'] = $this->designer_details->company_name ?: $this->webspace_details->name;
			$this->data['company_address1'] = $this->designer_details->address1 ?: $this->webspace_details->address1;
			$this->data['company_address2'] = $this->designer_details->address2 ?: $this->webspace_details->address2;
			$this->data['company_city'] = $this->designer_details->city ?: $this->webspace_details->city;
			$this->data['company_state'] = $this->designer_details->state ?: $this->webspace_details->state;
			$this->data['company_zipcode'] = $this->designer_details->zipcode ?: $this->webspace_details->zipcode;
			$this->data['company_country'] = $this->designer_details->country ?: $this->webspace_details->country;
			$this->data['company_telephone'] = $this->designer_details->phone ?: $this->webspace_details->phone;
			$this->data['company_contact_person'] = $this->designer_details->owner ?: $this->webspace_details->owner;
			$this->data['company_contact_email'] = $this->designer_details->info_email ?: $this->webspace_details->info_email;

			// need to show loading at start
			$this->data['show_loading'] = TRUE;
			$this->data['search_string'] = FALSE;

			$this->data['file'] = 'so_create';
			$this->data['page_title'] = 'Sales Order Create';
			$this->data['page_description'] = 'Create a Sales Order';

			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template5/template', $this->data);
		}
		else
		{
			/***********
			 * Process the input data
			 */
			// input post data
			/*
			Array
			(
			    [so_number] => 000003
			    [so_date] => 2019-10-01
				[author] => 000003
				[c] => 000003
			    [options] => Array
			        (
			            [ref_so_no] => 123456
			            [ref_checkout_no] => 987654
			            [ship_via] => UPS
			            [fob] => China
			            [terms] => Net 15
			        )

			    [delivery_date] => 2019-10-15
			    [subtotal] => 196
			    [remarks] => Remarks
			    [files] =>
			)
			*/

			// capture options array
			$options = $this->input->post('options');

			// to ensure that no doulbe entry on new so# when 2 users
			// coincidentally creates SO at about the exact same time
			$so_number = $this->sales_orders_list->max_so_number() + 1;
			for($c = strlen($so_number);$c < 6;$c++)
			{
				$so_number = '0'.$so_number;
			}

			// set post_aru
			$post_ary['sales_order_number'] = $so_number;
			$post_ary['rev'] = '0';
			$post_ary['sales_order_date'] = strtotime($this->input->post('so_date'));
			$post_ary['due_date'] = strtotime($this->input->post('delivery_date'));
			$post_ary['author'] = $this->input->post('author'); // author
			$post_ary['c'] = $this->input->post('c'); // 1-admin,2-sales
			$post_ary['user_id'] = $this->session->admin_so_user_id ?: 0; // 0 for manual input
			$post_ary['user_cat'] = $this->session->admin_so_user_cat ?: 0; // 0 for manual input ws/cs
			$post_ary['status'] = '1'; // set to pending approval
			$post_ary['options'] = json_encode(array_filter($options)); // remove empty options
			$post_ary['remarks'] = $this->input->post('remarks');

			// set items in the following format
			/* *
			array(
				'<prod_no>_<color_code>' = array(
					'discount' => '10',
					'<size names>' => '<qty',
					...,
					...
					// sizes not indicated defaults to zero
				)
			)
			// */

			// set so items
			$post_ary['items'] = $this->session->admin_so_items;

			/***********
			 * Save it to the database
			 */
			// connect to database
			$DB = $this->load->database('instyle', TRUE);
			$query = $DB->insert('sales_orders', $post_ary);
			$this_so_id = $DB->insert_id();

			// once done, we now remove session items
			// new so admin access
			unset($_SESSION['admin_so_user_id']); // store or consumer and 0 for manual input
			unset($_SESSION['admin_so_user_cat']); // ws, cs
			unset($_SESSION['admin_so_slug_segs']);
			unset($_SESSION['admin_so_dely_date']);
			unset($_SESSION['admin_so_items']);
			// remove po mod details
			unset($_SESSION['admin_so_mod_so_id']);
			unset($_SESSION['admin_so_mod_so_items']);

			/***********
			 * Send po email confirmation with PDF attachment
			 */
			$this->load->library('sales_orders/sales_order_sending');
	 		$this->sales_order_sending->send($this_so_id, 'admin');

			// set flash data
			$this->session->set_flashdata('success', 'add');

			// redirect user
			redirect('admin/sales_orders/details/index/'.$this_so_id, 'location');
		}
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
		$this->data['page_level_styles'] = '';

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
			// bootbox
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/admin-so-components.js" type="text/javascript"></script>
			';
	}

	// --------------------------------------------------------------------

}
