<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class edit_store_id_session extends MY_Controller {

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
			if ($param) $this->session->set_userdata('admin_po_mod_store_id', $param);
			else unset($_SESSION['admin_po_mod_store_id']);
		}
		else
		{
			if ($param) $this->session->set_userdata('admin_po_store_id', $param);
			else unset($_SESSION['admin_po_store_id']);
		}

		exit;
	}

	// ----------------------------------------------------------------------

}
