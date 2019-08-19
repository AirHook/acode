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
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('designers/designers_list');
		$this->load->library('users/vendor_users_list');
		$this->load->library('users/wholesale_users_list');
		$this->load->library('users/sales_user_details');
		$this->load->library('categories/categories_tree');
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');
		$this->load->library('color_list');

		// get color list
		$this->data['colors'] = $this->color_list->select();

		// let's ensure that there are no admin session for so mod
		if ($this->session->admin_so_mod_size_qty)
		{
			// new po admin access
			unset($_SESSION['admin_so_designer']);
			unset($_SESSION['admin_so_vendor_id']);
			unset($_SESSION['admin_so_store_id']);
			unset($_SESSION['admin_so_author']);
			unset($_SESSION['admin_so_dely_date']);
			unset($_SESSION['admin_so_items']);
			unset($_SESSION['admin_so_slug_segs']);
			// remove po mod details
			unset($_SESSION['admin_so_mod_so_id']);
			unset($_SESSION['admin_so_mod_so_items']);
		}

		// admin - either all designers or per designer admin
		$this->data['designers'] =
			$this->webspace_details->options['site_type'] == 'hub_site'
			? $this->designers_list->select()
			: $this->designers_list->select(
				array(
					'des_id' => $this->webspace_details->des_id
				)
			)
		;

		// get some data
		if ($this->session->admin_so_designer)
		{
			// initialize a property and then get list
			$this->categories_tree->d_url_structure = $this->session->admin_so_designer;
			$this->data['categories'] = $this->categories_tree->treelist();
			// get lists
			$this->data['vendors'] = $this->vendor_users_list->select(
				array(
					'reference_designer' => $this->session->admin_so_designer
				)
			);
			$this->data['users'] = $this->wholesale_users_list->select(
				array(
					'reference_designer' => $this->session->admin_so_designer
				)
			);

			// get details
			$this->data['designer_details'] = $this->designer_details->initialize(
				array(
					'designer.url_structure' => $this->session->admin_so_designer
				)
			);

			// get active category if any
			$this->data['slug_segs'] =
				$this->session->admin_so_slug_segs
				? json_decode($this->session->admin_so_slug_segs, TRUE)
				: array()
			;

			// get the designer category tree
			if ($this->session->admin_so_vendor_id)
			{
				$this->data['des_subcats'] = $this->categories_tree->treelist(
					array(
						'd_url_structure' => $this->data['designer_details']->url_structure,
						'vendor_id' => $this->session->admin_so_vendor_id,
						'with_products' => TRUE
					)
				);
				$this->data['row_count'] = $this->categories_tree->row_count;
				$this->data['max_level'] = $this->categories_tree->max_category_level;

				foreach ($this->data['des_subcats'] as $subcat)
				{
					if ($subcat->category_level == $this->data['max_level'])
					{
						$category_id = $subcat->category_id;
						break;
					}
				}
			}
		}

		// set the author
		$this->data['author'] = $this->sales_user_details->initialize(
			array(
				'admin_sales_email' => $this->webspace_details->info_email
			)
		);

		/*****
		 * Check for items in session
		 */
		// check for po items
		$this->data['so_items'] =
			$this->session->admin_so_items
			? json_decode($this->session->admin_so_items, TRUE)
			: array()
		;
		$items_count = 0;
		foreach ($this->data['so_items'] as $key => $val)
		{
			if (is_array($val))
			{
				$items_count += array_sum($val);
			}
			else $items_count += 1;
		}
		$this->data['items_count'] = count($this->data['so_items']);

		// set array for where condition of get product list
		if ($this->webspace_details->options['site_type'] == 'hub_site')
		{
			if ($this->session->admin_so_designer) $where['designer.url_structure'] = $this->session->admin_so_designer;
			if ($this->session->admin_so_vendor_id) $where['tbl_product.vendor_id'] = $this->session->admin_so_vendor_id;
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

		$this->data['file'] = 'so_create';
		$this->data['page_title'] = 'Sales Order';
		$this->data['page_description'] = 'A summary of recent activities';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template5/template', $this->data);
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
