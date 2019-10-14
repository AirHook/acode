<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Index extends Shop_Controller
{
	/**
	 * DB Object
	 *
	 * @return	object
	 */
	protected $DB;


	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();

		// connect to database for use by model
		$this->DB = $this->load->database('instyle', TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Primary method - index
	 *
	 * @return	void
	 */
	public function index()
	{
		// check of activation email click
		if ($this->input->get('act'))
		{
			// grab the uri access array
			$this->session->set_flashdata('segment_array', json_encode($this->uri->segment_array()));

			// grab the get values to session
			// while removing empty $_GET array elements
			$_GET = array_filter($this->input->get(), function($value) { return $value !== ''; });
			$this->session->set_flashdata('this_get', json_encode($_GET));

			// redirect user
			redirect('wholesale/activation_email_click', 'location');
		}

		// load pertinent library/model/helpers
		$this->load->library('designers/designer_details');
		$this->load->library('categories/category_details');
		$this->load->helpers('metronic/create_category_treelist_helper');

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// get the url segments to get the category ID of the last segment
		$this->session->set_flashdata('thumbs_uri_string', $this->uri->uri_string());
		$this->data['url_segs'] = explode('/', $this->uri->uri_string());
		// get the last category slug
		if (is_numeric($this->data['url_segs'][count($this->data['url_segs']) - 1]))
		{
			$last_category_slug = $this->data['url_segs'][count($this->data['url_segs']) - 2];
			// remove the numeric segment
			array_pop($this->data['url_segs']);
		}
		else $last_category_slug = $this->data['url_segs'][count($this->data['url_segs']) - 1];
		// get active category details
		$this->category_id = $this->categories_tree->get_id($last_category_slug);
		$this->data['category_details'] = $this->category_details->initialize(array('category_id' => $this->category_id));

		// other than shop/all, shop/categoreis, and shop/designers
		// shop/index is the main routing controller for both the
		// browse by category and browse by designer thumbs pages

		// we check if browse by designer or by general categories
		// by checking the first segment after shop if it's a designer slug
		// at satellite, it is assumed broswe by category but filter by designer
		$qry1 = $this->DB->get_where('designer', array('url_structure'=>$this->uri->segment(2)));
		if ($qry1->num_rows() > 0)
		{
			$this->browse_by = 'sidebar_browse_by_designer';
			$this->d_url_structure = $qry1->row()->url_structure;
		}
		else
		{
			$this->browse_by = 'sidebar_browse_by_category';
		}
		// on new category system, but we use the above $this->category_id instead
		$this->sc_url_structure = $last_category_slug;

		// now that $this->d_url_structure is set... in the case of tempoparis...
		// tempoparis is a stand alone wholesale site
		// we need to apply same conditions for tempo items at shop7
		// and not show tempo items in general pages
		// only when user is logged in
		if (
			$this->d_url_structure == 'tempoparis'
			&& $this->session->userdata('user_cat') != 'wholesale'
		)
		{
			// set session
			$this->session->set_flashdata('error', 'tempoparis_must_login');

			// redirect user..
			redirect('account', 'location');
		}

		// footer text for SEO purposes
		// applicable to thumbs pages only
		$this->data['footer_text'] = $this->thumbs_footer_text_model->get_footer_text('apparel/'.$this->sc_url_structure);

		// check for query string for faceting
		$this->check_facet_query_string();

		// wholesale user login details page visits tracking
		if ($this->num <= 1)
		{
			if (
				$this->session->user_loggedin
				&& $this->session->user_cat == 'wholesale'
				&& $this->session->this_login_id
			)
			{
				// set page name
				if ($this->browse_by == 'sidebar_browse_by_designer')
				{
					$pagename = 'shop/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4);
				}
				else
				{
					$pagename = 'shop/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
				}

				// update login details
				if ( ! $this->wholesale_user_details->update_login_detail(array($pagename, 1), 'page_visits'))
				{
					// in case the update went wrong
					// i.e., cases where user id in session got lost, or,
					// the record with the id was removed from database table...
					// manually logout user here to remove previous records, and
					// redirect to signin page
					$this->wholesale_user_details->initialize();
					$this->wholesale_user_details->unset_session();

					// destroy any cart items
					$this->cart->destroy();

					// set flash data
					$this->session->set_flashdata('flashMsg', 'Something went wrong with your connection.<br />Please login again.');

					// redirect to categories page
					redirect(site_url('wholesale/signin'), 'location');
				}
			}
		}

		// check for sort_by session
		if ($this->session->sort_by && $this->session->sort_by != '') $this->sort_by = $this->session->sort_by;

		// now we grab the product items
		$this->get_products();

		if ( ! $this->products) $this->get_suggested_products();

		// set data variables to pass to view file
		//$this->data['file'] 			= 'product_thumbs_new';
		$this->data['file'] 			= 'product_thumbs'; // 'blank_page'
		$this->data['view_pane']	 	= 'thumbs_list_subcategory_products'; // not being used
		$this->data['view_pane_sql'] 	= @$this->products ?: $this->suggested_products;
		$this->data['left_nav'] 		= $this->browse_by;
		$this->data['left_nav_sql'] 	= @$sidebar_qry;
		$this->data['search_by_style'] 	= TRUE;
		$this->data['search_result']	= FALSE;
		$this->data['site_title']		= @$meta_tags['title'];
		$this->data['site_keywords']	= @$meta_tags['keyword'];
		$this->data['site_description']	= @$meta_tags['description'];
		$this->data['alttags']			= @$meta_tags['alttags'];

		$this->data['c_url_structure']	= 'apparel';
		$this->data['d_url_structure']	= $this->d_url_structure;
		$this->data['sc_url_structure']	= $this->sc_url_structure;

		//$index = $this->d_url_structure ?: 'general';
		//$this->data['page_title'] = $this->category_details->title[$index];
		//$this->data['page_description'] = $this->category_details->$descriptions[$index];
		//$this->data['page_keywords'] = $this->category_details->keyword[$index];

		// get the product last query for use if user clicks on a product
		$this->session->set_tempdata('prod_list_last_query', $this->products_list->last_query, 1800);

		// load the view
		//$this->load->view($this->config->slash_item('template').'template', $this->data);
		//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
		$this->load->view('metronic/template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Create Plugin Scripts and CSS for the page
	 *
	 * This section is theme based.
	 * We will eventually need to come up with a system to load specific
	 * styles and scripts for each page as per selected theme
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

			// bootstrap select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
			';
			// bootstrap tagsinput
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
			';
			// iCheck
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />
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

			// unveil - lazy script for images
			$this->data['page_level_plugins'] = '
				<script src="'.base_url().'assets/custom/js/jquery.unveil.js" type="text/javascript"></script>
			';
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// bootstrap tagsinput
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
			';
			// iCheck
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
		 * after global scripts, before theme layout scripts
		 */
		$this->data['page_level_scripts'] = '';

			// handle bootstrap select - make select class '.bs-select' a boostrap select picker
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
			// handle scripts
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-frontend-product_thumbs-scripts.js" type="text/javascript"></script>
			';
	}

	// --------------------------------------------------------------------

}
