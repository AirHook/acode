<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * We shall be extending Frontend_Controller to reuse some methods
 * that are readily available. We only need to change the way thumbs
 * are presented such that we avoid too many HTTP requests that leads
 * to request time outs and 504 Bad Gateway errors (nginx)
 *
 * We are now able to show "all products" as new requirement by joe
 * 20170927. This gives us now the ability to create a proper controller
 * for all products per category
 */
class Designers extends Frontend_Controller
{
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();
	}
	
	// --------------------------------------------------------------------

	/**
	 * Index Page for this controller.
	 *
	 * This controller renders designer categories thumbs page
	 * This page replaces the old $this->show_designers2();
	 *
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function index(	)
	{
		/*
		// for backwards compatibility purposes
		if ($this->uri->segment(3) == 'basixblacklabel')
		{
			redirect('shop/designers/basix-black-label', 'location');
		}
		*/
		
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();
		
		// wholesale snippet
		if (
			$this->session->user_loggedin 
			&& $this->session->user_cat == 'wholesale'
			&& $this->session->this_login_id
		)
		{
			// set page name
			$pagename = 'shop/designers';
			
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
		
		// Set other variables to pass to the view file
		$this->data['file'] 			= 'product_designers';
		$this->data['view_pane']   		= 'thumbs_list_subcategories';
		$this->data['view_pane_sql'] 	= @$subcats;
		$this->data['left_nav'] 		= 'sidebar_browse_by_designer';
		$this->data['left_nav_sql'] 	= @$subcats;
		$this->data['search_by_style'] 	= FALSE;
		//$this->data['search_result']	= FALSE;
		//$this->data['jscript'] 			= $jscript;
		$this->data['site_title']		= @$meta_tags['title'];
		$this->data['site_keywords']	= @$meta_tags['keyword'];
		$this->data['site_description']	= @$meta_tags['description'];
		$this->data['alttags']			= @$meta_tags['alttags'];
		$this->data['footer_text']		= @$meta_tags['footer'];
		
		$this->data['d_url_structure']	= $this->uri->segment(3);
		$this->data['c_url_structure']	= 'apparel';
		$this->data['sc_url_structure']	= '';
		
		// load the view
		$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
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
		/****************
		 * page scripts for DEFAULT theme
		 */
		$this->data['jscript'] = '';
		
			// some old scripts for the pages
			$this->data['jscript'].= '<script type="text/javascript" src="'.base_url().'assets/js/jstools.js"></script>';
			// added autocomplete.js for search queries
			//$this->data['jscript'].= $this->set->autocomplete();
			//$this->data['jscript'].= $this->set->fade_thumbs_js(); //--> commenting to turn of thumb fadehover effect due to loading issues
			// add ui scripts and some jquery dailog script
			$this->data['jscript'].= '
				<link type="text/css" href="'.base_url().'jscript/themes/base/jquery.ui.all.css" rel="stylesheet" />
				<script type="text/javascript" src="'.base_url().'jscript/external/jquery.bgiframe-2.1.3.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.core.js"></script>					
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.widget.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.mouse.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.button.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.draggable.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.position.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.dialog.js"></script>
			';
	}
	
	// --------------------------------------------------------------------
	
}
