<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Sales_user_Controller {

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
	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('designers/designer_details');
		//$this->load->library('users/sales_user_details');
		$this->load->library('sales_package/sales_package_list');
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('products/product_details');
		$this->load->library('designers/designers_list');
		$this->load->library('categories/categories_tree');
		$this->load->library('color_list');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('sales_package_name', 'Sales Package Name', 'trim|required');
		$this->form_validation->set_rules('email_subject', 'Email Subject', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// get color list
			// used for "add product not in list"
			$this->data['colors'] = $this->color_list->select();

			// select designer on/off
			// and get the designers list for the category list
			// - general admin shows all designer category tree
			// - satellite and stand-alone sites defaults to it's designer category tree
			// - sales users default to it's reference designer category tree
			// NOTE: this controller is for sales users only hence the shortcut
			// also, presumption is sales users are dedicated to one designer at the moment
			$this->data['select_designer'] = FALSE;
			$des_slug = @$this->sales_user_details->designer ?: $this->webspace_details->slug;
			$this->session->sa_des_slug = $des_slug;
			$this->data['designers'] = $this->designers_list->select(
				array(
					'url_structure' => $this->sales_user_details->designer // used by my_account sales
				)
			);

			// get some data if a designer has been previously selected
			if ($this->session->sa_des_slug)
			{
				// get designer details
				$this->data['designer_details'] = $this->designer_details->initialize(
					array(
						'url_structure' => $this->session->sa_des_slug
					)
				);
				$this->data['des_id'] = $this->designer_details->des_id;

				// get the designer category tree
				$this->data['des_subcats'] = $this->categories_tree->treelist(
					array(
						'd_url_structure' => $this->session->sa_des_slug,
						'with_products' => TRUE
					)
				);
				$this->data['row_count'] = $this->categories_tree->row_count;
				$this->data['max_level'] = $this->categories_tree->max_category_level;
				$this->data['primary_subcat'] = $this->categories_tree->get_primary_subcat($this->session->sa_des_slug);

				// get last category slug
				if ($this->session->sa_slug_segs)
				{
					$this->data['slug_segs'] = json_decode($this->session->sa_slug_segs, TRUE);
					$category_slug = end($this->data['slug_segs']);
					$category_id = $this->categories_tree->get_id($category_slug);
					$designer_slug = reset($this->data['slug_segs']);
				}
				else
				{
					$designer_slug = $this->session->sa_des_slug;
					$category_id = $this->categories_tree->get_id($this->data['primary_subcat']);
				}

				$where_more['designer.url_structure'] = $designer_slug;
				$where_more['tbl_product.categories LIKE'] = $category_id;

				// sales package show item conditions
				// 1. 	super admin (0) gets to see everything but with stocks
				//		note: cannot send items without stocks at the moment
				// 2.	desginer admin (1) gest to see evrything but with stocks
		        // 3. 	sales users gets to see everything except
		        // 		preorder items
		        // 		esp not clearance cs items
				// but right now, sales packages are for the following:
				//		instock items
				//		on sale items

				// public
				$where_more['tbl_product.publish !='] = '0';
				$where_more['tbl_stock.new_color_publish !='] = '0';

				if ($this->sales_user_details->access_level == '2')
				{
					$where_more['tbl_stock.color_publish'] = 'Y';

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

				$params['with_stocks'] = FALSE; // TRUE shows instock items only

				$params['group_products'] = FALSE; // group per product number or per variant
				$params['special_sale'] = FALSE; // special sale items only
				$this->load->library('products/products_list', $params);
				$this->data['products'] = $this->products_list->select(
					// where conditions
					$where_more,
					// sorting conditions
					array(
						'seque' => 'asc',
						'tbl_product.prod_no' => 'desc'
					)
				);
				$this->data['products_count'] = $this->products_list->row_count;
			}

			/*****
			 * Check for items in session
			 */
			$this->data['sa_items'] =
				$this->session->sa_items
				? json_decode($this->session->sa_items, TRUE)
				: array()
			;
			$this->data['sa_items_count'] = count($this->data['sa_items']);
			$this->data['sa_options'] =
				$this->session->sa_options
				? json_decode($this->session->sa_options, TRUE)
				: array()
			;

			// set author to 1 for Inhouse or set logged in admin sales user
			if ($this->session->admin_sales_loggedin)
			{
				$this->data['author_name'] = $this->sales_user_details->fname.' '.$this->sales_user_details->lname;
				$this->data['author'] = $this->data['author_name'];
				$this->data['author_email'] = $this->sales_user_details->email;
				$this->data['author_id'] = $this->sales_user_details->admin_sales_id;
			}
			else
			{
				$this->data['author_name'] = 'In-House';
				$this->data['author'] = 'admin'; // admin/system
				$this->data['author_email'] = $this->webspace_details->info_email;
				$this->data['author_id'] = $this->session->admin_id;
			}

			// need to show loading at start
			$this->data['show_loading'] = @$this->data['products_count'] > 0 ? TRUE : FALSE;
			$this->data['search'] = FALSE;

			// breadcrumbs
			$this->data['page_breadcrumb'] = array(
				'sales_package' => 'Sales Packages',
				'create' => 'Create'
			);

			// set data variables...
			$this->data['role'] = 'sales';
			$this->data['file'] = 'sa_create';
			$this->data['page_title'] = 'Sales Package';
			$this->data['page_description'] = 'Create Sales Packages';

			// load views...
			$this->load->view('admin/metronic/template_my_account/template', $this->data);
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
				[date_create] => 1572636339
				[last_modified] => 1572636339
				[sales_package_name] => My First Sales Package
				[email_subject] => New Designs
				[email_message] => Here are designs that are now available. Review them for your store.
				[files] =>
				[options] => Array
					(
						[w_prices] => Y
						[w_images] => N
						[linesheets_only] => N
					)

				[sales_user] => 1	// sales user id, defaults to 1 for admin
				[author] => admin
				[prod_no] => Array
					(
						[0] => 036_BEIG1
						[1] => 036_GREY1
						[2] => 045_TAUP1
					)
				[save_sales_package] => 1	// item for create sales package
			)
			// other needed items for sales package create
			[sales_package_items] -> sa_items
			// */

			if ($this->input->post('save_sales_package'))
			{
				// connect to database
				$DB = $this->load->database('instyle', TRUE);

				// grab post data and process some other options data
				$post_ary = $this->input->post();
				// in case a sales user is the one who created the package
				$post_ary['options']['admin_sales_designer'] = @$this->sales_user_details->desginer;
				// des_slug can only be true for single designer packages
				// des_slug cannot be used as reference designer where the package was created
				$post_ary['options']['des_slug'] = $this->session->sa_des_slug; // additional data
				$post_ary['options']['designers'] = $this->session->sa_designers;
				$post_ary['options'] = json_encode($post_ary['options']);

				// additional items to set
				$post_ary['webspace_id'] = $this->webspace_details->id; // where the package was created

				// set sales package items
				$post_ary['sales_package_items'] = $this->session->sa_items ?: json_encode($post_ary['prod_no']);

				// remove variables not needed
				unset($post_ary['files']);
				unset($post_ary['prod_no']);
				unset($post_ary['save_sales_package']);

				// update records
				$DB->set($post_ary);
				$q = $DB->insert('sales_packages');
				$insert_id = $DB->insert_id();

				// unset create sessions
				unset($_SESSION['sa_id']);
				unset($_SESSION['sa_des_slug']);
				unset($_SESSION['sa_designers']);
				unset($_SESSION['sa_slug_segs']);
				unset($_SESSION['sa_items']);
				unset($_SESSION['sa_name']); // used at view
				unset($_SESSION['sa_email_subject']); // used at view
				unset($_SESSION['sa_email_message']); // used at view
				unset($_SESSION['sa_options']);

				// set flash data
				$this->session->set_flashdata('success', 'add');

				// redirect user
				redirect('my_account/sales/sales_package/send/index/'.$insert_id);
			}
			else
			{
				// we shall make additional session data
				$_SESSION['date_create'] = $this->input->post('date_create');
				$_SESSION['last_modified'] = $this->input->post('last_modified');
				$_SESSION['sa_name'] = $this->input->post('sales_package_name');
				$_SESSION['sa_email_subject'] = $this->input->post('email_subject');
				$_SESSION['sa_email_message'] = $this->input->post('email_message');
				//$_SESSION['sa_options'] = json_encode($this->input->post('options'));

				// redirect user
				redirect('my_account/sales/sales_package/send_package', 'location');
			}
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
		$this->data['page_level_styles'] = '';


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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/sales-sa-components.js?z='.time().'" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
