<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verify_barcode extends MY_Controller {

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

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('users/admin_user_details');

		// get admin login details
		if ($this->session->admin_loggedin)
		{
			$this->admin_user_details->initialize(
				array(
					'admin_id' => $this->session->admin_id
				)
			);
		}
		else
		{
			echo 'loggedout';
			exit;
		}

		if ( ! $this->input->post())
		{
			// nothing more to do...
			$data = array('status'=>'false','error'=>'no_post');
			echo json_encode($data);
		}
		else
		{
			// grab the post variables
			//$barcode = '710780167717'; // debug
			$barcode = $this->input->post('barcode');

			$this->load->library('barcodes/upc_barcodes');

			if ($this->upc_barcodes->validate($barcode))
			{
				// check and get stock id
				$st_id = $this->upc_barcodes->st_id;

				// get details
				$product = $this->product_details->initialize(
					array(
						'tbl_stock.st_id' => $st_id
					)
				);

				if ($product)
				{
					// eveything ok so return true with set product info
					$data['status'] = 'true';
					$data['item'] = $product->prod_no.'_'.$product->color_code;
					$data['color_code'] = $product->color_code;
					$data['size_label'] = $this->upc_barcodes->size_label;
					echo json_encode($data);
					exit;
				}
				else
				{
					// nothing more to do...
					$data = array('status'=>'ture','error'=>'no_product');
					echo json_encode($data);
					exit;
				}
			}
			else echo json_encode(array('status'=>'false','error'=>'invalid_barcode'));

			exit;
		}
	}

	// ----------------------------------------------------------------------

}
