<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_item_qty extends Admin_Controller {
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
			$quantity = $this->input->post('qty');
			$quantityArray = array($order_id => $quantity);
			if(isset($_SESSION['Modify-Order']['Quantity']))
			{
				$sessionArray = $_SESSION['Modify-Order']['Quantity'];
				$sessionArray[$order_id]=$quantity;
				$_SESSION['Modify-Order']['Quantity'] = $sessionArray;//array_push($_SESSION['NOEL_TEST'], $quantityArray);
			}
			else
				$_SESSION['Modify-Order']['Quantity'] = $quantityArray;
			$data = $this->input->post();
		}
		echo json_encode($data);
		exit;
	}

}
