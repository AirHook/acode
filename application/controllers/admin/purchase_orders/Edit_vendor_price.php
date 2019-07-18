<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_vendor_price extends MY_Controller {

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
	 * Add/Remove selected items to Sales Package
	 * Using session
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		if ( ! $this->input->post('prod_no'))
		{
			// nothing more to do...
			echo 'false';
		}

		// grab the post variable
		$item = $this->input->post('prod_no');
		$style_no = $this->input->post('style_no');
		$vendor_price = $this->input->post('vendor_price');

		// connect to DB
		$DB = $this->load->database('instyle', TRUE);

		// update records
		$DB->set('vendor_price', $vendor_price);
		$DB->where('prod_no', $style_no);
		$DB->update('tbl_product');

		echo $vendor_price;
	}

	// ----------------------------------------------------------------------

}
