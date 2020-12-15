<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends Admin_Controller {

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
	public function __construct()
	{
		parent::__construct();

		// connect to database for use by model
		$this->DB = $this->load->database('instyle', TRUE);

		// load pertinent library/model/helpers
		$this->load->model('get_pages');
    }

	// ----------------------------------------------------------------------

	/**
	 * Index Page for this controller.
	 */
	public function index($page_params = '', $user_tag = 'cs', $webspace_id = '')
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('designers/designers_list');

		if ($this->webspace_details->options['site_type'] == 'hub_site')
		{
			$this->data['designers'] = $this->designers_list->select();
		}

		// some default params
		$params['url_structure'] = $page_params;
		$params['webspace_id'] = $webspace_id;
		$params['user_tag'] = 'consumer';

		// variable params
		if ($user_tag == 'ws')
		{
			$params['user_tag'] = 'wholesale';
		}

		// get page content
		$this->data['page_details'] = $this->get_pages->page_details_new($params);

		if ( ! $this->data['page_details'])
		{
			// automate loading using old data
			$this->_check_page_params($page_params, $user_tag, $webspace_id);

			// get data again
			$this->data['page_details'] = $this->get_pages->page_details_new($params);
		}

		// other variables to set
		$this->data['user_tag'] = $user_tag;

		// load pertinent library/model/helpers
		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', 'Title', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// set data variables...
			$this->data['file'] = 'pages';
			$this->data['page_title'] = 'Edit Pages';
			$this->data['page_description'] = 'Edit page contents using WYSIWYG';

			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		}
		else
		{
			// insert record
			$post_ary = $this->input->post();
			// set necessary variables
			//$post_ary['account_status'] = '1';
			// unset unneeded variables
			unset($post_ary['files']);

			// udpate records
			$this->DB->where('page_name', $post_ary['title']);
			$this->DB->where('webspace_id', $webspace_id);
			$this->DB->where('user_tag', $params['user_tag']);
			$this->DB->update('pages_new', $post_ary);

			// set flash data
			$this->session->set_flashdata('success', 'add');

			redirect('admin/pages/edit/index/'.$page_params.'/'.$user_tag.'/'.$webspace_id, 'location');
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Check for pages existing or create one if none
	 *
	 * @return	void
	 */
	private function _check_page_params($page_params, $user_tag, $webspace_id = '')
	{
		if ($user_tag == 'ws')
		{
			$text_user_tag = 'wholesale';
			$pagename = 'wholesale_'.$page_params;
			$p_details = $this->get_pages->page_details($pagename);
		}
		else
		{
			$text_user_tag = 'consumer';
			$p_details = $this->get_pages->page_details($page_params);
		}

		if ($webspace_id)
		{
			// get webspace details of given webspace id
			$q = $this->DB->get_where('webspaces', array('webspace_id'=>$webspace_id));
			$r = $q->row();

			$ddata['title'] = $r->webspace_name;
			$ddata['description'] = $r->webspace_name;
			$ddata['keywords'] = $r->webspace_name;
			$ddata['alttags'] = $r->webspace_name;
			$ddata['footer'] = $r->webspace_name;
			$ddata['webspace_id'] = $r->webspace_id;
			$slug = $r->webspace_slug;
			$site = $r->domain_name;
		}
		else
		{
			$ddata['title'] = $this->webspace_details->name;
			$ddata['description'] = $this->webspace_details->name;
			$ddata['keywords'] = $this->webspace_details->name;
			$ddata['alttags'] = $this->webspace_details->name;
			$ddata['footer'] = $this->webspace_details->name;
			$ddata['webspace_id'] = $this->webspace_details->id;
			$slug = $this->webspace_details->slug;
			$site = $this->webspace_details->site;
		}

		$ddata['page_name'] = ucwords(strtolower(str_replace('_', ' ', $page_params)));
		$ddata['url_structure'] = $page_params;
		$ddata['user_tag'] = $text_user_tag;
		$ddata['view_status'] = 'Y';
		if (@$p_details->text)
		{
			$ddata['content'] = str_replace(
				array(
					'instylenewyork',
					'Instylenewyork',
					'shop7thavenue',
					'Shop7thavenue',
					'Shop 7th Avenue',
					'Instyle New York'
				),
				array(
					$slug,
					$slug,
					$slug,
					$slug,
					ucwords($site),
					ucwords($site)
				),
				@$p_details->text
			);
		}

		$this->DB->insert('pages_new', $ddata);

		return;
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
			// summernote wysiwyg
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
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
			// handle summernote wysiwyg
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/dcn-create.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
