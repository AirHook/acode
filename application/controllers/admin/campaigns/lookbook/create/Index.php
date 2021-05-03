<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Admin_Controller {

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

		if ($this->form_validation->run() == FALSE)
		{
			// get color list
			// used for "add product not in list"
			$this->data['colors'] = $this->color_list->select();

			// select designer on/off
			// and get the designers list for the category list
			// - general admin shows all designer category tree
			// - satellite and stand-alone sites defaults to it's designer category tree
			// - sales users now have their own admin panel
			if (
				$this->webspace_details->options['site_type'] == 'sat_site'
				OR $this->webspace_details->options['site_type'] == 'sal_site'
			)
			{
				$this->data['select_designer'] = FALSE;
				$des_slug = @$this->sales_user_details->designer ?: $this->webspace_details->slug;

				// set active designer slug and designer list
				// this obviously wont change anymore since this condition is for
				// sat or sal sites, and list will always be one designer
				$this->session->admin_lb_des_slug = $des_slug;
				$this->session->admin_lb_designers = array($des_slug);

				$this->designers_list->initialize(array('with_products'=>TRUE));
				$this->data['designers'] = $this->designers_list->select(
					array(
						'url_structure' => $des_slug
					)
				);
			}
			else
			{
				$this->data['select_designer'] = TRUE;

				$this->designers_list->initialize(array('with_products'=>TRUE));
				$this->data['designers'] = $this->designers_list->select();
			}

			// get some data if a designer has been previously selected
			if ($this->session->admin_lb_des_slug)
			{
				// get designer details
				$this->data['designer_details'] = $this->designer_details->initialize(
					array(
						'url_structure' => $this->session->admin_lb_des_slug
					)
				);
				$this->data['des_id'] = $this->designer_details->des_id;

				// get the designer category tree
				$this->data['des_subcats'] = $this->categories_tree->treelist(
					array(
						'd_url_structure' => $this->session->admin_lb_des_slug,
						'with_products' => TRUE
					)
				);
				$this->data['row_count'] = $this->categories_tree->row_count;
				$this->data['max_level'] = $this->categories_tree->max_category_level;
				$this->data['primary_subcat'] = $this->categories_tree->get_primary_subcat($this->session->admin_lb_des_slug);

				// get last category slug
				if ($this->session->admin_lb_slug_segs)
				{
					$this->data['slug_segs'] = json_decode($this->session->admin_lb_slug_segs, TRUE);
					$this->data['category_slug'] = end($this->data['slug_segs']);
					$category_id = $this->categories_tree->get_id($this->data['category_slug']);
					$designer_slug = reset($this->data['slug_segs']);
				}
				else
				{
					$designer_slug = $this->session->admin_lb_des_slug;
					$this->data['category_slug'] = $this->data['primary_subcat'];
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

				// don't show clearance cs only items for non-super admin
				if ($this->admin_user_details->access_level != '0')
				{
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
				//echo $this->products_list->last_query;
				//die();
			}

			/*****
			 * Check for items in session
			 */
			$this->data['lb_items'] =
				$this->session->admin_lb_items
				? json_decode($this->session->admin_lb_items, TRUE)
				: array()
			;
			$this->data['lb_items_count'] = count($this->data['lb_items']);
			$this->data['sa_options'] =
				$this->session->admin_lb_options
				? json_decode($this->session->admin_lb_options, TRUE)
				: array()
			;

			// set author to 1 for Inhouse as this is admin panel
			$this->data['author_name'] =
				$this->webspace_details->options['site_type'] == 'hub_site'
				? 'In-House'
				: ucwords(strtolower($this->admin_user_details->fname.' '.$this->admin_user_details->lname))
			;
			$this->data['author'] = 'admin'; // admin/sales - user_role
			$this->data['author_email'] =
				$this->webspace_details->options['site_type'] == 'hub_site'
				? $this->webspace_details->info_email
				: $this->admin_user_details->email
			;
			$this->data['author_id'] = $this->admin_user_details->admin_id;

			// need to show loading at start
			$this->data['show_loading'] = @$this->data['products_count'] > 0 ? TRUE : TRUE;
			$this->data['search_string'] = FALSE;

			// set data variables...
			$this->data['role'] = 'admin';
			$this->data['file'] = 'sa_lookbook_create';
			$this->data['page_title'] = 'Lookbook';
			$this->data['page_description'] = 'Create Lookbook';

			// load views...
			$this->load->view('admin/metronic/template/template', $this->data);
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
			    [date_create] => 1617485751
			    [last_modified] => 1617485751
			    [lookbook_name] => Lookbook Name
			    [email_subject] => Subject
			    [email_message] => Here are designs that are now available. Review them for your store.
			    [files] =>
			    [options] => Array
			        (
			            [w_prices] => Y
			            [w_images] => N
			            [linesheets_only] => N
			        )

			    [user_id] => 2
			    [user_role] => admin
			    [user_name] => In-House
				[user_email] => help@instylenewyork.com
			    [items_count] => 2
			)
			// other needed items
			[lb_items] -> admin_lb_items
			// */

			if ($this->input->post('save_lookbook'))
			{
				// connect to database
				$DB = $this->load->database('instyle', TRUE);

				// grab post data and process some other options data
				$post_ary = $this->input->post();

				// other items
				//$post_ary['options']['admin_sales_designer'] = @$this->sales_user_details->desginer;
				// des_slug can only be true for single designer packages
				// des_slug cannot be used as reference designer where the package was created
				$post_ary['options']['des_slug'] = $this->session->admin_lb_des_slug;
				if ($this->session->admin_lb_designers) $post_ary['options']['designers'] = json_encode($this->session->admin_lb_designers);
				$post_ary['options'] = json_encode($post_ary['options']);

				// additional items to set
				$post_ary['webspace_id'] = $this->webspace_details->id; // where the package was created
				$post_ary['designer'] = $this->session->admin_lb_des_slug;

				// remove variables not needed
				unset($post_ary['files']);
				unset($post_ary['items_count']);
				unset($post_ary['save_lookbook']);

				// set sales package items
				$post_ary['items'] = $this->session->admin_lb_items;

				// update records
				$DB->set($post_ary);
				$q = $DB->insert('lookbook');
				$insert_id = $DB->insert_id();

				// unset create sessions
				unset($_SESSION['admin_lb_id']);
				unset($_SESSION['admin_lb_des_slug']);
				unset($_SESSION['admin_lb_designers']);
				unset($_SESSION['admin_lb_slug_segs']);
				unset($_SESSION['admin_lb_items']);
				unset($_SESSION['admin_lb_name']); // used at view
				unset($_SESSION['admin_lb_email_subject']); // used at view
				unset($_SESSION['admin_lb_email_message']); // used at view
				unset($_SESSION['admin_lb_options']);

				// set flash data
				$this->session->set_flashdata('success', 'add');

				// redirect user
				redirect('admin/campaigns/lookbook/send/index/'.$insert_id);
			}
			else
			{
				// we shall make additional session data
				$_SESSION['date_create'] = $this->input->post('date_create');
				$_SESSION['last_modified'] = $this->input->post('last_modified');
				$_SESSION['admin_lb_name'] = $this->input->post('lookbook_name');
				$_SESSION['admin_lb_email_subject'] = $this->input->post('email_subject');
				$_SESSION['admin_lb_email_message'] = $this->input->post('email_message');
				$_SESSION['admin_lb_user_id'] = $this->input->post('user_id');
				$_SESSION['admin_lb_user_role'] = $this->input->post('user_role');
				$_SESSION['admin_lb_user_name'] = $this->input->post('user_name');
				$_SESSION['admin_lb_user_email'] = $this->input->post('user_email');

				// redirect user
				redirect('admin/campaigns/lookbook/send_lookbook', 'location');
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
