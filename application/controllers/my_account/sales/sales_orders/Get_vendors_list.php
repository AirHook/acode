<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_vendors_list extends MY_Controller {

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

		// load pertinent library/model/helpers
		$this->load->library('users/vendor_users_list');
		$this->load->library('users/sales_user_details');

		// get sales user login details
		if ($this->session->admin_sales_loggedin)
		{
			$this->sales_user_details->initialize(
				array(
					'admin_sales_id' => $this->session->admin_sales_id
				)
			);
		}
		else
		{
			echo 'loggedout';
			exit;
		}

		if ( ! $this->input->post('designer'))
		{
			// nothing more to do...
			echo 'false';
			exit;
		}

		// grab the post variable
		$designer = $this->input->post('designer');

		// set session
		$this->session->set_userdata('so_des_slug', $designer);

		// get the list
		$vendors = $this->vendor_users_list->select(
			array(
				'reference_designer' => $designer
			)
		);

		if ($vendors)
		{
			$html = '<option value="">Select Vendor...</option>';
			foreach ($vendors as $vendor)
			{
				$html .= '<option value="'
					.$vendor->vendor_id
					.'" data-subtext="<em>'
					.$vendor->designer
					.'</em>" data-des_slug="'
					.$vendor->url_structure
					.'">'
					.ucwords(strtolower($vendor->vendor_name))
					.' ('
					.$vendor->vendor_code
					.')</option>';
			}
		}
		else $html = 'false';

		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
