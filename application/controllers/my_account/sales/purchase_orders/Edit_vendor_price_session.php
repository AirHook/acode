<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_vendor_price_session extends MY_Controller {

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
	public function index($param = '0', $page = '')
	{
		$this->output->enable_profiler(FALSE);

		// reset edit vendor price session
		if ($page == 'modify')
		{
			if ($param == '1') $this->session->set_userdata('po_mod_edit_vendor_price', TRUE);
			else unset($_SESSION['po_mod_edit_vendor_price']);
		}
		else
		{
			if ($param == '1') $this->session->set_userdata('po_edit_vendor_price', TRUE);
			else unset($_SESSION['po_edit_vendor_price']);
		}

		exit;
	}

	// ----------------------------------------------------------------------

}
