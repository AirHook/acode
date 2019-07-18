<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_multiple extends Admin_Controller {

	/**
	 * Propery post array checked
	 *
	 * @params	boolean/int
	 */
	protected $post_ary_checked = 0;

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
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 *
	 * @return	void
	 */
	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('users/vendor_users_list');
		$this->load->library('users/vendor_user_details');

		if ( ! $this->input->post())
		{
			// get vendor details
			$this->data['vendor'] = $this->vendor_user_details->initialize(
				array(
					'vendor_id' => $this->session->admin_po_vendor_id
				)
			);
			if ( ! $this->data['vendor'])
			{
				// no vendor yet, let user selecct vendor
				// set flash data
				$this->session->set_flashdata('error', 'no_id_passed');

				// redirect user
				redirect('admin/purchase_orders/create/step1', 'location');
			}

			// some necessary variables
			$this->data['steps'] = 2;

			// need to show loading at start
			$this->data['show_loading'] = FALSE;
			$this->data['search_string'] = FALSE;

			// set data variables...
			$this->data['file'] = 'po_search_multi_products';
			$this->data['page_title'] = 'Purchase Order Search';
			$this->data['page_description'] = 'Search Multiple Products';

			// load views...
			$this->load->view('admin/'.($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
			//$this->load->view($this->data['sales_theme'].'/sales/template/template', $this->data);
		}
		else
		{
			if (empty($this->input->post()))
			{
				echo 'uh oh<br />';
				echo '<pre>';
				print_r($this->input->post());
				die();
			}

			/*****
			 * Check for items in session
			 */
			// check for po items
			$this->data['po_items'] =
				$this->session->admin_po_items
				? json_decode($this->session->admin_po_items, TRUE)
				: array()
			;
			$po_items_count = 0;
			foreach ($this->data['po_items'] as $key => $val)
			{
				if (is_array($val))
				{
					$po_items_count += array_sum($val);
				}
				else $po_items_count += 1;
			}
			$this->data['po_items_count'] = $po_items_count;
			$this->data['po_size_qty'] =
				$this->session->admin_po_size_qty
				? json_decode($this->session->admin_po_size_qty, TRUE)
				: array()
			;

			// load pertinent library/model/helpers
			$this->load->library('users/vendor_user_details');

			// get vendor details
			$this->data['vendor'] = $this->vendor_user_details->initialize(
				array(
					'vendor_id' => $this->session->admin_po_vendor_id
				)
			);
			if ( ! $this->data['vendor'])
			{
				// no vendor yet, let user selecct vendor
				// set flash data
				$this->session->set_flashdata('error', 'no_id_passed');

				// redirect user
				redirect('admin/purchase_orders/create/step1', 'location');
			}

			// grab the input posts
			$post_ary = $this->input->post();
			$prod_no = array_map('strtoupper', array_filter($post_ary['style_ary']));

			// let's do some defaults...
	 		// active designer selection
	 		$this->data['active_designer'] = $this->session->admin_po_des_url_structure;

			// set array for where condition of get product list
			if ($this->data['active_designer'])
			{
				$where_more = array(
					'designer.url_structure' => $this->data['active_designer'],
					'tbl_product.vendor_id' => $this->session->admin_po_vendor_id
				);
			}
			else
			{
				$where_more = array(
					'tbl_product.vendor_id' => $this->session->admin_po_vendor_id
				);
			}
			// consider input prod_no
			if (is_array($prod_no))
			{
				$where = array_merge($prod_no, $where_more);
			}
			else
			{
				$where_more['tbl_product.prod_no'] = $prod_no;
				$where = $where_more;
			}

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

			// some necessary variables
			$this->data['steps'] = 2;

			// need to show loading at start
			$this->data['show_loading'] = FALSE;
			$this->data['search_string'] = implode(',', $prod_no);

			// set data variables...
			$this->data['file'] = 'create_purchase_order_step2'; //'purchase_orders';
			$this->data['page_title'] = 'Purchase Order';
			$this->data['page_description'] = 'Select Items for Purchase Order';

			// load views...
			$this->load->view('admin/'.($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
			//$this->load->view($this->data['sales_theme'].'/sales/template/template', $this->data);
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Check if input array is empty
	 *
	 * @return	void
	 */
	public function check_empty($str, $post_ary)
	{
		echo 'here<br />';
		echo $post_ary;
		echo '<br />';

		if ($str == '')
		{
			echo 'inside<br />';
			echo $str.'<br />';
			die();

			$this->form_validation->set_message('check_empty', 'Please select a product');
			return FALSE;
		}
		else
		{
			echo 'down<br />';
			echo $str.'<br />';
			$this->post_ary_checked = '1';
			return $this;
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
			// summernote wysiwyg
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
			';
			// multi-select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/jquery-multi-select/css/multi-select.css" rel="stylesheet" type="text/css" />
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '';

			// this is a work around so that the inline jquery ajax request to add and remove items from the sales package to work
			$this->data['page_level_styles'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
			';

		/****************
		 * page js plugins inserted at <bottom>
		 * after core plugins, before global scripts
		 */
		$this->data['page_level_plugins'] = '';

			// unveil - simple image lazy loading
			$this->data['page_level_plugins'].= '
				<script src="'.base_url().'assets/custom/js/jquery.unveil.js" type="text/javascript"></script>
			';
			// ladda - show loading or progress bar on buttons
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>
			';
			// pulsate
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
			';
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// summernote wysiwyg
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
			';
			// form wizard - jquery validate is needed for the wizard to function
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
			';
			// multi-select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
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
			// handle form wizard
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/form-wizard.min.js" type="text/javascript"></script>
			';
			// handle summernote wysiwyg
			// and click scripts
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/sales-purchase_orders-components.js" type="text/javascript"></script>
			';
			// handle multiSelect
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/sales_package-send.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
