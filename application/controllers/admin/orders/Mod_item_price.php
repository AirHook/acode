<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_item_price extends Admin_Controller {
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
			$price = $this->input->post('unit_price');
			$priceArray = array($order_id => $price);
			if(isset($_SESSION['Modify-Order']['Price']))
			{
				$sessionArray = $_SESSION['Modify-Order']['Price'];
				$sessionArray[$order_id]=$price;
				$_SESSION['Modify-Order']['Price'] = $sessionArray;
			}
			else
				$_SESSION['Modify-Order']['Price'] = $priceArray;

			$data = $this->input->post();
		}
		echo json_encode($data);
		exit;
	}

}
