<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_store_details extends Admin_Controller {
	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply shows order details
	 *
	 * @return	void
	 */
	public function index()
	{
		if ( ! $this->input->post())
		{
			// nothing more to do...
			$data = array('status'=>'false','error'=>'no_post');
			echo json_encode($data);
		}
		else
		{
			$_SESSION['Modify-Order']['Store_Details'] = $this->input->post();
			$data = $this->input->post();
		}
		echo json_encode($data);
		exit;
	}

}
