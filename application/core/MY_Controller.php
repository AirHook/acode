<?php if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

class MY_Controller extends CI_Controller
{
	/**
	 * Data - Property
	 *
	 * property that holds data to pass to view files
	 *
	 * @return	array
	 */
    public $data = array();


	/**
	 * Constructor
	 *
	 * @return	void
	 */
    function __construct()
    {
        parent::__construct();

		// lets check for status of webspace and account
		$this->load->library('webspaces/webspace_details');
		if ( ! $this->webspace_details->initialize(array('domain_name'=>DOMAINNAME)))
		{
			// run domain set wizard
			redirect($this->config->slash_item('admin_folder').'domain_setup');
		}

		// see if domain has no theme selected yet
		if ( ! @$this->webspace_details->options['theme'])
		{
			if ($this->uri->segment(1) !== $this->config->item('admin_folder')) redirect($this->config->slash_item('admin_folder').'domain_setup/coming_soon');
		}

		/**************
		 * For TEMPOPARIS only
		 */
		if (
            (
    			$this->webspace_details->slug === 'tempoparis'
    			&& (
    				DOMAINNAME === 'tempoparis.com'
    				OR DOMAINNAME === 'tempo-paris.com'
    			)
                OR @$this->webspace_details->options['wholesale_only_site']
            )
			&& $this->uri->segment(1) !== $this->config->item('admin_folder')
		)
		{
			/**************
			 * We shall allow theses pages to get accessed while rest, NO...
			 * Only when logged in...
			 */
			if (
				! $this->session->user_loggedin
				//&& $this->session->user_cat == 'wholesale'
				&& (
					// wholesale pages
                    $this->uri->uri_string() !== 'account' &&
                    $this->uri->uri_string() !== 'account/register/wholesale' &&
					$this->uri->uri_string() !== 'wholesale/signin' &&
					$this->uri->uri_string() !== 'wholesale/authenticate' &&
					$this->uri->uri_string() !== 'wholesale/authenticated' &&
					$this->uri->uri_string() !== 'wholesale/activation' &&
					$this->uri->uri_string() !== 'wholesale/register' &&
					$this->uri->uri_string() !== 'wholesale/register_complete' &&
					$this->uri->uri_string() !== 'wholesale/reset_password' &&
					$this->uri->uri_string() !== 'wholesale/change_password' &&
					$this->uri->uri_string() !== 'wholesale/details' &&
					// uri with additional segment passed as parameters
					! preg_match('/(wholesale\/optout\/[a-zA-Z0-9.\/&=?-])\S+/', $this->uri->uri_string()) &&
					! preg_match('/(wholesale\/authenticated\/[a-zA-Z0-9.\/&=?-])\S+/', $this->uri->uri_string()) &&
					// general pages
					$this->uri->uri_string() !== 'contact' &&
					$this->uri->uri_string() !== 'ordering' &&
					$this->uri->uri_string() !== 'shipping' &&
					$this->uri->uri_string() !== 'return_policy' &&
					$this->uri->uri_string() !== 'privacy_notice' &&
					$this->uri->uri_string() !== 'order_status' &&
					$this->uri->uri_string() !== 'faq' &&
					$this->uri->uri_string() !== 'sitemap' &&
					$this->uri->uri_string() !== 'press' &&
					$this->uri->uri_string() !== 'term_of_use' &&
					$this->uri->uri_string() !== 'resource' &&
					$this->uri->uri_string() !== 'register' &&
					$this->uri->uri_string() !== 'resource/validate' &&
					// sales pages
					$this->uri->uri_string() !== 'sa' &&
					! preg_match('/(sa\/[a-zA-Z0-9.\/&=?-])\S+/', $this->uri->uri_string()) &&
					// index
					$this->uri->uri_string() !== 'shop/categories' &&
					$this->uri->uri_string() !== ''
				)
			)
			{
				$this->session->set_flashdata('logErr', 'Login required');
				$this->session->set_flashdata('page_being_accessed', $this->uri->uri_string());
				$this->session->set_flashdata('flashMsg', 'Login required');
				redirect(site_url('wholesale/signin'), 'location');
			}
		}

        if (ENVIRONMENT != 'development') $this->output->enable_profiler(FALSE);
		else $this->output->enable_profiler(TRUE);
		$sections = array(
			'benchmarks' => FALSE,
			'get' => FALSE,
			'memory_usage' => FALSE,
			'post' => FALSE,
			'http_headers' => FALSE,
			'queries' => FALSE,
			'config' => FALSE
		);
		$this->output->set_profiler_sections($sections);
    }

	// --------------------------------------------------------------------

}
