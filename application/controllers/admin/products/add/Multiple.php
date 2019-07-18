<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Multiple extends Admin_Controller {

	/**
	 * DB Reference
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

	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('designers/designers_list');
		$this->load->library('categories/categories');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('designer', 'Designer', 'trim|required');
		$this->form_validation->set_rules('subcat_id', 'Categories', 'trim|required');
		$this->form_validation->set_rules('products', 'Product Numbers', 'trim|required|callback_process_products');

		if ($this->form_validation->run() == FALSE)
		{
			// check for default tab
			$this->data['active_tab'] = $this->session->userdata('active_tab') ?: 'general';

			// set data variables
			$this->data['designers'] = $this->designers_list->select();

			// set page variables...
			$this->data['file'] = 'products_add_multiple';
			$this->data['page_title'] = 'Add Products';
			$this->data['page_description'] = 'Add multiple products';

			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		}
		else
		{
			// process input variables
			$post_ary = $this->input->post();
			// set necessary variables
			$post_ary['cat_id'] = '1'; // fashion default cat_id
			$post_ary['prod_date'] = @date('Y-m-d', time());
			$post_ary['view_status'] = 'N';
			$post_ary['public'] = 'Y';
			$post_ary['publish'] = '0';
			// process/add some variables
			$products = explode(',', strtoupper(trim($post_ary['products'])));
			$d_url_structure = $post_ary['designer_slug'];
			$c_url_structure = 'apparel';
			$sc_url_structure = $post_ary['subcat_slug'];
			// unset unneeded variable
			unset($post_ary['products']);
			unset($post_ary['designer_slug']);
			unset($post_ary['subcat_slug']);

			// assume only prod_no and no color to add
			$insert_color = FALSE;

			// process records
			foreach ($products as $product)
			{
				// breakdown product texts
				$prod_ary = explode('_', trim($product));

				// the following processes is also taken cared of
				// at the form validation callback function

				// first array index is always the prod_no
				// lets validate the prod_no
				// (FALSE for non-existent which means new product)
				if ($this->product_details->initialize(array('tbl_product.prod_no'=>trim($prod_ary[0]))))
				{
					// set prod_id if existing
					$_prod_id = $this->product_details->prod_id;
					$post_ary['prod_date'] = $this->product_details->create_date;
					$post_ary['view_status'] = $this->product_details->view_status;
					$post_ary['public'] = $this->product_details->public;
					$post_ary['publish'] = $this->product_details->publish;
				}
				else $_prod_id = FALSE;

				// set prod_no regardless of breakdown count
				// and existing or not
				$_prod_no = trim($prod_ary[0]);

				// assume color doesn't exist, get color name of color code
				// (return FALSE for existing color on existing prod_id)
				if (isset($prod_ary[1]))
				{
					$_color_name = $this->_color_name(trim($prod_ary[1]), $_prod_id);
				}

				// check and set prices
				if (isset($prod_ary[2]))
				{
					if ( ! $this->_is_camera_sequence(isset($prod_ary[2]))) $_wholesale_price = trim($prod_ary[2]);
				}
				else $_wholesale_price = FALSE;

				// check and set vendor code
				if (isset($prod_ary[3]))
				{
					if ( ! $this->_is_camera_sequence(isset($prod_ary[3]))) $_vendor_code = trim($prod_ary[3]);
				}
				else $_vendor_code = FALSE;

				// add the color variant on the colors field
				if (@$_color_name)
				{
					if ($_prod_id)
					{
						$post_ary['colors'] = $this->product_details->colors.'-'.$_color_name;
					}
					else
					{
						$post_ary['colors'] = $_color_name;
						$post_ary['primary_img_id'] = trim($prod_ary[1]);
					}
				}

				// process data
				$post_ary['prod_no'] = $_prod_no;
				if ($_vendor_code)
				{
					$post_ary['vendor_id'] = $this->_get_vendor_id($_vendor_code);
				}
				if ($_wholesale_price)
				{
					$post_ary['wholesale_price'] = $_wholesale_price;
					$post_ary['less_discount'] = $_wholesale_price * 2;
				}

				if ($_prod_id)
				{
					// update the record...
					$this->DB->set($post_ary);
					$this->DB->where('prod_id', $_prod_id);
					$this->DB->update('tbl_product');
				}
				else
				{
					// insert the record...
					$this->DB->set($post_ary);
					$this->DB->insert('tbl_product');
					$_prod_id = $this->DB->insert_id();
				}

				if (@$_color_name)
				{
					$data = array(
						'prod_id' => $_prod_id,
						'prod_no' => $_prod_no,
						'color_name' => $_color_name,
						'primary_color' => (
							@$post_ary['primary_img_id']
							? '1'
							: '0'
						),
						'stock_date' => $post_ary['prod_date'],
						'des_id' => $post_ary['designer'],
						'color_publish' => 'Y', // publishing color as over all product publish is set to UNPUBLISH-ed
						'new_color_publish' => 1 // publishing color as over all product publish is set to UNPUBLISH-ed
					);

					$this->DB->insert('tbl_stock', $data);
					$stock_id = $this->DB->insert_id();
				}

				// process data to post to ODOO
				$post_ary_to_odoo = $post_ary;
				$post_ary_to_odoo['prod_id'] = $_prod_id;
				$post_ary_to_odoo['cat_slug'] = $c_url_structure;
				$post_ary_to_odoo['designer_slug'] = $d_url_structure;
				$post_ary_to_odoo['subcat_slug'] = $sc_url_structure;
				if ($_vendor_code) $post_ary_to_odoo['vendor_code'] = $_vendor_code;
				if (@$_color_name)
				{
					$post_ary_to_odoo['stock_id'] = $stock_id;
					$post_ary_to_odoo['color'] = $_color_name;
					$post_ary_to_odoo['primary_color'] = @$post_ary_to_odoo['primary_img_id'] ? '1' : '0';
				}
				$post_ary_to_odoo['retail_price'] = $post_ary_to_odoo['less_discount'];

				unset($post_ary_to_odoo['vendor_id']);
				unset($post_ary_to_odoo['less_discount']);
				unset($post_ary_to_odoo['des_id']);
				unset($post_ary_to_odoo['colors']);
				unset($post_ary_to_odoo['primary_img_id']);

				// add product to odoo
				/* *
				if (
					ENVIRONMENT !== 'development'
					&& $this->input->post('designer_slug') === 'basixblacklabel'
				)
				{
					$this->_add_product_to_odoo($post_ary_to_odoo);
				}
				// */

				// reset processed post_ary indeces
				unset($post_ary['colors']);
				unset($post_ary['primary_img_id']);
				unset($post_ary['wholesale_price']);
				unset($post_ary['less_discount']);
				unset($post_ary['vendor_code']);
			}

			// set flash data
			$_SESSION['active_designer'] = $d_url_structure;
			$_SESSION['active_category'] = $sc_url_structure;
			$_SESSION['success'] = 'add';
			$this->session->mark_as_flash('success');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'products');
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Add Product To Odoo via API
	 *
	 * @access 	private
	 * @return	void
	 */
	private function _add_product_to_odoo($post_ary)
	{
		//
		// A very simple PHP example that sends a HTTP POST to a remote site
		//
		//$api_url = base_url('test/test_ajax_post_to_odoo');
		$api_url = 'http://70.32.74.131:8069/api/create/single/product';
		$api_key = $this->config->item('odoo_api_key');
		if ($api_url != '')
		{
			// add api_key to post_ary
			$post_ary['client_api_key'] = $api_key;

			// set post fields
			$post = $post_ary;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $api_url);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			// execute
			$response = curl_exec($ch);

			// for debugging purposes, check for response
			/*
			if($response === false)
			{
				//echo 'Curl error: ' . curl_error($ch);
				// set flash data
				$this->session->set_flashdata('error', 'post_data_error');
				$this->session->set_flashdata('error_value', curl_error($ch));

				redirect($this->config->slash_item('admin_folder').'products/edit/index/'.$prod_id, 'location');
			}
			*/

			// close the connection, release resources used
			curl_close ($ch);
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Get vendor id given vendor code
	 *
	 * @params	string
	 * @return	string/boolean FALSE
	 */
	private function _get_vendor_id($vendor_code)
	{
		// get recrods
		$this->DB->where('vendor_code', $vendor_code);
		$q = $this->DB->get('vendors');

		if ($q->num_rows() > 0)
		{
			return $q->row()->vendor_id;
		}
		else return FALSE;
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Get color name given color code
	 *
	 * @params	string
	 * @return	string/boolean FALSE
	 */
	private function _get_color_name($color_code)
	{
		// get recrods
		$this->DB->where('color_code', $color_code);
		$q = $this->DB->get('tblcolor');

		if ($q->num_rows() > 0)
		{
			return $q->row()->color_name;
		}
		else return FALSE;
	}

	// ----------------------------------------------------------------------

	/**
	 * CALLBACK function for form validation on input element $products
	 *
	 * @params	string
	 * @return	boolean
	 */
	public function process_products($str)
	{
		// break down $str
		$products = explode(',', strtoupper(trim($str)));

		foreach ($products as $product)
		{
			$prod_ary = explode('_', $product);

			// first array index is always the prod_no
			// lets validate the prod_no
			$_prod_id = $this->_prod_id(trim($prod_ary[0]));

			// if item is prod_no only
			if (count($prod_ary) == 1)
			{
				// for only prod_no items
				if ($_prod_id)
				{
					// prod_no already exists, nothing more to do...
					$this->form_validation->set_message('process_products', '"'.trim($prod_ary[0]).'" in your list already exists!<br /> Remove it and submit form again.');
					return FALSE;
				}
			}

			// get color_name if color doesn't exist (false for existing)
			if (isset($prod_ary[1])) $_color_name = $this->_color_name(trim($prod_ary[1]), $_prod_id);

			// if item is with color_code and other info
			// important to check on color code for existence
			if (count($prod_ary) > 1)
			{
				// let's validate color
				if ($_prod_id && ! $_color_name)
				{
					// prod_no and color already exists, nothing more to do...
					$this->form_validation->set_message('process_products', 'Either "'.trim($product).'" in your list already exists, or, there is something wrong with the color code!<br /> Please check and change, or, remove it and submit form again.');
					return FALSE;
				}

				if ( ! $_color_name)
				{
					// something wrong with color code
					$this->form_validation->set_message('process_products', 'There is something wrong with the color code of "'.trim($product).'" in your list!<br /> Please check and change, or, remove it and submit form again.');
					return FALSE;
				}

				if (isset($prod_ary[3]))
				{
					if ( ! $this->_get_vendor_id(trim($prod_ary[3])))
					{
						// something wrong with vendor code
						$this->form_validation->set_message('process_products', 'The vendor code portion of "'.trim($product).'" in your list is not valid!<br /> Please check and change, or, remove it and submit form again.');
						return FALSE;
					}
				}
			}
		}

		return TRUE;
	}

	// ----------------------------------------------------------------------

	/**
	 * Check if PROD_NO exists
	 *
	 * Set _prod_id to prod_id and return for use on updating prod
	 * If this is false, it will mean product is new and will use insert process instead
	 *
	 * @params	string
	 * @return	string/boolean -> prod_id if true
	 */
	public function _prod_id($prod_no)
	{
		if ($this->product_details->initialize(array('tbl_product.prod_no'=>$prod_no)))
		{
			// if this index is set, product is existing
			return $this->product_details->prod_id;
		}
		else
		{
			return FALSE;
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Check if COLOR_CODE exists for product item
	 *
	 * @params	string
	 * @return	string/boolean FALSE
	 */
	public function _color_name($color_code, $prod_id)
	{
		// initialize records
		if ($this->product_details->initialize(array('tbl_product.prod_id'=>$prod_id)))
		{
			if ($this->product_details->available_colors())
			{
				foreach ($this->product_details->available_colors() as $color)
				{
					if ($color_code == $color->color_code)
					{
						return FALSE; // color exists for the product item
					}
				}
			}
		}

		return $this->_get_color_name($color_code); // new color
	}

	// ----------------------------------------------------------------------

	/**
	 * Check if string is camera sequence
	 *
	 * @scope	private
	 * @params	string
	 * @return	string/boolean FALSE
	 */
	private function _is_camera_sequence($str)
	{
		// will need to limit vendor code to less than 6 chars length
		// in order to ensure that camera sequence is checked
		// this is used only for 3rd and above index for product file name
		if (strlen($str) > 5) return TRUE;
		return FALSE;
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
			// fancybox
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
			';
			// dropzone
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
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
			// datepicker & date-time-pickers
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
			';
			// fancybox
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
			';
			// dropzone
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
			';
			// form validation
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
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
			// dropzone
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/form-dropzone.js" type="text/javascript"></script>
			';
			// datepicker & other compnents
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-products_add_multiple.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
