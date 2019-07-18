<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends Search_Controller
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
	function index()
	{
		// load pertinent library/model/helpers
		$this->load->helpers('metronic/create_category_treelist_helper');
		
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();
		
		// serach results page will use the sidebar for browse
		// by category
		$this->browse_by = 'sidebar_browse_by_category';
		$this->sc_url_structure = '';
		//$this->d_url_structure = '';
		
		// footer text for SEO purposes
		// applicable to thumbs pages only
		$this->data['footer_text'] = '';
		
		// check for query string for faceting
		//$this->check_facet_query_string();
		
		// wholesale user page visits and product clicks tracking
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
		
		// now, get the product items
		$this->search_products($this->input->post('style_no'));
		
		// if no search result, send to shop/all
		if ($this->products_list->row_count == 0) 
		{
			// set flash data
			$_SESSION['flashMsg'] = 'zero_search_result';
			$this->session->mark_as_flash('flashMsg');
			
			redirect('shop/all');
		}
		
		// set data variables to pass to view file
		//$this->data['file'] 			= 'product_thumbs_new';
		$this->data['file'] 			= 'product_thumbs'; // 'blank_page'
		$this->data['view_pane']	 	= 'thumbs_list_subcategory_products'; // not being used
		$this->data['view_pane_sql'] 	= @$this->products;
		$this->data['left_nav'] 		= $this->browse_by;
		$this->data['left_nav_sql'] 	= @$sidebar_qry;
		$this->data['search_by_style'] 	= TRUE;
		$this->data['search_result']	= TRUE;
		$this->data['search_string']	= $this->input->post('style_no');
		$this->data['site_title']		= @$meta_tags['title'];
		$this->data['site_keywords']	= @$meta_tags['keyword'];
		$this->data['site_description']	= @$meta_tags['description'];
		$this->data['alttags']			= @$meta_tags['alttags'];
		
		$this->data['c_url_structure']	= 'apparel';
		$this->data['d_url_structure']	= $this->d_url_structure;
		$this->data['sc_url_structure']	= $this->sc_url_structure;
		
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
			// matchheight
			$this->data['page_level_plugins'].= '
				<script src="'.base_url().'assets/custom/jscript/matchheight/jquery.matchHeight.min.js" type="text/javascript"></script>
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
