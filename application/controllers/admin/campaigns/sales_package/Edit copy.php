<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends Admin_Controller {

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
		$this->load->library('categories/categories_tree');
		$this->load->library('designers/designers_list');	// 	the sales package
		$this->load->library('designers/designer_details');
		$this->load->library('products/product_details');	// 	sed on view file to set image paths
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('sales_package/update_sales_package');

		// update designer sales package if $id = '2'
		if ($id == '2')
		{
			if ( ! $this->update_sales_package->update_designer_recent_items($this->input->post('designer')))
			{
				// set flash data
				$this->session->set_flashdata('error', 'no_id_passed');

				// redirect user
				redirect($this->config->slash_item('admin_folder').'campaigns/sales_package');
			}

			// intialize designer details
			$this->designer_details->initialize(array('designer.des_id'=>$this->input->post('designer')));
		}

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

		// let's do some defaults...
		// active designer selection
		$this->data['active_designer'] =
			$this->session->designer ?:
			(
				@$this->webspace_details->options['site_type'] === 'hub_site'
				? (
					@$this->webspace_details->options['primary_designer'] ?:
					$this->designers_list->first_row->url_structure
				)
				: ($this->webspace_details->slug ?: $this->config->item('site_slug')) // should default to the webspace slug for sat_sites
			)
		;

		// initiate categories via select
		$this->categories_tree->select(
			array(
				'd_url_structure LIKE' => '%'.$this->data['active_designer'].'%'
			)
		);

		// active category selection
		// changing active categories using id's in an array
		// from the old version using slugs
		$this->data['active_category'] =
			$this->session->active_category
			?: $this->categories_tree->first_row->category_slug // first category on list
		;

		// misc...
		$this->data['order_by'] = $this->session->userdata('order_by') ?: 'prod_date';

		// process the category array putting those checked items (active categories) at top of list
		// add a new object field 'checked' to object
		foreach ($this->data['categories'] as $category)
		{
			if (is_array($this->data['active_category']))
			{
				$category->checked = in_array($category->category_id, $this->data['active_category']) ? 'checked' : 'unchecked';
			}
			else $category->checked = $category->category_slug == $this->data['active_category'] ? 'checked' : 'unchecked';
		}
		// sorting array using a user-defined comparison function
		function compare($a, $b)
		{
			return strcmp($a->checked, $b->checked);
		}
		// sort the object
		usort($this->data['categories'], "compare");

		// set array for where condition of get product list
		if (
			$this->data['active_category'] === 'uncategorized'
			OR $this->data['active_category'] === '0'
		)
		{
			// this will be depracated
			$where = array(
				'designer.url_structure' => $this->data['active_designer'],
				'tbl_product.categories LIKE' => '%[]%',
				'OR tbl_product.categories' => '',
				'OR tbl_product.categories' => '0',
			);
		}
		else
		{
			if (is_array($this->data['active_category']))
			{
				$where = array(
					'designer.url_structure' => $this->data['active_designer']
				);
				// search if '0' is in array and remove it for the where condition
				$active_category = $this->data['active_category'];
				//$key = array_search('0', $active_category);
				//if ($key !== FALSE) unset($active_category[$key]);
				//$active_category = array_values($active_category);
				for ($v = 0; $v < count($active_category); $v++)
				{
					if ($v == 0) $where['tbl_product.categories LIKE'] = '%'.($active_category[$v] == '0' ? '[]' : $active_category[$v]).'%';
					else $where['OR tbl_product.categories LIKE'] = '%'.($active_category[$v] == '0' ? '[]' : $active_category[$v]).'%';
				}
			}
			else
			{
				// this will be depracated
				$where = array(
					'designer.url_structure' => $this->data['active_designer'],
					'OR tbl_product.categories LIKE' => '%'.$this->categories_tree->get_id($this->data['active_category']).'%',
				);
			}
		}

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
				$this->data['order_by'] => ($this->data['order_by'] == 'prod_date' ? 'desc' : 'asc')
			)
		);
		$this->data['products_count'] = $this->products_list->row_count;

		// this will be used to hold the designers generated from above
		//$this->data['categories'] = array();

		// need to show loading at start
		$this->data['show_loading'] = TRUE;

		// set data variables...
		$this->data['file'] = 'sales_package';
		$this->data['page_title'] = 'Sales Package';
		$this->data['page_description'] = 'Edit Sales Packages';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
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
	}

	// ----------------------------------------------------------------------

}
