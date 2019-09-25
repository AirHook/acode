<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_store_details extends Admin_Controller {

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

		if ( ! $this->input->post('po_store_id'))
		{
			// nothing more to do...
			echo json_encode(array('company_name'=>'false'));
			exit;
		}

		// grab the post variable
		//$designer = 'basixblacklabel';
		$po_store_id = $this->input->post('po_store_id');

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');

		// get data
		$store_details = $this->wholesale_user_details->initialize(
			array(
				'user_id' => $po_store_id
			)
		);

		if ($store_details)
		{
			$array = array(
				'company_name' => $store_details->store_name,
				'company_address1' => $store_details->address1,
				'company_address2' => $store_details->address2,
				'company_city' => $store_details->city,
				'company_state' => $store_details->state,
				'company_zipcode' => $store_details->zipcode,
				'company_country' => $store_details->country,
				'company_telephone' => $store_details->telephone,
				'company_contact_person' => $store_details->fname.' '.$store_details->lname,
				'company_contact_email' => $store_details->email,
			);
		}
		else $array = array('company_name'=>'false');

		echo json_encode($array);
		exit;
	}

	// ----------------------------------------------------------------------

}
