<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_options extends MY_Controller {

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
		$page = $this->input->post('page');
		$val = $this->input->post('val');

		// grab the options array
		$options_array =
			$page == 'create'
			? (
				$this->session->admin_lb_options
				? json_decode($this->session->admin_lb_options, TRUE)
				: array()
			)
			: (
				$this->session->admin_lb_mod_options
				? json_decode($this->session->admin_lb_mod_options, TRUE)
				: array()
			)
		;

		switch ($param)
		{
			case 'w_prices':
				if ($val == 'Y') $options_array['w_prices'] = 'Y';
				else $options_array['w_prices'] = 'N';
			break;
			case 'w_sizes':
				if ($val == 'Y') $options_array['w_sizes'] = 'Y';
				else $options_array['w_sizes'] = 'N';
			break;
			case 'w_images':
				if ($val == 'Y') $options_array['w_images'] = 'Y';
				else unset($options_array['w_images']);
			break;
			case 'linesheets_only':
				if ($val == 'Y') $options_array['linesheets_only'] = 'Y';
				else unset($options_array['linesheets_only']);
			break;
		}

		// reset session value for items array
		if ($this->input->post('page') == 'create')
		{
			$this->session->set_userdata('admin_lb_options', json_encode($options_array));
		}
		if ($this->input->post('page') == 'modify')
		{
			$this->session->set_userdata('admin_lb_mod_options', json_encode($options_array));
		}

		exit;
	}

	// ----------------------------------------------------------------------

}
