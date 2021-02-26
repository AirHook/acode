<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class By_product_clicks_report extends Sales_user_Controller {

	/**
	 * DB Object
	 *
	 * @return	object
	 */
	protected $DB;

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// connect to database for use by model
		$this->DB = $this->load->database('instyle', TRUE);
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
		// redirect link
		// for depracation
		// this file used to be saving the product clicks as sales package
		// we are not saving it anymore and instead just send the package as
		// a not saved sales package offer creating a new controller
		// with pretty much the same flow
		// the link from the product clicks report goes through here
		// we simply pass it to the new controller class
		// as being 'for depracation', we can change the link from the report
		// to go directly to the new controller class (see link below)
		redirect(site_url('my_account/sales/sales_package/send_product_clicks').'?'.http_build_query($_GET), 'location');
	}

	// ----------------------------------------------------------------------

}
