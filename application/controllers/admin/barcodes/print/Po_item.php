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
	public function index($po_id = '', $item = '', $item_size_label = '', $all = NULL)
    {
    	if (
			$po_id
			&& $item
		)
    	{
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

				// if item size label is present
				if ($item_size_label)
				{
					// initialize and generate barcode
					$upcfg['prod_no'] = $prod_no;
					$upcfg['st_id'] = $st_id;
					$upcfg['size_label'] = $item_size_label;
					$this->upc_barcodes->initialize($upcfg);
					$upc_barcode = $this->upc_barcodes->generate();

					// set params to pass to view file
					$barcodes[$upc_barcode]['prod_no'] = $prod_no;
					$barcodes[$upc_barcode]['color_name'] = $color_name;
					$barcodes[$upc_barcode]['size'] = $size_names[$item_size_label];
					$barcodes[$upc_barcode]['qty'] = $all ? $items[$item][$item_size_label] : '1';
				}
				else
				{
					$barcodes = array();
					foreach ($size_names as $size_label => $s)
					{
						if ($s != 'XL1' && $s != 'XL2')
						{
							if (isset($items[$item][$size_label]))
							{
								// initialize and generate barcode
								$upcfg['prod_no'] = $prod_no;
								$upcfg['st_id'] = $st_id;
								$upcfg['size_label'] = $size_label;
								$this->upc_barcodes->initialize($upcfg);
								$upc_barcode = $this->upc_barcodes->generate();

								// set params to pass to view file
								$barcodes[$upc_barcode]['prod_no'] = $prod_no;
								$barcodes[$upc_barcode]['color_name'] = $color_name;
								$barcodes[$upc_barcode]['size'] = $s;
								$barcodes[$upc_barcode]['qty'] = $items[$item][$size_label];
							}
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
