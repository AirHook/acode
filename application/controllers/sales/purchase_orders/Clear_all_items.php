<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clear_all_items extends MY_Controller {

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

		/* */
		// yes, it's as simple as destroying the session
		unset($_SESSION['po_items']);
		unset($_SESSION['po_size_qty']);
		unset($_SESSION['po_options']);

		unset($_SESSION['po_vendor_id']);
		// */

		echo 'clear';
	}

	// ----------------------------------------------------------------------

}
