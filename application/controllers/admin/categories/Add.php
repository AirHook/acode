<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add extends Admin_Controller {

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
	
	/**
	 * Index - Edit Item
	 *
	 * Edit selected item
	 *
	 * @return	void
	 */
	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();
		
		// load pertinent library/model/helpers
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('categories/categories');
		$this->load->library('categories/categories_tree');
		$this->load->library('designers/designers_list');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('view_status', 'Status', 'trim|required');
		$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');
		$this->form_validation->set_rules('category_slug', 'Category Slug', 'trim|required|callback_check_slug');
		
		if ($this->form_validation->run() == FALSE)
		{
			// set data
			$this->data['categories'] = $this->categories_tree->treelist();
			$this->data['designers'] = $this->designers_list->select();
			
			// set data variables...
			$this->data['file'] = 'categories_add';
			$this->data['page_title'] = 'Category Add';
			$this->data['page_description'] = 'Add New Category';
			
			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		}
		else
		{
			//echo '<pre>';
			//print_r($this->input->post());
			//die();
			
			// insert record
			$post_ary = $this->input->post();
			// set necessary variables
			//$post_ary['account_status'] = '1';
			// process/add some variables
			
			// process the parent category
			// as such, category checkboxes are acting as radio button
			// so there is always only one category chosen as parent category
			// or none at all...
			if (isset($post_ary['categories']) && ! empty($post_ary['categories']))
			{
				$post_ary['parent_category'] = implode($post_ary['categories']);
				$post_ary['category_level'] = $post_ary['parent_category_level'] + 1;
			}
			else $post_ary['category_level'] = 0;
			
			// unset unneeded variables
			//unset($post_ary['passconf']);
			unset($post_ary['categories']);
			unset($post_ary['parent_category_level']);

			//echo '<pre>';
			//print_r($post_ary);
			//die();
			
			// finally, insert new record
			$this->DB->insert('categories', $post_ary);
			$inser_id = $this->DB->insert_id();

			// if no parent category is selected
			// we update records to indicate self as parent
			// by using the insert id as the parent category id
			if ( ! isset($post_ary['parent_category']))
			{
				// update record
				$this->DB->set('parent_category', $inser_id);
				$this->DB->where('category_id', $inser_id);
				$this->DB->update('categories');
			}
			
			// set flash data
			$this->session->set_userdata('active_category_tab', ($this->input->post('link_designer') ?: 'general'));
			$this->session->set_userdata('active_linked_designer_tab', ($this->input->post('link_designer') ?: 'general'));
			
			// set flash data
			$this->session->set_flashdata('success', 'add');
			
			redirect($this->config->slash_item('admin_folder').'categories/edit/index/'.$inser_id, 'location');
		}
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * PRIVATE - Check slug for duplicates
	 *
	 * @return	void
	 */
	public function check_slug($slug)
	{
		$query = $this->DB->get_where('categories', array('category_slug'=>$slug));
		
		if ($query->num_rows() > 0)
		{
			$this->form_validation->set_message('check_slug', 'The {field} already exists. Edit the Slug or create a new Name.');
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
			// dropzone
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
			';
			// bootstrap fileinput
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
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
			// form validation
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>		
			';
			// bootstap tabdrop
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
			';
			// dropzone
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
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
			// bootstap fileinput
			$this->data['page_level_scripts'].= '
				 <script src="'.$assets_url.'/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
			';
			// handle validation
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/form-validation-categories_add.js" type="text/javascript"></script>
			';
	}
	
	// ----------------------------------------------------------------------
	
}