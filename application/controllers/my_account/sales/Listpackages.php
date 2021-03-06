<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listpackages extends Sales_user_Controller {

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
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index($des_slug = '')
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('designers/designers_list');
		$this->load->library('sales_package/sales_package_list');
		$this->load->library('products/product_details');

		// get designer list for the dropdown filter
		$this->designers_list->initialize(array('with_products'=>TRUE));
		$this->data['designers'] = $this->designers_list->select();

		// set some variables
		// we need a real variable to process some calculations
		$url_segs = $this->uri->segment_array();
		$this->data['page'] = is_numeric(end($url_segs)) ? end($url_segs) : 1;
		$this->data['limit'] = 100;
		$this->data['offset'] = $this->data['page'] == '' ? 0 : ($this->data['page'] * 100) - 100;
		//$this->orders_list->pagination = $this->data['page'];

		// check for $des_slug
		$this->data['des_slug'] = '';
		if ($des_slug)
		{
			$where['sales_packages.options LIKE'] = '%'.$des_slug.'%';
			$this->data['des_slug'] = $des_slug;
		}

		// get the list
		$where['sales_package_id >'] = '2';
		$where['tbladmin_sales.admin_sales_id'] = $this->session->userdata('admin_sales_id');
		if (@$this->webspace_details->options['site_type'] != 'hub_site')
		{
			$where['tbladmin_sales.admin_sales_designer'] = @$this->webspace_details->slug;
		}
		$this->data['packages'] = $this->sales_package_list->select($where);


		// set data variables...
		$this->data['role'] = 'sales';
		$this->data['file'] = '../../my_account/sa_list';
		$this->data['page_title'] = 'Sales Package';
		$this->data['page_description'] = 'List of Sales Packages';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template_my_account/template', $this->data);
	}
	
	public function modify($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/sales/listpackages');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('designers/designer_details');
		$this->load->library('users/sales_user_details');
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
			// let's ensure that there are no admin session for sa create
			if ($this->session->admin_sa_items)
			{
				// new po admin createa ccess
				unset($_SESSION['admin_sa_id']);
				unset($_SESSION['admin_sa_des_slug']);
				unset($_SESSION['admin_sa_slug_segs']);
				unset($_SESSION['admin_sa_items']);
				unset($_SESSION['admin_sa_name']); // used at view
				unset($_SESSION['admin_sa_email_subject']); // used at view
				unset($_SESSION['admin_sa_email_message']); // used at view
				unset($_SESSION['admin_sa_options']);
				// remove po mod details
				unset($_SESSION['admin_sa_mod_id']);
				unset($_SESSION['admin_sa_mod_items']);
				unset($_SESSION['admin_sa_mod_slug_segs']);
				unset($_SESSION['admin_sa_mod_options']);
				unset($_SESSION['admin_sa_mod_des_slug']);
			}

			// capture package id being modified
			if ( ! $this->session->admin_sa_mod_id)
			{
				$this->session->admin_sa_mod_id = $id;
			}

			// check for different id's
			if ($this->session->admin_sa_mod_id != $id)
			{
				// ooops... different id
				// reset and reload
				redirect('my_account/sales/listpackages/reset/index/'.$id);
			}

			// get color list
			// used for "add product not in list"
			$this->data['colors'] = $this->color_list->select();

			// initialize sales package properties
			$this->data['sa_details'] = $this->sales_package_details->initialize(
				array(
					'sales_package_id'=>$id
				)
			);

			// disect some information from sales package
			if ( ! $this->session->admin_sa_mod_items)
			{
				$this->session->admin_sa_mod_items = json_encode($this->sales_package_details->items);
			}
			$this->data['sa_items'] = json_decode($this->session->admin_sa_mod_items, TRUE);
			$this->data['sa_items_count'] = count($this->data['sa_items']);
			if ( ! $this->session->admin_sa_mod_options)
			{
				$this->session->admin_sa_mod_options = json_encode($this->sales_package_details->options);
				$this->data['sa_options'] = $this->sales_package_details->options;
			}
			else
			{
				$this->data['sa_options'] = json_decode($this->session->admin_sa_mod_options, TRUE);
			}

			// at modify, designer is already selected from create
			// no more need for dropdown
			$this->data['select_designer'] = FALSE;
			$designer_slug =
				@$this->data['sa_options']['des_slug']
				?: (
					@$this->sales_user_details->designer
					?: $this->webspace_details->slug
				)
			;

			// get the designer name
			$this->data['designer_details'] = $this->designer_details->initialize(
				array(
					'url_structure' => $designer_slug
				)
			);
			$this->data['designer'] = $this->designer_details->designer;
			$this->session->admin_sa_mod_des_slug = $designer_slug;

			// get the designer category tree
			$param1['with_products'] = TRUE;
			if ($designer_slug != 'shop7thavenue') $param1['d_url_structure'] = $designer_slug;
			$this->data['des_subcats'] = $this->categories_tree->treelist($param1);
			$this->data['row_count'] = $this->categories_tree->row_count;
			$this->data['max_level'] = $this->categories_tree->max_category_level;

			// check of last active slugs selected for category tree
			if ($this->session->admin_sa_mod_slug_segs)
			{
				// get last category slug
				$this->data['slug_segs'] = explode('/', $this->session->admin_sa_mod_slug_segs);
				$category_slug = end($this->data['slug_segs']);
				$category_id = $this->categories_tree->get_id($category_slug);
				$designer_slug = reset($this->data['slug_segs']);
				$where_more['designer.url_structure'] = $designer_slug;
			}
			else
			{
				if ($designer_slug != 'shop7thavenue')
				{
					foreach ($this->data['des_subcats'] as $category)
					{
						// let's get the first max cat level category
						if ($category->category_level == $this->data['max_level'])
						{
							$category_id = $category->category_id;
							break;
						}
						else continue;
					}
				}
				else
				{
					// by default...
					$category_id = '195';
				}
			}

			$where_more['tbl_product.categories LIKE'] = $category_id;

			// get the products list for the thumbs grid view
			$params['show_private'] = TRUE; // all items general public (Y) - N for private
			$params['view_status'] = 'ALL'; // all items view status (Y, Y1, Y2, N)
			$params['view_at_hub'] = TRUE; // all items general public at hub site
			$params['view_at_satellite'] = TRUE; // all items publis at satellite site
			$params['variant_publish'] = 'ALL'; // all items at variant level publish (view status)
			$params['variant_view_at_hub'] = TRUE; // variant level public at hub site
			$params['variant_view_at_satellite'] = TRUE; // varian level public at satellite site
			$params['with_stocks'] = FALSE; // Show all with and without stocks
			$params['group_products'] = FALSE; // group per product number or per variant
			$params['special_sale'] = FALSE; // special sale items only
			$this->load->library('products/products_list', $params);
			$this->data['products'] = $this->products_list->select(
				$where_more,
				array( // order conditions
					'seque' => 'asc'
				)
			);
			$this->data['products_count'] = $this->products_list->row_count;

			// author
			if ($this->sales_package_details->sales_user == '1')
			{
				$this->data['author_name'] = 'In-House';
				$this->data['author'] = 'admin'; // admin/system
				$this->data['author_email'] = $this->webspace_details->info_email;
				$this->data['author_id'] = $this->session->admin_id;
			}
			else
			{
				$this->sales_user_details->initialize(
					array(
						'admin_sales_id' => $this->sales_package_details->sales_user
					)
				);

				$this->data['author_name'] = $this->sales_user_details->fname.' '.$this->sales_user_details->lname;
				$this->data['author'] = $this->data['author_name'];
				$this->data['author_email'] = $this->sales_user_details->email;
				$this->data['author_id'] = $this->sales_user_details->admin_sales_id;
			}

			// need to show loading at start
			$this->data['show_loading'] = @$this->data['products_count'] > 0 ? TRUE : FALSE;
			$this->data['search_string'] = FALSE;

			// set data variables...
			$this->data['role'] = 'sales';
			$this->data['file'] = 'sa_modify';
			$this->data['page_title'] = 'Sales Package Edit';
			$this->data['page_description'] = 'Modify Sales Packages';

			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template_my_account/template', $this->data);
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
			    [sales_user] => 1
			    [author] => admin
			    [prod_no] => Array
			        (
			            [0] => 036_BEIG1
			            [1] => 036_GREY1
			            [2] => 045_TAUP1
			        )
			)
			// other needed items
			[sales_package_items] -> sa_items
			// */

			echo 'Processing...';

			// connect to database
			$DB = $this->load->database('instyle', TRUE);

			// grab post data and process some of them to accomodate database
			$post_ary = $this->input->post();
			$post_ary['options'] = json_encode($post_ary['options']);

			// remove variables not needed
			unset($post_ary['files']);
			unset($post_ary['prod_no']);

			// set sales package items
			$post_ary['sales_package_items'] = $this->session->admin_sa_mod_items;

			// update records
			$DB->set($post_ary);
			$DB->where('sales_package_id', $id);
			$q = $DB->update('sales_packages');

			// unset create sessions
			unset($_SESSION['admin_sa_mod_items']);
			unset($_SESSION['admin_sa_mod_options']);

			// set flash data
			$this->session->set_flashdata('success', 'edit');

			// redirect user
			redirect('my_account/sales/listpackages/send/index/'.$id);
		}
	}
	public function delete($id = '')
	{
		echo 'Processing...';
		
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect('my_account/sales/listpackages');
		}
		
		// load pertinent library/model/helpers
		$this->load->library('sales_package/sales_package_details');
		
		// initialize certain properties
		$this->sales_package_details->initialize(array('sales_package_id'=>$id));
		
		if ($this->sales_package_details->author === 'system')
		{
			// cannot delete super sales
			// set flash data
			$this->session->set_flashdata('error', 'del_system_sales_package');
			
			// redirect user
			redirect('my_account/sales/listpackages');
		}
		
		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		
		// delete item from records
		$DB->where('sales_package_id', $id);
		$q = $DB->delete('sales_packages');
		
		// set flash data
		$this->session->set_flashdata('success', 'delete');
		
		// redirect user
		redirect('my_account/sales/listpackages');
	}
	public function send($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'campaigns/sales_package');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helpers('state_country');
		$this->load->library('sales_package/sales_package_list');
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('products/product_details');
		$this->load->library('designers/designers_list');
		$this->load->library('categories/categories_tree');
		$this->load->library('users/wholesale_users_list');
		$this->load->library('users/sales_user_details');
		$this->load->library('color_list');
		$this->load->library('form_validation');

		// initialize sales package properties
		$this->data['sa_details'] = $this->sales_package_details->initialize(
			array(
				'sales_package_id'=>$id
			)
		);

		// disect some information from sales package
		$this->data['sa_items'] = $this->sales_package_details->items;
		$this->data['sa_options'] = $this->sales_package_details->options;

		// author
		if ($this->sales_package_details->sales_user == '1')
		{
			$this->data['author_name'] = $this->webspace_details->name;
			$this->data['author'] = 'admin'; // admin/system
			$this->data['author_email'] = $this->webspace_details->info_email;
			$this->data['author_id'] = $this->session->admin_id;
		}
		else
		{
			$this->sales_user_details->initialize(
				array(
					'admin_sales_id' => $this->sales_package_details->sales_user
				)
			);

			$this->data['author_name'] = $this->sales_user_details->fname.' '.$this->sales_user_details->lname;
			$this->data['author'] = $this->data['author_name'];
			$this->data['author_email'] = $this->sales_user_details->email;
			$this->data['author_id'] = $this->sales_user_details->admin_sales_id;
		}

		// get data
		if (@$user_id)
		{
			$this->data['users'] = $this->wholesale_users_list->select(
				array( // where
					'tbluser_data_wholesale.user_id' => $user_id
				),
				array( // order by
					'tbluser_data_wholesale.store_name' => 'asc'
				)
			);
			$this->data['user_id'] = $user_id;
		}
		else
		{
			$this->data['users'] = $this->wholesale_users_list->select(
				array( // where
					'tbluser_data_wholesale.is_active' => '1'
				),
				array( // order by
					'tbluser_data_wholesale.store_name' => 'asc'
				)
			);
			$this->data['user_id'] = '';
		}
		$this->data['total_users'] = $this->wholesale_users_list->row_count;
		$this->data['users_per_page'] = 20;
		$this->data['end_cur_users'] = floor($this->data['total_users'] / $this->data['users_per_page']) + 1;

		// need to show loading at start
		$this->data['show_loading'] = FALSE;
		$this->data['search_string'] = FALSE;

		// set data variables...
		$this->data['role'] = 'sales';
		$this->data['file'] = 'sa_send';
		$this->data['page_title'] = 'Sales Package Sending';
		$this->data['page_description'] = 'Send Sales Packages To Users';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template5/template', $this->data);
	}
	public function set_as_default($id = '')
	{
		echo 'Processing...';
		
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect('my_account/sales/listpackages');
		}
		
		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		
		// remove any other set as defaul package
		$DB->set('set_as_default', '0');
		$q1 = $DB->update('sales_packages');
		
		// finally, update records
		$DB->set('set_as_default', '1');
		$DB->where('sales_package_id', $id);
		$q = $DB->update('sales_packages');
		
		// set flash data
		$this->session->set_flashdata('success', 'edit');
		
		// redirect user
		redirect('my_account/sales/listpackages');
	}
	
	public function reset($id = '')
	{
		// reset sessions
		unset($_SESSION['admin_sa_id']);
		unset($_SESSION['admin_sa_des_slug']);
		unset($_SESSION['admin_sa_slug_segs']);
		unset($_SESSION['admin_sa_items']);
		unset($_SESSION['admin_sa_name']);
		unset($_SESSION['admin_sa_email_subject']);
		unset($_SESSION['admin_sa_email_message']);
		unset($_SESSION['admin_sa_options']);
		// remove po mod details
		unset($_SESSION['admin_sa_mod_id']);
		unset($_SESSION['admin_sa_mod_items']);
		unset($_SESSION['admin_sa_mod_slug_segs']);
		unset($_SESSION['admin_sa_mod_options']);
		unset($_SESSION['admin_sa_mod_des_slug']);

		// redirect user
		if ($id) redirect('my_account/sales/listpackages/modify/index/'.$id, 'location');
		else redirect('my_account/sales/newpackage', 'location');
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
			// datatable
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '
		';

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
			// datatable
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/scripts/datatable.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
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
			// handle datatable
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/table-datatables-sales_package_list.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}