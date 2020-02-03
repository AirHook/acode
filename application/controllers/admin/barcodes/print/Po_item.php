<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Po_item extends Admin_Controller {

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
	public function index($po_id = '', $item = '', $size_label = '', $all = '')
    {
    	if (
			$po_id == ''
			OR $item == ''
			OR $size_label == ''
		)
    	{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			$this->load->library('user_agent');
			if ($this->agent->is_referral())
			{
				redirect($this->agent->referrer(), 'location');
			}
			else redirect('admin/purchase_orders', 'location');
		}

		// load pertinent library/model/helpers
		$this->load->library('barcodes/upc_barcodes');
		$this->load->library('designers/designer_details');
		$this->load->library('purchase_orders/purchase_order_details');
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');

		// initialize purchase order properties and items
		$po_details = $this->purchase_order_details->initialize(
			array(
				'po_id' => $po_id
			)
		);

		// get the items
		$items = $po_details->items;

		// get designer details
		$this->designer_details->initialize(array('designer.des_id'=>$this->purchase_order_details->des_id));

		// get the barcodes
		if (isset($items[$item]))
		{
			// get product details
			$exp = explode('_', $item);
			$product = $this->product_details->initialize(
				array(
					'tbl_product.prod_no' => $exp[0],
					'color_code' => $exp[1]
				)
			);

			// set params where necessary
			$prod_no = $product->prod_no ?: $exp[0];
			$color_code = $product->color_code ?: $exp[1];
			$color_name = $product->color_name ?: $this->product_details->get_color_name($color_code);
			$st_id = $product->st_id ?: '';
			$size_mode = $product->size_mode ?: @$this->designer_details->webspace_options['size_mode'];

			// get size names
			$size_names = $this->size_names->get_size_names($size_mode);

			// initialize and generate barcode
			$upcfg['prod_no'] = $prod_no;
			$upcfg['st_id'] = $st_id;
			$upcfg['size_label'] = $size_label;
			$this->upc_barcodes->initialize($upcfg);

			// generate array to pass to view file
			//array_push($barcodes, $this->upc_barcodes->generate());
			$barcodes[$this->upc_barcodes->generate()] = array(
				'prod_no' => $prod_no,
				'color_name' => $color_name,
				'size' => $size_names[$size_label],
				'qty' => $all === '0' ? '1' : $items[$item][$size_label]
			);
		}

		$this->data['barcodes'] = $barcodes;

		$this->load->view($this->config->slash_item('admin_folder').'metronic/barcodes/print_barcodes', $this->data);
    }

 	// --------------------------------------------------------------------

}
