<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Index extends Frontend_Controller
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
		// we need to put a check for when ordering is done via satellite site
		// only logged in wholesale users are allowed to order on satellite site
		if (
			$this->webspace_details->options['site_type'] === 'sat_site'
			&& ! $this->session->user_role == 'wholesale'
		)
		{
			// nothing more to do...
			// set flash session
			$this->session->set_flashdata('error', 'must_login');

			// redirect user
			redirect('account', 'location');
		}

		if ($this->session->userdata('user_cat') != 'wholesale')
		{
			$data_shipping = array(
				'shipping_fee'		=> '',
				'shipping_id'		=> '',
				'shipping_country'	=> '',
				'shipping_courier'	=> ''
			);
			$this->session->unset_userdata($data_shipping);

			$reset_checkbox = 'onload="reset_checkboxes()"';
			$function_reset_checkboxes = '
				<script>
					function reset_checkboxes() {
						frmlen=document.forms.length
						for(i=0;i<frmlen;i++)
							{document.forms[i].reset()}
						document.getElementById("dvloader").style.display="none";
					}
				</script>
			';
			$div_loader = '<div style="display:block" id="dvloader"><img src="'.base_url().'images/loadingAnimation.gif" /><br />Loading</div>';
		}
		else
		{
			$reset_checkbox = '';
			$function_reset_checkboxes = '';
			$div_loader = '';
		}

		// set data variables to pass to view file
		$this->data['file'] 						= 'cart_basket';
		$this->data['reset_checkbox'] 				= $reset_checkbox;
		$this->data['function_reset_checkboxes'] 	= $function_reset_checkboxes;
		$this->data['div_loader'] 					= $div_loader;
		$this->data['site_title']					= @$meta_tags['title'];
		$this->data['site_keywords']				= @$meta_tags['keyword'];
		$this->data['site_description']				= @$meta_tags['description'];
		$this->data['alttags']						= @$meta_tags['alttags'];

		// load the view
		//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
		$this->load->view('metronic/template/template', $this->data);
	}

	// --------------------------------------------------------------------

}
