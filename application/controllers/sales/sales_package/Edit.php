<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends Sales_Controller {

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
		redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/');
	}

	// ----------------------------------------------------------------------

	public function step1($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('sales/sales_package', 'location');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('sales_package/update_sales_package');
		$this->load->library('products/product_details');

		// in case sales package is the system generated sales package
		// such as General Recent Items and Designer Recent Items
		// we update the sales package before displaying
		$this->update_sales_package->update_recent_items();
		if ($id == '2') $this->update_sales_package->update_designer_recent_items($id);

		// initialize sales package properties
		$this->sales_package_details->initialize(array('sales_package_id'=>$id));

		// update recent list for edit sales packages sidebar menu
		if ( ! $this->session->flashdata('clear_recent_sales_package'))
		{
			$this->webspace_details->update_recent_sales_package(
				array(
					'sales_package_id' => $this->sales_package_details->sales_package_id,
					'sales_package_name' => $this->sales_package_details->sales_package_name
				)
			);
		}

		// some necessary variables
		$this->data['steps'] = 1;

		// need to show loading at start
		$this->data['show_loading'] = FALSE;

		// set data variables...
		$this->data['file'] = 'sales_package_edit_step1'; //'sales_package';
		$this->data['page_title'] = 'Sales Package';
		$this->data['page_description'] = 'Edit Sales Packages';

		// load views...
		//$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		$this->load->view($this->data['sales_theme'].'/sales/template', $this->data);
	}

	// ----------------------------------------------------------------------

	public function step2($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('sales/sales_package', 'location');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('categories/categories_tree');
		$this->load->library('designers/designers_list');
		$this->load->library('designers/designer_details');
		$this->load->library('products/product_details');

		// initialize sales package properties
		$this->sales_package_details->initialize(array('sales_package_id'=>$id));

		// update recent list for edit sales packages sidebar menu
		if ( ! $this->session->flashdata('clear_recent_sales_package'))
		{
			$this->webspace_details->update_recent_sales_package(
				array(
					'sales_package_id' => $this->sales_package_details->sales_package_id,
					'sales_package_name' => $this->sales_package_details->sales_package_name
				)
			);
		}

		// get some data
		$this->data['designers'] = $this->designers_list->select();
		$this->data['categories'] = $this->categories_tree->treelist(array('with_products'=>TRUE));
		$this->data['number_of_categories'] = $this->categories_tree->row_count;

		// let's do some defaults...
		// active designer selection
		$this->data['active_designer'] = $this->sales_user_details->designer;

		// initiate categories via select
		$this->categories_tree->select(
			array(
				'd_url_structure LIKE' => '%'.$this->data['active_designer'].'%'
			)
		);

		// let's grab the uri segments
		$this->session->set_flashdata('thumbs_uri_string', $this->uri->uri_string());
		$this->data['url_segs'] = explode('/', $this->uri->uri_string());

		// let's remove the segments (up to controller class method/function)
		// and parameters from the resulting array
		array_shift($this->data['url_segs']); // sales
		array_shift($this->data['url_segs']); // sales_package
		array_shift($this->data['url_segs']); // edit
		array_shift($this->data['url_segs']); // step2
		array_shift($this->data['url_segs']); // sales_package_id

		// get the last segment which will serve as the category_slug in reference for the product list
		if (count($this->data['url_segs']) > 0)
		{
			// we need to check if browsing by designer/category through the first segment
			$first_seg = $this->data['url_segs'][0];
			if ($this->designer_details->initialize(array('designer.url_structure'=>$first_seg)))
			{
				// use first segment designer_slug if present
				$this->data['active_designer'] = $this->designer_details->slug;
				// and set sessiong accordingly
				$this->session->set_userdata('active_designer', $this->designer_details->slug);
			}
			/*
			else
			{
				// check for session first, otherwise, go browse by category only
				$this->data['active_designer'] = FALSE;
				unset($_SESSION['active_designer']);
			}
			*/

			// last segment as category slug
			$this->data['active_category'] = $this->data['url_segs'][count($this->data['url_segs']) - 1];
		}
		else
		{
			// defauls to all dresses under womens apparel
			if ($this->uri->segment(1) === 'sales')
			{
				redirect('sales/sales_package/edit/step2/'.$id.'/womens_apparel');
			}
			else redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/edit/step2/'.$id.'/womens_apparel');
			//$this->data['active_designer'] = FALSE;
			//$this->data['active_category'] = 'womens_apparel';
		}

		// get respective active category ID for use on product list where condition
		$category_id = $this->categories_tree->get_id($this->data['active_category']);

		// misc...
		$this->data['order_by'] = $this->session->userdata('order_by') ?: 'seque';

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

		//echo '<pre>'; print_r($where); die();

		// get the products list
		$params['show_private'] = TRUE; // all items general public (Y) - N for private
		$params['view_status'] = 'ALL'; // ALL items view status (Y, Y1, Y2, N)
		$params['variant_publish'] = 'ALL'; // ALL variant level color publish (view status)
		$params['group_products'] = TRUE; // group per product number or per variant
		// show items even without stocks at all
		$params['with_stocks'] = FALSE;
		$this->load->library('products/products_list', $params);
		$this->data['products'] = $this->products_list->select(
			$where,
			array( // order conditions
				$this->data['order_by'] => ($this->data['order_by'] == 'seque' ? 'desc' : 'asc')
			)
		);
		$this->data['products_count'] = $this->products_list->row_count;

		// some necessary variables
		$this->data['steps'] = 2;

		// need to show loading at start
		$this->data['show_loading'] = ENVIRONMENT == 'development' ? FALSE : TRUE;

		// set data variables...
		$this->data['file'] = 'sales_package_edit_step2'; //'sales_package';
		$this->data['page_title'] = 'Sales Package';
		$this->data['page_description'] = 'Edit Sales Packages';

		// load views...
		//$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		$this->load->view($this->data['sales_theme'].'/sales/template', $this->data);
	}

	// ----------------------------------------------------------------------

	public function step3($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('products/product_details');

		// initialize sales package properties
		$this->sales_package_details->initialize(array('sales_package_id'=>$id));

		// update recent list for edit sales packages sidebar menu
		if ( ! $this->session->flashdata('clear_recent_sales_package'))
		{
			$this->webspace_details->update_recent_sales_package(
				array(
					'sales_package_id' => $this->sales_package_details->sales_package_id,
					'sales_package_name' => $this->sales_package_details->sales_package_name
				)
			);
		}

		$data['username'] = '<cite>Customer Name</cite>';
		$data['email_message'] = $this->sales_package_details->email_message;

		$data['access_link'] = '';

		$data['items'] = $this->sales_package_details->items;
		$data['email'] = '';
		$data['w_prices'] = 'Y';
		$data['w_images'] = '';
		$data['linesheets_only'] = '';
		$data['sales_username'] = @$this->sales_user_details->admin_sales_id ? ucwords(strtolower(trim($this->sales_user_details->fname).' '.trim(@$this->sales_user_details->lname))) : ucwords(strtolower(trim(@$this->wholesale_user_details->admin_sales_user).' '.trim(@$this->wholesale_user_details->admin_sales_lname)));
		$data['sales_ref_designer'] = @$this->sales_user_details->admin_sales_id ? @$this->sales_user_details->designer_name : @$this->wholesale_user_details->designer;

		// let's get the message
		$this->data['html_email'] = $this->load->view('templates/sales_package', $data, TRUE);

		// some necessary variables
		$this->data['steps'] = 3;

		// need to show loading at start
		$this->data['show_loading'] = FALSE;

		// set data variables...
		$this->data['file'] = 'sales_package_edit_step3'; //'sales_package';
		$this->data['page_title'] = 'Sales Package';
		$this->data['page_description'] = 'Edit Sales Packages';

		// load views...
		//$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		$this->load->view($this->data['sales_theme'].'/sales/template', $this->data);
	}

	// ----------------------------------------------------------------------

	public function step4($id = '', $user_id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('products/product_details');
		$this->load->library('users/wholesale_users_list');

		// initialize sales package properties
		$this->sales_package_details->initialize(array('sales_package_id'=>$id));

		// get data
		if ($user_id)
		{
			$this->data['users'] = $this->wholesale_users_list->select(array('tbluser_data_wholesale.user_id'=>$user_id));
			$this->data['user_id'] = $user_id;
		}
		else
		{
			$this->data['users'] = $this->wholesale_users_list->select(array('tbluser_data_wholesale.is_active'=>'1'));
			$this->data['user_id'] = $user_id;
		}

		// some necessary variables
		$this->data['steps'] = 4;

		// need to show loading at start
		$this->data['show_loading'] = FALSE;

		// set data variables...
		$this->data['file'] = 'sales_package_edit_step4';
		$this->data['page_title'] = 'Sales Package';
		$this->data['page_description'] = 'Edit Sales Packages';

		// load views...
		//$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		$this->load->view($this->data['sales_theme'].'/sales/template', $this->data);
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
