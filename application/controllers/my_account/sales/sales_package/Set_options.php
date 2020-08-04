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
		$val = $this->input->post('val');

		// grab the options array
		$options_array =
			$this->session->sa_options
			? json_decode($this->session->sa_options, TRUE)
			: array()
		;

		switch ($param)
		{
			case 'w_prices':
				if ($val == 'Y') $options_array['w_prices'] = 'Y';
				else $options_array['w_prices'] = 'N';
			break;
			case 'w_images':
				if ($val == 'Y') $options_array['w_images'] = 'Y';
				else unset($options_array['w_images']);
			break;
			case 'linesheets_only':
				if ($val == 'Y')
				{
					$options_array['linesheets_only'] = 'Y';
					// set other options to NO
					$options_array['w_prices'] = 'N';
					unset($options_array['w_images']);
				}
				else unset($options_array['linesheets_only']);
			break;
		}

		$this->session->set_userdata('sa_options', json_encode($options_array));
		exit;
	}

	// ----------------------------------------------------------------------

}
