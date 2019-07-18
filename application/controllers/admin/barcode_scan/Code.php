<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Code extends Admin_Controller {

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
	 * $params
	 *		open-details 	= open product details page
	 *		create-so		= create SO with item as intial selection
	 *		select-so		= open SO with current item
	 *		create-po		= create PO with item as intial selection
	 *		select-po		= open PO with current item
	 *
	 * $code	 = $product->prod_no.'-'.$product->color_code.'-'.$size_label.'-'.$product->st_id;
	 *
	 * @return	void
	 */
	public function index($params = '', $code = '')
	{
		if ($params == '' OR $code == '')
		{
			// nothing more to do...
			$this->session->set_userdata('error', 'no_id_passed');

			// send user to dashbaord
			redirect('admin/dashboard', 'location');
		}

		// first, breakdown code
		if ($code)
		{
			$exp = explode('-', $code);
			$prod_no = $exp[0];
			$color_code = $exp[1];
			$size_label = $exp[2];
			$st_id = $exp[3];
			$item = $prod_no.'_'.$color_code;

			// open product details
			if ($params == 'open-details')
			{
				// load pertinent library/model/helpers
				$this->load->library('products/product_details');

				// initialize product details
				$this->product_details->initialize(array('tbl_product.prod_no'=>$prod_no));

				// redirect user
				redirect('admin/products/edit/index/'.$this->product_details->prod_id, 'location');
			}

			// connect to database
			$DB = $this->load->database('instyle', TRUE);

			// create SO
			if ($params == 'create-so')
			{
				// send user to dashbaord
				redirect('admin/dashboard', 'location');
			}

			// select SO
			if ($params == 'select-so')
			{
				// send user to dashbaord
				redirect('admin/dashboard', 'location');
			}

			// create PO
			if ($params == 'create-po')
			{
				// send user to dashbaord
				redirect('admin/dashboard', 'location');
			}

			// select existing PO with item
			if ($params == 'select-po')
			{
				// load pertinent library/model/helpers
				// $this->load->library('sales_orers/purchase_order_details');

				// get details
				$DB->select('po_id');
				$DB->like('items', $item);
				$DB->order_by('po_number', 'DESC');
				$qpo = $DB->get('purchase_orders');

				$po_id = $qpo->row()->po_id;

				// redirect user
				redirect('admin/purchase_orders/details/index/'.$po_id, 'location');
			}
		}

		// Code here...
		echo '<br />here';

		// redirect user
		//redirect('admin/dashboard', 'location');
	}

	// ----------------------------------------------------------------------

}
