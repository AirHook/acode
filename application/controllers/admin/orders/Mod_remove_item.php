<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_remove_item extends Admin_Controller {

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
			$order_id = $this->input->post('order_log_detail_id');
			$removeArray = array($order_id => 1);
			if(isset($_SESSION['Modify-Order']['Remove']))
			{
				$sessionArray = $_SESSION['Modify-Order']['Remove'];
				$sessionArray[$order_id]=1;
				$_SESSION['Modify-Order']['Remove'] = $sessionArray;
			}
			else
				$_SESSION['Modify-Order']['Remove'] = $removeArray;
			//$_SESSION['edit_remove_item_'.$this->input->post('order_log_detail_id')] = json_encode($this->input->post());
			$data = $this->input->post();
		}
		echo json_encode($data);
		exit;
	}

}
