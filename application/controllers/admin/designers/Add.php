<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add extends Admin_Controller {

	/**
	 * This Class database object holder
	 *
	 * @var	object
	 */
	protected $DB = '';

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
	 * Index - Add New Designer
	 *
	 * @return	void
	 */
	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('webspaces/webspaces_list');
		$this->load->library('designers/designers_list');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('view_status', 'Status', 'trim|required');
		$this->form_validation->set_rules('designer', 'Designer Name', 'trim|required');
		$this->form_validation->set_rules('webspace_id', 'Webspace', 'trim|required');
		$this->form_validation->set_rules('designer_address1', 'Address1', 'trim|required');
		$this->form_validation->set_rules('designer_phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('designer_info_email', 'Site Info Email', 'trim|required|callback_validate_email');

		if ($this->form_validation->run() == FALSE)
		{
			// get some data
			$this->data['webspaces'] = $this->webspaces_list->select();

			// set data variables...
			$this->data['file'] = 'designers_add';
			$this->data['page_title'] = 'Designer Add';
			$this->data['page_description'] = 'Add new designer';

			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		}
		else
		{
			// grab post array
			$post_ary = $this->input->post();
			// set necessary variables
			//$post_ary['account_status'] = '1';
			// process/add some variables
			if ($post_ary['webspace_id'] == '-1')
			{
				$post_ary['view_status'] = 'N';
				$post_ary['webspace_id'] = '0';
				$post_ary['domain_name'] = '';
				$post_ary['designer_site_domain'] = '';
			}
			else
			{
				$webspace_domain_name = trim($post_ary['webspace_domain_name']);
				list($domain, $tld) = explode('.', $webspace_domain_name);
				$post_ary['domain_name'] = $domain;
				$post_ary['url_structure'] = $domain;
				$post_ary['designer_site_domain'] = 'www.' . $webspace_domain_name;
			}
			$post_ary['logo_image'] = $this->input->post('logo_light'); // renaming field for logo_light data
			// unset unneeded variables
			//unset($post_ary['passconf']);
			unset($post_ary['webspace_domain_name']);
			unset($post_ary['logo_light']);

			// insert record
			$query = $this->DB->insert('designer', $post_ary);
			$insert_id = $this->DB->insert_id();

			// let us upload the image
			if ($_FILES)
			{
				$this->_upload_image($insert_id);
			}

			// set flash data
			$this->session->set_flashdata('success', 'add');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'designers/edit/index/'.$insert_id, 'location');
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * @return	void
	 */
	private function _upload_image($des_id)
	{
		foreach ($_FILES as $field => $file)
		{
			// if no errors
			if ($file['error'] == 0)
			{
				// let's grab the FILE array variables and process it
				$tempFile = $file['tmp_name']; // this also store file object into a temporary variable
				$filename = basename($file['name']);

				$config['tempFile'] = $tempFile;
				$config['filename'] = $filename;
				$config['attached_to'] = json_encode(array('designer'=>$des_id));
				$this->load->library('uploads/image_upload', $config);
				if ( ! $this->image_upload->upload())
				{
					// deinitialize library
					$this->image_upload->deinitialize();

					// set flash data
					$this->session->set_flashdata('error', 'image_upload_error');
					$this->session->set_flashdata('error_message', 'ERROR on image upload  for "'.$field.'"');
				}
				else
				{
					// upload succesful
					// let process data
					if ($field == 'logo')
					{
						$post_ary['logo'] = $this->image_upload->image_url;
					}
					if ($field == 'logo_light')
					{
						$post_ary['logo_image'] = $this->image_upload->image_url;
					}
					if ($field == 'icon')
					{
						$post_ary['icon'] = $this->image_upload->image_url;
					}

					// update records
					if ( ! empty($post_ary))
					{
						// connect to database
						$DB = $this->load->database('instyle', TRUE);
						$DB->where('des_id', $des_id);
						$query = $DB->update('designer', $post_ary);
					}
					else
					{
						// deinitialize library
						$this->image_upload->deinitialize();

						// set flash data
						$this->session->set_flashdata('error', 'image_upload_error');
						$this->session->set_flashdata('error_message', 'There was an error on data entry for "'.$field.'"');
					}
				}
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Form Validation Callback Functions
	 *
	 * @return	boolean
	 */
	function validate_email($str)
	{
		if ($str == '')
		{
			$this->form_validation->set_message('validate_email', 'Please enter an email address of the Email field.');
			return FALSE;
		}
		else
		{
			if ( ! filter_var($str, FILTER_VALIDATE_EMAIL))
			{
				$this->form_validation->set_message('validate_email', 'The Email field must contain a valid email address.');
				return FALSE;
			}
			else return TRUE;
		}
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
			// handle validation and others
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/form-validation-designer_add.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
