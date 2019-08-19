<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class So extends Admin_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - Primary class function
	 *
	 * @return	void
	 */
    public function index($so_id = NULL)
    {
    	if ($so_id != NULL)
    	{
			// load pertinent library/model/helpers
			$this->load->library('products/size_names');
			$this->load->library('sales_orders/sales_order_details');
			$this->load->library('products/product_details');
			$this->load->library('barcodes/upc_barcodes');

			// initialize...
			$so_details = $this->sales_order_details->initialize(
				array(
					'sales_orders.sales_order_id' => $so_id
				)
			);

			// set the items
			$so_items = $so_details->items;

			// get the barcodes
			$barcodes = array();
			if ( ! empty($so_items))
			{
				foreach ($so_items as $item => $size_qty)
				{
					// get product details
					$exp = explode('_', $item);
					$product = $this->product_details->initialize(
						array(
							'tbl_product.prod_no' => $exp[0],
							'color_code' => $exp[1]
						)
					);

					$st_id = $product->st_id;

					foreach ($size_qty as $size_label => $qty)
					{
						if (isset($so_items[$item][$size_label]))
						{
							$upcfg['st_id'] = $st_id;
							$upcfg['size_label'] = $size_label;
							$this->upc_barcodes->initialize($upcfg);
							array_push($barcodes, $this->upc_barcodes->generate());
						}
					}
				}
			}

			$this->data['barcodes'] = $barcodes;

			$this->load->view($this->config->slash_item('admin_folder').'metronic/barcodes/print_barcodes', $this->data);
    	}
    }

 	// --------------------------------------------------------------------

}
