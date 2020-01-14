<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_designer_details extends Sales_user_Controller {

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

		if ( ! $this->input->post('designer'))
		{
			// nothing more to do...
			echo json_encode(array('company_name'=>'false'));
			exit;
		}

		// grab the post variable
		//$designer = 'basixblacklabel';
		$designer = $this->input->post('designer');

		// load pertinent library/model/helpers
		$this->load->library('designers/designer_details');

		// get the list
		$designer_details = $this->designer_details->initialize(
			array(
				'url_structure' => $designer
			)
		);

		if ($designer_details)
		{
			$array = array(
				'company_name' => $designer_details->company_name,
				'company_address1' => $designer_details->address1,
				'company_address2' => $designer_details->address2,
				'company_city' => $designer_details->city,
				'company_state' => $designer_details->state,
				'company_zipcode' => $designer_details->zipcode,
				'company_country' => $designer_details->country,
				'company_telephone' => $designer_details->phone,
				'company_contact_person' => $designer_details->owner,
				'company_contact_email' => $designer_details->info_email,
			);
		}
		else $array = array('company_name'=>'false');

		echo json_encode($array);
		exit;
	}

	// ----------------------------------------------------------------------

}
