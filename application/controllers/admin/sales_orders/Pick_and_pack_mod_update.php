<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pick_and_pack_mod_update extends MY_Controller {

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

		if ( ! $this->input->post('so_id'))
		{
			// nothing more to do...
			echo 'no post';
			exit;
		}

		// grab the post variables
		//$so_id = '1';
		$so_id = $this->input->post('so_id');

		// initialize... and get so details
		$this->load->library('sales_orders/sales_order_details');
		$so_details = $this->sales_order_details->initialize(
			array(
				'sales_orders.sales_order_id' => $so_id
			)
		);

		// get existing items array
		$current_items_array = $so_details->items;

		// get the session items array
		$items_array = json_decode($this->session->admin_so_mod_items, TRUE);

		// set stocks update array
		$stocks_array = array();

		// iterate through the items
		foreach ($current_items_array as $item => $size_qty)
		{
			foreach ($size_qty as $size_label => $qty)
			{
				$picked = $items_array[$item][$size_label][1] - $qty[1];
				if ($picked > 0)
				{
					$stocks_array[$item][$size_label] = $picked;
				}
			}
		}

		/***********
		 * Update sales order
		 */
		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		$DB->set('items', json_encode($items_array));
		$DB->where('sales_order_id', $so_id);
		$query = $DB->update('sales_orders');

		foreach ($stocks_array as $item => $size_qty)
		{
			// get product details
			// NOTE: some items may not be in product list
			$exp = explode('_', $item);
			$this->load->library('products/product_details');
			$product = $this->product_details->initialize(
				array(
					'tbl_product.prod_no' => $exp[0],
					'color_code' => $exp[1]
				)
			);

			if ($product)
			{
				foreach ($size_qty as $size_label => $qty)
				{
					// update stocks
					$exp1 = explode('_', $size_label);
					$physical_size_label = 'physical_'.$exp1[1];

					$value_physical = $product->$physical_size_label - $qty;
					// update physical stock
					$DB->set($size_label, $value_physical);
					$DB->where('st_id', $product->st_id);
					$query = $DB->update('tbl_stock_physical');

					$value_available = $product->$size_label - $qty;
					// update available stock where necessary
					$DB->set($size_label, $value_available);
					$DB->where('st_id', $product->st_id);
					$query = $DB->update('tbl_stock');
				}
			}
		}

		echo 'success';
		exit;
	}

	// ----------------------------------------------------------------------

}
