<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Admin_Controller {

	/**
	 * Properties that are used between view files
	 *
	 * @var	object
	 */
	public $cat_slugs; // used for category_slugs input(s) (edit product and upload images)

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
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('odoo');
		$this->load->library('products/product_details');
		$this->load->library('designers/designers_list');
		$this->load->library('categories/categories_tree');
		$this->load->library('color_list');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('prod_no', 'SKU (Prod. No.)', 'trim|required|callback_validate_prod_no');
		$this->form_validation->set_rules('prod_name', 'Product Name', 'trim|required');
		$this->form_validation->set_rules('designer', 'Designer', 'trim|required');
		$this->form_validation->set_rules('categories[]', 'Categories', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// de-initialize certain properties
			$this->product_details->initialize(array());

			// check for default tab
			$this->data['active_tab'] = $this->session->userdata('active_tab') ?: 'general';

			// set data variables
			$this->data['designers'] = $this->designers_list->select();
			//$this->data['categories'] = $this->categories_tree->treelist(array('d_url_structure'=>$this->product_details->d_url_structure));
			$this->data['categories'] = $this->categories_tree->treelist(array('view_status'=>'1'));
			$this->data['colors'] = $this->color_list->select();

			//$front_image = 'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_url_structure.'/product_front/'.$this->product_details->prod_no.'_'.$this->product_details->primary_img_id.'.jpg';

			// set some switches for incomplete items
			$this->data['inc_general'] = 0;
			$this->data['inc_colors'] = 0;
			$this->data['inc_images'] = 0;

			// set page variables...
			$this->data['file'] = 'products_edit';
			$this->data['page_title'] = 'Add Product';
			$this->data['page_description'] = 'Add new products';

			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		}
		else
		{
			// before inserting new product
			// we need to update seque since new product's seque is '0'
			$qry_str1 = "UPDATE tbl_product SET seque = seque + 1";
			$this->DB->query($qry_str1);

			// insert record
			// set $post_ary
			$post_ary = $this->input->post();
			$post_ary_to_odoo = $this->input->post();
			// unset unneeded variable
			unset($post_ary['category_slugs']);
			unset($post_ary['designer_slug']);
			// set additional items
			$post_ary['cat_id'] = '1'; // fashion default cat_id
			//$post_ary['subcat_id'] = ''; //
			$post_ary['categories'] = json_encode($post_ary['categories']);

			$this->DB->set($post_ary);
			$q = $this->DB->insert('tbl_product');
			$insert_id = $this->DB->insert_id();

			$post_ary_to_odoo['prod_id'] = $insert_id;
			$post_ary_to_odoo['categories'] = implode(',', $post_ary_to_odoo['categories']);
			$post_ary_to_odoo['prod_name'] = $post_ary_to_odoo['prod_no'];

			// pass data to odoo
			/* *
			if (
				ENVIRONMENT !== 'development'
				&& $post_ary_to_odoo['designer_slug'] === 'basixblacklabel'
			)
			{
				// pass to odoo
				$odoo_response = $this->odoo->post_data($post_ary_to_odoo, 'products', 'add');
			}
			// */

			//echo '<pre>';
			//print_r($post_ary_to_odoo);
			//echo $odoo_response;
			//die('<br />here');

			// update recent items after adding new product
			$this->load->library('sales_package/update_sales_package');
			$this->update_sales_package->update_recent_items(); // for multiple designer users
			$this->update_sales_package->update_designer_recent_items($post_ary['designer']); // singer designer users

			// set flash data
			$this->session->set_flashdata('success', 'add');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'products/edit/index/'.$insert_id);
		}
	}

	// ----------------------------------------------------------------------

	public function validate_prod_no($prod_no)
	{
		// check if prod_no exists...
		$this->DB->where('prod_no', $prod_no);
		$q = $this->DB->get('tbl_product');

		if ($q->num_rows() > 0)
		{
			$this->form_validation->set_message('validate_prod_no', 'Prod No already exists!');
			return FALSE;
		}
		else return TRUE;
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-products_add.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
