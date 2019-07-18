<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_multiple extends Sales_Controller {

	/**
	 * SO stock ordering status whether instock or preorder
	 * Ordering is separate
	 * 		0 - start (default)
	 *		1 - instock
	 *		2 - preorder
	 *
	 * @return	void
	 */
	public $so_stocstat = 0;


	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// instock/preorder ordering session switch
		$this->so_stocstat = $this->session->so_stocstat ?: '0';
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

		if ( ! $this->input->post())
		{
			// some necessary variables
			$this->data['steps'] = 1;

			// need to show loading at start
			$this->data['show_loading'] = FALSE;
			$this->data['search'] = TRUE;

			// set data variables...
			$this->data['file'] = 'so_create_steps'; //'purchase_orders';
			//$this->data['file'] = 'so_search_multi_products';
			$this->data['page_title'] = 'Sales Package';
			$this->data['page_description'] = 'Search Multiple Products';

			// load views...
			$this->load->view($this->data['sales_theme'].'/sales/template/template', $this->data);
		}
		else
		{
			// grab the input posts and process it first
			$post_ary = $this->input->post();
			$prod_no = array_map('strtoupper', array_filter($post_ary['style_ary']));

			if (empty($prod_no))
			{
				// set flash data
				$this->session->set_flashdata('error', 'empty_style_ary');

				// redirect user
				redirect('sales/sales_orders/search_multiple', 'location');
			}

			// check for po items
			$this->data['so_items'] =
				$this->session->so_items
				? json_decode($this->session->so_items, TRUE)
				: array()
			;

			// let's do some defaults...
			// sales user have one designer only
			// get the designer details for the sidebar
			$this->load->library('designers/designer_details');
			$this->load->library('products/size_names');
			$this->data['designer'] = $this->designer_details->initialize(array('url_structure'=>$this->sales_user_details->designer));
			$this->data['size_names'] = $this->size_names->get_size_names($this->designer_details->webspace_options['size_mode']);

			$where_more = array(
				'designer.url_structure' => $this->sales_user_details->designer
			);
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
			$this->data['steps'] = 1;

			// need to show loading at start
			$this->data['show_loading'] = FALSE;
			$this->data['search_string'] = implode(',', $prod_no);

			// set data variables...
			$this->data['file'] = 'so_create_steps'; //'purchase_orders';
			$this->data['page_title'] = 'Purchase Order';
			$this->data['page_description'] = 'Create Purchase Orders';

			// load views...
			//$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
			$this->load->view($this->data['sales_theme'].'/sales/template/template', $this->data);
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
			// form wizard - jquery validate is needed for the wizard to function
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-sales-sales_orders_create.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
