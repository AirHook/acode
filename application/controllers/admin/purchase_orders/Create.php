<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Create PO Class
 *
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
		$this->load->library('form_validation');
		$this->load->library('users/vendor_users_list');
		$this->load->library('users/wholesale_users_list');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('categories/categories_tree');
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');
		$this->load->library('color_list');
		$this->load->library('purchase_orders/purchase_orders_list');

		// set validation rules
		$this->form_validation->set_rules('start_date', 'Deliver Data', 'trim|required');
		$this->form_validation->set_rules('cancel_date', 'Deliver Data', 'trim|required');
		$this->form_validation->set_rules('delivery_date', 'Deliver Data', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// get color list
			// used for "add product not in list"
			$this->data['colors'] = $this->color_list->select();

			// let's ensure that there are no admin session for po mod
			if ($this->session->admin_po_mod_items)
			{
				// new po admin access
				unset($_SESSION['admin_po_vendor_id']);
				unset($_SESSION['admin_po_des_url_structure']);
				unset($_SESSION['admin_po_items']);
				unset($_SESSION['admin_po_size_qty']);
				unset($_SESSION['admin_po_store_id']);
				unset($_SESSION['admin_po_edit_vendor_price']);
				unset($_SESSION['admin_po_slug_segs']);
				// remove po mod details
				unset($_SESSION['admin_po_mod_po_id']);
				unset($_SESSION['admin_po_mod_items']);
				unset($_SESSION['admin_po_mod_size_qty']);
				unset($_SESSION['admin_po_mod_edit_vendor_price']);
			}

			// set po number
			$this->data['po_number'] = $this->purchase_orders_list->max_po_number() + 1;
			for($c = strlen($this->data['po_number']);$c < 6;$c++)
			{
				$this->data['po_number'] = '0'.$this->data['po_number'];
			}

			// step 1, get list for select vendor
			$this->data['vendors'] = $this->vendor_users_list->select();

			// designer details iteration
			// if no designer session present, company details defaults to webspace details
			// when session is present, get designer details and use it for the company details
			// populating both company info and ship to info
			// this also serves as reference in getting category tree information
			if ($this->session->admin_po_des_url_structure)
			{
				$this->data['designer_details'] = $this->designer_details->initialize(
					array(
						'url_structure' => $this->session->admin_po_des_url_structure
					)
				);
				$this->data['des_id'] = $this->designer_details->des_id;
			}

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

			// get some data
			if ($this->session->admin_po_des_url_structure)
			{
				// get the designer category tree
				$this->data['des_subcats'] = $this->categories_tree->treelist(
					array(
						'd_url_structure' => $this->data['designer_details']->url_structure,
						'vendor_id' => $this->session->admin_po_vendor_id,
						'with_products' => TRUE
					)
				);
				$this->data['row_count'] = $this->categories_tree->row_count;
				$this->data['max_level'] = $this->categories_tree->max_category_level;
			}

			// stores list and store details iteration
			// in the beginning, its simply get all list
			// on refresh of existing session, check for admin_po_store_id session
			// and admin_po_des_url_structure session
			// stores list will now be based on reference designer session
			// and store details populating ship to is based on store id session
			if ($this->session->admin_po_des_url_structure)
			{
				$this->data['stores'] = $this->wholesale_users_list->select(
					array(
						'reference_designer' => $this->session->admin_po_des_url_structure
					)
				);
			}
			else
			{
				$this->data['stores'] = $this->wholesale_users_list->select();
			}
			if ($this->session->admin_po_store_id)
			{
				$this->data['store_details'] = $this->wholesale_user_details->initialize(
					array(
						'user_id' => $this->session->admin_po_store_id
					)
				);
			}

			// set author info for the summary view
			$this->data['author_name'] = $this->admin_user_details->fname.' '.$this->admin_user_details->lname;
			$this->data['author_email'] = $this->admin_user_details->email;

			/*****
			 * Check for items in session
			 */
			// check for po items
			$this->data['po_items'] =
				$this->session->admin_po_items
				? json_decode($this->session->admin_po_items, TRUE)
				: array()
			;
			$items_count = 0;
			foreach ($this->data['po_items'] as $key => $val)
			{
				if (is_array($val))
				{
					$items_count += array_sum($val);
				}
				else $items_count += 1;
			}
			$this->data['items_count'] = count($this->data['po_items']);

			// set slugs segments if any
			$this->data['slug_segs'] =
				$this->session->admin_po_slug_segs
				? json_decode($this->session->admin_po_slug_segs, TRUE)
				: array()
			;

			$category_slug = end($this->data['slug_segs']);
			$category_id = $this->categories_tree->get_id($category_slug);

			// set array for where condition of get product list
			if ($this->webspace_details->options['site_type'] == 'hub_site')
			{
				if ($this->session->admin_po_des_url_structure) $where['designer.url_structure'] = $this->session->admin_po_des_url_structure;
				if ($this->session->admin_po_vendor_id) $where['tbl_product.vendor_id'] = $this->session->admin_po_vendor_id;
				if (@$this->data['des_subcats']) $where['tbl_product.categories LIKE'] = '%'.$category_id.'%';
			}
			/*
			else
			{
				$where = array(
					'designer.url_structure' => $this->data['active_designer'],
					'tbl_product.categories LIKE' => '%'.$category_id.'%',
					'tbl_product.vendor_id' => $this->session->admin_po_vendor_id
				);
			}
			*/

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

			// need to show loading at start
			$this->data['show_loading'] = TRUE;
			$this->data['search_string'] = FALSE;

			$this->data['file'] = 'po_create';
			$this->data['page_title'] = 'Create Purchase Order';
			$this->data['page_description'] = 'Purcahse Order Create';

			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		}
		else
		{
			/***********
			 * Process the input data
			 */
			// input post data
			/* *
			Array
			(
			    [po_number] => 000007
			    [po_date] => 2019-09-19
			    [des_id] => 5
			    [options] => Array
			        (
			            [ref_po_no] => 98765
			            [ref_so_no] => 123456
			            [po_store_id] => 6854
						[po_store_name] => Rey Store
			            [po_purpose] => Stock Replenishment
						[show_vendor_price] => 1
						[ship_via] => UPS
			            [fob] => China
			            [terms] => Net 15
			        )
			    [start_date] => 2019-09-19
			    [cancel_date] => 2019-09-30
			    [delivery_date] => 2019-09-28
			    [remarks] =>
			)
			// */

			// capture options array
			$options = $this->input->post('options');

			// will need to insert other items as options array
			if ($this->input->post('start_date')) $options['start_date'] = $this->input->post('start_date');
			if ($this->input->post('cancel_date')) $options['cancel_date'] = $this->input->post('cancel_date');

			// initialize designer details
			$this->designer_details->initialize(array('designer.des_id'=>$this->input->post('des_id')));

			// to ensure that no doulbe entry on new po# when 2 users
			// coincidentally creates PO at the exact same time
			$po_number = $this->purchase_orders_list->max_po_number() + 1;
			for($c = strlen($po_number);$c < 6;$c++)
			{
				$po_number = '0'.$po_number;
			}

			// insert record
			// contents of a PO
			$post_ary['des_code'] = strtoupper($this->designer_details->des_code);
			$post_ary['po_number'] = $po_number;
			$post_ary['rev'] = '0';
			$post_ary['des_id'] = $this->input->post('des_id');
			$post_ary['vendor_id'] = $this->session->admin_po_vendor_id;
			$post_ary['user_id'] = 0;
			$post_ary['po_date'] = strtotime($this->input->post('po_date'));
			$post_ary['delivery_date'] = strtotime($this->input->post('delivery_date'));
			$post_ary['author'] = $this->admin_user_details->admin_id; // author
			$post_ary['c'] = '1'; // 1-admin,2-sales
			$post_ary['status'] = '0'; // set to pending approval
			$post_ary['options'] = json_encode(array_filter($options)); // remove empty options
			$post_ary['remarks'] = $this->input->post('remarks');

			// set items in the following format
			/* *
			array(
				'<prod_no>_<color_code>' = array(
					'color_name' => '<color_name>',
					'vendor_price' => '<vendor_price>',
					'<size names>' => '<qty',
					...,
					...
					// sizes not indicated defaults to zero
				)
			)
			// */

			// set po items
			$post_ary['items'] = $this->session->admin_po_items;

			/***********
			 * Save it to the database
			 */
			// connect to database
			$DB = $this->load->database('instyle', TRUE);
			$query = $DB->insert('purchase_orders', $post_ary);
			$this_po_id = $DB->insert_id();

			// once done, we now remove session items
			// new po admin access
			unset($_SESSION['admin_po_vendor_id']);
			unset($_SESSION['admin_po_des_url_structure']);
			unset($_SESSION['admin_po_items']);
			unset($_SESSION['admin_po_size_qty']);
			unset($_SESSION['admin_po_store_id']);
			unset($_SESSION['admin_po_edit_vendor_price']);
			unset($_SESSION['admin_po_slug_segs']);
			// remove po mod details
			unset($_SESSION['admin_po_mod_po_id']);
			unset($_SESSION['admin_po_mod_items']);
			unset($_SESSION['admin_po_mod_size_qty']);
			unset($_SESSION['admin_po_mod_edit_vendor_price']);

			/***********
			 * Send po email confirmation with PDF attachment
			 */
			$this->load->library('purchase_orders/purchase_order_sending');
	 		$this->purchase_order_sending->send($this_po_id, 'admin');

			// set flash data
			$this->session->set_flashdata('success', 'add');

			// redirect user
			redirect('admin/purchase_orders/details/index/'.$this_po_id, 'location');
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/admin-po-components.js" type="text/javascript"></script>
			';
	}

	// --------------------------------------------------------------------

}
