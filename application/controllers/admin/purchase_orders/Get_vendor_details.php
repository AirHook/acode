<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_vendor_details extends Admin_Controller {

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
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		if ( ! $this->input->post('vendor_id'))
		{
			// nothing more to do...
			echo 'false';
			exit;
		}

		// grab the post variable
		$vendor_id = $this->input->post('vendor_id');

		// load pertinent library/model/helpers
		$this->load->library('users/vendor_user_details');

		// get the list
		$vendor_details = $this->vendor_user_details->initialize(
			array(
				'vendor_id' => $vendor_id
			)
		);

		if ($vendor_details)
		{
			$html = $vendor_details->vendor_name
				.'<br />'
				.$vendor_details->address1
				.'<br />'
				.($vendor_details->address2 ? $vendor_details->address2.'<br />' : '')
				.$vendor_details->city.($vendor_details->state ? ', '.$vendor_details->state : '')
				.'<br />'
				.$vendor_details->country
				.'<br />'
				.$vendor_details->telephone
				.'<br />'
				.$vendor_details->contact_1
				.' '
				.($vendor_details->vendor_email ? '('.$vendor_details->vendor_email.')': '')
			;
		}
		else $html = 'false';

		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
