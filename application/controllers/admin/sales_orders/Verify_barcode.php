<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verify_barcode extends Admin_Controller {

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

		if ( ! $this->input->post())
		{
			// nothing more to do...
			$data = array('status'=>'false','error'=>'no_post');
			echo json_encode($data);
		}
		else
		{
			// grab the post variables
			$designer = $this->input->post('designer');
			$vendor_id = $this->input->post('vendor_id');
			$barcode = $this->input->post('barcode');

			$this->load->library('barcodes/upc_barcodes');

			if ($this->upc_barcodes->validate($barcode))
			{
				// check and get stock id
				$st_id = $this->upc_barcodes->st_id;

				// load pertinent library/model/helpers
				$this->load->library('products/product_details');

				// get details
				$product = $this->product_details->initialize(
					array(
						'tbl_stock.st_id' => $st_id
					)
				);

				if ($product)
				{
					// if designer is empty
					// set product designer slug
					if ($designer == '')
					{
						$des = $product->designer_slug;
					}
					elseif ($product->designer_slug != $designer)
					{
						// if designer is not empty
						// compare with product designer slug
						// if not the same - return fail
						$data = array(
							'status' => 'false',
							'error' => 'des_slug'
						);
						echo json_encode($data);
						exit;
					}

					// if vendor is empty
					// set product vendor id
					if ($vendor_id == '')
					{
						$ven = $product->vendor_id;
					}
					elseif ($product->vendor_id != $vendor_id)
					{
						// if vendor is not emtpy
						// compare with product vendor id
						// if not the same - return fail
						$data = array(
							'status' => 'false',
							'error' => 'vendor_id'
						);
						echo json_encode($data);
						exit;
					}

					// eveything ok so return true with set product info
					$data['status'] = 'true';
					$data['item'] = $product->prod_no.' '.$product->color_code;
					if (@$des) $data['des_slug'] = $product->designer_slug;
					if (@$ven) $data['vendor_id'] = $product->vendor_id;
					echo json_encode($data);
					exit;
				}
				else
				{
					// nothing more to do...
					$data = array('status'=>'false','error'=>'no_product');
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
