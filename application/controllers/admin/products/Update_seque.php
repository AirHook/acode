<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_seque extends Admin_Controller {

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
	 * @return	void
	 */
	public function index($prod_id, $new_seque)
	{
		$this->output->enable_profiler(FALSE);

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// update record
		$DB->set('seque', $new_seque);
		$DB->where('prod_id', $prod_id);
		$q = $DB->update('tbl_product');

		if ($q)
		{
			echo 'Success';
		}
		else echo 'ERROR: '.$this->db->error();
	}

	// ----------------------------------------------------------------------

}
