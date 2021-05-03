<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modify extends Admin_Controller {

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
	 * Index - Create Sales Package
	 *
	 * Creates a sales package given an input sales page name with some default values
	 * inserted to database.
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
			redirect($this->config->slash_item('admin_folder').'campaigns/lookbook');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('designers/designer_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('lookbook/lookbook_list');
		$this->load->library('lookbook/lookbook_details');
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');
		$this->load->library('designers/designers_list');
		$this->load->library('categories/categories_tree');
		$this->load->library('color_list');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('lookbook_name', 'Lookbook Name', 'trim|required');
		$this->form_validation->set_rules('email_subject', 'Email Subject', 'trim|required');

		// capture package id being modified
		if ( ! $this->session->admin_lb_mod_id)
		{
			$this->session->admin_lb_mod_id = $id;
		}

		// check for different id's
		if ($this->session->admin_lb_mod_id != $id)
		{
			// ooops... different id
			// reset and reload
			redirect('admin/campaigns/lookbook/reset/index/'.$id);
		}

		// get color list
		// used for "add product not in list"
		$this->data['colors'] = $this->color_list->select();

		// initialize sales package properties
		$this->data['sa_details'] = $this->lookbook_details->initialize(
			array(
				'lookbook_id'=>$id
			)
		);

		if ($this->form_validation->run() == FALSE)
		{
			if ( ! $this->data['sa_details'])
			{
				// nothing more to do...
				// set flash data
				$this->session->set_flashdata('error', 'no_id_passed');

				// redirect user
				redirect('admin/campaigns/lookbook', 'location');
			}

			// disect some information from sales package
			$this->data['sa_items'] = $this->data['sa_details']->items;
			$this->data['sa_items_count'] = count($this->data['sa_items']);
			$this->data['sa_options'] = $this->data['sa_details']->options;

			// set sessions
			$this->session->admin_lb_mod_items = json_encode($this->data['sa_items']);
			$this->session->admin_lb_mod_options = json_encode($this->data['sa_options']);

			// at modify, designer is already selected from create
			// no more need for dropdown
			$this->data['select_designer'] = FALSE;
			$designer_slug =
				@$this->data['sa_options']['des_slug']
				?: (
					@$admin_sales_details->designer // only on sales user logged in
					?: (
						@$this->webspace_details->options['site_type'] != 'hub_site'
						? $this->webspace_details->slug // can only use if sat_site
						: @$this->webspace_details->options['primary_designer']
						// we have to trap the chance that the options didn't capture the des_slug
						// setting it to blank for now
					)
				)
			;

			// get the designer name
			$this->data['designer_details'] = $this->designer_details->initialize(
				array(
					'url_structure' => $designer_slug
				)
			);
			$this->data['designer'] = $this->designer_details->designer;
			$this->session->admin_lb_mod_des_slug = $designer_slug;

			// get the designer category tree
			$param1['with_products'] = TRUE;
			if ($designer_slug != 'shop7thavenue') $param1['d_url_structure'] = $designer_slug;
			$this->data['des_subcats'] = $this->categories_tree->treelist($param1);
			$this->data['row_count'] = $this->categories_tree->row_count;
			$this->data['max_level'] = $this->categories_tree->max_category_level;
			$this->data['primary_subcat'] = $this->categories_tree->get_primary_subcat($this->session->admin_lb_mod_des_slug);

			// check of last active slugs selected for category tree
			if ($this->session->admin_lb_mod_slug_segs)
			{
				// get last category slug
				//$this->data['slug_segs'] = explode('/', $this->session->admin_lb_mod_slug_segs);
				$this->data['slug_segs'] = json_decode($this->session->admin_lb_mod_slug_segs, TRUE);
				$this->data['category_slug'] = end($this->data['slug_segs']);
				$category_id = $this->categories_tree->get_id($this->data['category_slug']);
				$designer_slug = reset($this->data['slug_segs']);
				$where_more['designer.url_structure'] = $designer_slug;
			}
			else
			{
				$designer_slug = $this->session->admin_lb_mod_des_slug;
				$this->data['category_slug'] = $this->data['primary_subcat'];
				$category_id = $this->categories_tree->get_id($this->data['primary_subcat']);
			}

			$where_more['tbl_product.categories LIKE'] = $category_id;

			// public
			$where_more['tbl_product.publish !='] = '0';
			$where_more['tbl_stock.new_color_publish !='] = '0';

			// don't show clearance cs only items for non-super admin
			if ($this->admin_user_details->access_level != '0')
			{
				// don't show clearance cs only items
				$where_more['tbl_stock.options NOT LIKE'] = '"clearance_consumer_only":"1"';
			}

			// get the products list for the thumbs grid view
			//$params['show_private'] = TRUE; // all items general public (Y) - N for private
			//$params['view_status'] = 'ALL'; // all items view status (Y, Y1, Y2, N)
			//$params['view_at_hub'] = TRUE; // all items general public at hub site
			//$params['view_at_satellite'] = TRUE; // all items publis at satellite site
			//$params['variant_publish'] = 'ALL'; // all items at variant level publish (view status)
			//$params['variant_view_at_hub'] = TRUE; // variant level public at hub site
			//$params['variant_view_at_satellite'] = TRUE; // varian level public at satellite site

			$params['with_stocks'] = FALSE; // Show all with and without stocks

			$params['group_products'] = FALSE; // group per product number or per variant
			$params['special_sale'] = FALSE; // special sale items only
			$this->load->library('products/products_list', $params);
			$this->data['products'] = $this->products_list->select(
				$where_more,
				array( // order conditions
					'seque' => 'asc',
					'tbl_product.prod_no' => 'desc'
				)
			);
			$this->data['products_count'] = $this->products_list->row_count;

			// author
			$this->data['author_name'] = $this->lookbook_details->user_name; // usually 'In-House' being admin
			$this->data['author'] = $this->lookbook_details->user_role; // usually 'admin' being admin (or 'sales')
			$this->data['author_email'] = $this->lookbook_details->user_email;
			$this->data['author_id'] = $this->lookbook_details->user_id;

			// need to show loading at start
			$this->data['show_loading'] = @$this->data['products_count'] > 0 ? TRUE : FALSE;
			$this->data['search_string'] = FALSE;

			// set data variables...
			$this->data['role'] = 'admin';
			$this->data['file'] = 'sa_lookbook_modify';
			$this->data['page_title'] = 'Sales Package Edit';
			$this->data['page_description'] = 'Modify Sales Packages';

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
			echo '<pre>';
			print_r($this->input->post());
			die();
			Array
			(
			    [last_modified] => 1618523522
			    [lookbook_name] => Elegant Fully Covered Dresses
			    [date_create] => 2021-04-15
			    [email_subject] => Elegant Fully Covered Dresses
			    [email_message] => Please review the attached look book for your stores.
			    [files] =>
			    [options] => Array
			        (
			            [w_prices] => N
			            [w_images] => N
			            [linesheets_only] => N
			        )

			    [usre_role] => admin
			    [user_id] => 2
			    [user_name] => In-House
			    [user_email] => help@instylenewyork.com
			    [items_count] => 3
			)
			// other needed items
			[lookbook_items] -> $this->session->admin_lb_mod_items
			// */

			echo 'Processing...';

			// connect to database
			$DB = $this->load->database('instyle', TRUE);

			// grab post data and process some of them to accomodate database
			$post_ary = $this->input->post();
			// in case a sales user is the one who created the package
			//$post_ary['options']['admin_sales_designer'] = @$this->sales_user_details->desginer;
			// des_slug can only be true for single designer packages
			// des_slug cannot be used as reference designer where the package was created
			$post_ary['designer'] = $this->session->admin_lb_mod_des_slug;
			// keeping options for future use (unset it first)
			// so as not to record the sales packaeg like options for now
			$post_ary['options']['des_slug'] = $this->session->admin_lb_mod_des_slug;
			if ($this->session->admin_lb_mod_designers) $post_ary['options']['designers'] = $this->session->admin_lb_mod_designers;
			$post_ary['options'] = json_encode($post_ary['options']);

			// remove variables not needed
			unset($post_ary['files']);
			unset($post_ary['date_create']); // we don't need to re-save this
			unset($post_ary['items_count']);

			// set sales package items
			$post_ary['items'] = $this->session->admin_lb_mod_items ?: $this->data['sa_details']->items;

			// update records
			$DB->set($post_ary);
			$DB->where('lookbook_id', $id);
			$q = $DB->update('lookbook');

			// unset create sessions
			unset($_SESSION['admin_lb_mod_id']);
			unset($_SESSION['admin_lb_mod_items']);
			unset($_SESSION['admin_lb_mod_slug_segs']);
			unset($_SESSION['admin_lb_mod_options']);
			unset($_SESSION['admin_lb_mod_des_slug']);

			// set flash data
			$this->session->set_flashdata('success', 'edit');

			// redirect user
			redirect('admin/campaigns/lookbook/send/index/'.$id, 'location');
		}
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/admin-lb-components.js?z='.time().'" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
