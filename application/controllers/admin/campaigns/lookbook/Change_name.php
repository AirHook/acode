<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_name extends Admin_Controller {

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
	 * Index - Change Sales Package Name
	 *
	 * Updates the package details informations like sales package name,
	 * subject and message
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		//echo '<pre>';
		//print_r($this->input->post());
		//die();

		echo 'Processing...';

		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'campaigns/lookbook', 'location');
		}

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// process record
		$post_ary = $this->input->post();
		// set necessary variables
		$post_ary['last_modified'] = time();
		// unset unneeded variables
		unset($post_ary['files']);
		unset($post_ary['submit']);

		// check for set_as_default
		if (isset($post_ary['set_as_default']))
		{
			// remove any other set as defaul package
			$DB->set('set_as_default', '0');
			$q1 = $DB->update('sales_packages');
		}

		// finally, update records
		$DB->set($post_ary);
		$DB->where('lookbook_id', $id);
		$q = $DB->update('lookbook');

		// set flash data
		$this->session->set_flashdata('success', 'change_sales_package_name');

		// redirect user
		if ($this->input->post('submit') === 'step2')
		{
			redirect($this->config->slash_item('admin_folder').'campaigns/lookbook/edit/step2/'.$id.'/womens_apparel', 'location');
		}
		else redirect($this->config->slash_item('admin_folder').'campaigns/lookbook/edit/step1/'.$id, 'location');
	}

	// ----------------------------------------------------------------------

}
