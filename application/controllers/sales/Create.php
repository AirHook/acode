<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends Sales_Controller {

	/**
	 * DB Object
	 *
	 * @var	object
	 */
	protected $DB;

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - Edit Sales Package
	 *
	 * Edit selected sales pacakge or newly created sales package
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		// nothing more to do...
		// set flash data
		$this->session->set_flashdata('error', 'no_id_passed');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'sales/dashboard', 'location');
	}

	// ----------------------------------------------------------------------

	public function step1()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('sales_package/update_sales_package');
		$this->load->library('products/product_details');

		// last segment as category slug
		$this->data['active_category'] =
			$this->uri->segment(2) == 'create'
			? ((count($this->data['url_segs']) - 1) >= 0 ? $this->data['url_segs'][count($this->data['url_segs']) - 1] : 'womens_apparel')
			: 'womens_apparel'
		;

		// get respective active category ID for use on product list where condition
		$category_id = $this->categories_tree->get_id($this->data['active_category']);

		// let's do some defaults...
 		// active designer selection
 		$this->data['active_designer'] = $this->sales_user_details->designer;

		// set array for where condition of get product list
		if ($this->data['active_designer'])
		{
			$where = array(
				'designer.url_structure' => $this->data['active_designer'],
				'tbl_product.categories LIKE' => '%'.$category_id.'%',
			);
		}
		else
		{
			$where = array(
				'tbl_product.categories LIKE' => '%'.$category_id.'%',
			);
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
		$this->data['show_loading'] = TRUE;
		$this->data['search_string'] = FALSE;

		// set data variables...
		$this->data['file'] = 'create_sales_package_step1'; //'sales_package';
		$this->data['page_title'] = 'Sales Package';
		$this->data['page_description'] = 'Edit Sales Packages';

		// load views...
		//$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		$this->load->view($this->data['sales_theme'].'/sales/template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	public function step2()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('products/product_details');

		// some necessary variables
		$this->data['steps'] = 2;

		// need to show loading at start
		$this->data['show_loading'] = FALSE;

		// set data variables...
		$this->data['file'] = 'create_sales_package_step2'; //'sales_package';
		$this->data['page_title'] = 'Sales Package';
		$this->data['page_description'] = 'Edit Sales Packages';

		$this->load->view($this->data['sales_theme'].'/sales/template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	public function step3()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helper('state_country_helper');
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('products/product_details');
		$this->load->library('users/wholesale_users_list');

		// initialize sales package properties and items
		// if $id is present, hence, saved sales package
		// set flags
		if ($this->session->sa_id)
		{
			// initialize certain properties
			$this->sales_package_details->initialize(array('sales_package_id'=>$this->session->sa_id));

			// compare current items with previously saved items
			if ($this->session->sa_items !== $this->sales_package_details->sales_package_items)
			{
				$this->data['i_changed'] = TRUE;
			}

			// retrieve sa_options for possible changes to 'e_prices'
			$options_array =
				$this->session->sa_options
				? json_decode($this->session->sa_options, TRUE)
				: array()
			;
			if (@$options_array['e_prices'] != @$this->sales_package_details->options['e_prices'])
			{
				$this->data['p_changed'] = TRUE;
			}
		}

		// get user list
		$params = array(
			'tbluser_data_wholesale.admin_sales_email' => $this->sales_user_details->email
		);
		$this->data['users'] = $this->wholesale_users_list->select($params);

		// some necessary variables
		$this->data['steps'] = 3;

		// need to show loading at start
		$this->data['show_loading'] = FALSE;

		// set data variables...
		$this->data['file'] = 'create_sales_package_step3'; //'sales_package';
		$this->data['page_title'] = 'Sales Package';
		$this->data['page_description'] = 'Edit Sales Packages';

		// load views...
		$this->load->view($this->data['sales_theme'].'/sales/template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	public function send()
	{
		//echo '<pre>';
		//print_r($this->input->post());
		//die();

		if ( ! $this->input->post())
		{
			// set flash data
			$this->session->set_flashdata('error', 'error_sending_package');

			// redirect user
			redirect('sales/create/step3', 'location');
		}

		// load pertinent library/model/helpers
		$this->load->library('sales_package/sales_package_details');

		/***********
		 * Process Sales Package
		 */
		// save sales package as new or existing

		// NOTES:
		// 1.0 name, email, and message is added to session if from an existing
		// sales package, in which case, input fields is pre-poppulated on
		// step 3 and then passed on here as so...
		// 2.0 sa_options is also passed to session, but, a consideration must
		// be done for other options saved for the sales package and preserved
		// as is, in which case, is set on sa_

		$post_sa = array(
			'sales_package_name' => $this->input->post('sales_package_name'),
			'email_subject' => $this->input->post('email_subject'),
			'email_message' => $this->input->post('email_message'),
			'sales_package_items' => $this->session->sa_items,
			'last_modified' => time()
		);

		// retrieve sa_options for possible changes to 'e_prices'
		$options_array =
			$this->session->sa_options
			? json_decode($this->session->sa_options, TRUE)
			: array()
		;

		//if ($this->session->sa_id)
		if ($this->input->post('sales_package_id') != '0')
		{
			// check and reset sales package options particularly for 'e_prices'
			if (isset($options_array['e_prices']))
			{
				$this->sales_package_details->initialize(array('sales_package_id'=>$this->session->sa_id));
				$this_sa_options = $this->sales_package_details->options;
				$this_sa_options['e_prices'] = $options_array['e_prices'];
				$post_sa['options'] = json_encode($this_sa_options);
			}

			// update existing sales package
			$this->DB->where('sales_package_id', $this->session->sa_id);
			$this->DB->update('sales_packages', $post_sa);
			$sa_id = $this->session->sa_id;
		}
		else
		{
			// save new sales package
			$post_sa['sales_user'] = $this->sales_user_details->admin_sales_id;
			$post_sa['author'] = $this->sales_user_details->fname.' '.$this->sales_user_details->lname;
			$post_sa['date_create'] = date('Y-m-d', time());
			$post_sa['options'] = @$options_array['e_prices'] ? json_encode(array('e_prices'=>$options_array['e_prices'])) : '';
			$this->DB->insert('sales_packages', $post_sa);
			$sa_id = $this->DB->insert_id();
		}

		// check for 'preset'
		if ($this->session->sa_preset)
		{
			$user_options = $this->sales_user_details->options;
			$user_options['preset'][$this->session->sa_preset] = $sa_id;
			$this->sales_user_details->update_options($user_options);
		}

		/***********
		 * Process Users
		 */
		if ($this->input->post('send_to') === 'new_user')
		{
			// add user to wholesale list and set user array
			$post_user = array(
				'email' => $this->input->post('email'),
				'pword' => 'instyle2019', // set default
				'store_name' => $this->input->post('store_name'),
				'firstname' => $this->input->post('firstname'),
				'lastname' => $this->input->post('lastname'),
				'fed_tax_id' => $this->input->post('fed_tax_id'),
				'telephone' => $this->input->post('telephone'),
				'address1' => $this->input->post('address1'),
				'address2' => $this->input->post('address2'),
				'city' => $this->input->post('city'),
				'state' => $this->input->post('state'),
				'country' => $this->input->post('country'),
				'zipcode' => $this->input->post('zipcode'),
				'create_date' => date('Y-m-d', time()),
				'admin_sales_id' => $this->input->post('email'),
				'admin_sales_email' => $this->input->post('email'),
				'reference_designer' => $this->input->post('email')
			);
			$this->DB->insert('tbluser_data_wholesale', $post_user);
			$users = array($this->input->post('email'));
		}
		else $users = $this->input->post('email');

		// send the sales package
		$this->load->library('sales_package/sales_package_sending');
		$this->sales_package_sending->initialize(
			array(
				'sales_package_id' => $sa_id,
				'w_prices' => $this->input->post('w_prices'),
				'w_images' => $this->input->post('w_images'),
				'linesheets_only' => $this->input->post('linesheets_only'),
				'users' => $users
			)
		);

		if ( ! $this->sales_package_sending->send())
		{
			$this->session->set_flashdata('error', 'error_sending_package');

			redirect('sales/create/step3', 'location');
		}

		// all is well, sales package is now saved to list
		// we now set the session sa_id to recodnize package is saved
		$this->session->set_userdata('sa_id', $sa_id);

		// set flash data
		$this->session->set_flashdata('success', 'sales_package_sent');

		redirect('sales/create/step3', 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Creaet Plugin Scripts and CSS for the page
	 *
	 * @return	void
	 */
	public function filter($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/');
		}

		if ($this->input->post('designer')) $this->session->set_userdata('designer', $this->input->post('designer'));
		if ($this->input->post('category')) $this->session->set_userdata('category', $this->input->post('category'));
		if ($this->input->post('categories')) $this->session->set_userdata('categories', $this->input->post('categories'));
		if ($this->input->post('order_by')) $this->session->set_userdata('order_by', $this->input->post('order_by'));

		redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/edit/index/'.$id);
	}

	// ----------------------------------------------------------------------

	/**
	 * Clear Recent User Edit List
	 *
	 * @return	void
	 */
	public function clear_recent()
	{
		// capture webspace details options
		$options = $this->webspace_details->options;

		// get the array of recent users and unset it
		if (
			isset($options['recent_sales_package'])
			&& ! empty($options['recent_sales_package'])
		) unset($options['recent_sales_package']);

		// udpate the sales package items...
		$this->DB->set('webspace_options', json_encode($options));
		$this->DB->where('webspace_id', $this->webspace_details->id);
		$q = $this->DB->update('webspaces');

		// set flash data
		$this->session->set_flashdata('clear_recent_sales_package', TRUE);

		// reload page
		redirect($_SERVER['HTTP_REFERER'], 'location');
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
			// fancybox
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" media="screen" />
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
			// fancybox
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
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
			// bootbox
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/sales_pacakge-edit.js" type="text/javascript"></script>
			';
			// handle multiSelect
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/sales_package-send.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
