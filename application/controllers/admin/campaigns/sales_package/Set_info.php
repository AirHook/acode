<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_info extends MY_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - Sales Package View
	 *
	 * Open and view existing sales package for edit/sending
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		if ( ! $this->input->post())
		{
			// nothing more to do...
			echo 'There is no post data.';
			exit;
		}

		// grab the post variable
		$param = $this->input->post('param');
		$val = $this->input->post('val');

		switch ($param)
		{
			case 'sales_package_name':
				$this->session->set_userdata('admin_sa_name', $val);
			break;
			case 'email_subject':
				$this->session->set_userdata('admin_sa_email_subject', $val);
			break;
			case 'email_message':
				$this->session->set_userdata('admin_sa_email_message', $val);
			break;
		}

		exit;
	}

	// ----------------------------------------------------------------------

}
